<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Support\Str;
use App\Models\LapakProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Can;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:dashboard-website')->only(['webdesa_dashboard']);
        $this->middleware('can:dashboard-website.create')->only(['webdesa_dashboard']);
        $this->middleware('can:dashboard')->only(['dashboard']);
        $this->middleware('can:dashboard.create')->only(['dashboard']);
    }

    public function index(Request $request)
    {
        $cek1 = cekAktivasi()['cek1'];
        $cek2 = cekAktivasi()['cek2'];
        if ($cek1 == 0 || $cek2 == 0) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route('login'));
        }
        include_once('dashboard-origin.php');
        $dataArtikel = Artikel::where('jenis', 'post')->limit(5)->latest()->get();
        // $dataBuku = Artikel::where('idkategori', 'perpusdes')->limit(5)->latest()->get();
        $title = 'Dashboard';
        return view('pages.v3.dashboard-sid', compact('title', 'statistics', 'statmutasi',  'wn', 'dataArtikel'));
    }
    public function webdesa_dashboard(Request $request)
    {
        $title = 'Dashboard';
        $cek1 = cekAktivasi()['cek1'];
        $cek2 = cekAktivasi()['cek2'];
        if ($cek1 == 0 || $cek2 == 0) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route('login'));
        }
        $dataArtikel = Artikel::where('jenis', 'post')->limit(5)->latest()->get();
        $dataBuku = Artikel::where('idkategori', 'perpusdes')->limit(5)->latest()->get();

        return view('pages.v3.dashboard-webdesa', compact('title', 'dataArtikel', 'dataBuku'));
    }
}
