<?php

namespace App\Http\Controllers\Frontend;

use Ramsey\Uuid\Uuid;
use App\Models\ImageResize;
use App\Models\ProfilBisnis;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfilBizRequest;
use App\Models\LinkExternal;

class ProfilBisnisController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:profil-bisnis')->only(['index', 'show']);
        $this->middleware('can:profil-bisnis.create')->only(['create', 'store']);
        $this->middleware('can:profil-bisnis.edit')->only(['edit', 'update']);
        $this->middleware('can:profil-bisnis.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(ProfilBisnis $profil_bisni)
    {
        $profil = $profil_bisni;
        return response()->json(['profil' => $profil]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ProfilBisnis $profil_bisni)
    {
        $cek1 = cekAktivasi()['cek1'];
        $cek2 = cekAktivasi()['cek2'];
        if ($cek1 == 0 || $cek2 == 0) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route('login'));
        }
        $medsos = LinkExternal::where('tipe', 'medsos')->get();
        return view('backend.profile.edit')->with(['profilBisnis' => $profil_bisni, 'title' => 'Profil', 'medsos' => $medsos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfilBizRequest $request, ProfilBisnis $profil_bisni)
    {
        DB::beginTransaction();
        $imagePath = $profil_bisni->logo;
        $iconPath = $profil_bisni->image_icon;
        $validate = $request->validated();

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $extFile = $logo->getClientOriginalExtension();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $logo->storeAs('profile_img', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/profile_img/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 300 || $height >= 300) {
                ImageResize::createThumbnail($smallthumbnailpath, 300, 300);
            }
        }
        if ($request->hasFile('image_icon')) {
            $image_icon = $request->file('image_icon');
            $extFile = $image_icon->getClientOriginalExtension();
            if ($iconPath && Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->delete($iconPath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $iconPath = $image_icon->storeAs('profile_img', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/profile_img/' . $nameFile);
            ImageResize::createThumbnail($smallthumbnailpath, 64, 64);
        }
        $validate['logo'] = $imagePath;
        $validate['image_icon'] = $iconPath;
        $validate['footnot'] = $request->footnot;
        $validate['phone'] = $request->phone;
        // $validate['facebook'] = $request->facebook;
        // $validate['youtube'] = $request->youtube;
        // $validate['twitter'] = $request->twitter;
        // $validate['instagram'] = $request->instagram;
        $validate['peta'] = str_replace('width="600" height="450"', 'width="100%" height="390" ', $request->peta);
        $profil_bisni->update($validate);
        DB::commit();
        return back()->with('success', 'Edit Profil Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilBisnis $profil_bisni)
    {
        //
    }
}
