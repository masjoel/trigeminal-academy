<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:course')->only(['index', 'show']);
        $this->middleware('can:course.create')->only(['create', 'store']);
        $this->middleware('can:course.edit')->only(['edit', 'update']);
        $this->middleware('can:course.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 12);
        $nomor = ($page - 1) * $limit + 1;
        $qry = Product::orderBy('id', 'desc');

        $products = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate($limit);
        $title = 'Course';
        return view('backend.lapak-desa.product.index', compact('products', 'nomor', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
