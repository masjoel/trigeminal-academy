<?php

namespace App\Http\Controllers\Backend;

use App\Models\DdkKk;
use App\Models\Provinsi;
use App\Models\AdpddInduk;
use App\Models\AdpddMutasi;
use App\Models\DdkPersonil;
use App\Exports\IndukExport;
use Illuminate\Http\Request;
use App\Models\AdprofAnggota;
use App\Models\PerangkatDesa;
use App\Models\AdsrtPermohonan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\Backend\StorePendudukReq;
use App\Http\Requests\Backend\UpdatePendudukReq;

class AdpddIndukController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:adm-penduduk-induk')->only(['index', 'show']);
        $this->middleware('can:adm-penduduk-induk.create')->only(['create', 'store']);
        $this->middleware('can:adm-penduduk-induk.edit')->only(['edit', 'update']);
        $this->middleware('can:adm-penduduk-induk.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $sortField = $request->query('sort', 'id');
        $sortDirection = $request->query('direction', 'desc');
        $cari = $request->input('search');
        $hashNik = hash('sha256', $request->input('search'));

        $qry = AdpddInduk::select('*')->selectRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) AS usia')
            ->orderBy($sortField, $sortDirection);
        $penduduks = $qry->when($cari, function ($query, $search) use ($hashNik) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nama', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($hashNik) {
                $subQuery->where('hash_nik', 'like', '%' . $hashNik . '%');
            })->orWhere(function ($subQuery) use ($hashNik) {
                $subQuery->where('hash_kk', 'like', '%' . $hashNik . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('telpon', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('dusun', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('mutasi', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('alamat', 'like', '%' . $search . '%');
            });
        })
            ->when($request->input('gender'), function ($query, $searchGender) {
                $query->where('gender', '=', $searchGender);
            })
            ->when($request->input('agama'), function ($query, $searchAgama) {
                $query->where('agama', '=', $searchAgama);
            })
            ->when($request->input('pendidikan'), function ($query, $searchPendidikan) {
                $query->where('pendidikan', '=', $searchPendidikan);
            })
            ->when($request->input('pekerjaan'), function ($query, $searchPekerjaan) {
                $query->where('pekerjaan', '=', $searchPekerjaan);
            })
            ->when($request->input('status_kawin'), function ($query, $searchKawin) {
                $query->where('status_kawin', '=', $searchKawin);
            })
            ->when($request->input('hubungan'), function ($query, $searchHubungan) {
                $query->where('hubungan', '=', $searchHubungan);
            })
            ->paginate($limit);
        // $encryptedFields = ['id_ktp', 'nik', 'kk'];

        // $penduduks = decryptFields($qryPenduduks, $encryptedFields);

        // $users = DB::table('users')->select('data')->get();
        // $penduduks = $qryPenduduks->map(function ($penduduk) {
        //     try {
        //         $penduduk->id_ktp = Crypt::decryptString($penduduk->id_ktp);
        //         $penduduk->nik = Crypt::decryptString($penduduk->nik);
        //         $penduduk->kk = Crypt::decryptString($penduduk->kk);
        //     } catch (\Exception $e) {
        //         $penduduk->id_ktp = $penduduk->id_ktp;
        //         $penduduk->nik = $penduduk->nik;
        //         $penduduk->kk = $penduduk->kk;
        //     }
        //     return $penduduk;
        // });
        // return view('users.index', ['users' => $decryptedUsers]);

        $provinsi = Provinsi::all();
        $title = 'Buku Data Induk Penduduk';
        $agama = ['-', 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Kepercayaan'];
        $pendidikan = ['-', 'Tidak/Belum Sekolah', 'Belum Tamat SD/sederajat', 'Tamat SD/sederajat', 'SLTP/sederajat', 'SLTA/sederajat', 'Diploma I/II', 'Akademi/Diploma III/Sarjana Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'];
        $pekerjaan = ['-', 'Belum/Tidak Bekerja', 'Pegawai Negeri Sipil (PNS)', 'TNI', 'POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Buruh', 'Nelayan', 'Mahasiswa', 'Petani', 'Pekebun', 'Pedagang', 'Pegawai Swasta', 'Pensiunan', 'Pekerja Lepas', 'Mengurus Rumah Tangga', 'Dosen', 'Pekerjaan lainnya', 'TKI', 'Asisten Rumah Tangga', 'ASN', 'Guru', 'Wartawan', 'Perawat'];
        $status_kawin = ['-', 'Belum Kawin', 'Kawin', 'Janda', 'Duda', 'Cerai Mati', 'Kawin Belum Tercatat', 'Cerai Hidup Tercatat', 'Cerai Hidup Belum Tercatat'];
        $hubungan = ['-', 'Kepala Keluarga', 'Suami', 'Istri', 'Anak Kandung', 'Anak Angkat', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili lain', 'Pembantu', 'Lainnya'];
        $bacahuruf = ['-', 'A', 'D', 'L', 'AD', 'AL', 'LD', 'ALD'];
        $jkn = ['-', 'BPJS-PBI', 'BPJS-Non PBI', 'Non BPJS', 'Tidak Memiliki', 'KIS', 'BPJS Mandiri'];
        return view('sid.v3.adm-penduduk.induk.index', compact('penduduks', 'nomor', 'title', 'provinsi', 'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 'hubungan',  'sortField', 'sortDirection'));
    }

    public function report(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $sortField = $request->query('sort', 'nama');
        $sortDirection = $request->query('direction', 'asc');
        $cari = $request->input('search');

        $qry = AdpddInduk::select('*')->selectRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) AS usia')
            ->orderBy($sortField, $sortDirection);
        $penduduks = $qry->when($cari, function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nama', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('nik', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('kk', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('telpon', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('dusun', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('alamat', 'like', '%' . $search . '%');
            });
        })
            ->when($request->input('gender'), function ($query, $searchGender) {
                $query->where('gender', '=', $searchGender);
            })
            ->when($request->input('agama'), function ($query, $searchAgama) {
                $query->where('agama', '=', $searchAgama);
            })
            ->when($request->input('pendidikan'), function ($query, $searchPendidikan) {
                $query->where('pendidikan', '=', $searchPendidikan);
            })
            ->when($request->input('pekerjaan'), function ($query, $searchPekerjaan) {
                $query->where('pekerjaan', '=', $searchPekerjaan);
            })
            ->when($request->input('status_kawin'), function ($query, $searchKawin) {
                $query->where('status_kawin', '=', $searchKawin);
            })
            ->when($request->input('hubungan'), function ($query, $searchHubungan) {
                $query->where('hubungan', '=', $searchHubungan);
            })
            ->paginate($limit);
        $provinsi = Provinsi::all();
        $title = 'Buku Data Induk Penduduk';
        $agama = ['-', 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Kepercayaan'];
        $pendidikan = ['-', 'Tidak/Belum Sekolah', 'Belum Tamat SD/sederajat', 'Tamat SD/sederajat', 'SLTP/sederajat', 'SLTA/sederajat', 'Diploma I/II', 'Akademi/Diploma III/Sarjana Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'];
        $pekerjaan = ['-', 'Belum/Tidak Bekerja', 'Pegawai Negeri Sipil (PNS)', 'TNI', 'POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Buruh', 'Nelayan', 'Mahasiswa', 'Petani', 'Pekebun', 'Pedagang', 'Pegawai Swasta', 'Pensiunan', 'Pekerja Lepas', 'Mengurus Rumah Tangga', 'Dosen', 'Pekerjaan lainnya', 'TKI', 'Asisten Rumah Tangga', 'ASN', 'Guru', 'Wartawan', 'Perawat'];
        $status_kawin = ['-', 'Belum Kawin', 'Kawin', 'Janda', 'Duda', 'Cerai Mati', 'Kawin Belum Tercatat', 'Cerai Hidup Tercatat', 'Cerai Hidup Belum Tercatat'];
        $hubungan = ['-', 'Kepala Keluarga', 'Suami', 'Istri', 'Anak Kandung', 'Anak Angkat', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili lain', 'Pembantu', 'Lainnya'];
        $bacahuruf = ['-', 'A', 'D', 'L', 'AD', 'AL', 'LD', 'ALD'];
        $jkn = ['-', 'BPJS-PBI', 'BPJS-Non PBI', 'Non BPJS', 'Tidak Memiliki', 'KIS', 'BPJS Mandiri'];
        return view('sid.v3.adm-penduduk.induk.report', compact('penduduks', 'nomor', 'title', 'provinsi', 'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 'hubungan',  'sortField', 'sortDirection'));
    }
    public function cetak(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $sortField = $request->query('sort', 'nama');
        $sortDirection = $request->query('direction', 'asc');
        $cari = $request->input('search');

        $qry = AdpddInduk::select('*')->selectRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) AS usia')
            ->orderBy($sortField, $sortDirection);
        $penduduks = $qry->when($cari, function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nama', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('nik', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('kk', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('telpon', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('dusun', 'like', '%' . $search . '%');
            })->orWhere(function ($subQuery) use ($search) {
                $subQuery->where('alamat', 'like', '%' . $search . '%');
            });
        })
            ->when($request->input('gender'), function ($query, $searchGender) {
                $query->where('gender', '=', $searchGender);
            })
            ->when($request->input('agama'), function ($query, $searchAgama) {
                $query->where('agama', '=', $searchAgama);
            })
            ->when($request->input('pendidikan'), function ($query, $searchPendidikan) {
                $query->where('pendidikan', '=', $searchPendidikan);
            })
            ->when($request->input('pekerjaan'), function ($query, $searchPekerjaan) {
                $query->where('pekerjaan', '=', $searchPekerjaan);
            })
            ->when($request->input('status_kawin'), function ($query, $searchKawin) {
                $query->where('status_kawin', '=', $searchKawin);
            })
            ->when($request->input('hubungan'), function ($query, $searchHubungan) {
                $query->where('hubungan', '=', $searchHubungan);
            })->get();
        $provinsi = Provinsi::all();
        $title = 'Buku Data Induk Penduduk';
        $agama = ['-', 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Kepercayaan'];
        $pendidikan = ['-', 'Tidak/Belum Sekolah', 'Belum Tamat SD/sederajat', 'Tamat SD/sederajat', 'SLTP/sederajat', 'SLTA/sederajat', 'Diploma I/II', 'Akademi/Diploma III/Sarjana Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'];
        $pekerjaan = ['-', 'Belum/Tidak Bekerja', 'Pegawai Negeri Sipil (PNS)', 'TNI', 'POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Buruh', 'Nelayan', 'Mahasiswa', 'Petani', 'Pekebun', 'Pedagang', 'Pegawai Swasta', 'Pensiunan', 'Pekerja Lepas', 'Mengurus Rumah Tangga', 'Dosen', 'Pekerjaan lainnya', 'TKI', 'Asisten Rumah Tangga', 'ASN', 'Guru', 'Wartawan', 'Perawat'];
        $status_kawin = ['-', 'Belum Kawin', 'Kawin', 'Janda', 'Duda', 'Cerai Mati', 'Kawin Belum Tercatat', 'Cerai Hidup Tercatat', 'Cerai Hidup Belum Tercatat'];
        $hubungan = ['-', 'Kepala Keluarga', 'Suami', 'Istri', 'Anak Kandung', 'Anak Angkat', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili lain', 'Pembantu', 'Lainnya'];
        $bacahuruf = ['-', 'A', 'D', 'L', 'AD', 'AL', 'LD', 'ALD'];
        $jkn = ['-', 'BPJS-PBI', 'BPJS-Non PBI', 'Non BPJS', 'Tidak Memiliki', 'KIS', 'BPJS Mandiri'];
        return view('sid.v3.adm-penduduk.induk.show', compact('penduduks', 'nomor', 'title', 'provinsi', 'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 'hubungan',  'sortField', 'sortDirection'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Buku Data Induk Penduduk';
        $agama = ['-', 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Kepercayaan'];
        $pendidikan = ['-', 'Tidak/Belum Sekolah', 'Belum Tamat SD/sederajat', 'Tamat SD/sederajat', 'SLTP/sederajat', 'SLTA/sederajat', 'Diploma I/II', 'Akademi/Diploma III/Sarjana Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'];
        $pekerjaan = ['-', 'Belum/Tidak Bekerja', 'Pegawai Negeri Sipil (PNS)', 'TNI', 'POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Buruh', 'Nelayan', 'Mahasiswa', 'Petani', 'Pekebun', 'Pedagang', 'Pegawai Swasta', 'Pensiunan', 'Pekerja Lepas', 'Mengurus Rumah Tangga', 'Dosen', 'Pekerjaan lainnya', 'TKI', 'Asisten Rumah Tangga', 'ASN', 'Guru', 'Wartawan', 'Perawat'];
        $status_kawin = ['-', 'Belum Kawin', 'Kawin', 'Janda', 'Duda', 'Cerai Mati', 'Kawin Belum Tercatat', 'Cerai Hidup Tercatat', 'Cerai Hidup Belum Tercatat'];
        $hubungan = ['-', 'Kepala Keluarga', 'Suami', 'Istri', 'Anak Kandung', 'Anak Angkat', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili lain', 'Pembantu', 'Lainnya'];
        $bacahuruf = ['-', 'A', 'D', 'L', 'AD', 'AL', 'LD', 'ALD'];
        $jkn = ['-', 'BPJS-PBI', 'BPJS-Non PBI', 'Non BPJS', 'Tidak Memiliki', 'KIS', 'BPJS Mandiri'];
        return view('sid.v3.adm-penduduk.induk.create', compact('title', 'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 'hubungan', 'bacahuruf', 'jkn'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePendudukReq $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $idKtp = $request->id_ktp;
        // $nik = Crypt::encryptString($request->nik);
        // $kk = Crypt::encryptString($request->kk);
        // $validate['nik'] = $nik;
        // $validate['kk'] = $kk;
        $validate['iduser'] = auth()->user()->id;
        $validate['iddesa'] = infodesa('kodedesa');
        $validate['id_ktp'] = $idKtp ?? $request->nik;
        $save = AdpddInduk::create($validate);
        $validate['kcds'] = infodesa('kodedesa') . '-' . $save->id;
        $save->update($validate);
        DB::commit();
        return redirect(route('adm-penduduk-induk.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(AdpddInduk $adpddInduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdpddInduk $adm_penduduk_induk)
    {
        $penduduk = $adm_penduduk_induk;
        $title = 'Buku Data Induk Penduduk';
        $agama = ['-', 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Kepercayaan'];
        $pendidikan = ['-', 'Tidak/Belum Sekolah', 'Belum Tamat SD/sederajat', 'Tamat SD/sederajat', 'SLTP/sederajat', 'SLTA/sederajat', 'Diploma I/II', 'Akademi/Diploma III/Sarjana Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'];
        $pekerjaan = ['-', 'Belum/Tidak Bekerja', 'Pegawai Negeri Sipil (PNS)', 'TNI', 'POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Buruh', 'Nelayan', 'Mahasiswa', 'Petani', 'Pekebun', 'Pedagang', 'Pegawai Swasta', 'Pensiunan', 'Pekerja Lepas', 'Mengurus Rumah Tangga', 'Dosen', 'Pekerjaan lainnya', 'TKI', 'Asisten Rumah Tangga', 'ASN', 'Guru', 'Wartawan', 'Perawat'];
        $status_kawin = ['-', 'Belum Kawin', 'Kawin', 'Janda', 'Duda', 'Cerai Mati', 'Kawin Belum Tercatat', 'Cerai Hidup Tercatat', 'Cerai Hidup Belum Tercatat'];
        $hubungan = ['-', 'Kepala Keluarga', 'Suami', 'Istri', 'Anak Kandung', 'Anak Angkat', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili lain', 'Pembantu', 'Lainnya'];
        $bacahuruf = ['-', 'A', 'D', 'L', 'AD', 'AL', 'LD', 'ALD'];
        $jkn = ['-', 'BPJS-PBI', 'BPJS-Non PBI', 'Non BPJS', 'Tidak Memiliki', 'KIS', 'BPJS Mandiri'];
        return view('sid.v3.adm-penduduk.induk.edit', compact('title', 'penduduk', 'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 'hubungan', 'bacahuruf', 'jkn'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePendudukReq $request, AdpddInduk $adm_penduduk_induk)
    {
        DB::beginTransaction();
        $nikDecrypt = $adm_penduduk_induk->nik;
        $validate = $request->validated();
        $validate['mutasi'] = $adm_penduduk_induk->mutasi == 'baru' ? '-' : $adm_penduduk_induk->mutasi;
        $validate['id_ktp'] = $request->id_ktp ?? $request->nik;
        $adm_penduduk_induk->update($validate);
        $dataPerangkat = PerangkatDesa::where('nik', $nikDecrypt)->first();
        if ($dataPerangkat) {
            $data['id_ktp'] = $request->id_ktp ?? $request->nik;
            $data['nik'] = $request->nik;
            $data['nama'] = $adm_penduduk_induk->nama;
            $dataPerangkat->update($data);
        }
        DB::commit();
        return redirect()->route('adm-penduduk-induk.index')->with('success', 'Edit Successfully');
    }

    // -- Import  --
    // public function importExcel(Request $request)
    // {
    //     try {
    //         // 1. Validasi file
    //         $request->validate([
    //             'file' => 'required|mimes:xlsx,xls',
    //         ]);
    //         $userId = auth()->user()->id;
    //         $key = 'import_excel_' . $userId;
    //         // 2. Cek rate limiting
    //         if (RateLimiter::tooManyAttempts($key, 1)) {
    //             $seconds = RateLimiter::availableIn($key);
    //             return response()->json([
    //                 'status' => 'error',
    //                 // 'message' => "Mohon tunggu " . ceil($seconds / 60) . " menit sebelum melakukan import lagi"
    //                 'message' => "Mohon tunggu " . $seconds . " detik sebelum melakukan import lagi"
    //             ]);
    //         }
    //         // 3. Hitung jumlah baris terlebih dahulu
    //         $path = $request->file('file')->getRealPath();
    //         $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
    //         $worksheet = $spreadsheet->getActiveSheet();
    //         $highestRow = $worksheet->getHighestDataRow();
    //         // Kurangi 1 untuk header
    //         $dataRows = $highestRow - 1;
    //         // 4. Validasi jumlah baris
    //         if ($dataRows > batasRowImport()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => "Maksimal " . batasRowImport() . " baris. File Anda memiliki " . $dataRows . " baris."
    //             ]);
    //         }
    //         // 5. Jika lolos validasi, lakukan import
    //         $import = new IndukImport();
    //         Excel::import($import, $request->file('file'));
    //         $errors = $import->getErrors();
    //         if (!empty($errors)) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => $errors,
    //             ]);
    //         }
    //         // 6. Set rate limiting setelah berhasil import
    //         RateLimiter::hit($key, waktuDelayImport());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Data berhasil diimpor'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan saat impor data: ' . $e->getMessage()
    //         ]);
    //     }
    // }
    // -- Export Excel --
    public function exportToExcel(Request $request)
    {
        return Excel::download(new IndukExport($request), 'data-induk-penduduk.xlsx');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdpddInduk $adm_penduduk_induk)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $adm_penduduk_induk->nik . ' ' . $adm_penduduk_induk->nama,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        // $cekMutasi = AdpddMutasi::where('adpdd_induk_id', $adm_penduduk_induk->id)->first();
        // $cekAgtLembaga = AdprofAnggota::where('adpdd_induk_id', $adm_penduduk_induk->id)->first();
        // $cekDdk = DdkKk::where('adpdd_induk_id', $adm_penduduk_induk->id)->first();
        // $cekDdkPersonil = DdkPersonil::where('adpdd_induk_id', $adm_penduduk_induk->id)->first();
        // $cekSurket = AdsrtPermohonan::where('nik', $adm_penduduk_induk->nik)->first();
        $cekPerangkat = PerangkatDesa::where('nik', $adm_penduduk_induk->nik)->first();
        // if ($cekMutasi || $cekAgtLembaga || $cekDdk || $cekDdkPersonil || $cekSurket || $cekPerangkat) {
        if ( $cekPerangkat) {
            $status = 'error';
            $msg = 'Data tidak dapat dihapus karena sudah terhubung dengan database lain';
        } else {
            $status = 'success';
            $msg = 'Succesfully Deleted Data';
            $adm_penduduk_induk->delete();
        }
        DB::commit();
        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
    }
}
