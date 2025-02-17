<?php

namespace App\Http\Controllers\Frontend;

use Ramsey\Uuid\Uuid;
use App\Models\AdpddInduk;
use App\Models\Attendance;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePerangkatReq;
use App\Http\Requests\UpdatePerangkatReq;
use App\Models\Anggota;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PerangkatDesaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-pengurus')->only(['index', 'show', 'absensi', 'absensiDetail']);
        $this->middleware('can:admin-pengurus.create')->only(['create', 'store']);
        $this->middleware('can:admin-pengurus.edit')->only(['edit', 'update']);
        $this->middleware('can:admin-pengurus.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = PerangkatDesa::orderBy('id', 'desc');
        $aparat = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%')
                ->orWhere('jabatan', 'like', '%' . $search . '%');
        })
            ->paginate($limit);
        $title = 'Anggota Pengurus';
        return view('backend.admin-pengurus.index', compact('title', 'aparat'));
    }

    public function absensi(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Attendance::with('perangkatDesa')
            // ->whereDate('date', Carbon::today())
            ->orderBy('id', 'desc');
        $aparat = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('time_in', 'like', '%' . $search . '%')
                ->orWhere('time_out', 'like', '%' . $search . '%')
                ->orWhereHas('perangkatDesa', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('jabatan', 'like', '%' . $search . '%');
                });
        })
            ->paginate($limit);
        // dd($aparat);
        $title = 'Absensi Kehadiran';
        return view('backend.admin-pengurus.absensi', compact('title', 'aparat'));
    }
    public function datatableAbsensi(Request $request)
    {
        $query = Attendance::with('perangkatDesa')->select('attendances.*');

        return DataTables::of($query)
            ->filter(function ($instance) use ($request) {
                if ($request->get('search')['value']) {
                    $search = strtolower($request->get('search')['value']);
                    $instance->where(function ($w) use ($search) {
                        $w->orWhereRaw('LOWER(attendances.date) LIKE ?', ["%$search%"])
                            ->orWhereRaw('LOWER(attendances.time_in) LIKE ?', ["%$search%"])
                            ->orWhereRaw('LOWER(attendances.time_out) LIKE ?', ["%$search%"])
                            ->orWhereRaw('LOWER(attendances.time_out) LIKE ?', ["%$search%"])
                            ->orWhereHas('perangkatDesa', function ($query) use ($search) {
                                $query->whereRaw('LOWER(perangkat_desas.nama) LIKE ?', ["%$search%"])
                                    ->orWhereRaw('LOWER(perangkat_desas.jabatan) LIKE ?', ["%$search%"]);
                            });
                    });
                }
            })
            ->addColumn('fotoPerangkat', function ($row) {
                $src = $row->foto !== null
                    ? Storage::url($row->foto)
                    : asset('img/example-image-50.jpg');
                return '<img class="rounded-circle mr-3 foto-detail" width="50" height="50" src="' . $src . '" alt="avatar" data-toggle="modal" data-target="#detail-' . $row->id . '" title="Detail">';
            })
            ->addColumn('namaPerangkat', function ($row) {
                return  $row->perangkatDesa->nama;
            })
            ->addColumn('format_tgl', function ($row) {
                return '<span class="text-nowrap">' . tgldmY($row->date) . '</span>';
            })
            ->addColumn('datang', function ($row) {
                return '<span class="text-nowrap">' . $row->time_in . '</span>';
            })
            ->addColumn('pulang', function ($row) {
                return '<span class="text-nowrap">' . $row->time_out . '</span>';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('admin-perangkat-desa.absensi.detail', $row->id) . '" class="detil btn btn-info btn-sm"><i class="fa fa-eye me-2"></i>Detail</a>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'fotoPerangkat', 'namaPerangkat', 'format_tgl', 'datang', 'pulang'])
            ->make(true);
    }

    public function absensiDetail($id)
    {
        $absensi = Attendance::with('perangkatDesa')->findOrFail($id);
        $title = 'Detail Absensi Kehadiran';
        return view('backend.admin-pengurus.absensi-detail', compact('title', 'absensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Anggota Pengurus';
        $jabatan = ['Ketua', 'Sekretaris', 'Sekretaris 2', 'Bendahara', 'Bendahara 2', 'Pejabat lainnya'];
        $penduduk = AdpddInduk::all();
        return view('backend.admin-pengurus.create', compact('title', 'jabatan', 'penduduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerangkatReq $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $imagePath = Anggota::where('nik', $request->nik)->value('image');
        $slug = SlugService::createSlug(PerangkatDesa::class, 'slug', $request->nama);
        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $extFile = $avatar->getClientOriginalExtension();
        //     $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
        //     $imagePath = $avatar->storeAs('perangkat', $nameFile, 'public');
        //     $thumbnail = $avatar->storeAs('thumb/perangkat', $nameFile, 'public');

        //     $smallthumbnailpath = public_path('storage/perangkat/' . $nameFile);
        //     $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
        //     if ($imageInfo) {
        //         $width = $imageInfo['width'];
        //         $height = $imageInfo['height'];
        //         if ($width >= 200 || $height >= 300) {
        //             ImageResize::createThumbnail($smallthumbnailpath, 200, 300);
        //         }
        //     }
        //     $smallthumbnailpath = public_path('storage/thumb/perangkat/' . $nameFile);
        //     $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
        //     if ($imageInfo) {
        //         $width = $imageInfo['width'];
        //         $height = $imageInfo['height'];
        //     }
        //     if ($width >= 150 || $height >= 200) {
        //         ImageResize::createThumbnail($smallthumbnailpath, 150, 200);
        //     }
        // }

        $validate['id_ktp'] = $request->input('id_ktp') ?? $request->input('nik');
        $validate['slug'] = $slug;
        $validate['password'] = Hash::make($request->input('password'));
        $validate['avatar'] = $imagePath;
        $validate['user_id'] = auth()->user()->id;
        PerangkatDesa::create($validate);

        DB::commit();
        return redirect(route('admin-pengurus.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerangkatDesa $admin_penguru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerangkatDesa $admin_penguru)
    {
        $title = 'Anggota Pengurus';
        $jabatan = ['Ketua', 'Sekretaris', 'Sekretaris 2', 'Bendahara', 'Bendahara 2', 'Pejabat lainnya'];
        $penduduk = AdpddInduk::all();
        // $jsonString = json_encode($penduduk);
        // $penduduk = json_decode($jsonString);
        return view('backend.admin-pengurus.edit', compact('title', 'admin_penguru', 'jabatan', 'penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerangkatReq $request, PerangkatDesa $admin_penguru)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $title = $request->input('title');
        $slug = $admin_penguru->slug;
        $deskripsi = $request->input('deskripsi');
        if ($admin_penguru->title != $title) {
            $slug = SlugService::createSlug(PerangkatDesa::class, 'slug', $request->title);
        }
        // $imagePath = $admin_penguru->avatar;
        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $extFile = $avatar->getClientOriginalExtension();
        //     if ($imagePath && Storage::disk('public')->exists($imagePath)) {
        //         Storage::disk('public')->delete($imagePath);
        //         Storage::disk('public')->delete('thumb/' . $imagePath);
        //     }
        //     $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
        //     $imagePath = $avatar->storeAs('perangkat', $nameFile, 'public');
        //     $thumbnail = $avatar->storeAs('thumb/perangkat', $nameFile, 'public');

        //     $smallthumbnailpath = public_path('storage/perangkat/' . $nameFile);
        //     $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
        //     if ($imageInfo) {
        //         $width = $imageInfo['width'];
        //         $height = $imageInfo['height'];
        //         if ($width >= 200 || $height >= 300) {
        //             ImageResize::createThumbnail($smallthumbnailpath, 200, 300);
        //         }
        //     }

        //     $smallthumbnailpath = public_path('storage/thumb/perangkat/' . $nameFile);
        //     $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
        //     if ($imageInfo) {
        //         $width = $imageInfo['width'];
        //         $height = $imageInfo['height'];
        //     }
        //     if ($width >= 150 || $height >= 200) {
        //         ImageResize::createThumbnail($smallthumbnailpath, 150, 200);
        //     }
        // }
        $validate = $request->validated($request->id);
        if (!empty($request->input('password'))) {
            $validate['password'] = Hash::make($request->input('password'));
        } else {
            $validate['password'] = $admin_penguru->password;
        }
        $validate['id_ktp'] = $request->input('id_ktp') ?? $request->input('nik');
        $validate['slug'] = $slug;
        $validate['password'] = Hash::make($request->input('password'));
        // $validate['avatar'] = $imagePath;
        $admin_penguru->update($validate);

        DB::commit();
        return redirect(route('admin-pengurus.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerangkatDesa $admin_penguru)
    {
        DB::beginTransaction();
        $imagePath = $admin_penguru->foto_unggulan;
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $admin_penguru->nama,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
        }
        $admin_penguru->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
