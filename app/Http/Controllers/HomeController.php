<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Anggota;
use App\Models\Artikel;
use App\Models\Halaman;
use App\Models\Product;
use App\Models\Provinsi;
use App\Models\OrderItem;
use App\Models\ImageResize;
use App\Models\Slidebanner;
use App\Models\ProfilBisnis;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SID\StorePendudukReq;
use Cviebrock\EloquentSluggable\Services\SlugService;

class HomeController extends Controller
{
    function index(Request $request)
    {
        $profil_usaha = ProfilBisnis::first();
        $feature = Artikel::where('jenis', 'post')->where('status', 'published')->where('feature', '1')->latest()->first();
        $berita = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')
            // ->where('categories.slug', '=', 'berita')
            ->select('artikels.*')
            ->latest()->first();
        $berita2 = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')
            // ->where('categories.slug', '=', 'berita')
            ->select('artikels.*')
            ->latest()->limit(2)->get();
        $berita3 = $berita == null ? [] : Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')
            // ->where('categories.slug', '=', 'berita')
            ->where('artikels.id', '!=', $berita->id)
            ->select('artikels.*')
            ->latest()->limit(4)->get();
        $pengumuman = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'pengumuman')
            ->select('artikels.*')
            ->latest()->first();
        $pengumuman3 =  $pengumuman == null ? [] : Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'pengumuman')
            ->where('artikels.id', '!=', $pengumuman->id)
            ->select('artikels.*')
            ->latest()->limit(3)->get();
        $agenda = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'agenda-kegiatan')
            ->select('artikels.*')
            ->latest()->first();
        $agenda3 =  $agenda == null ? [] : Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'agenda-kegiatan')
            ->where('artikels.id', '!=', $agenda->id)
            ->select('artikels.*')
            ->latest()->limit(3)->get();
        $video = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'galeri-video')
            ->select('artikels.*')
            ->latest()->limit(9)->get();
        $foto = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'galeri-foto')
            ->select('artikels.*')
            ->latest()->limit(9)->get();
        $top_stories = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', 'not like', '%galeri%')
            ->select('artikels.*')
            ->latest()->limit(5)->get();
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'home')->latest()->first();
        $section1 = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'section1')->latest()->first();
        $faq = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'faq')->latest()->first();
        $tentang_kami = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'about')->latest()->first();
        $kontak_kami = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'kontak')->latest()->first();

        $qry_artikel = Artikel::select('artikels.*')->leftJoin('categories', 'categories.id', '=', 'artikels.category_id')->where('categories.slug', '!=', 'sid')->where('jenis', 'post')->where('artikels.status', 'published');
        $qry_sid = Halaman::where('jenis', 'sid')->where('status', 'published');
        $sid = null;
        $artikel = null;
        if ($qry_sid->count() > 0) {
            $sid = $qry_sid->latest()->get();
        }
        if ($qry_artikel->count() > 0) {
            $artikel = $qry_artikel->limit(3)->latest()->get();
        }
        $banner = Slidebanner::where('status', 'publish')->limit(3)->latest()->get();
        $galeries = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', 'like', '%galeri%')
            ->select('artikels.*')
            ->latest()->limit(9)->get();

        $title = klien('nama_client') == null ? 'LMS' : klien('nama_client');
        $courses = Product::with('productCategory', 'instruktur', 'orderitems')->where('publish', '1')->limit(4)->latest()->get();

        return view('frontend.beranda', compact('title', 'profil_usaha', 'artikel', 'banner', 'halaman', 'sid', 'tentang_kami', 'kontak_kami', 'feature', 'berita', 'berita2', 'berita3', 'pengumuman', 'pengumuman3', 'top_stories', 'video', 'agenda', 'agenda3', 'galeries', 'foto', 'courses', 'section1', 'faq'));
    }
    function slide()
    {
        return view('slide');
    }
    function exampleProductDetail(Request $request)
    {
        $profil_usaha = ProfilBisnis::first();
        $feature = Artikel::where('jenis', 'post')->where('status', 'published')->where('feature', '1')->latest()->first();
        $berita = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'berita')
            ->select('artikels.*')
            ->latest()->first();
        $berita2 = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'berita')
            ->select('artikels.*')
            ->latest()->limit(2)->get();
        $berita3 = $berita == null ? [] : Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'berita')
            ->where('artikels.id', '!=', $berita->id)
            ->select('artikels.*')
            ->latest()->limit(4)->get();
        $pengumuman = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'pengumuman')
            ->select('artikels.*')
            ->latest()->first();
        $pengumuman3 =  $pengumuman == null ? [] : Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'pengumuman')
            ->where('artikels.id', '!=', $pengumuman->id)
            ->select('artikels.*')
            ->latest()->limit(3)->get();
        $agenda = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'agenda-kegiatan')
            ->select('artikels.*')
            ->latest()->first();
        $agenda3 =  $agenda == null ? [] : Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'agenda-kegiatan')
            ->where('artikels.id', '!=', $agenda->id)
            ->select('artikels.*')
            ->latest()->limit(3)->get();
        $video = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'galeri-video')
            ->select('artikels.*')
            ->latest()->limit(9)->get();
        $foto = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'galeri-foto')
            ->select('artikels.*')
            ->latest()->limit(9)->get();
        $top_stories = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', 'not like', '%galeri%')
            ->select('artikels.*')
            ->latest()->limit(5)->get();
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'home')->latest()->first();
        $tentang_kami = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'about')->latest()->first();
        $kontak_kami = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'kontak')->latest()->first();

        $qry_artikel = Artikel::select('artikels.*')->leftJoin('categories', 'categories.id', '=', 'artikels.category_id')->where('categories.slug', '!=', 'sid')->where('jenis', 'post')->where('artikels.status', 'published');
        $qry_sid = Halaman::where('jenis', 'sid')->where('status', 'published');
        $sid = null;
        $artikel = null;
        if ($qry_sid->count() > 0) {
            $sid = $qry_sid->latest()->get();
        }
        if ($qry_artikel->count() > 0) {
            $artikel = $qry_artikel->limit(3)->latest()->get();
        }
        $banner = Slidebanner::where('status', 'publish')->limit(3)->latest()->get();
        $perangkatdesa = PerangkatDesa::where('status', 'Aktif')->get();
        $galeries = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', 'like', '%galeri%')
            ->select('artikels.*')
            ->latest()->limit(9)->get();

        $title = klien('nama_client') == null ? 'Desa Klampok' : klien('nama_client');

        return view('frontend.example-product-detail', compact('title', 'profil_usaha', 'artikel', 'banner', 'halaman', 'sid', 'tentang_kami', 'kontak_kami', 'feature', 'berita', 'berita2', 'berita3', 'pengumuman', 'pengumuman3', 'top_stories', 'video', 'agenda', 'agenda3', 'galeries', 'perangkatdesa', 'foto'));
    }


    public function about()
    {
        $title = 'Tentang ' . klien('nama_client') == null ? 'LMS' : klien('nama_client');;
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'about')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function kontak()
    {
        $title = 'Kontak';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'kontak')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function visimisi()
    {
        $title = 'Visi & Misi';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'visimisi')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }

    public function precise()
    {
        $title = 'Precise';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'precise')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function regenerativePainSchool()
    {
        $title = 'Regenerative Pain School';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'regenerative-pain-school')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function painscope()
    {
        $title = 'Painscope';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'painscope')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function galery(Request $request)
    {
        $title = '';
        $search = $request->input('search');
        $category = $request->slug;
        $title = 'Galery Foto & Video';
        $foto = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'galeri-foto')
            ->select('artikels.*')
            ->when($search, function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('artikels.title', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('artikels.id', 'desc')
            ->paginate(12);
        $video = Artikel::leftJoin('categories', 'categories.id', '=', 'artikels.category_id')
            ->where('artikels.jenis', 'post')->where('artikels.status', 'published')->where('categories.slug', '=', 'galeri-video')
            ->select('artikels.*')
            ->when($search, function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('artikels.title', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('artikels.id', 'desc')
            ->paginate(12);

        return view('frontend.hlm-galeri', compact('title', 'foto', 'video'));
    }
    public function download()
    {
        $title = 'Download';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'download')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }

    public function aktivasi(Request $request)
    {
        DB::beginTransaction();
        // $mac = getMacAddressLinux();
        $mac = cekAktivasi()['mcad'];
        $data = $request->all();
        $profilBisnis = ProfilBisnis::first();
        $data['mcad'] = $mac;
        $data['init'] = $request->kode;
        $profilBisnis->update($data);
        DB::commit();
        return redirect(route('login'));
    }
    public function login(Request $request)
    {
        return redirect('/');
    }
    public function mymap(Request $request)
    {
        return view('map-leaflet');
    }
    public function registrasi()
    {
        $title = 'Formulir Pendaftaran Anggota';
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $pendidikan = ['SD', 'SMP', 'SMA', 'D1', 'D3', 'D4', 'S1', 'S2', 'S3'];
        $pekerjaan = ['PNS', 'TNI', 'POLRI', 'SWASTA', 'WIRAUSAHA'];
        $keperluan = ['pelayanan masyarakat', 'studi banding', 'kunjungan kerja', 'sosialisasi', 'bertamu'];
        $provinsi = Provinsi::all();

        return view('pages.form-anggota', compact(
            'title',
            'jenis_kelamin',
            'pendidikan',
            'pekerjaan',
            'keperluan',
            'provinsi'
        ));
    }
    public function detailKelas($slug)
    {
        $title = 'Detail Kelas';
        $course = Product::with('productCategory', 'instruktur', 'productContent', 'orderitems')->where('slug', $slug)->where('publish', '1')->limit(3)->firstOrFail();

        return view('frontend.detail-kelas', compact('title', 'course'));
    }
}
