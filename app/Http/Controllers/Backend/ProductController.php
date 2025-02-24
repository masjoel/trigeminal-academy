<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Instructor;
use App\Models\ImageResize;
use Illuminate\Support\Str;
use App\Models\ImageArticle;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductReq;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:course')->only(['index']);
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
        $qry = Product::with('productCategory', 'instruktur')->orderBy('id', 'desc');
        $products = $qry->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate($limit);
        $title = 'Course';
        return view('backend.e-commerce.product.index', compact('products', 'nomor', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = ProductCategory::orderBy('name', 'asc')->get();
        $instruktur = Instructor::orderBy('nama', 'asc')->get();
        $title = 'Course';
        return view('backend.e-commerce.product.create', compact('category', 'instruktur', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductReq $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        $deskripsi = $request->input('description');
        preg_match_all('/src=["\']data:image\/([a-zA-Z]*);base64,([^\s"]+)[^>]/', $deskripsi, $matches, PREG_SET_ORDER);
        $path = 'file_artikel/';
        foreach ($matches as $match) {
            $extension = $match[1];
            $base64_str = $match[2];
            $image = base64_decode($base64_str);
            $nama_file = Uuid::uuid1()->getHex() . '.' . $extension;
            Storage::disk('public')->put($path . $nama_file, $image);
            $smallthumbnailpath = public_path('storage/file_artikel/' . $nama_file);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 1200 || $height >= 800) {
                    ImageResize::createThumbnail($smallthumbnailpath, 1200, 800);
                }
            }
            $dataImageArticle[] = $path . $nama_file;

            $deskripsi = str_replace('data:image/' . $extension . ';base64,' . $base64_str, '../../storage/' . $path . $nama_file, $deskripsi);
        }

        $imagePath = null;
        $videoPath = null;
        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url');
            $extFile = $image_url->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $image_url->storeAs('product_img', $nameFile, 'public');
            $thumbnail = $image_url->storeAs('thumb/product_img', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/product_img/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/product_img/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 300 || $height >= 185) {
                    ImageResize::createThumbnail($smallthumbnailpath, 300, 185);
                }
            }
        }
        if ($request->hasFile('video_file')) {
            $video_file = $request->file('video_file');
            $extFile = $video_file->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $videoPath = $video_file->storeAs('product_video', $nameFile, 'public');
            $videoUrl = $videoPath;
        } else {
            $videoUrl = $request->input('video_url');
        }
        if (str_contains($videoPath, 'youtube')) {
            $videoUrl = Str::replace('/watch?v=', '/embed/', $videoUrl);
        }

        $validate['description'] = $deskripsi;
        $validate['slug'] = $slug;
        $validate['image_url'] = $imagePath;
        $validate['video_url'] = $videoUrl;
        $validate['user_id'] = Auth::user()->id;
        $save = Product::create($validate);
        if (isset($dataImageArticle)) {
            foreach ($dataImageArticle as $key => $value) {
                $dataImageArticle['artikel_id'] = $save->id;
                $dataImageArticle['image'] = $value;
                ImageArticle::create($dataImageArticle);
            }
        }
        DB::commit();
        return redirect(route('course.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $course)
    {
        $title = 'Course';
        if (Auth::user()->role == 'user') {
            $totStudent = Order::where('customer_id', $course->id)->count();
            $myCourses = OrderItem::with('product', 'order')->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')->where('order_items.product_id', $course->id)->where('orders.customer_id', Auth::user()->id)->first();
            // dd($myCourses->payment_status);
            // dd($myCourses[0]->payment_status);
            return view('backend.e-commerce.product.show-student', compact('title', 'course', 'totStudent', 'myCourses'));
        }
        $totStudent = Order::where('customer_id', $course->id)->count();
        return view('backend.e-commerce.product.show', compact('title', 'course', 'totStudent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $course)
    {
        $title = 'Course';
        $category = ProductCategory::orderBy('name', 'asc')->get();
        $instruktur = Instructor::orderBy('nama', 'asc')->get();
        return view('backend.e-commerce.product.edit', compact('category', 'instruktur', 'title', 'course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductReq $request, Product $course)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $title = $request->input('name');
        $videoUrl = $request->input('video_url');
        $slug = $course->slug;
        $imagePath = $course->image_url;
        $videoPath = $course->video_url;
        if ($course->title != $title) {
            $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        }
        if ($videoPath !== $videoUrl && $videoUrl) {
            $videoPath = $videoUrl;
        }
        $deskripsi = $request->input('description');
        preg_match_all('/src=["\']data:image\/([a-zA-Z]*);base64,([^\s"]+)[^>]/', $deskripsi, $matches, PREG_SET_ORDER);
        $path = 'file_artikel/';
        $dataImageArticle = [];
        $gambarLama = ImageArticle::where('artikel_id', $course->id)->pluck('image')->toArray();
        $gambarYangMasihDigunakan = [];

        if (!empty($matches[1])) {
            foreach ($matches[1] as $src) {
                if (str_starts_with($src, 'data:image/')) {
                    preg_match('/data:image\/([a-zA-Z]*);base64,([^"]+)/', $src, $match);
                    $extension = $match[1];
                    $base64_str = $match[2];
                    $image = base64_decode($base64_str);
                    $nama_file = Uuid::uuid1()->getHex() . '.' . $extension;
                    Storage::disk('public')->put($path . $nama_file, $image);
                    $dataImageArticle[] = $path . $nama_file;
                    $deskripsi = str_replace($src, '../../storage/' . $path . $nama_file, $deskripsi);
                } elseif (str_contains($src, '../../storage/')) {
                    $relativePath = str_replace('../../storage/', '', $src);
                    if (in_array($relativePath, $gambarLama)) {
                        $gambarYangMasihDigunakan[] = $relativePath;
                    }
                }
            }
        }

        $gambarYangHarusDihapus = array_diff($gambarLama, $gambarYangMasihDigunakan);
        foreach ($gambarYangHarusDihapus as $gambar) {
            Storage::disk('public')->delete($gambar);
            ImageArticle::where('artikel_id', $course->id)->where('image', $gambar)->delete();
        }
        foreach ($dataImageArticle as $imagePath) {
            ImageArticle::create([
                'artikel_id' => $course->id,
                'image' => $imagePath,
            ]);
        }

        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url');
            $extFile = $image_url->getClientOriginalExtension();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Storage::disk('public')->delete('thumb/' . $imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $image_url->storeAs('product_img', $nameFile, 'public');
            $thumbnail = $image_url->storeAs('thumb/product_img', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/product_img/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 800 || $height >= 600) {
                    ImageResize::createThumbnail($smallthumbnailpath, 800, 600);
                }
            }

            $smallthumbnailpath = public_path('storage/thumb/product_img/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 200 || $height >= 185) {
                    ImageResize::createThumbnail($smallthumbnailpath, 200, 185);
                }
            }
        }
        if ($request->hasFile('video_file')) {
            $video_file = $request->file('video_file');
            $extFile = $video_file->getClientOriginalExtension();
            if ($videoPath && Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $videoPath = $video_file->storeAs('product_video', $nameFile, 'public');
            $videoUrl = $videoPath;
        } else {
            $videoUrl = $request->input('video_url');
        }
        if (str_contains($videoPath, 'youtube')) {
            $videoUrl = Str::replace('/watch?v=', '/embed/', $videoUrl);
        }
        $validate['description'] = $deskripsi;
        $validate['slug'] = $slug;
        $validate['image_url'] = $imagePath;
        $validate['video_url'] = $videoUrl;
        $course->update($validate);

        DB::commit();
        return redirect(route('course.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $course)
    {
        DB::beginTransaction();
        $imagePath = $course->image_url;
        $videoPath = $course->video_url;
        $clientIP = request()->ip();
        $log = [
            'iduser' => Auth::user()->id,
            'nama' => Auth::user()->username,
            'level' => Auth::user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $course->name,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
            Storage::disk('public')->delete($videoPath);
        }
        if ($videoPath && Storage::disk('public')->exists($videoPath)) {
            Storage::disk('public')->delete($videoPath);
        }
        $course->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
