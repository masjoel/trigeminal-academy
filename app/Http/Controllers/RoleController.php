<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleManagement;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRoleReq;
use App\Http\Requests\UpdateRoleReq;
use App\Models\PermissionManagement;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:seting-roles')->only(['index', 'show']);
        $this->middleware('can:seting-roles.create')->only(['create', 'store']);
        $this->middleware('can:seting-roles.edit')->only(['edit', 'update']);
        $this->middleware('can:seting-roles.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = RoleManagement::orderBy('id', 'desc')->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);
        $title = 'Roles';
        return view('backend.roles.index', compact('roles', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Role';
        return view('backend.roles.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleReq $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $validate['name'] = strtolower($validate['name']);
        $validate['guard_name'] = 'web';
        RoleManagement::create($validate);
        DB::commit();
        return redirect(route('roles.index'))->with('success', 'Data berhasil ditambahkan');
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
    public function edit(RoleManagement $role)
    {
        $title = 'Role';
        $permissions = PermissionManagement::where('name', 'not like', '%.%')->get();
        $permissionChilds = PermissionManagement::where('name', 'like', '%.%')->get();
        return view('backend.roles.edit', compact('title', 'role', 'permissions', 'permissionChilds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleReq $request, RoleManagement $role)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $validate['name'] = strtolower($validate['name']);
        $validate['guard_name'] = 'web';
        $role->update($validate);
        DB::commit();
        return redirect()->route('roles.index')->with('success', 'Edit Role Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleManagement $role)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $role->name,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        $role->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
