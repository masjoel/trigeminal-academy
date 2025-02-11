<?php

namespace App\Http\Controllers\Webdesa;

use Ramsey\Uuid\Uuid;
use App\Models\Artikel;
use App\Models\Halaman;
use App\Models\ImageResize;
use App\Models\ImageArticle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateHalamanRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class HalamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:halaman')->only(['index', 'show']);
        $this->middleware('can:halaman.create')->only(['create', 'store']);
        $this->middleware('can:halaman.edit')->only(['edit', 'update']);
        $this->middleware('can:halaman.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Artikel::where('jenis', 'page')->where('idkategori', '!=', 'struktur-organisasi');

        $artikel = $qry->when($request->input('search'), function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate($limit);
        $title = 'Halaman';
        return view('pages.v3.halaman.index', compact('title', 'artikel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Halaman';
        $kategori = [
            "home" => "Beranda",
            "about" => "Tentang kami",
            "kontak" => "Kontak",
            // "visimisi" => "Visi Misi",
            // "sejarah" => "Sejarah Desa",
            // "geografis" => "Geografis Desa",
            // "demografi" => "Demografi Desa",
            // "sotk" => "Struktur Organisasi",
            // "perangkat" => "Perangkat Desa",
            // "lembaga" => "Lembaga Desa",
        ];
        return view('pages.v3.halaman.create', compact('title', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateHalamanRequest $request)
    {
        DB::beginTransaction();
        $title = $request->input('title');
        $deskripsi = $request->input('deskripsi');
        $validate = $request->validated();

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
        $save = Artikel::create([
            'title' => $title,
            'slug' => $slug,
            'idkategori' => $request->input('idkategori'),
            'deskripsi' => $deskripsi,
            'status' => $request->input('status'),
            'jenis' => 'page',
        ]);
        if (isset($dataImageArticle)) {
            foreach ($dataImageArticle as $key => $value) {
                $dataImageArticle['artikel_id'] = $save->id;
                $dataImageArticle['image'] = $value;
                ImageArticle::create($dataImageArticle);
            }
        }

        DB::commit();
        return redirect(route('halaman.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Halaman $halaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Halaman $halaman)
    {
        $kategori = [
            "home" => "Beranda",
            "about" => "Tentang kami",
            "kontak" => "Kontak",
            // "visimisi" => "Visi Misi",
            // "sejarah" => "Sejarah Desa",
            // "geografis" => "Geografis Desa",
            // "demografi" => "Demografi Desa",
            // "sotk" => "Struktur Organisasi",
            // "perangkat" => "Perangkat Desa",
            // "lembaga" => "Lembaga Desa",
        ];
        return view('pages.v3.halaman.edit')->with(['artikel' => $halaman, 'title' => 'Edit Halaman', 'kategori' => $kategori]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHalamanRequest $request, Halaman $halaman)
    {
        DB::beginTransaction();
        try {
            $validate = $request->validated();
            $title = $request->input('title');
            $slug = $halaman->slug;
            $category_id = $request->input('category_id');
            $deskripsi = $request->input('deskripsi');

            if ($halaman->title != $title) {
                $slug = SlugService::createSlug(Artikel::class, 'slug', $request->title);
            }

            $path = 'file_artikel/';
            $dataImageArticle = [];
            $gambarLama = ImageArticle::where('artikel_id', $halaman->id)->pluck('image')->toArray();
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
                ImageArticle::where('artikel_id', $halaman->id)->where('image', $gambar)->delete();
            }

            // Simpan gambar baru ke database
            foreach ($dataImageArticle as $imagePath) {
                ImageArticle::create([
                    'artikel_id' => $halaman->id,
                    'image' => $imagePath,
                ]);
            }

            // Update artikel
            $validate['slug'] = $slug;
            $validate['excerpt'] = $request->input('excerpt');
            $validate['deskripsi'] = $deskripsi;
            $halaman->update($validate);

            DB::commit();
            return redirect(route('halaman.index'))->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('halaman.index'))->with('success', 'Data gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Halaman $halaman)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $halaman->title,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        $hapus = ImageArticle::where('artikel_id', $halaman->id)->get();
        foreach ($hapus as $value) {
            Storage::disk('public')->delete($value->image);
        }
        ImageArticle::where('artikel_id', $halaman->id)->delete();

        $halaman->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
