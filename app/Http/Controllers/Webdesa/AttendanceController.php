<?php

namespace App\Http\Controllers\Webdesa;

use App\Models\Provinsi;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AttendanceProsesRequest;

class AttendanceController extends Controller
{
    public function index()
    {
        if (!Session::has('absensi_user_id')) {
            return redirect()->route('absensi.login')->with('error', 'Silahkan login terlebih dahulu');
        }
        $userId = Session::get('absensi_user_id');
        $user = PerangkatDesa::find($userId);
        $absensi = Attendance::where('user_id', $user->id)->where('date', Carbon::today())->first();
        $title = 'Absensi Kehadiran';
        return view('pages.absensi.index', compact('title', 'user', 'absensi'));
    }

    public function login()
    {
        // if (Session::has('absensi_user_id')) {
        //     return redirect()->route('absensi');
        // }
        Session::forget('absensi_user_id');
        $title = 'Absensi Kehadiran';
        return view('pages.absensi.login', compact('title'));
    }

    public function auth(AttendanceProsesRequest $request)
    {
        DB::beginTransaction();
        $validasi = $request->validated();
        $cekUser = PerangkatDesa::where('nik', $validasi['username'])->orWhere('id_ktp', $validasi['username'])->first();
        // if ($cekUser && Hash::check($validasi['password'], $cekUser->password)) {
        if ($cekUser) {
            Session::put('absensi_user_id', $cekUser->id);
            DB::commit();
            return redirect()->route('absensi');
        } else {
            DB::rollback();
            return redirect()->route('absensi.login')->with('error', 'NIK tidak terdaftar.');
        }
    }

