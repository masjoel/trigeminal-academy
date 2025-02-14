<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PermissionManagement;
use App\Http\Requests\StorePermissionReq;
use App\Http\Requests\UpdatePermissionReq;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:seting-permissions')->only(['index', 'show']);
        $this->middleware('can:seting-permissions.create')->only(['create', 'store']);
        $this->middleware('can:seting-permissions.edit')->only(['edit', 'update']);
        $this->middleware('can:seting-permissions.delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = PermissionManagement::orderBy('id', 'desc')->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);
        $title = 'Permissions';
        return view('backend.permissions.index', compact('permissions', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Permissions';
        return view('backend.permissions.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionReq $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $validate['name'] = strtolower($validate['name']);
        $validate['guard_name'] = 'web';
        PermissionManagement::create($validate);
        DB::commit();
        return redirect(route('permissions.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermissionManagement $permission)
    {
        $title = 'Permissions';
        return view('backend.permissions.edit', compact('title', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionReq $request, PermissionManagement $permission)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $validate['name'] = strtolower($validate['name']);
        $validate['guard_name'] = 'web';
        $permission->update($validate);
        DB::commit();
        return redirect()->route('permissions.index')->with('success', 'Edit Role Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermissionManagement $permission)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $permission->name,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        $permission->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
