<?php

namespace App\Http\Controllers\Api\SID;

use App\Http\Controllers\Controller;
use App\Http\Resources\SID\CariNikResource;
use App\Http\Resources\SID\PendudukIndukResource;
use App\Models\AdpddInduk;
use Illuminate\Http\Request;

class PddIndukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->apikey == infodesa('apikey')) {
            $hashNik = $request->input('search');
            return PendudukIndukResource::collection(AdpddInduk::when($request->input('search'), function ($query, $search) use ($hashNik) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%');
                })->orWhere(function ($subQuery) use ($hashNik) {
                    $subQuery->where('paspor', 'like', '%' . $hashNik . '%');
                })->orWhere(function ($subQuery) use ($search) {
                    $subQuery->where('telpon', 'like', '%' . $search . '%');
                })->orWhere(function ($subQuery) use ($search) {
                    $subQuery->where('alamat', 'like', '%' . $search . '%');
                })->orWhere(function ($subQuery) use ($search) {
                    $subQuery->where('dusun', 'like', '%' . $search . '%');
                });
            })->get());
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return PendudukIndukResource::collection(AdpddInduk::where('id', $id)->get());
    }
    public function cariNik(string $nik)
    {
        $cari = $nik;
        $data = AdpddInduk::where('nik', $cari)->orWhere('paspor', $cari)->get();
        return CariNikResource::collection($data);
    }
    public function statistik(Request $request, $data)
    {
        if ($request->apikey == infodesa('apikey')) {
            switch ($data) {
                case 'jumlahpenduduk':
                    return PendudukIndukResource::collection(AdpddInduk::selectRaw('SUM(CASE WHEN mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_pdd, SUM(CASE WHEN hubungan = "Kepala Keluarga" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_kk, SUM(CASE WHEN gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_lk, SUM(CASE WHEN gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_pr')->get());
                    break;
                case 'data-mutasi':
                    return PendudukIndukResource::collection(AdpddInduk::selectRaw('SUM(CASE WHEN mutasi = "Lahir" THEN 1 ELSE 0 END) as total_lahir, SUM(CASE WHEN mutasi = "Datang" THEN 1 ELSE 0 END) as total_datang, SUM(CASE WHEN mutasi = "Pindah" THEN 1 ELSE 0 END) as total_pindah, SUM(CASE WHEN mutasi = "Meninggal" THEN 1 ELSE 0 END) as total_mati')->get());
                    break;
                case 'kategori-usia':
                    return PendudukIndukResource::collection(AdpddInduk::selectRaw(
                        'SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 13) THEN 1 ELSE 0 END) as u_anak_l, 
                            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 13) THEN 1 ELSE 0 END) as u_anak_p,
                            SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 18) THEN 1 ELSE 0 END) as u_remaja_l, 
                            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 18) THEN 1 ELSE 0 END) as u_remaja_p,
                            SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 66) THEN 1 ELSE 0 END) as u_dewasa_l, 
                            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 66) THEN 1 ELSE 0 END) as u_dewasa_p,
                            SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 65) THEN 1 ELSE 0 END) as u_lansia_l, 
                            SUM(CASE WHEN (gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 65) THEN 1 ELSE 0 END) as u_lansia_p'
                    )->get());
                    break;
                case 'data-penduduk':
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 3) THEN 1 ELSE 0 END)as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 0 and 3) THEN 1 ELSE 0 END)as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 4 and 5) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 4 and 5) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 6 and 12) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 6 and 12) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 16) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 13 and 16) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) = 17) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) = 17) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 25) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 18 and 25) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 26 and 30) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 26 and 30) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 31 and 35) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 31 and 35) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 36 and 40) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 36 and 40) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 41 and 65) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 41 and 65) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 66 and 70) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 66 and 70) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 71 and 80) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) between 71 and 80) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    $usia[] = AdpddInduk::selectRaw('SUM(CASE WHEN (gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 80) THEN 1 ELSE 0 END) as lk, SUM(CASE WHEN (gender = "Pr" AND TIMESTAMPDIFF(year, tgl_lahir, now()) > 80) THEN 1 ELSE 0 END) as pr')->first()->toArray();
                    return PendudukIndukResource::collection($usia);
                    break;
                case 'data-pendidikan':
                    $data = AdpddInduk::selectRaw('distinct pendidikan')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('pendidikan')->get();
                    $data_pendidikan = [];
                    foreach ($data as $j) {
                        $jml = AdpddInduk::where('pendidikan', $j->pendidikan)->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_l = AdpddInduk::where('pendidikan', $j->pendidikan)->where('gender', 'Lk')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_p = AdpddInduk::where('pendidikan', $j->pendidikan)->where('gender', 'Pr')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();

                        $data_pendidikan[] = [
                            'pendidikan' => $j->pendidikan,
                            'pria' => $j_l,
                            'wanita' => $j_p,
                            'total' => $jml,
                        ];
                    }
                    return PendudukIndukResource::collection($data_pendidikan);
                    break;
                case 'data-pekerjaan':
                    $data = AdpddInduk::selectRaw('distinct pekerjaan')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('pekerjaan')->get();
                    $data_pekerjaan = [];
                    foreach ($data as $j) {
                        $jml = AdpddInduk::where('pekerjaan', $j->pekerjaan)->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_l = AdpddInduk::where('pekerjaan', $j->pekerjaan)->where('gender', 'Lk')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_p = AdpddInduk::where('pekerjaan', $j->pekerjaan)->where('gender', 'Pr')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();

                        $data_pekerjaan[] = [
                            'pekerjaan' => $j->pekerjaan,
                            'pria' => $j_l,
                            'wanita' => $j_p,
                            'total' => $jml,
                        ];
                    }
                    return PendudukIndukResource::collection($data_pekerjaan);
                    break;
                case 'data-hub-keluarga':
                    $data = AdpddInduk::selectRaw('distinct hubungan')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('hubungan')->get();
                    $data_hub_klg = [];
                    foreach ($data as $j) {
                        $jml = AdpddInduk::where('hubungan', $j->hubungan)->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_l = AdpddInduk::where('hubungan', $j->hubungan)->where('gender', 'Lk')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_p = AdpddInduk::where('hubungan', $j->hubungan)->where('gender', 'Pr')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();

                        $data_hub_klg[] = [
                            'hubungan' => $j->hubungan,
                            'pria' => $j_l,
                            'wanita' => $j_p,
                            'total' => $jml,
                        ];
                    }
                    return PendudukIndukResource::collection($data_hub_klg);
                    break;
                case 'data-jkn':
                    $color = [
                        'blue', 'cyan', 'green', 'red', 'orange', 'teal', 'yellow', 'purple', 'pink', 'indigo', 'lime', 'gray', 'brown', 'amber'
                    ];
                    $i = 0;
                    $data = AdpddInduk::selectRaw('distinct jkn')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->orderBy('jkn')->get();
                    $data_jkn = [];
                    foreach ($data as $j) {
                        $jml = AdpddInduk::where('jkn', $j->jkn)->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_l = AdpddInduk::where('jkn', $j->jkn)->where('gender', 'Lk')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();
                        $j_p = AdpddInduk::where('jkn', $j->jkn)->where('gender', 'Pr')->where('mutasi', '!=', 'Pindah')->where('mutasi', '!=', 'Meninggal')->count();

                        $data_jkn[] = [
                            'jkn' => $j->jkn,
                            'jkn_label' => $j->jkn,
                            'jkn_data' => $jml,
                            'jkn_color' => $color[$i++],
                            'pria' => $j_l,
                            'wanita' => $j_p,
                            'total' => $jml,
                        ];
                    }
                    return PendudukIndukResource::collection($data_jkn);
                    break;
                default:
                    return PendudukIndukResource::collection(AdpddInduk::selectRaw('SUM(CASE WHEN mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_pdd, SUM(CASE WHEN hubungan = "Kepala Keluarga" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_kk, SUM(CASE WHEN gender = "Lk" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_lk, SUM(CASE WHEN gender = "Pr" AND mutasi != "Pindah" AND mutasi != "Meninggal" THEN 1 ELSE 0 END) as total_pr')->get());
                    break;
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
