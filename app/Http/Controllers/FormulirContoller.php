<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\AdpddInduk;
use App\Models\ProfilBisnis;
use App\Models\AdsrtKategori;
use App\Models\AdsrtTemplate;
use App\Models\KegiatanUsaha;
use App\Models\AdsrtPermohonan;
use App\Models\BentukPerusahaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreMemberRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SID\StoreSrtPermohonanReq;
use App\Http\Resources\SID\SuratKategoriResource;

class FormulirContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function formSurket()
    {
        $title = 'Surat Keterangan';
        $kategori = $themeSurat = AdsrtTemplate::select('id', 'judul', 'adsrt_kategori_id')->where('is_active', 1)->get();
        return view('surat-keterangan.surket', compact('title', 'kategori'));
    }

    public function storeSurket(StoreMemberRequest $request)
    {
        DB::beginTransaction();
        $cariNik = hash('sha256', $request->nik);
        $cek_nik = AdpddInduk::where('hash_nik', $cariNik)->with('surket.kategoriSurat', 'surket.templateSurat')->get();
        // $cek_nik = AdpddInduk::where('nik', $request->nik)->with('surket.kategoriSurat', 'surket.templateSurat')->get();

        $ada_nik = count($cek_nik);
        if ($ada_nik == 0) {
            $status = "error";
            $message = "Data gagal disimpan. NIK tidak ditemukan.";
        } else {
            $kategori_id = $request['kategori_id'];
            $kode = SuratKategoriResource::collection(AdsrtKategori::where('id', $kategori_id)->get());
            $nomor_surat = str_replace('NOMOR', $kode[0]->kode, $request['nomor_surat']);

            $tgl_permohonan = date('Y-m-d');
            $tgl_permohonan_rt = isset($request['tgl_permohonan_rt']) ? $request['tgl_permohonan_rt'] : null;
            $tgl_domisili = isset($request['tgl_domisili']) ? $request['tgl_domisili'] : null;
            $tgl_meninggal = isset($request['tgl_meninggal']) ? $request['tgl_meninggal'] : null;
            $tgl_pelaksanaan = isset($request['tgl_pelaksanaan']) ? $request['tgl_pelaksanaan'] : null;
            $tgl_noreg = isset($request['tgl_noreg']) ? $request['tgl_noreg'] : null;
            $tgl_pernyataan = isset($request['tgl_pernyataan']) ? $request['tgl_pernyataan'] : null;
            $mempelai_tgl_lahir = isset($request['mempelai_tgl_lahir']) ? $request['mempelai_tgl_lahir'] : null;
            $anak_tgl_lahir = isset($request['anak_tgl_lahir']) ? $request['anak_tgl_lahir'] : null;
            $berlaku_dari = $tgl_permohonan;
            $berlaku_sd = $tgl_permohonan;
            $tgl_cetak = $tgl_permohonan;
            if ($kategori_id == 6 || $kategori_id == 10) {
                $masa_berlaku = kalender($berlaku_dari) . ' s/d ' . kalender($berlaku_dari);
            } else {
                $masa_berlaku = '';
            }
            $res = $cek_nik[0];

            $csrfToken = csrf_token();
            $data = [
                "adsrt_kategori_id" => $kategori_id,
                "adsrt_template_id" => $request->input('template_id'),
                "nik" => $request->input('nik'),
                "hash_nik" => $cariNik,
                "phone" => $request->input('phone'),
                "tgl_permohonan" => $tgl_permohonan,
                "tgl_permohonan_rt" =>  $tgl_permohonan_rt,
                "tgl_domisili" =>  $tgl_domisili,
                "tgl_meninggal" =>  $tgl_meninggal,
                "tgl_pelaksanaan" =>  $tgl_pelaksanaan,
                "tgl_noreg" =>  $tgl_noreg,
                "tgl_pernyataan" =>  $tgl_pernyataan,
                "berlaku_dari" =>  $berlaku_dari,
                "berlaku_sd" =>  $berlaku_sd,
                "tgl_cetak" =>  $tgl_cetak,
                "keperluan" =>  $request->input('keperluan', ""),
                "status" => "pending",
                "staf_jabatan" =>  $request->input('staf_jabatan', ""),
                "staf_nama" =>  $request->input('staf_nama', ""),
                "ketua_rw" =>  $request->input('ketua_rw', ""),
                "ketua_rt" =>  $request->input('ketua_rt', ""),
                "rw" =>  $res->rw,
                "rt" =>  $res->rt,
                "nomor_surat" =>  $nomor_surat,
                "nomor_surat_rt" =>  $request->input('nomor_surat_rt', ""),
                "staf_alamat" =>  $request->input('staf_alamat', ""),
                "staf_alamat2" =>  $request->input('staf_alamat2', ""),
                "kades" =>  ProfilBisnis::where("id", 1)->first()->signature,
                "camat" =>  $request->input('camat', ""),
                "camat_nip" =>  $request->input('camat_nip', ""),
                "nik_meninggal" =>  $request->input('nik_meninggal', ""),
                "alamat_meninggal" =>  $request->input('alamat_meninggal', ""),
                "jumlah_waris_meninggal" =>  $request->input('jumlah_waris_meninggal', 0),
                "saksi_1" =>  $request->input('saksi_1', ""),
                "saksi_2" =>  $request->input('saksi_2', ""),
                "saksi_3" =>  $request->input('saksi_3', ""),
                "saksi_4" =>  $request->input('saksi_4', ""),
                "nomor_1" =>  $request->input('nomor_1', ""),
                "nomor_2" =>  $request->input('nomor_2', ""),
                "nomor_3" =>  $request->input('nomor_3', ""),
                "nomor_4" =>  $request->input('nomor_4', ""),
                "warga_nama" =>  $res->nama,
                "warga_anak_dari" =>  $request->input('warga_anak_dari', ""),
                "pernyataan" =>  $request->input('pernyataan', ""),
                "maksud_keramaian" =>  $request->input('maksud_keramaian', ""),
                "waktu_pelaksanaan" =>  $request->input('waktu_pelaksanaan', ""),
                "hiburan" =>  $request->input('hiburan', ""),
                "hiburan" =>  $request->input('hiburan', ""),
                "jumlah_undangan" =>  $request->input('jumlah_undangan', 0),
                "tempat_pelaksanaan" =>  $request->input('tempat_pelaksanaan', ""),
                "noreg" =>  $request->input('noreg', ""),
                "status_kawin" =>  $request->input('status_kawin', ""),
                "masa_berlaku" =>  $request->input('masa_berlaku', ""),
                "keterangan_lain" =>  $request->input('keterangan_lain', ""),
                "usaha_nama" =>  $request->input('usaha_nama', ""),
                "usaha_pemilik" =>  $request->input('usaha_pemilik', ""),
                "usaha_alamat" =>  $request->input('usaha_alamat', ""),
                "usaha_jenis" =>  $request->input('usaha_jenis', ""),
                "usaha_status" =>  $request->input('usaha_status', ""),
                "usaha_luas" => $request->input('usaha_luas', ""),
                "usaha_waktu" => $request->input('usaha_waktu', ""),
                "jumlah_karyawan" => $request->input('jumlah_karyawan', 0),
                "bentuk_perusahaan_id" => $request->input('bentuk_perusahaan_id', 0),
                "kegiatan_usaha_id" => $request->input('kegiatan_usaha_id', 0),
                "jam_meninggal" => $request->input('jam_meninggal', ""),
                "tempat_meninggal" => $request->input('tempat_meninggal', ""),
                "sebab_meninggal" => $request->input('sebab_meninggal', ""),
                "warga_pasangan_hidup" => $request->input('warga_pasangan_hidup', ""),
                "mempelai_nama" => $request->input('mempelai_nama', ""),
                "mempelai_binti" => $request->input('mempelai_binti', ""),
                "mempelai_tempat_lahir" => $request->input('mempelai_tempat_lahir', ""),
                "mempelai_tgl_lahir" => $mempelai_tgl_lahir,
                "mempelai_warganegara" => $request->input('mempelai_warganegara', ""),
                "mempelai_agama" => $request->input('mempelai_agama', ""),
                "mempelai_pekerjaan" => $request->input('mempelai_pekerjaan', ""),
                "mempelai_alamat" => $request->input('mempelai_alamat', ""),
                "nik_ayah" => $request->input('nik_ayah', ""),
                "nik_ibu" => $request->input('nik_ibu', ""),
                "anak_nama" => $request->input('anak_nama', ""),
                "anak_ke" => $request->input('anak_ke', ""),
                "anak_tempat_lahir" => $request->input('anak_tempat_lahir', ""),
                "anak_tgl_lahir" => $anak_tgl_lahir,
                "anak_agama" => $request->input('anak_agama', ""),
                "anak_gender" => $request->input('anak_gender', ""),
                "anak_alamat" => $request->input('anak_alamat', ""),
                "anak_sekolah" => $request->input('anak_sekolah', ""),
                "anak_jurusan" => $request->input('anak_jurusan', ""),
                "anak_semester" => $request->input('anak_semester', ""),
            ];
            $rules = [
                'adsrt_kategori_id' => 'required',
                'adsrt_template_id' => 'nullable',
                'user_id' => 'nullable',
                'nik' => 'required|string',
                'hash_nik' => 'nullable|string',
                'phone' => 'nullable|string',
                'keperluan' => 'nullable|string',
                'status' => 'nullable|string',
                'staf_jabatan' => 'nullable|string',
                'staf_nama' => 'nullable|string',
                'ketua_rw' => 'nullable|string',
                'ketua_rt' => 'nullable|string',
                'rw' => 'nullable|string',
                'rt' => 'nullable|string',
                'nomor_surat' => 'nullable|string',
                'tgl_permohonan' => 'nullable|date',
                'nomor_surat_rt' => 'nullable|string',
                'tgl_permohonan_rt' => 'nullable|date',
                'berlaku_dari' => 'nullable|date',
                'berlaku_sd' => 'nullable|date',
                'staf_alamat' => 'nullable|string',
                'staf_alamat2' => 'nullable|string',
                'tgl_domisili' => 'nullable|date',
                'kades' => 'nullable|string',
                'camat' => 'nullable|string',
                'camat_nip' => 'nullable|string',
                'nik_meninggal' => 'nullable|string',
                'tgl_meninggal' => 'nullable|date',
                'alamat_meninggal' => 'nullable|string',
                'jumlah_waris_meninggal' => 'nullable|integer',
                'saksi_1' => 'nullable|string',
                'saksi_2' => 'nullable|string',
                'saksi_3' => 'nullable|string',
                'saksi_4' => 'nullable|string',
                'nomor_1' => 'nullable|string',
                'nomor_2' => 'nullable|string',
                'nomor_3' => 'nullable|string',
                'nomor_4' => 'nullable|string',
                'warga_nama' => 'nullable|string',
                'warga_anak_dari' => 'nullable|string',
                'tgl_pernyataan' => 'nullable|date',
                'pernyataan' => 'nullable|string',
                'maksud_keramaian' => 'nullable|string',
                'tgl_pelaksanaan' => 'nullable|date',
                'waktu_pelaksanaan' => 'nullable|string',
                'hiburan' => 'nullable|string',
                'jumlah_undangan' => 'nullable|integer',
                'tempat_pelaksanaan' => 'nullable|string',
                'noreg' => 'nullable|string',
                'tgl_noreg' => 'nullable|date',
                'status_kawin' => 'nullable|string',
                'masa_berlaku' => 'nullable|string',
                'keterangan_lain' => 'nullable|string',
                'usaha_nama' => 'nullable|string',
                'usaha_pemilik' => 'nullable|string',
                'usaha_alamat' => 'nullable|string',
                'usaha_jenis' => 'nullable|string',
                'usaha_status' => 'nullable|string',
                'usaha_luas' => 'nullable|string',
                'usaha_waktu' => 'nullable|string',
                'jumlah_karyawan' => 'nullable|integer',
                'bentuk_perusahaan_id' => 'nullable|integer',
                'kegiatan_usaha_id' => 'nullable|integer',
                'tgl_cetak' => 'nullable|date',
                'jam_meninggal' => 'nullable|string',
                'tempat_meninggal' => 'nullable|string',
                'sebab_meninggal' => 'nullable|string',
                'warga_pasangan_hidup' => 'nullable|string',
                'mempelai_nama' => 'nullable|string',
                'mempelai_binti' => 'nullable|string',
                'mempelai_tempat_lahir' => 'nullable|string',
                'mempelai_tgl_lahir' => 'nullable|date',
                'mempelai_warganegara' => 'nullable|string',
                'mempelai_agama' => 'nullable|string',
                'mempelai_pekerjaan' => 'nullable|string',
                'mempelai_alamat' => 'nullable|string',
                'nik_ayah' => 'nullable|string',
                'nik_ibu' => 'nullable|string',
                'anak_nama' => 'nullable|string',
                'anak_ke' => 'nullable|string',
                'anak_tempat_lahir' => 'nullable|string',
                'anak_tgl_lahir' => 'nullable|date',
                'anak_agama' => 'nullable|string',
                'anak_gender' => 'nullable|string',
                'anak_alamat' => 'nullable|string',
                'anak_sekolah' => 'nullable|string',
                'anak_jurusan' => 'nullable|string',
                'anak_semester' => 'nullable|string',
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                $status = "error";
                $message = "Data gagal disimpan.";
            }


            $validate = $validator->validated();


            $save = AdsrtPermohonan::create($validate);
            if ($save) {
                $status = "success";
                $message = "Data berhasil disimpan.";
            } else {
                $status = "error";
                $message = "Data gagal disimpan.";
            }
        }
        DB::commit();
        return redirect(route('surket'))->with($status, $message);
    }
    public function storeSurketX(StoreMemberRequest $request)
    {
        DB::beginTransaction();

        $client = new Client();
        try {
            $response = $client->request('GET', klien('endpoint') . '/cari-nik/' . $request['nik'], [
                'http_errors' => false,
            ]);
            $body = $response->getBody();
            $content = $body->getContents();
            $cek_nik = [];
            if ($content) {
                $cek_nik = json_decode($content)->data;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching data: ' . $e->getMessage());
            $cek_nik = [];
        }
        $ada_nik = count($cek_nik);
        if ($ada_nik == 0) {
            $status = "error";
            $message = "Data gagal disimpan. NIK tidak ditemukan.";
        } else {
            $kategori_id = $request['kategori_id'];
            $client = new Client();
            try {
                $response = $client->request('GET', klien('endpoint') . '/kategori-surat/' . $kategori_id, [
                    'http_errors' => false,
                ]);
                $body = $response->getBody();
                $content = $body->getContents();
                $kode = [];
                if ($content) {
                    $kode = json_decode($content)->data;
                }
            } catch (\Exception $e) {
                Log::error('Error fetching data: ' . $e->getMessage());
                $kode = [];
            }
            $nomor_surat = str_replace('NOMOR', $kode[0]->kode, $request['nomor_surat']);

            $tgl_permohonan = date('Y-m-d');
            $tgl_permohonan_rt = isset($request['tgl_permohonan_rt']) ? $request['tgl_permohonan_rt'] : null;
            $tgl_domisili = isset($request['tgl_domisili']) ? $request['tgl_domisili'] : null;
            $tgl_meninggal = isset($request['tgl_meninggal']) ? $request['tgl_meninggal'] : null;
            $tgl_pelaksanaan = isset($request['tgl_pelaksanaan']) ? $request['tgl_pelaksanaan'] : null;
            $tgl_noreg = isset($request['tgl_noreg']) ? $request['tgl_noreg'] : null;
            $tgl_pernyataan = isset($request['tgl_pernyataan']) ? $request['tgl_pernyataan'] : null;
            $mempelai_tgl_lahir = isset($request['mempelai_tgl_lahir']) ? $request['mempelai_tgl_lahir'] : null;
            $anak_tgl_lahir = isset($request['anak_tgl_lahir']) ? $request['anak_tgl_lahir'] : null;
            $berlaku_dari = $tgl_permohonan;
            $berlaku_sd = $tgl_permohonan;
            $tgl_cetak = $tgl_permohonan;
            if ($kategori_id == 6 || $kategori_id == 10) {
                $masa_berlaku = kalender($berlaku_dari) . ' s/d ' . kalender($berlaku_dari);
            } else {
                $masa_berlaku = '';
            }
            $res = $cek_nik[0];

            $csrfToken = csrf_token();
            $data = [
                "adsrt_kategori_id" => $kategori_id,
                "adsrt_template_id" => $request->input('template_id'),
                "nik" => $request->input('nik'),
                "phone" => $request->input('phone'),
                "tgl_permohonan" => $tgl_permohonan,
                "tgl_permohonan_rt" =>  $tgl_permohonan_rt,
                "tgl_domisili" =>  $tgl_domisili,
                "tgl_meninggal" =>  $tgl_meninggal,
                "tgl_pelaksanaan" =>  $tgl_pelaksanaan,
                "tgl_noreg" =>  $tgl_noreg,
                "tgl_pernyataan" =>  $tgl_pernyataan,
                "berlaku_dari" =>  $berlaku_dari,
                "berlaku_sd" =>  $berlaku_sd,
                "tgl_cetak" =>  $tgl_cetak,
                "keperluan" =>  $request->input('keperluan', ""),
                "status" => "pending",
                "staf_jabatan" =>  $request->input('staf_jabatan', ""),
                "staf_nama" =>  $request->input('staf_nama', ""),
                "ketua_rw" =>  $request->input('ketua_rw', ""),
                "ketua_rt" =>  $request->input('ketua_rt', ""),
                "rw" =>  $res->rw,
                "rt" =>  $res->rt,
                "nomor_surat" =>  $nomor_surat,
                "nomor_surat_rt" =>  $request->input('nomor_surat_rt', ""),
                "staf_alamat" =>  $request->input('staf_alamat', ""),
                "staf_alamat2" =>  $request->input('staf_alamat2', ""),
                "kades" =>  ProfilBisnis::where("id", 1)->first()->signature,
                "camat" =>  $request->input('camat', ""),
                "camat_nip" =>  $request->input('camat_nip', ""),
                "nik_meninggal" =>  $request->input('nik_meninggal', ""),
                "alamat_meninggal" =>  $request->input('alamat_meninggal', ""),
                "jumlah_waris_meninggal" =>  $request->input('jumlah_waris_meninggal', 0),
                "saksi_1" =>  $request->input('saksi_1', ""),
                "saksi_2" =>  $request->input('saksi_2', ""),
                "saksi_3" =>  $request->input('saksi_3', ""),
                "saksi_4" =>  $request->input('saksi_4', ""),
                "nomor_1" =>  $request->input('nomor_1', ""),
                "nomor_2" =>  $request->input('nomor_2', ""),
                "nomor_3" =>  $request->input('nomor_3', ""),
                "nomor_4" =>  $request->input('nomor_4', ""),
                "warga_nama" =>  $res->nama,
                "warga_anak_dari" =>  $request->input('warga_anak_dari', ""),
                "pernyataan" =>  $request->input('pernyataan', ""),
                "maksud_keramaian" =>  $request->input('maksud_keramaian', ""),
                "waktu_pelaksanaan" =>  $request->input('waktu_pelaksanaan', ""),
                "hiburan" =>  $request->input('hiburan', ""),
                "hiburan" =>  $request->input('hiburan', ""),
                "jumlah_undangan" =>  $request->input('jumlah_undangan', 0),
                "tempat_pelaksanaan" =>  $request->input('tempat_pelaksanaan', ""),
                "noreg" =>  $request->input('noreg', ""),
                "status_kawin" =>  $request->input('status_kawin', ""),
                "masa_berlaku" =>  $request->input('masa_berlaku', ""),
                "keterangan_lain" =>  $request->input('keterangan_lain', ""),
                "usaha_nama" =>  $request->input('usaha_nama', ""),
                "usaha_pemilik" =>  $request->input('usaha_pemilik', ""),
                "usaha_alamat" =>  $request->input('usaha_alamat', ""),
                "usaha_jenis" =>  $request->input('usaha_jenis', ""),
                "usaha_status" =>  $request->input('usaha_status', ""),
                "usaha_luas" => $request->input('usaha_luas', ""),
                "usaha_waktu" => $request->input('usaha_waktu', ""),
                "jumlah_karyawan" => $request->input('jumlah_karyawan', 0),
                "bentuk_perusahaan_id" => $request->input('bentuk_perusahaan_id', 0),
                "kegiatan_usaha_id" => $request->input('kegiatan_usaha_id', 0),
                "jam_meninggal" => $request->input('jam_meninggal', ""),
                "tempat_meninggal" => $request->input('tempat_meninggal', ""),
                "sebab_meninggal" => $request->input('sebab_meninggal', ""),
                "warga_pasangan_hidup" => $request->input('warga_pasangan_hidup', ""),
                "mempelai_nama" => $request->input('mempelai_nama', ""),
                "mempelai_binti" => $request->input('mempelai_binti', ""),
                "mempelai_tempat_lahir" => $request->input('mempelai_tempat_lahir', ""),
                "mempelai_tgl_lahir" => $mempelai_tgl_lahir,
                "mempelai_warganegara" => $request->input('mempelai_warganegara', ""),
                "mempelai_agama" => $request->input('mempelai_agama', ""),
                "mempelai_pekerjaan" => $request->input('mempelai_pekerjaan', ""),
                "mempelai_alamat" => $request->input('mempelai_alamat', ""),
                "nik_ayah" => $request->input('nik_ayah', ""),
                "nik_ibu" => $request->input('nik_ibu', ""),
                "anak_nama" => $request->input('anak_nama', ""),
                "anak_ke" => $request->input('anak_ke', ""),
                "anak_tempat_lahir" => $request->input('anak_tempat_lahir', ""),
                "anak_tgl_lahir" => $anak_tgl_lahir,
                "anak_agama" => $request->input('anak_agama', ""),
                "anak_gender" => $request->input('anak_gender', ""),
                "anak_alamat" => $request->input('anak_alamat', ""),
                "anak_sekolah" => $request->input('anak_sekolah', ""),
                "anak_jurusan" => $request->input('anak_jurusan', ""),
                "anak_semester" => $request->input('anak_semester', ""),
            ];
            $client = new Client();
            try {
                $response = $client->request('POST', klien('endpoint') . '/surat-permohonan', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-CSRF-TOKEN' => $csrfToken,
                    ],
                    'json' => $data,
                ]);
                $status = "success";
                $message = "Data berhasil disimpan.";
            } catch (\Exception $e) {
                $status = "error";
                $message = "Data gagal disimpan.";
            }
        }
        DB::commit();
        return redirect(route('surket'))->with($status, $message);
    }

    public function getForm($id)
    {
        if ($id == 5 || $id == 21) {
            $kegiatanUsaha = KegiatanUsaha::select('id', 'nama as kegiatan_usaha', 'kode as kode_usaha')->orderBy('id', 'desc')->get();
            $bentukUsaha = BentukPerusahaan::select('id', 'nama as bentuk_usaha', 'kode as kode_usaha')->orderBy('id', 'desc')->get();
        }

        if ($id == 1) {
            return view('surat-keterangan.form.1-usaha')->render();
        } elseif ($id == 2) {
            return view('surat-keterangan.form.2-domisili-tempat-tinggal')->render();
        } elseif ($id == 3) {
            return view('surat-keterangan.form.3-umum')->render();
        } elseif ($id == 4) {
            return view('surat-keterangan.form.4-tidak-mampu')->render();
        } elseif ($id == 5) {
            return view('surat-keterangan.form.5-domisili-usaha', compact('kegiatanUsaha', 'bentukUsaha'))->render();
        } elseif ($id == 6) {
            return view('surat-keterangan.form.6-pengantar')->render();
        } elseif ($id == 7) {
            return view('surat-keterangan.form.7-skck')->render();
        } elseif ($id == 8) {
            return view('surat-keterangan.form.8-keramaian')->render();
        } elseif ($id == 9) {
            return view('surat-keterangan.form.9-pernyataan')->render();
        } elseif ($id == 10) {
            return view('surat-keterangan.form.10-ahli-waris')->render();
        } elseif ($id == 11) {
            return view('surat-keterangan.form.11-domisili')->render();
        } elseif ($id == 12) {
            return view('surat-keterangan.form.12-kematian')->render();
        } elseif ($id == 13) {
            return view('surat-keterangan.form.13-suket-penghasilan-ortu')->render();
        } elseif ($id == 14) {
            return view('surat-keterangan.form.14-suket-tanah-tdk-sengketa')->render();
        } elseif ($id == 15) {
            return view('surat-keterangan.form.15-suket-domisili-org')->render();
        } elseif ($id == 16) {
            return view('surat-keterangan.form.16-suket-domisili')->render();
        } elseif ($id == 17) {
            return view('surat-keterangan.form.17-suket-beda-identitas')->render();
        } elseif ($id == 18) {
            return view('surat-keterangan.form.18-suket-kehilangan')->render();
        } elseif ($id == 19) {
            return view('surat-keterangan.form.19-suket-kelahiran')->render();
        } elseif ($id == 20) {
            return view('surat-keterangan.form.20-suket-tidak-mampu')->render();
        } elseif ($id == 21) {
            return view('surat-keterangan.form.21-suket-usaha', compact('kegiatanUsaha', 'bentukUsaha'))->render();
        } elseif ($id == 22) {
            return view('surat-keterangan.form.22-suket-rekomendasi')->render();
        } elseif ($id == 23) {
            return view('surat-keterangan.form.23-suket-domisili-duplikat')->render();
        } elseif ($id == 24) {
            return view('surat-keterangan.form.24-suket-keterangan-lain')->render();
        } elseif ($id == 25) {
            return view('surat-keterangan.form.25-sutar-pindah-sedesa')->render();
        } elseif ($id == 26) {
            return view('surat-keterangan.form.26-sutar-pindah-kota')->render();
        } elseif ($id == 28) {
            return view('surat-keterangan.form.28-sutar-asal-usul')->render();
        } elseif ($id == 30) {
            return view('surat-keterangan.form.30-sutar-izin-ortu')->render();
        } elseif ($id == 31) {
            return view('surat-keterangan.form.31-sutar-tentang-ortu')->render();
        } elseif ($id == 33) {
            return view('surat-keterangan.form.33-sutar-pengantar-lain')->render();
        } elseif ($id == 34) {
            return view('surat-keterangan.form.34-sutar-persetujuan-mempelai')->render();
        } elseif ($id == 35) {
            return view('surat-keterangan.form.35-sutar-pindah')->render();
        } elseif ($id == 39) {
            return view('surat-keterangan.form.39-sutar-menikah')->render();
        } elseif ($id == 40) {
            return view('surat-keterangan.form.40-super-pernyataan-lain')->render();
        } elseif ($id == 41) {
            return view('surat-keterangan.form.41-super-belum-nikah')->render();
        } elseif ($id == 42) {
            return view('surat-keterangan.form.42-super-ahli-waris')->render();
        } elseif ($id == 44) {
            return view('surat-keterangan.form.44-suket-lampiran-beda-id')->render();
        }
        return '';
    }
}