    public function store(Request $request)
    {
        if (!Session::has('absensi_user_id')) {
            return redirect()->route('absensi.login')->with('error', 'Silahkan login terlebih dahulu');
        }
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'foto' => 'nullable|string', // Mengubah required menjadi nullable
        ], [
            'foto.required' => 'Foto wajib diupload.',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $userId = Session::get('absensi_user_id');
        if (!$userId) {
            return response()->json(['error' => ['Data tidak tidak ditemukan.']]);
        }
        $filename = null;
        if ($request->input('foto')) {
            $data = $request->input('foto');
            if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $type = strtolower($type[1]);
                if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                    return response()->json(['error' => ['Format gambar tidak valid.']]);
                }
                $data = base64_decode($data);
                if ($data === false) {
                    return response()->json(['error' => ['Gagal mendecode gambar.']]);
                }
            } else {
                return response()->json(['error' => ['Data gambar tidak valid.']]);
            }
            $timestamp = Carbon::now()->timestamp;
            $filename = $timestamp . '_' . md5($timestamp) . '.' . $type;
            $path = 'public/absensi/selfie/' . $userId . 'b' . $filename;
            try {
                Storage::put($path, $data);
            } catch (\Exception $e) {
                return response()->json(['error' => ['Terjadi kesalahan saat menyimpan file: ' . $e->getMessage()]]);
            }
        }
        $pesan_upload_sukses = '';
        $cekAbsensi = Attendance::where('user_id', $userId)->where('date', Carbon::today())->first();
        if ($cekAbsensi) {
            $simpan = $cekAbsensi;
            $simpan->date = Carbon::today()->toDateString();
            $simpan->time_out = Carbon::now()->toTimeString();
            if ($filename) {
                $simpan->foto = 'absensi/selfie/' . $userId . 'b' . $filename;
            }
            $simpan->save();
            $pesan_upload_sukses = 'Absensi kepulangan anda telah disimpan.';
        } else {
            $simpan = new Attendance();
            $simpan->user_id = $userId;
            $simpan->date = Carbon::today()->toDateString();
            $simpan->time_in = Carbon::now()->toTimeString();
            if ($filename) {
                $simpan->foto = 'absensi/selfie/' . $userId . 'b' . $filename;
            }
            $simpan->save();
            $pesan_upload_sukses = 'Absensi kedatangan anda telah disimpan.';
        }
        Session::put('get_attendance_id', $pesan_upload_sukses);
        Session::flash('pesan_upload_sukses', $pesan_upload_sukses);
        Session::flash('upload_foto_sukses', true);
        Session::flash('userid_sementara', $userId);
        DB::commit();
        return response()->json(['success' => 'Data absensi telah disimpan.']);
    }




    public function uploadFotoSukses()
    {
        if (!Session::has('absensi_user_id')) {
            return redirect()->route('absensi.login')->with('error', 'Silahkan login terlebih dahulu');
        } else {
            if (!Session::has('upload_foto_sukses')) {
                Session::forget('absensi_user_id');
                return redirect()->route('absensi.login');
            }
            Session::forget('absensi_user_id');
            // return redirect()->route('absensi.info')->with('success', Session::get('pesan_upload_sukses'));
            $title = 'Absensi Kehadiran';
            $absensi = Attendance::where('user_id', Session::get('userid_sementara'))->where('date', Carbon::today())->first();
            return view('pages.absensi.info', compact('title', 'absensi'));
        }
    }

    public function detail()
    {
        if (!Session::has('absensi_user_id')) {
            return redirect()->route('absensi.login')->with('error', 'Silahkan login terlebih dahulu');
        }
        $title = 'Detail Absensi';
        $userId = session('absensi_user_id');
        return view('pages.absensi.detail', compact('title'));
    }

    public function logout()
    {
        Session::forget('absensi_user_id');
        return redirect()->route('absensi.login')->with('success', 'Anda sudah logout');
    }








    public function create()
    {
        //
    }

    public function show(Attendance $attendance)
    {
        //
    }

    public function edit(Attendance $attendance)
    {
        //
    }

    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    public function destroy(Attendance $attendance)
    {
        //
    }
    public function store_old(Request $request)
    {
        // disini masih fitur dimana absen kedatangan & absen kepulangan itu wajib pakai foto selfie
        if (!Session::has('absensi_user_id')) {
            return redirect()->route('absensi.login')->with('error', 'Silahkan login terlebih dahulu');
        }
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'foto' => 'required|string',
        ], [
            'foto.required' => 'Foto wajib diupload.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $userId = Session::get('absensi_user_id');

        if (!$userId) {
            return response()->json(['error' => ['Data tidak tidak ditemukan.']]);
        }

        $data = $request->input('foto');
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                return response()->json(['error' => ['Format gambar tidak valid.']]);
            }
            $data = base64_decode($data);
            if ($data === false) {
                return response()->json(['error' => ['Gagal mendecode gambar.']]);
            }
        } else {
            return response()->json(['error' => ['Data gambar tidak valid.']]);
        }

        $timestamp = Carbon::now()->timestamp;
        $filename = $timestamp . '_' . md5($timestamp) . '.' . $type;
        $path = 'public/absensi/selfie/' . $userId . 'b' . $filename;

        try {
            Storage::put($path, $data);
        } catch (\Exception $e) {
            return response()->json(['error' => ['Terjadi kesalahan saat menyimpan file: ' . $e->getMessage()]]);
        }
        $pesan_upload_sukses = '';
        $cekAbsensi = Attendance::where('user_id', $userId)->where('date', Carbon::today())->first();
        if ($cekAbsensi) {
            $simpan = $cekAbsensi;
            $simpan->date = Carbon::today()->toDateString();
            $simpan->time_out = Carbon::now()->toTimeString();
            $simpan->foto = 'absensi/selfie/' . $userId . 'b' . $filename;
            $simpan->save();
            $pesan_upload_sukses = 'Absensi kepulangan anda telah disimpan.';
        } else {
            $simpan = new Attendance();
            $simpan->user_id = $userId;
            $simpan->date = Carbon::today()->toDateString();
            $simpan->time_in = Carbon::now()->toTimeString();
            $simpan->foto = 'absensi/selfie/' . $userId . 'b' . $filename;
            $simpan->save();
            $pesan_upload_sukses = 'Absensi kedatangan anda telah disimpan.';
        }
        Session::put('get_attendance_id', $pesan_upload_sukses);
        Session::flash('pesan_upload_sukses', $pesan_upload_sukses);
        Session::flash('upload_foto_sukses', true);
        DB::commit();
        return response()->json(['success' => 'Foto berhasil diupload.']);
    }
    public function encrypt()
    {
        echo hash('sha256', '8203202002960001').'<br>';
    }
}
