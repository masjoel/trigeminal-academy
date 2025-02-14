<?php

namespace App\Http\Controllers;

// use App\Models\Role;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:seting-user')->only(['index', 'show']);
        $this->middleware('can:seting-user.create')->only(['create', 'store']);
        $this->middleware('can:seting-user.edit')->only(['edit', 'update']);
        $this->middleware('can:seting-user.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'desc')->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%');
        })->paginate(10);
        $title = 'User';
        return view('backend.user.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'New User';
        $roles = Role::all();
        return view('backend.user.create', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $extFile = $avatar->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
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
        }
        $validate['role'] = $request->role;
        $validate['phone'] = $request->phone;
        $validate['avatar'] = $avatarPath;
        $validate['password'] = Hash::make($request['password']);
        $validate['perusahaan_id'] = 1;
        $user = User::create($validate);

        $userRole = Role::where('name', $request->role)->first();
        $dataUser = User::where('role', $request->role)->first();
        $permissions = $dataUser->getPermissionNames();
        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $user->assignRole($userRole);
            $user->givePermissionTo($permission);
        }
        DB::commit();
        return redirect(route('user.index'))->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $title = 'Edit User';
        return view('backend.user.edit', compact('title', 'roles', 'user'));
    }
    public function permission(User $user)
    {
        $roles = Role::all();
        if (auth()->user()->role == 'admin') {
            $permissions = Permission::where('name', 'not like', '%.%')->get();
            $permissionChilds = Permission::where('name', 'like', '%.%')->get();
        } else {
            $permissions = Permission::where('name', 'not like', '%.%')->where('name', 'not like', '%permission%')->get();
            $permissionChilds = Permission::where('name', 'like', '%.%')->where('name', 'not like', '%permission%')->get();
        }
        $permissionUsers = $user->getPermissionNames()->toArray();
        $title = 'User Permission';
        return view('backend.user.permission', compact('title', 'roles', 'user', 'permissions', 'permissionChilds', 'permissionUsers'));
    }
    public function permissionError(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permissions = $permissions->groupBy(function ($permission) {
            return str_contains($permission->name, '.') ? 'child' : 'main';
        });
        $permissionGroups = [
            'create' => $permissions->get('main')->where('name', 'ilike', '%create%'),
            'edit' => $permissions->get('main')->where('name', 'like', '%edit%'),
            'delete' => $permissions->get('main')->where('name', 'like', '%delete%'),
        ];

        $data = $permissions->get('child')->toArray(); // Mengubah objek menjadi array
        // if (in_array('seting-user.create', $data)) {
        //     dd('disini');
        //     // Lakukan sesuatu jika nilai ditemukan dalam array
        // } else {
        //     dd('tidak disini');
        //     // Lakukan sesuatu jika nilai tidak ditemukan dalam array
        // }
        // dd($permissions->get('child')->toArray()[1]['name']);
        $permissionUsers = $user->getPermissionNames()->toArray();
        $title = 'User Permission';
        return view('pages.user.permission', compact('title', 'roles', 'user', 'permissions', 'permissionGroups', 'permissionUsers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();
        $avatarPath = $user->avatar;
        $pass = $user->password;
        if ($request->password) {
            $pass = Hash::make($request->password);
        }
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $extFile = $avatar->getClientOriginalExtension();
            // $fileSize = $avatar->getSize();
            // $fileSizeInKB = $fileSize / 1024;
            // $fileSizeInMB = $fileSizeInKB / 1024;

            // if (!in_array($extFile, ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp']) || $fileSizeInMB > 8) {
            //     return back()->with('error', 'File harus berupa image (jpeg, png, jpg, gif, svg, webp) max. size 8 MB')->withInput();
            //     DB::rollBack();
            // }
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
        }
        $validate = $request->validated();

        $validate['role'] = $request->role;
        $validate['phone'] = $request->phone;
        $validate['avatar'] = $avatarPath;
        $validate['password'] = $pass;
        $user->update($validate);
        DB::commit();
        return redirect()->route('user.index')->with('success', 'Edit User Successfully');
    }
    public function updatepermission(Request $request, User $user)
    {
        DB::beginTransaction();
        // Revoke old permissions
        $oldPermissions = $user->getPermissionNames();
        foreach ($oldPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->where('guard_name', 'web')->first();
            if ($permission) {
                $user->revokePermissionTo($permission);
            }
        }

        // Sync roles to prevent duplication
        $userRole = Role::findByName($user->role, 'web');
        if ($userRole) {
            $user->syncRoles([$userRole]);
        }

        // Assign new permissions
        if ($request->user_permission !== null) {
            $newPermissions = array_keys($request->user_permission);
            foreach ($newPermissions as $key) {
                $permission = Permission::firstOrCreate(['name' => $key, 'guard_name' => 'web']);
                $user->givePermissionTo($permission);
            }
        }
        DB::commit();
        return redirect()->route('user.index')->with('success', 'Edit User Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        $imagePath = $user->avatar;
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $user->username,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
        }
        $user->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
