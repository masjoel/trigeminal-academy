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

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:galeri-video')->only(['index', 'show']);
        $this->middleware('can:galeri-video.create')->only(['create', 'store']);
        $this->middleware('can:galeri-video.edit')->only(['edit', 'update']);
        $this->middleware('can:galeri-video.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Artikel::leftjoin('categories', 'categories.id', '=', 'artikels.category_id')->where('artikels.jenis', 'post')->where('categories.slug', '=', 'galeri-video')->select('artikels.*');

        $artikel = $qry->when($request->input('search'), function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('artikels.title', 'like', '%' . $search . '%');
            });
        })
            ->orderBy('artikels.id', 'desc')
            ->paginate($limit);
        $title = 'Galeri Video';
        return view('pages.v3.galeri-video.index', compact('title', 'artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Galeri Video';
        $category_id = Category::where('slug', '=', 'galeri-video')->first()->id;
        return view('pages.v3.galeri-video.create', compact('title', 'category_id'));
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
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 400 || $height >= 300) {
                ImageResize::createThumbnail($smallthumbnailpath, 400, 300);
            }
        }
        Artikel::create([
            'user_id' => auth()->user()->id,
            'title' => $title,
            'slug' => $slug,
            'category_id' => $request->input('category_id'),
            'excerpt' => $request->input('excerpt'),
            'status' => $request->input('status'),
            'jenis' => 'post',
            'foto_unggulan' => $imagePath,
        ]);

        DB::commit();
        return redirect(route('galeri-video.index'))->with('success', 'Data berhasil ditambahkan');
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
    public function edit(Artikel $galeri_video)
    {
        $title = 'Edit Video';
        return view('pages.v3.galeri-video.edit', compact('title', 'galeri_video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHalamanRequest $request, Artikel $galeri_video)
    {
        DB::beginTransaction();
        $title = $request->input('title');
        $slug = $galeri_video->slug;
        $deskripsi = $request->input('deskripsi');
        $validate = $request->validated();

        if ($galeri_video->title != $title) {
            $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
        }
        $imagePath = $galeri_video->foto_unggulan;
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
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/artikel/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 400 || $height >= 300) {
                ImageResize::createThumbnail($smallthumbnailpath, 400, 300);
            }
        }
        $validate['slug'] = $slug;
        $validate['excerpt'] = $request->input('excerpt');
        $validate['status'] = $request->input('status');
        $validate['jenis'] = 'post';
        $validate['foto_unggulan'] = $imagePath;
        $galeri_video->update($validate);

        DB::commit();
        return redirect(route('galeri-video.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $galeri_video)
    {
        DB::beginTransaction();
        $imagePath = $galeri_video->foto_unggulan;
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $galeri_video->title,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
        }
        $galeri_video->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
