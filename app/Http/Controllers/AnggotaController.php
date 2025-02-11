<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Anggota;
use BaconQrCode\Writer;
use App\Models\AdpddInduk;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use BaconQrCode\Renderer\ImageRenderer;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SID\StorePendudukReq;
use App\Http\Requests\SID\UpdatePendudukReq;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Anggota::orderBy('id', 'desc');
        $anggota = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%')
                ->orWhere('telpon', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
            ->paginate($limit);
        $title = 'Anggota LSM';
        return view('pages.v3.admin-anggota.index', compact('title', 'anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Anggota LSM';
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $pendidikan = ['SD', 'SMP', 'SMA', 'D1', 'D3', 'D4', 'S1', 'S2', 'S3'];
        $pekerjaan = ['PNS', 'TNI', 'POLRI', 'SWASTA', 'WIRAUSAHA'];
        return view('pages.v3.admin-anggota.create', compact('title', 'jenis_kelamin', 'pendidikan', 'pekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePendudukReq $request)
    {
        DB::beginTransaction();
        $slug = SlugService::createSlug(Anggota::class, 'slug', $request->nama);
        $imagePath = $imagePath2 = null;
        $validate = $request->validated();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extFile = $image->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $image->storeAs('anggota', $nameFile, 'public');
            $smallthumbnailpath = public_path('storage/anggota/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 800 || $height >= 600) {
                ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
            }
            $thumbnail = $image->storeAs('thumb/anggota', $nameFile, 'public');
            $smallthumbnailpath = public_path('storage/thumb/anggota/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 800 || $height >= 600) {
                ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
            }
        }
        if ($request->hasFile('image_ktp')) {
            $image_ktp = $request->file('image_ktp');
            $extFile = $image_ktp->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath2 = $image_ktp->storeAs('anggota', $nameFile, 'public');
            $smallthumbnailpath = public_path('storage/anggota/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 800 || $height >= 600) {
                ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
            }

            $thumbnail = $image_ktp->storeAs('thumb/anggota', $nameFile, 'public');
            $smallthumbnailpath = public_path('storage/thumb/anggota/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 800 || $height >= 600) {
                ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
            }
        }
        $validate['id_ktp'] = $request->nik;
        $validate['slug'] = $slug;
        $validate['image'] = $imagePath;
        $validate['image_ktp'] = $imagePath2;
        $validate['status'] = $request->status ?? 'aktif';
        $validate['iduser'] = Auth::user()->id;
        $save = Anggota::create($validate);
        $validate['kcds'] = infodesa('kodedesa') . '-' . $save->id;
        $save->update($validate);
        DB::commit();
        return redirect(route('admin-anggota.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $admin_anggotum)
    {
        $title = 'Anggota LSM';
        $text = url('/status-anggota/' . $admin_anggotum->nik);
        $renderer = new ImageRenderer(new RendererStyle(256), new ImagickImageBackEnd());
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($text);
        $qrCodeBase64 = base64_encode($qrCode);
        return json_encode([
            'qrCodeBase64' => $qrCodeBase64,
            'nama' => $admin_anggotum->nama,
            'nik' => $admin_anggotum->nik,
            'nra' => $admin_anggotum->paspor,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $admin_anggotum)
    {
        $title = 'Anggota LSM';
        $anggota = $admin_anggotum;
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $pendidikan = ['SD', 'SMP', 'SMA', 'D1', 'D3', 'D4', 'S1', 'S2', 'S3'];
        $pekerjaan = ['PNS', 'TNI', 'POLRI', 'SWASTA', 'WIRAUSAHA'];
        return view('pages.v3.admin-anggota.edit', compact('title', 'anggota', 'jenis_kelamin', 'pendidikan', 'pekerjaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePendudukReq $request, Anggota $admin_anggotum)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $nama = $request->input('nama');
        $slug = $admin_anggotum->slug;
        if ($admin_anggotum->nama != $nama) {
            $slug = SlugService::createSlug(Anggota::class, 'slug', $request->nama);
        }
        $imagePath = $admin_anggotum->image;
        $image_ktpPath = $admin_anggotum->image_ktp;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extFile = $image->getClientOriginalExtension();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Storage::disk('public')->delete('thumb/' . $imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $image->storeAs('anggota', $nameFile, 'public');
            $thumbnail = $image->storeAs('thumb/anggota', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/anggota/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/anggota/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 800 || $height >= 600) {
                ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
            }
        }
        if ($request->hasFile('image_ktp')) {
            $image_ktp = $request->file('image_ktp');
            $extFile = $image_ktp->getClientOriginalExtension();
            if ($image_ktpPath && Storage::disk('public')->exists($image_ktpPath)) {
                Storage::disk('public')->delete($image_ktpPath);
                Storage::disk('public')->delete('thumb/' . $image_ktpPath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $image_ktpPath = $image_ktp->storeAs('anggota', $nameFile, 'public');
            $thumbnail = $image_ktp->storeAs('thumb/anggota', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/anggota/' . $nameFile);
            $image_ktpInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($image_ktpInfo) {
                $width = $image_ktpInfo['width'];
                $height = $image_ktpInfo['height'];
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/anggota/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 800 || $height >= 600) {
                ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
            }
        }
        $validate = $request->validated($request->id);
        $validate['id_ktp'] = $request->input('nik');
        $validate['status'] = $request->status;
        $validate['slug'] = $slug;
        $validate['image'] = $imagePath;
        $validate['image_ktp'] = $image_ktpPath;
        $admin_anggotum->update($validate);
        $pengurus = PerangkatDesa::where('nik', $admin_anggotum->nik)->first();
        if ($pengurus) {
            $pengurus->update([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'id_ktp' => $request->nik,
                'nip' => $request->paspor,
                'slug' => $slug,
                'status' => $request->status,
                'avatar' => $imagePath,
            ]);
        }

        DB::commit();
        return redirect(route('admin-anggota.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $admin_anggotum)
    {
        DB::beginTransaction();
        $imagePath = $admin_anggotum->image;
        $clientIP = request()->ip();
        $log = [
            'iduser' => Auth::user()->id,
            'nama' => Auth::user()->username,
            'level' => Auth::user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $admin_anggotum->nik . ' ' . $admin_anggotum->nama,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        $cekPerangkat = PerangkatDesa::where('nik', $admin_anggotum->nik)->first();
        if ($cekPerangkat) {
            $status = 'error';
            $msg = 'Data tidak dapat dihapus karena sudah terhubung dengan database lain';
        } else {
            $status = 'success';
            $msg = 'Succesfully Deleted Data';
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Storage::disk('public')->delete('thumb/' . $imagePath);
            }
            $admin_anggotum->delete();
        }
        DB::commit();
        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
    }
}
