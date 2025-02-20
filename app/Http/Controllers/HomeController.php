<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Anggota;
use App\Models\Artikel;
use App\Models\Halaman;
use App\Models\Provinsi;
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

        return view('frontend.beranda', compact('title', 'profil_usaha', 'artikel', 'banner', 'halaman', 'sid', 'tentang_kami', 'kontak_kami', 'feature', 'berita', 'berita2', 'berita3', 'pengumuman', 'pengumuman3', 'top_stories', 'video', 'agenda', 'agenda3', 'galeries', 'perangkatdesa', 'foto'));
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
        $title = 'Tentang ' . klien('nama_client') == null ? 'Desa Klampok' : klien('nama_client');;
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
    public function sejarah()
    {
        $title = 'Sejarah Desa';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'sejarah')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function geografis()
    {
        $title = 'Geografis Desa';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'geografis')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function demografi()
    {
        $title = 'Demografi Desa';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'demografi')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function sotk()
    {
        $title = 'Struktur Organisasi';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'struktur-organisasi')->latest()->first();
        return view('frontend.hlm', compact('title', 'halaman'));
    }
    public function perangkat()
    {
        $title = 'Anggota Pengurus';
        $aparat = PerangkatDesa::where('status', 'Aktif')->orderBy('urut')->get();
        return view('frontend.hlm-perangkat', compact('title', 'aparat'));
    }
    public function perangkatdetail(PerangkatDesa $varpost)
    {
        $title = 'Anggota Pengurus';
        $aparat = PerangkatDesa::with('anggota')->where('status', 'Aktif')->where('id', '!=', $varpost->id)->orderBy('urut')->get();
        $perwakilan = Anggota::where('nik', $varpost->nik)->first();
        // dd($aparat->anggota->wakil_dpd);
        return view('frontend.hlm-perangkat-detail', compact('title', 'varpost', 'aparat', 'perwakilan'));
    }
    public function lembaga()
    {
        $title = 'Lembaga Desa';
        $halaman = Halaman::where('jenis', 'page')->where('status', 'published')->where('idkategori', 'demografi')->latest()->first();
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

    public function potensipenduduk()
    {
        $title = 'Potensi Penduduk';

        $data_hub_klg = null;
        $data_pekerjaan = null;
        $data_pendidikan = [];
        $data_usia = null;
        $v_usia = null;
        $u_lk = [];
        $u_pr = [];
        $data_jkn = null;
        $jkn_label = [];
        $jkn_data = [];
        $jkn_color = [];
        $data_luas_wilayah = null;
        $luas_wilayah_label = [];
        $luas_wilayah_data = [];
        $luas_wilayah_color = [];
        $i = 0;
        $wn = [
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
        ];
        $v_usia = ['0 - 3th', '4 - 5th', '6 - 12th', '13 - 16th', '17th', '18 - 25th', '26 - 30th', '31 - 35th', '36 - 40th', '41 - 65th', '66 - 70th', '71 - 80th', '> 80th'];
        $color = [
            'blue',
            'cyan',
            'green',
            'red',
            'orange',
            'teal',
            'yellow',
            'purple',
            'pink',
            'indigo',
            'lime',
            'gray',
            'brown',
            'amber'
        ];

        // if (url('api') == klien('endpoint') || klien('endpoint') == null) {
        //     $statistics = null;

        //     $data_usia = null;
        //     $data_pendidikan = [];
        //     $data_pekerjaan = [];

        //     $data_pekerjaan[] = [
        //         'pekerjaan' => null,
        //         'pria' => null,
        //         'wanita' => null,
        //         'total' => null,
        //     ];

        //     $data_jkn = [];
        //     $jkn_label[] = null;
        //     $jkn_data[] = null;
        //     $jkn_color[] = null;
        //     $data_sarkantor = [];
        //     $data_sardik = [];
        //     $data_sarkes = [];

        //     $data_batas_wilayah = [];
        //     $data_jenis_lahan = [];
        //     $data_orbitasi = [];
        //     $data_wisata = [];
        // } else {
        // $statistics = getSid('statistik/jumlahpenduduk', 'jumlahpenduduk');
        // $usia = getSid('statistik/data-penduduk', 'penduduk');
        // if (count($usia) > 0) {
        //     $usia = array_combine($v_usia, $usia);
        // }
        // $data_usia = [];
        // foreach ($usia as $key => $j) {
        //     $u_lk[] = $j['lk'];
        //     $u_pr[] = $j['pr'];

        //     $data_usia[] = [
        //         'usia' => $key,
        //         'pria' => $j['lk'],
        //         'wanita' => $j['pr'],
        //         'total' => $j['lk'] + $j['pr'],
        //     ];
        // }

        // $data_pendidikan = getSid('statistik/data-pendidikan', 'pendidikan');
        // $data_pekerjaan = getSid('statistik/data-pekerjaan', 'pekerjaan');

        // $value = getSid('statistik/data-jkn', 'jkn');
        // if (count($value) > 0) {
        //     $data_jkn = $value['rows'];
        //     $jkn_label = $value['jkn_label'];
        //     $jkn_data = $value['jkn_data'];
        //     $jkn_color = $value['jkn_color'];
        // }
        include_once('data/statistik-penduduk.php');
        include_once('data/sarana-kantor.php');
        include_once('data/sarana-pendidikan.php');
        include_once('data/sarana-kesehatan.php');
        include_once('data/potensi-luas-wilayah.php');
        include_once('data/potensi-batas-wilayah.php');
        include_once('data/potensi-jenis-lahan.php');
        include_once('data/potensi-orbitasi.php');
        include_once('data/potensi-wisata.php');

        // $data_sarkantor = getSid('data-sarana-kantor', 'sarana-kantor');
        // $data_sardik = getSid('data-sarana-pendidikan', 'sarana-kantor');
        // $data_sarkes = getSid('data-sarana-kesehatan', 'sarana-kantor');
        // $value = getSid('data-luas-wilayah', 'luas-wilayah');
        // if (count($value) > 0) {
        //     $data_luas_wilayah = $value['rows'];
        //     $luas_wilayah_label = $value['luas_wilayah_label'];
        //     $luas_wilayah_data = $value['luas_wilayah_data'];
        //     $luas_wilayah_color = $value['luas_wilayah_color'];
        // }
        // $data_batas_wilayah = getSid('data-batas-wilayah', 'batas-wilayah');
        // $data_jenis_lahan = getSid('data-jenis-lahan', 'jenis-lahan');
        // $data_orbitasi = getSid('data-orbitasi', 'orbitasi');
        // $data_wisata = getSid('data-wisata', 'wisata');
        // }
        return view('frontend.hlm-potensi-penduduk', compact('title', 'v_usia', 'data_usia', 'u_lk', 'u_pr', 'statistics', 'data_pendidikan', 'data_pekerjaan', 'data_jkn', 'jkn_label', 'jkn_data', 'jkn_color', 'color', 'wn', 'data_sarkantor', 'data_sardik', 'data_sarkes', 'data_luas_wilayah', 'luas_wilayah_label', 'luas_wilayah_data', 'luas_wilayah_color', 'data_batas_wilayah', 'data_jenis_lahan', 'data_orbitasi', 'data_wisata'));
    }
    public function potensiwilayah()
    {
        $title = 'Potensi Wilayah';

        $data_hub_klg = null;
        $data_pekerjaan = null;
        $data_pendidikan = [];
        $data_usia = null;
        $v_usia = null;
        $u_lk = [];
        $u_pr = [];
        $data_jkn = null;
        $jkn_label = [];
        $jkn_data = [];
        $jkn_color = [];
        $data_luas_wilayah = null;
        $luas_wilayah_label = [];
        $luas_wilayah_data = [];
        $luas_wilayah_color = [];
        $i = 0;
        $wn = [
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
        ];
        $v_usia = ['0 - 3th', '4 - 5th', '6 - 12th', '13 - 16th', '17th', '18 - 25th', '26 - 30th', '31 - 35th', '36 - 40th', '41 - 65th', '66 - 70th', '71 - 80th', '> 80th'];
        $color = [
            'blue',
            'cyan',
            'green',
            'red',
            'orange',
            'teal',
            'yellow',
            'purple',
            'pink',
            'indigo',
            'lime',
            'gray',
            'brown',
            'amber'
        ];

        include_once('data/statistik-penduduk.php');
        include_once('data/sarana-kantor.php');
        include_once('data/sarana-pendidikan.php');
        include_once('data/sarana-kesehatan.php');
        include_once('data/potensi-luas-wilayah.php');
        include_once('data/potensi-batas-wilayah.php');
        include_once('data/potensi-jenis-lahan.php');
        include_once('data/potensi-orbitasi.php');
        include_once('data/potensi-wisata.php');

        // $data_sarkantor = getSid('data-sarana-kantor', 'sarana-kantor');
        // $data_sardik = getSid('data-sarana-pendidikan', 'sarana-kantor');
        // $data_sarkes = getSid('data-sarana-kesehatan', 'sarana-kantor');
        // $value = getSid('data-luas-wilayah', 'luas-wilayah');
        // if (count($value) > 0) {
        //     // dd($value);
        //     $data_luas_wilayah = $value;
        //     $luas_wilayah_label = $value['luas_wilayah_label'];
        //     $luas_wilayah_data = $value['luas_wilayah_data'];
        //     $luas_wilayah_color = $value['luas_wilayah_color'];
        // } else {
        //     $data_luas_wilayah = null;
        //     $luas_wilayah_label = null;
        //     $luas_wilayah_data = null;
        //     $luas_wilayah_color = null;
        // }
        //     $data_batas_wilayah = getSid('data-batas-wilayah', 'batas-wilayah');
        //     $data_jenis_lahan = getSid('data-jenis-lahan', 'jenis-lahan');
        //     $data_orbitasi = getSid('data-orbitasi', 'orbitasi');
        //     $data_wisata = getSid('data-wisata', 'wisata');
        // }

        return view('frontend.hlm-potensi-desa', compact('title', 'v_usia', 'data_usia', 'u_lk', 'u_pr', 'statistics', 'data_pendidikan', 'data_pekerjaan', 'data_jkn', 'jkn_label', 'jkn_data', 'jkn_color', 'color', 'wn', 'data_sarkantor', 'data_sardik', 'data_sarkes', 'data_luas_wilayah', 'luas_wilayah_label', 'luas_wilayah_data', 'luas_wilayah_color', 'data_batas_wilayah', 'data_jenis_lahan', 'data_orbitasi', 'data_wisata'));
    }
    public function potensisarana()
    {
        $title = 'Sarana & Prasarana';

        $data_hub_klg = null;
        $data_pekerjaan = null;
        $data_pendidikan = [];
        $data_usia = null;
        $v_usia = null;
        $u_lk = [];
        $u_pr = [];
        $data_jkn = null;
        $jkn_label = [];
        $jkn_data = [];
        $jkn_color = [];
        $data_luas_wilayah = [];
        $luas_wilayah_label = [];
        $luas_wilayah_data = [];
        $luas_wilayah_color = [];
        $i = 0;
        $wn = [
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
            'bg-success',
            'bg-info',
            'bg-warning',
            'bg-danger',
            'bg-primary',
        ];
        $v_usia = ['0 - 3th', '4 - 5th', '6 - 12th', '13 - 16th', '17th', '18 - 25th', '26 - 30th', '31 - 35th', '36 - 40th', '41 - 65th', '66 - 70th', '71 - 80th', '> 80th'];
        $color = [
            'blue',
            'cyan',
            'green',
            'red',
            'orange',
            'teal',
            'yellow',
            'purple',
            'pink',
            'indigo',
            'lime',
            'gray',
            'brown',
            'amber'
        ];

        include_once('data/statistik-penduduk.php');
        include_once('data/sarana-kantor.php');
        include_once('data/sarana-pendidikan.php');
        include_once('data/sarana-kesehatan.php');
        include_once('data/potensi-luas-wilayah.php');
        include_once('data/potensi-batas-wilayah.php');
        include_once('data/potensi-jenis-lahan.php');
        include_once('data/potensi-orbitasi.php');
        include_once('data/potensi-wisata.php');

        // $data_sarkantor = getSid('data-sarana-kantor', 'sarana-kantor');
        // $data_sardik = getSid('data-sarana-pendidikan', 'sarana-kantor');
        // $data_sarkes = getSid('data-sarana-kesehatan', 'sarana-kantor');
        // $value = getSid('data-luas-wilayah', 'luas-wilayah');
        // if (count($value) > 0) {
        //     $data_luas_wilayah = $value['rows'];
        //     $luas_wilayah_label = $value['luas_wilayah_label'];
        //     $luas_wilayah_data = $value['luas_wilayah_data'];
        //     $luas_wilayah_color = $value['luas_wilayah_color'];
        // } else {
        //     $data_luas_wilayah = null;
        //     $luas_wilayah_label = null;
        //     $luas_wilayah_data = null;
        //     $luas_wilayah_color = null;
        // }
        //     $data_batas_wilayah = getSid('data-batas-wilayah', 'batas-wilayah');
        //     $data_jenis_lahan = getSid('data-jenis-lahan', 'jenis-lahan');
        //     $data_orbitasi = getSid('data-orbitasi', 'orbitasi');
        //     $data_wisata = getSid('data-wisata', 'wisata');
        // }
        return view('frontend.hlm-potensi-sarpras', compact('title', 'v_usia', 'data_usia', 'u_lk', 'u_pr', 'statistics', 'data_pendidikan', 'data_pekerjaan', 'data_jkn', 'jkn_label', 'jkn_data', 'jkn_color', 'color', 'wn', 'data_sarkantor', 'data_sardik', 'data_sarkes', 'data_luas_wilayah', 'luas_wilayah_label', 'luas_wilayah_data', 'luas_wilayah_color', 'data_batas_wilayah', 'data_jenis_lahan', 'data_orbitasi', 'data_wisata'));
    }
    public function produkHukumDownload($filename)
    {
        $fileUrl = storage_path('app/public/dokumen/' . $filename);
        if (!file_exists($fileUrl)) {
            abort(404, 'File tidak ditemukan');
        }
        // $fileUrl = str_replace('/api', '', klien('endpoint')) . '/storage/dokumen/' . $filename;
        // $fileUrl = url('/storage/dokumen/' . $filename);
        $fileContent = file_get_contents($fileUrl);
        return response($fileContent)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    public function perpustakaanDesa(Request $request)
    {
        $title = 'Perpustakaan Desa';
        $bukuPerpus = Artikel::where(['jenis' => 'perpusdes', 'status' => 'published', 'idkategori' => 'perpusdes'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })->latest()->paginate(10);

        return view('frontend.hlm-perpustakaan', compact('title', 'bukuPerpus'));
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
    public function storeRegistrasi(StorePendudukReq $request)
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
        $validate['image'] = $imagePath;
        $validate['image_ktp'] = $imagePath2;
        $validate['slug'] = $slug;
        $validate['iddesa'] = infodesa('kodedesa');
        $validate['id_ktp'] = $request->nik;
        $validate['status'] = 'pending';
        $save = Anggota::create($validate);
        $validate['iduser'] = $save->id;
        $validate['kcds'] = infodesa('kodedesa') . '-' . $save->id;
        $save->update($validate);
        DB::commit();
        return redirect(route('form-registrasi'))->with('success', 'Data berhasil ditambahkan');
    }
    public function cekAnggota()
    {
        $title = 'Cek Status Anggota';
        return view('pages.cek-status-anggota', compact('title'));
    }
    public function statusAnggota($nik)
    {
        $title = 'Status Anggota';
        $profil = Anggota::where('nik', $nik)->orWhere('paspor', $nik)->with('pengurus')->first();
        // dd($profil);
        return view('pages.status-anggota', compact('title', 'profil'));
    }
}
