<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Student;
use App\Models\ImageResize;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        $avatarPath = $user->avatar;
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');
        $avatarPath = null;
        if (isset($input['avatar']) && $input['avatar'] instanceof UploadedFile) {
            /** @var UploadedFile $avatar */
            $avatar = $input['avatar'];
            // $originalName = $avatar->getClientOriginalName();
            // $extension = $avatar->getClientOriginalExtension();
            // $filenameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);

            $extFile = $avatar->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            if ($avatarPath != null) {
                Storage::delete($avatarPath);
                Storage::delete('thumbs/' . $avatarPath);
            }
            $avatarPath = $avatar->storeAs('pengguna', $nameFile, 'public');
            $thumbnail = $avatar->storeAs('thumbs/pengguna', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/pengguna/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 300 || $height >= 300) {
                    ImageResize::createThumbnail($smallthumbnailpath, 300, 300);
                }
            }
            $smallthumbnailpath = public_path('storage/thumbs/pengguna/' . $nameFile);
            ImageResize::createThumbnail($smallthumbnailpath, 100, 100);
            // Simpan file atau lakukan operasi lain
            // $avatarPath = $avatar->store('avatars');

            // Simpan informasi ini ke database atau log
            // Misalnya:
            // $user->avatar = $avatarPath;

            // Debugging output to ensure correct values
            // dd([
            //     'originalName' => $originalName,
            //     'extension' => $extension,
            //     'filenameWithoutExtension' => $filenameWithoutExtension,
            //     'avatarPath' => $avatarPath,
            // ]);
        }
        // dd($input['avatar']);

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['alamat'],
                'avatar' => $avatarPath,
            ])->save();
            // cek Student
            $cekStudent = Student::where('user_id', $user->id)->first();
            if ($cekStudent) {
                // User::where('user_id', $user->id)->update([
                //     'name' => $input['name'],
                //     'email' => $input['email'],
                //     'phone' => $input['phone'],
                //     'address' => $input['alamat'],
                // ]);
                Student::where('user_id', $user->id)->update([
                    'nama' => $input['name'],
                    'email' => $input['email'],
                    'telpon' => $input['phone'],
                    'alamat' => $input['alamat'],
                    'keterangan' => $input['keterangan'],
                    'photo' => $avatarPath,
                ]);
            }
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
