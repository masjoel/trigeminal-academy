<?php

namespace App\Http\Controllers\Webdesa;

use Ramsey\Uuid\Uuid;
use App\Models\Artikel;
use App\Models\Category;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateHalamanRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class StrukturOrganisasi extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-struktur-organisasi')->only(['index', 'show']);
        $this->middleware('can:admin-struktur-organisasi.create')->only(['create', 'store']);
        $this->middleware('can:admin-struktur-organisasi.edit')->only(['edit', 'update']);
        $this->middleware('can:admin-struktur-organisasi.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Artikel::where('jenis', 'page')->where('idkategori', '=', 'struktur-organisasi')->select('*');

        $artikel = $qry->when($request->input('search'), function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate($limit);
        $title = 'Struktur Organisasi';
        return view('pages.v3.admin-struktur-organisasi.index', compact('title', 'artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Struktur Organisasi';
        $category_id = Category::where('slug', '=', 'struktur-organisasi')->first()->id ?? null;
        return view('pages.v3.admin-struktur-organisasi.create', compact('title', 'category_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateHalamanRequest $request)
    {
        DB::beginTransaction();
        $title = $request->input('title');
        $imagePath = null;
        $validate = $request->validated();

        $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
        if ($request->hasFile('foto_unggulan')) {
            $foto_unggulan = $request->file('foto_unggulan');
            $extFile = $foto_unggulan->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $foto_unggulan->storeAs('artikel', $nameFile, 'public');
            $thumbnail = $foto_unggulan->storeAs('thumb/artikel', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 1200 || $height >= 800) {
                    ImageResize::createThumbnail($smallthumbnailpath, 1200, 800);
                }
            }
            $smallthumbnailpath = public_path('storage/thumb/artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 200 || $height >= 185) {
                ImageResize::createThumbnail($smallthumbnailpath, 200, 185);
            }
        }
        Artikel::create([
            'iduser' => auth()->user()->id,
            'title' => $title,
            'slug' => $slug,
            'status' => $request->input('status'),
            'idkategori' => 'struktur-organisasi',
            'jenis' => 'page',
            'foto_unggulan' => $imagePath,
        ]);

        DB::commit();
        return redirect(route('admin-struktur-organisasi.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $admin_struktur_organisasi)
    {
        $title = 'Struktur Organisasi';
        return view('pages.v3.admin-struktur-organisasi.edit', compact('title', 'admin_struktur_organisasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHalamanRequest $request, Artikel $admin_struktur_organisasi)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $title = $request->input('title');
        $slug = $admin_struktur_organisasi->slug;
        $deskripsi = $request->input('deskripsi');

        if ($admin_struktur_organisasi->title != $title) {
            $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
        }
        $imagePath = $admin_struktur_organisasi->foto_unggulan;
        if ($request->hasFile('foto_unggulan')) {
            $foto_unggulan = $request->file('foto_unggulan');
            $extFile = $foto_unggulan->getClientOriginalExtension();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Storage::disk('public')->delete('thumb/' . $imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $foto_unggulan->storeAs('artikel', $nameFile, 'public');
            $thumbnail = $foto_unggulan->storeAs('thumb/artikel', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 1200 || $height >= 800) {
                    ImageResize::createThumbnail($smallthumbnailpath, 1200, 800);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 200 || $height >= 185) {
                ImageResize::createThumbnail($smallthumbnailpath, 200, 185);
            }
        }
        $validate['slug'] = $slug;
        $validate['status'] = $request->input('status');
        $validate['idkategori'] = 'struktur-organisasi';
        $validate['jenis'] = 'page';
        $validate['foto_unggulan'] = $imagePath;
        $admin_struktur_organisasi->update($validate);

        DB::commit();
        return redirect(route('admin-struktur-organisasi.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $admin_struktur_organisasi)
    {
        DB::beginTransaction();
        $imagePath = $admin_struktur_organisasi->foto_unggulan;
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $admin_struktur_organisasi->title,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
        }
        $admin_struktur_organisasi->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
