<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Instructor;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInstructorReq;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:instruktur')->only(['index', 'show']);
        $this->middleware('can:instruktur.create')->only(['create', 'store']);
        $this->middleware('can:instruktur.edit')->only(['edit', 'update']);
        $this->middleware('can:instruktur.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $qry = Instructor::orderBy('id', 'desc');
        $instruktur = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->paginate($limit);
        $title = 'Instruktur';
        return view('backend.e-commerce.instruktur.index', compact('title', 'instruktur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Instruktur';
        return view('backend.e-commerce.instruktur.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructorReq $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $extFile = $photo->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $photo->storeAs('photo_profil', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/photo_profil/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 180 || $height >= 180) {
                    ImageResize::createThumbnail($smallthumbnailpath, 180, 180);
                }
            }
        }

        $validate['approval'] = 'pending';
        $validate['photo'] = $imagePath;
        Instructor::create($validate);
        DB::commit();
        return redirect(route('instruktur.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instruktur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instruktur)
    {
        $title = 'Instruktur';
        return view('backend.e-commerce.instruktur.edit', compact('title', 'instruktur'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInstructorReq $request, Instructor $instruktur)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $imagePath = $instruktur->photo;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $extFile = $photo->getClientOriginalExtension();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $photo->storeAs('photo_profil', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/photo_profil/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 180 || $height >= 180) {
                    ImageResize::createThumbnail($smallthumbnailpath, 180, 180);
                }
            }
        }
        $validate['photo'] = $imagePath;
        $instruktur->update($validate);
        DB::commit();
        return redirect()->route('instruktur.index')->with('success', 'Edit Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instruktur)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => Auth::user()->id,
            'nama' => Auth::user()->username,
            'level' => Auth::user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $instruktur->name,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($instruktur->photo && Storage::disk('public')->exists($instruktur->photo)) {
            Storage::disk('public')->delete($instruktur->photo);
        }
        $instruktur->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
