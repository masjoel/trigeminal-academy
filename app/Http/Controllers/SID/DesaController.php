<?php

namespace App\Http\Controllers\SID;

use App\Models\Desa;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use App\Models\Provinsi;
use App\Models\AdkeuApbd;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\AdpddInduk;
use App\Models\AdpddMutasi;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use App\Models\AdsrtKategori;
use App\Models\AdsrtTemplate;
use App\Models\AdmPembangunan;
use App\Models\AdpddSementara;
use App\Models\AdkeuApbdDetail;
use App\Models\AdsrtPermohonan;
use App\Models\AdkeuApbdAccount;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateDesaReq;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMemberRequest;
use App\Models\ProfilBisnis;

class DesaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:seting-profil-bisnis')->only(['index', 'show']);
        $this->middleware('can:seting-profil-bisnis.edit')->only(['edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cek1 = cekAktivasi()['cek1'];
        $cek2 = cekAktivasi()['cek2'];
        if ($cek1 == 0 || $cek2 == 0) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route('login'));
        }
        $profil_bisni = Desa::first();
        $title = 'Profil Bisnis';
        $latitude = $profil_bisni->latitude;
        $longitude = $profil_bisni->longitude;
        return view('backend.desa.index', compact('title', 'profil_bisni', 'latitude', 'longitude'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $profil_bisni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $profil_bisni)
    {
        $title = 'Profil Bisnis';
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::where('provinsi_id', $profil_bisni->provinsi_id)->get();
        $kecamatan = Kecamatan::where('kabupaten_id', $profil_bisni->kabupaten_id)->get();
        $kelurahan = Kelurahan::where('kecamatan_id', $profil_bisni->kecamatan_id)->get();
        return view('backend.desa.edit', compact('title', 'profil_bisni', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDesaReq $request, Desa $profil_bisni)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $photoPath = $profil_bisni->photo;
        $logoPath = $profil_bisni->logo;
        $image_iconPath = $profil_bisni->image_icon;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $extFile = $logo->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            if ($logoPath != null) {
                Storage::delete($logoPath);
                Storage::delete('thumbs/' . $logoPath);
            }
            $logoPath = $logo->storeAs('desa', $nameFile, 'public');
            $thumbnail = $logo->storeAs('thumbs/desa', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/desa/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 300 || $height >= 300) {
                ImageResize::createThumbnail($smallthumbnailpath, 300, 300);
            }

            $smallthumbnailpath = public_path('storage/thumbs/desa/' . $nameFile);
            ImageResize::createThumbnail($smallthumbnailpath, 150, 150);
        }
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $extFile = $photo->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            if ($photoPath != null) {
                Storage::delete($photoPath);
                Storage::delete('thumbs/' . $photoPath);
            }
            $photoPath = $photo->storeAs('desa', $nameFile, 'public');
            $thumbnail = $photo->storeAs('thumbs/desa', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/desa/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 300 || $height >= 300) {
                ImageResize::createThumbnail($smallthumbnailpath, 300, 300);
            }

            $smallthumbnailpath = public_path('storage/thumbs/desa/' . $nameFile);
            ImageResize::createThumbnail($smallthumbnailpath, 150, 150);
        }
        if ($request->hasFile('image_icon')) {
            $image_icon = $request->file('image_icon');
            $extFile = $image_icon->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            if ($image_iconPath != null) {
                Storage::delete($image_iconPath);
                Storage::delete('thumbs/' . $image_iconPath);
            }
            $image_iconPath = $image_icon->storeAs('desa', $nameFile, 'public');
            $thumbnail = $image_icon->storeAs('thumbs/desa', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/desa/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 300 || $height >= 300) {
                ImageResize::createThumbnail($smallthumbnailpath, 64, 64);
            }

            $smallthumbnailpath = public_path('storage/thumbs/desa/' . $nameFile);
            ImageResize::createThumbnail($smallthumbnailpath, 64, 64);
        }
        $validate['photo'] = $photoPath;
        $validate['logo'] = $logoPath;
        $validate['image_icon'] = $image_iconPath;
        $profil_bisni->update($validate);
        $desa = ProfilBisnis::first();
        $desa->update([
            'nama_client' => $request->nama_client,
            'alamat_client' => $request->alamat_client,
            'logo' => $logoPath,
            'image_icon' => $image_iconPath,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->web,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'footnot' => $request->footnot,
        ]);
        DB::commit();
        return redirect()->route('profil-bisnis.index')->with('success', 'Edit Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desa $profil_bisni)
    {
        //
    }

    public function link()
    {
        // 
    }

    public function aktivasi(Request $request)
    {
        DB::beginTransaction();
        // $mac = getMacAddressLinux();
        $mac = cekAktivasi()['mcad'];
        $data = $request->all();
        $profilBisnis = Desa::first();
        $data['mcad'] = $mac;
        $data['init'] = $request->kode;
        $profilBisnis->update($data);
        DB::commit();
        return redirect(route('login'));
    }
}
