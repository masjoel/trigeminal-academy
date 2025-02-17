<?php

namespace App\Http\Controllers\Frontend;

use App\Models\BukuTamu;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Illuminate\Support\Facades\Session;

class BukuTamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getKabupaten($provinsi_id)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsi_id)->get();
        return response()->json($kabupaten);
    }

    public function getKecamatan($kabupaten_id)
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $kabupaten_id)->get();
        return response()->json($kecamatan);
    }

    public function getDesa($kecamatan_id)
    {
        $desa = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($desa);
    }

    public function getPerangkatDesa()
    {
        $perangkatDesas = PerangkatDesa::where('status', 'Aktif')
            ->orderBy('urut')
            ->select('id', 'nama', 'jabatan', 'avatar')
            ->get();

        return response()->json($perangkatDesas);
    }

    public function index()
    {
        $title = 'Buku Tamu';
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $pendidikan = ['sd', 'smp', 'sma', 's1', 's2', 's3'];
        $pekerjaan = ['pns', 'tni', 'polri', 'swasta', 'wirausaha'];
        $keperluan = ['pelayanan masyarakat', 'studi banding', 'kunjungan kerja', 'sosialisasi', 'bertamu'];
        $provinsi = Provinsi::all();

        return view('pages.buku-tamu.index', compact(
            'title',
            'jenis_kelamin',
            'pendidikan',
            'pekerjaan',
            'keperluan',
            'provinsi'
        ));
    }


    public function cekNik(Request $request)
    {
        $nik = $request->input('nik');
        $hasPendingStatus = BukuTamu::where('nik', $nik)
            ->where('status', 'pending')
            ->exists();
        if (!$hasPendingStatus) {
            $bukuTamu = BukuTamu::where('nik', $nik)->first();
            if (!$bukuTamu) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
            // Simpan id ke session jika data ditemukan tapi tidak ada yang punya status pending
            Session::put('buku_tamu_session_id', $bukuTamu->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Terima kasih telah mengisi buku tamu.'
            ]);
        }

        // Jika ada data dengan status pending, simpan id ke session dan arahkan untuk ngisi kuisioner
        Session::put('buku_tamu_session_id', BukuTamu::where('nik', $nik)->where('status', 'pending')->value('id'));

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih telah mengisi buku tamu. Silahkan mengisi kuisioner pada link berikut ini.',
            'redirect' => route('buku-tamu.kuisioner')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BukuTamu $bukuTamu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BukuTamu $bukuTamu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BukuTamu $bukuTamu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BukuTamu $bukuTamu)
    {
        //
    }
}
