<?php

namespace App\Http\Controllers\Webdesa;

use Ramsey\Uuid\Uuid;
use App\Models\Artikel;
use App\Models\Category;
use App\Models\ImageResize;
use App\Models\ImageArticle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateHalamanRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class FotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:galeri-foto')->only(['index', 'show']);
        $this->middleware('can:galeri-foto.create')->only(['create', 'store']);
        $this->middleware('can:galeri-foto.edit')->only(['edit', 'update']);
        $this->middleware('can:galeri-foto.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Artikel::leftjoin('categories', 'categories.id', '=', 'artikels.category_id')->where('artikels.jenis', 'post')->where('categories.slug', '=', 'galeri-foto')->select('artikels.*');

        $artikel = $qry->when($request->input('search'), function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('artikels.title', 'like', '%' . $search . '%');
            });
        })
            ->orderBy('artikels.id', 'desc')
            ->paginate($limit);
        $title = 'Galeri Foto';
        return view('backend.galeri-foto.index', compact('title', 'artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Galeri Foto';
        $category_id = Category::where('slug', '=', 'galeri-foto')->first()->id ?? null;
        return view('backend.galeri-foto.create', compact('title', 'category_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateHalamanRequest $request)
    {
        DB::beginTransaction();
        $title = $request->input('title');
        $deskripsi = $request->input('deskripsi');
        $imagePath = null;
        $validate = $request->validated();

        $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
        preg_match_all('/src=["\']data:image\/([a-zA-Z]*);base64,([^\s"]+)[^>]/', $deskripsi, $matches, PREG_SET_ORDER);

        $path = 'file_artikel/';
        $nama_file = null;
        foreach ($matches as $match) {
            $extension = $match[1];
            $base64_str = $match[2];
            $image = base64_decode($base64_str);
            $nama_file = Uuid::uuid1()->getHex() . '.' . $extension;
            Storage::disk('public')->put($path . $nama_file, $image);
            $smallthumbnailpath = public_path('storage/file_artikel/' . $nama_file);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 1200 || $height >= 800) {
                    ImageResize::createThumbnail($smallthumbnailpath, 1200, 800);
                }
            }
            $dataImageArticle[] = $path . $nama_file;

            $deskripsi =  '<img src="../../storage/' . $path . $nama_file . '">';
        }
        if ($request->hasFile('foto_unggulan')) {
            $foto_unggulan = $request->file('foto_unggulan');
            $extFile = $foto_unggulan->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $foto_unggulan->storeAs('file_artikel', $nameFile, 'public');
            $thumbnail = $foto_unggulan->storeAs('thumb/file_artikel', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/file_artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }
            $smallthumbnailpath = public_path('storage/thumb/file_artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 300 || $height >= 200) {
                ImageResize::createThumbnail($smallthumbnailpath, 300, 200);
            }
        }
        $save = Artikel::create([
            'user_id' => auth()->user()->id,
            'title' => $title,
            'slug' => $slug,
            'category_id' => $request->input('category_id'),
            'excerpt' => $request->input('excerpt'),
            'deskripsi' => $deskripsi,
            'meta_tags' => 'file_artikel/' . $nama_file,
            'status' => $request->input('status'),
            'jenis' => 'post',
            'foto_unggulan' => $imagePath,
        ]);

        if (isset($dataImageArticle)) {
            foreach ($dataImageArticle as $key => $value) {
                $dataImageArticle['artikel_id'] = $save->id;
                $dataImageArticle['image'] = $value;
                ImageArticle::create($dataImageArticle);
            }
        }

        DB::commit();
        return redirect(route('galeri-foto.index'))->with('success', 'Data berhasil ditambahkan');
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
    public function edit(Artikel $galeri_foto)
    {
        $title = 'Edit Foto';
        return view('backend.galeri-foto.edit', compact('title', 'galeri_foto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHalamanRequest $request, Artikel $galeri_foto)
    {
        DB::beginTransaction();
        $title = $request->input('title');
        $slug = $galeri_foto->slug;
        $deskripsi = $request->input('deskripsi');
        $validate = $request->validated();

        if ($galeri_foto->title != $title) {
            $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
        }
        preg_match_all('/src=["\']data:image\/([a-zA-Z]*);base64,([^\s"]+)[^>]/', $deskripsi, $matches, PREG_SET_ORDER);
        $path = 'file_artikel/';
        $nama_file = null;
        if (!empty($matches)) {
            foreach ($matches as $match) {
                $extension = $match[1];
                $base64_str = $match[2];
                $image = base64_decode($base64_str);
                $nama_file = Uuid::uuid1()->getHex() . '.' . $extension;
                Storage::disk('public')->put($path . $nama_file, $image);
                $smallthumbnailpath = public_path('storage/file_artikel/' . $nama_file);
                $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
                if ($imageInfo) {
                    $width = $imageInfo['width'];
                    $height = $imageInfo['height'];
                    if ($width >= 1200 || $height >= 800) {
                        ImageResize::createThumbnail($smallthumbnailpath, 1200, 800);
                    }
                }
                $dataImageArticle[] = $path . $nama_file;
                $deskripsi =  '<img src="../../storage/' . $path . $nama_file . '">';
            }
            $hapus = ImageArticle::where('artikel_id', $galeri_foto->id)->get();
            foreach ($hapus as $value) {
                Storage::disk('public')->delete($value->image);
            }
            ImageArticle::where('artikel_id', $galeri_foto->id)->delete();
            $dataImageArticle = array_unique($dataImageArticle);
            foreach ($dataImageArticle as $key => $value) {
                $dataImageArticle['artikel_id'] = $galeri_foto->id;
                $dataImageArticle['image'] = $value;
                ImageArticle::create($dataImageArticle);
            }
        }
        $imagePath = $galeri_foto->foto_unggulan;
        if ($request->hasFile('foto_unggulan')) {
            $foto_unggulan = $request->file('foto_unggulan');
            $extFile = $foto_unggulan->getClientOriginalExtension();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Storage::disk('public')->delete('thumb/' . $imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $foto_unggulan->storeAs('file_artikel', $nameFile, 'public');
            $thumbnail = $foto_unggulan->storeAs('thumb/file_artikel', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/file_artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/file_artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 300 || $height >= 200) {
                ImageResize::createThumbnail($smallthumbnailpath, 300, 200);
            }
        }

        $validate['slug'] = $slug;
        $validate['excerpt'] = $request->input('excerpt');
        $validate['deskripsi'] = $deskripsi;
        $validate['meta_tags'] = 'file_artikel/' . $nama_file;
        $validate['status'] = $request->input('status');
        $validate['jenis'] = 'post';
        $validate['foto_unggulan'] = $imagePath;
        $galeri_foto->update($validate);

        DB::commit();
        return redirect(route('galeri-foto.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $galeri_foto)
    {
        DB::beginTransaction();
        $imagePath = $galeri_foto->foto_unggulan;
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $galeri_foto->title,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
        }
        $hapus = ImageArticle::where('artikel_id', $galeri_foto->id)->get();
        foreach ($hapus as $value) {
            Storage::disk('public')->delete($value->image);
        }
        ImageArticle::where('artikel_id', $galeri_foto->id)->delete();
        $galeri_foto->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
