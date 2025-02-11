<?php

namespace App\Http\Controllers;

use App\Models\BackupData;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class BackupDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:seting-backup')->only(['index', 'create', 'download']);
        $this->middleware('can:seting-restore')->only(['upload', 'restore']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $recs = BackupData::where('jenis', 'B')->orderBy('id', 'desc')->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('created_at', 'like', '%' . $search . '%')
            ->orWhere('username', 'like', '%' . $search . '%');
        })->paginate(10);
        $title = 'Backup Data';
        return view('pages.v3.utilities.backup', compact('title', 'recs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Artisan::call('database:backup');
        $files = File::files(storage_path("app/backup/"));
        $filename = $files[count($files) - 1]->getFileName();
        $file_gz = storage_path("app/backup/" . $filename);
        $size = filesize($file_gz) / 1024 / 1024;
        $dataSaved = [
            'nama' => $filename,
            'jenis' => 'B',
            'iduser' => auth()->user()->id,
            'username' => auth()->user()->username,
            'ket' => number_format($size, 2),
        ];
        BackupData::create($dataSaved);
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Backup Data',
        ]);
    }
    public function download($file)
    {
        return response()->download(storage_path('app/backup/' . $file));
    }
    public function upload(Request $request)
    {
        $params = $request->all();
        if ($request->file('file_restore')) {
            $folder = 'restore/';
            $file = $request->file('file_restore');
            $filename =  $file->getClientOriginalName();
            $request->file('file_restore')->storeAs($folder, $filename);

            $file_gz = storage_path("app/restore/" . $filename);
            $size = filesize($file_gz) / 1024 / 1024;

            $dataSaved = [
                'nama' => $filename,
                'jenis' => 'R',
                'iduser' => auth()->user()->id,
                'username' => auth()->user()->username,
                'ket' => number_format($size, 2),
            ];
            BackupData::create($dataSaved);
            Artisan::call('unzip:gz');
            Artisan::call('database:restore');
            BackupData::create($dataSaved);
            return response()->json([
                'status' => 'success',
                'message' => 'Succesfully Restore Data',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Ada kesalahan di server',
        ]);
    }

    public function restore(Request $request)
    {
        $title = 'Restore Data';
        $recs = BackupData::where('jenis', 'R')->orderBy('id', 'desc')->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('created_at', 'like', '%' . $search . '%')
            ->orWhere('username', 'like', '%' . $search . '%');
        })->paginate(10);
        return view('pages.v3.utilities.restore', compact('title', 'recs'));
    }
}
