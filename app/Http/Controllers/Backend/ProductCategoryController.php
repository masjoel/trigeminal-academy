<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductCatReq;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:kategori-kursus')->only(['index', 'show']);
        $this->middleware('can:kategori-kursus.create')->only(['create', 'store']);
        $this->middleware('can:kategori-kursus.edit')->only(['edit', 'update']);
        $this->middleware('can:kategori-kursus.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $qry = ProductCategory::orderBy('id', 'desc');
        $categories = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->paginate($limit);
        $title = 'Kategori';
        return view('backend.e-commerce.kategori.index', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Kategori';
        return view('backend.e-commerce.kategori.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCatReq $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $validate['user_id'] = Auth::user()->id;
        ProductCategory::create($validate);
        DB::commit();
        return redirect(route('kategori-kursus.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $kategori_kursu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $kategori_kursu)
    {
        $title = 'Kategori';
        $category = $kategori_kursu;
        return view('backend.e-commerce.kategori.edit', compact('title', 'category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductCatReq $request, ProductCategory $kategori_kursu)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $kategori_kursu->update($validate);
        DB::commit();
        return redirect()->route('kategori-kursus.index')->with('success', 'Edit Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $kategori_kursu)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => Auth::user()->id,
            'nama' => Auth::user()->username,
            'level' => Auth::user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $kategori_kursu->name,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        $kategori_kursu->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
