<?php

namespace App\Http\Controllers\Webdesa;

use App\Models\Artikel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateCategoryRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:category-artikel')->only(['index', 'show']);
        $this->middleware('can:category-artikel.create')->only(['create', 'store']);
        $this->middleware('can:category-artikel.edit')->only(['edit', 'update']);
        $this->middleware('can:category-artikel.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        if (auth()->user()->role == 'superadmin') {
            $qry = Category::where('tipe', 'post');
        } else {
            $qry = Category::where('tipe', 'post')->where('slug', 'not like', '%galeri%')->where('slug', 'not like', '%struktur%')->where('slug', 'not like', '%perpusdes%');
        }
        $categories = $qry->when($request->input('search'), function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('kategori', 'like', '%' . $search . '%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate($limit);
        $title = 'Kategori';
        return view('pages.v3.category.index', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Kategori';
        return view('pages.v3.category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateCategoryRequest $request)
    {
        DB::beginTransaction();
        $kategori = $request->input('kategori');

        $slug = SlugService::createSlug(Category::class, 'slug', $request->kategori);
        Category::create([
            'iduser' => auth()->user()->id,
            'kategori' => $kategori,
            'slug' => $slug,
            'status' => $request->input('status'),
            'tipe' => 'post',
        ]);

        DB::commit();
        return redirect(route('category.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $title = 'Edit Kategori';
        return view('pages.v3.category.edit', compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        DB::beginTransaction();
        $kategori = $request->input('kategori');
        $slug = $request->slug;
        if ($category->kategori != $kategori) {
            $slug = SlugService::createSlug(Category::class, 'slug', $request->kategori);
        }
        $validate = $request->validated();
        $validate['slug'] = $slug;
        $validate['status'] = $request->input('status');
        $validate['tipe'] = 'post';
        $category->update($validate);

        DB::commit();
        return redirect(route('category.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $category->kategori,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        $cek = Artikel::where('category_id', $category->id)->count();
        if ($cek > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal Dihapus, kategori sudah digunakan di database lain !'
            ]);
        }
        $category->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
