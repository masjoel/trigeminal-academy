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

class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:artikel')->only(['index', 'show']);
        $this->middleware('can:artikel.create')->only(['create', 'store']);
        $this->middleware('can:artikel.edit')->only(['edit', 'update']);
        $this->middleware('can:artikel.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Artikel::leftjoin('categories', 'categories.id', '=', 'artikels.category_id')->where('artikels.jenis', 'post')->where('categories.slug', 'not like', '%galeri%')->where('categories.slug', 'not like', '%perpusdes%')->select('artikels.*');

        $artikel = $qry->when($request->input('search'), function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('artikels.title', 'like', '%' . $search . '%');
            });
        })
            ->orderBy('artikels.id', 'desc')
            ->paginate($limit);
        $title = 'Artikel';
        return view('pages.v3.artikel.index', compact('title', 'artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Artikel';
        $categories = Category::where('slug', 'not like', '%galeri%')->where('slug', 'not like', 'perpusdes')->get();
        return view('pages.v3.artikel.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateHalamanRequest $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $title = $request->input('title');
        $deskripsi = $request->input('deskripsi');
        $imagePath = null;

        $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
        preg_match_all('/src=["\']data:image\/([a-zA-Z]*);base64,([^\s"]+)[^>]/', $deskripsi, $matches, PREG_SET_ORDER);

        $path = 'file_artikel/';
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

            $deskripsi = str_replace('data:image/' . $extension . ';base64,' . $base64_str, '../../storage/' . $path . $nama_file, $deskripsi);
        }
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
                if ($width >= 300 || $height >= 200) {
                    ImageResize::createThumbnail($smallthumbnailpath, 300, 200);
                }
            }
        }
        $save = Artikel::create([
            'user_id' => auth()->user()->id,
            'title' => $title,
            'slug' => $slug,
            'category_id' => $request->input('category_id'),
            'excerpt' => $request->input('excerpt'),
            'deskripsi' => $deskripsi,
            'status' => $request->input('status'),
            'feature' => $request->input('feature'),
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
        return redirect(route('artikel.index'))->with('success', 'Data berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        $categories = Category::where('slug', 'not like', '%galeri%')->where('slug', 'not like', 'perpusdes')->get();
        $title = 'Edit Artikel';
        return view('pages.v3.artikel.edit', compact('title', 'categories', 'artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHalamanRequest $request, Artikel $artikel)
    {
        DB::beginTransaction();
        try {
            $validate = $request->validated();
            $title = $request->input('title');
            $slug = $artikel->slug;
            $category_id = $request->input('category_id');
            $deskripsi = $request->input('deskripsi');

            if ($artikel->title != $title) {
                $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
            }

            $path = 'file_artikel/';
            $dataImageArticle = [];
            $gambarLama = ImageArticle::where('artikel_id', $artikel->id)->pluck('image')->toArray();
            $gambarYangMasihDigunakan = [];

            // Deteksi semua gambar dalam deskripsi, baik base64 maupun yang sudah tersimpan
            preg_match_all('/<img.*?src=["\'](.*?)["\'].*?>/i', $deskripsi, $matches);

            if (!empty($matches[1])) {
                foreach ($matches[1] as $src) {
                    if (str_starts_with($src, 'data:image/')) {
                        // Jika gambar masih dalam base64, simpan sebagai file baru
                        preg_match('/data:image\/([a-zA-Z]*);base64,([^"]+)/', $src, $match);
                        $extension = $match[1];
                        $base64_str = $match[2];
                        $image = base64_decode($base64_str);
                        $nama_file = Uuid::uuid1()->getHex() . '.' . $extension;

                        Storage::disk('public')->put($path . $nama_file, $image);
                        $dataImageArticle[] = $path . $nama_file;

                        // Ubah src di deskripsi menjadi path gambar yang tersimpan
                        $deskripsi = str_replace($src, '../../storage/' . $path . $nama_file, $deskripsi);
                    } elseif (str_contains($src, '../../storage/')) {
                        // Jika gambar lama masih ada dalam deskripsi, jangan hapus
                        $relativePath = str_replace('../../storage/', '', $src);
                        if (in_array($relativePath, $gambarLama)) {
                            $gambarYangMasihDigunakan[] = $relativePath;
                        }
                    }
                }
            }

            // Hapus gambar yang tidak lagi digunakan dalam deskripsi
            $gambarYangHarusDihapus = array_diff($gambarLama, $gambarYangMasihDigunakan);
            foreach ($gambarYangHarusDihapus as $gambar) {
                Storage::disk('public')->delete($gambar);
                ImageArticle::where('artikel_id', $artikel->id)->where('image', $gambar)->delete();
            }

            // Simpan gambar baru ke database
            foreach ($dataImageArticle as $imagePath) {
                ImageArticle::create([
                    'artikel_id' => $artikel->id,
                    'image' => $imagePath,
                ]);
            }

            // Update artikel
            $imagePath = $artikel->foto_unggulan;
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
                if ($width >= 300 || $height >= 200) {
                    ImageResize::createThumbnail($smallthumbnailpath, 300, 200);
                }
            }

            $validate['slug'] = $slug;
            $validate['excerpt'] = $request->input('excerpt');
            $validate['deskripsi'] = $deskripsi;
            $validate['category_id'] = $category_id;
            $validate['status'] = $request->input('status');
            $validate['feature'] = $request->input('feature');
            $validate['jenis'] = 'post';
            $validate['foto_unggulan'] = $imagePath;
            $artikel->update($validate);

            DB::commit();
            return redirect(route('artikel.index'))->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('artikel.index'))->with('success', 'Data gagal diupdate');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        DB::beginTransaction();
        $imagePath = $artikel->foto_unggulan;
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $artikel->category->kategori . ' - ' . $artikel->title,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
        }
        $hapus = ImageArticle::where('artikel_id', $artikel->id)->get();
        foreach ($hapus as $value) {
            Storage::disk('public')->delete($value->image);
        }
        ImageArticle::where('artikel_id', $artikel->id)->delete();
        $artikel->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
