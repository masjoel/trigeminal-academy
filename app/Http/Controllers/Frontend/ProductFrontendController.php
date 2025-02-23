<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class ProductFrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Kelas Online';
        $query = Product::with('productCategory', 'instruktur', 'productContent', 'orderitems')->where('publish', '1');

        if($request->search) {
            $query->where('name', 'like', '%'. $request->search .'%');
        }
        if($request->category) {
            $query->where('category_id', $request->category);
        }
        switch($request->sort) {
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            case 'harga_terendah':
                $query->orderBy('price', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('price', 'desc');
                break;
            default:
            $query->orderBy('created_at', 'desc');
        }

        // $courses = Product::with('productCategory', 'instruktur', 'productContent')->where('publish', '1')->get();
        $courses = $query->paginate(9);
        $categories = ProductCategory::all();

        return view('frontend.product.index', compact(
            'title',
            'courses',
            'categories'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function process()
    {
        $title = 'Proses Data';
        return view('frontend.product.process', compact('title'));
    }

    public function keranjang(Request $request)
    {
        $cartIds = json_decode($request->input('cart_items'), true);

        if (!$cartIds || !is_array($cartIds)) {
            $cartIds = [];
        }

        $courses = Product::whereIn('id', $cartIds)->where('publish', '1')->get();

        $title = 'Keranjang Belanja';
        return view('frontend.product.keranjang', compact(
            'title',
            'courses'
        ));
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
    public function show($slug)
    {
        $title = 'Show';
        $course = Product::with('productCategory', 'instruktur', 'productContent', 'orderitems')->where('slug', $slug)->where('publish', '1')->limit(3)->firstOrFail();

        return view('frontend.product.show', compact(
            'title',
            'course'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
