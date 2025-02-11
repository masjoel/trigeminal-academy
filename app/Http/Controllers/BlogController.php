<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Artikel;
use App\Models\Halaman;
use App\Models\Category;
use App\Models\FiturPost;
use Illuminate\Http\Request;
use App\Models\AdpddMutasi;
use PhpParser\Node\Expr\Cast;
use Illuminate\Support\Facades\DB;
use App\Models\AdpddInduk;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $title = '';
        $search = $request->input('search');
        $category = $request->slug;
        $blogtitle = 'Blog ' . klien('nama_client');
        $blogcaption = 'mengenal lebih dekat ' . klien('nama_client');
        // if (request('category')) {
        //     $category = Category::firstWhere('slug', request('category'));
        //     $title = " in $category->kategori";
        // }
        // if (request('author')) {
        //     $author = User::firstWhere('username', request('author'));
        //     $title = " by $author->fullname";
        // }
        // $po = Artikel::where(['jenis' => 'post', 'status' => 'published'])->latest()->filter(request(['search', 'category', 'author']))->paginate(10)->withQueryString();
        $po = Artikel::where('artikels.status', 'published')->where('artikels.jenis', 'post')
            ->leftJoin('categories', 'artikels.category_id', '=', 'categories.id')
            ->select('artikels.*')
            ->when($search, function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('artikels.title', 'like', '%' . $search . '%')
                        ->orWhere('artikels.excerpt', 'like', '%' . $search . '%')
                        ->orWhere('artikels.deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->when($category, function ($query, $category) {
                $query->where(function ($subquery) use ($category) {
                    $subquery->where('categories.slug', '=', $category);
                });
            })
            ->orderBy('artikels.id', 'desc')
            ->paginate(10);

        // $terbaru = Artikel::where(['jenis' => 'post', 'status' => 'published'])->latest()->limit(3)->get();
        $terbaru = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', 'not like', '%galeri%')
            ->select('artikels.*')
            ->latest()->limit(5)->get();

        // $mCategories = Category::where('tipe', 'post')->get();
        $categories = Category::select('categories.id', 'categories.slug', 'categories.kategori', DB::raw('COUNT(artikels.id) as total_article'))
            ->leftJoin('artikels', 'artikels.category_id', '=', 'categories.id')
            ->where(['artikels.status' => 'published', 'categories.tipe' => 'post'])
            ->where('categories.slug', 'not like', '%galeri%')
            ->groupBy('categories.id', 'categories.slug', 'categories.kategori')->get();

        $data = [
            'title' => 'All Post' . $title,
            'posts' => $po,
            'terbaru' => $terbaru,
            'blogtitle' => $blogtitle,
            'categories' => $categories,
            'blogcaption' => $blogcaption,
        ];
        return view('blog.post', $data);
    }
    // public function apbdesa(Request $request)
    // {
    //     $varpost = Artikel::where(['jenis' => 'sid', 'status' => 'published', 'idkategori' => 'data-rpjm'])
    //         ->orWhere(['idkategori' => 'data-rpk'])
    //         ->orWhere(['idkategori' => 'data-apbdes'])
    //         ->latest()->first();

    //     $data_apbdes = null;
    //     if ($varpost !== null) {
    //         if ($varpost->idkategori == 'data-apbdes') {
    //             if (url('api') == klien('endpoint') || klien('endpoint') == null) {
    //                 $data_apbdes = [];
    //             } else {
    //                 $data_apbdes = getSid('data-apbdes', 'data-apbdes');
    //                 if ($request->input('search') !== null) {
    //                     $data_apbdes = getSid('data-apbdes', 'data-apbdes', $request->input('search'));
    //                 }
    //             }
    //         }
    //     }
    //     $title = 'Blog';
    //     $posts = $varpost;
    //     $tahun = $request->input('search') !== null ? $request->input('search') : date('Y');
    //     return view('blog.apbdpost', compact('title', 'posts', 'data_apbdes', 'tahun'));
    // }
    // public function lembagaDesa(Request $request)
    // {
    //     $varpost = Artikel::where(['jenis' => 'sid', 'status' => 'published', 'idkategori' => 'data-lembaga'])
    //         ->latest()->first();
    //     $data_lembaga = null;
    //     if ($varpost !== null) {
    //         if ($varpost->idkategori == 'data-lembaga') {
    //             if (url('api') == klien('endpoint') || klien('endpoint') == null) {
    //                 $data_lembaga = [];
    //             } else {
    //                 $data_lembaga = getSid('data-lembaga', 'data-lembaga');
    //                 if ($request->input('search') !== null) {
    //                     $data_lembaga = getSid('data-lembaga', 'data-lembaga', $request->input('search'));
    //                 }
    //             }
    //         }
    //     }
    //     // dd($data_lembaga);
    //     $title = 'Blog';
    //     $posts = $varpost;
    //     $tahun = $request->input('search') !== null ? $request->input('search') : date('Y');
    //     return view('blog.lembagapost', compact('title', 'posts', 'data_lembaga'));
    // }
    // public function lembagaDesaDetail(Request $request)
    // {
    //     $varpost = Artikel::where(['jenis' => 'sid', 'status' => 'published', 'idkategori' => 'data-lembaga'])
    //         ->latest()->first();

    //     $data_lembaga = null;
    //     if ($varpost->idkategori == 'data-lembaga') {
    //         if (url('api') == klien('endpoint') || klien('endpoint') == null) {
    //             $data_lembaga = [];
    //         } else {
    //             $data_lembaga = getSid('data-lembaga', 'data-lembaga');
    //             if ($request->slug !== null) {
    //                 $data_lembaga = getSid('data-lembaga', 'data-lembaga', $request->slug);
    //             }
    //         }
    //     }
    //     // dd($data_lembaga);
    //     $title = 'Blog';
    //     $posts = $varpost;
    //     return view('blog.lembagapost-detail', compact('title', 'posts', 'data_lembaga'));
    // }
    public function produk()
    {
        $title = '';
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = " in $category->kategori";
        }
        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = " by $author->fullname";
        }
        $po = Artikel::where(['jenis' => 'product', 'status' => 'published'])->latest()->filter(request(['search', 'category', 'author']))->paginate(10)->withQueryString();
        $mCategories = Category::where('tipe', 'product')->get();
        $data = [
            'title' => 'All Post' . $title, 'mCategories' => $mCategories,
            'posts' => $po
        ];
        return view('produk.post', $data);
    }
    public function show(Artikel $varpost)
    {
        $po = Artikel::where(['jenis' => 'post', 'status' => 'published'])->latest()->filter(request(['search', 'category', 'author']))->paginate(10)->withQueryString();
        // $terbaru = Artikel::where(['jenis' => 'post', 'status' => 'published'])->latest()->limit(3)->get();
        $terbaru = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', 'not like', '%galeri%')
            ->select('artikels.*')
            ->latest()->limit(5)->get();

        $categories = Category::select('categories.id', 'categories.slug', 'categories.kategori', DB::raw('COUNT(artikels.id) as total_article'))
            ->leftJoin('artikels', 'artikels.category_id', '=', 'categories.id')
            ->where(['artikels.status' => 'published', 'categories.tipe' => 'post'])
            ->where('categories.slug', 'not like', '%galeri%')
            ->groupBy('categories.id', 'categories.slug', 'categories.kategori')->get();

        if (url('api') == klien('endpoint') || klien('endpoint') == null) {
            $statistics = null;
        } else {
            // include('SID/endpoint/statistik-jumlahpenduduk.php');
            $statistics = getSid('statistik/jumlahpenduduk', 'jumlahpenduduk');
        }
        $data_hub_klg = null;
        $data_pekerjaan = null;
        $data_pendidikan = null;
        $data_usia = null;
        $v_usia = null;
        $u_lk = [];
        $u_pr = [];
        $data_jkn = null;
        $jkn_label = [];
        $jkn_data = [];
        $jkn_color = [];
        $i = 0;
        $wn = [
            'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-primary',
        ];
        if ($varpost->idkategori == 'data-penduduk') {
            $v_usia = ['0 - 3th', '4 - 5th', '6 - 12th', '13 - 16th', '17th', '18 - 25th', '26 - 30th', '31 - 35th', '36 - 40th', '41 - 65th', '66 - 70th', '71 - 80th', '> 80th'];
            if (url('api') == klien('endpoint') || klien('endpoint') == null) {
                $data_usia = null;
            } else {
                // include('SID/endpoint/statistik-data-penduduk.php');
                $usia = getSid('statistik/data-penduduk', 'penduduk');
                $usia = array_combine($v_usia, $usia);
                $data_usia = [];
                foreach ($usia as $key => $j) {
                    $u_lk[] = $j['lk'];
                    $u_pr[] = $j['pr'];

                    $data_usia[] = [
                        'usia' => $key,
                        'pria' => $j['lk'],
                        'wanita' => $j['pr'],
                        'total' => $j['lk'] + $j['pr'],
                    ];
                }
            }
        }
        if ($varpost->idkategori == 'data-pendidikan') {
            if (url('api') == klien('endpoint') || klien('endpoint') == null) {
                $data_pendidikan[] = [
                    'pendidikan' => null,
                    'pria' => null,
                    'wanita' => null,
                    'total' => null,
                ];
            } else {
                // include('SID/endpoint/statistik-data-pendidikan.php');
                $data_pendidikan = getSid('statistik/data-pendidikan', 'pendidikan');
            }
        }
        if ($varpost->idkategori == 'data-pekerjaan') {
            if (url('api') == klien('endpoint') || klien('endpoint') == null) {
                $data_pekerjaan = [];

                $data_pekerjaan[] = [
                    'pekerjaan' => null,
                    'pria' => null,
                    'wanita' => null,
                    'total' => null,
                ];
            } else {
                // include('SID/endpoint/statistik-data-pekerjaan.php');
                $data_pekerjaan = getSid('statistik/data-pekerjaan', 'pekerjaan');
            }
        }
        if ($varpost->idkategori == 'data-hub-keluarga') {
            if (url('api') == klien('endpoint') || klien('endpoint') == null) {
                $data_hub_klg = [];
                $data_hub_klg[] = [
                    'hubungan' => null,
                    'pria' => null,
                    'wanita' => null,
                    'total' => null,
                ];
            } else {
                // include('SID/endpoint/statistik-data-hub-keluarga.php');
                $data_hub_klg = getSid('statistik/data-hub-keluarga', 'hub-keluarga');
            }
        }
        if ($varpost->idkategori == 'data-jkn') {
            $color = [
                'blue', 'cyan', 'green', 'red', 'orange', 'teal', 'yellow', 'purple', 'pink', 'indigo', 'lime', 'gray', 'brown', 'amber'
            ];
            if (url('api') == klien('endpoint') || klien('endpoint') == null) {
                $data_jkn = [];
                $jkn_label[] = null;
                $jkn_data[] = null;
                $jkn_color[] = null;

                $data_jkn[] = [
                    'jkn' => null,
                    'pria' => null,
                    'wanita' => null,
                    'total' => null,
                ];
            } else {
                // include('SID/endpoint/statistik-data-jkn.php');
                $value = getSid('statistik/data-jkn', 'jkn');
                $data_jkn = $value['rows'];
                $jkn_label = $value['jkn_label'];
                $jkn_data = $value['jkn_data'];
                $jkn_color = $value['jkn_color'];
            }
        }

        $title = 'Blog';
        $posts = $varpost;
        $mPost = $po;
        return view('blog.singlepost', compact('title', 'categories', 'posts', 'mPost', 'statistics', 'data_jkn', 'jkn_label', 'jkn_data', 'jkn_color', 'data_hub_klg', 'data_pekerjaan', 'data_pendidikan', 'v_usia', 'data_usia', 'terbaru', 'u_lk', 'u_pr', 'wn'));
    }
    public function categories()
    {
        return view('categories', [
            'title' => 'Post Categories', 'active' => 'categories',
            'categories' => Category::tipe('post')
        ]);
    }
}
