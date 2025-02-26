<?php

namespace App\Http\Controllers\Backend;

use Ramsey\Uuid\Uuid;
use App\Models\Student;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInstructorReq;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:student')->only(['index', 'show']);
        $this->middleware('can:student.create')->only(['create', 'store']);
        $this->middleware('can:student.edit')->only(['edit', 'update']);
        $this->middleware('can:student.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $qry = Student::orderBy('id', 'desc');
        $student = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->paginate($limit);
        $title = 'Peserta';
        return view('backend.student.index', compact('title', 'student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Peserta';
        return view('backend.student.create', compact('title'));
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
        Student::create($validate);
        DB::commit();
        return redirect(route('student.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $title = 'Peserta';
        return view('backend.student.show', compact('title', 'student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $title = 'Peserta';
        return view('backend.student.edit', compact('title', 'student'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInstructorReq $request, Student $student)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $imagePath = $student->photo;
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
        $student->update($validate);
        DB::commit();
        return redirect()->route('student.index')->with('success', 'Edit Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => Auth::user()->id,
            'nama' => Auth::user()->username,
            'level' => Auth::user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $student->name,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }

}