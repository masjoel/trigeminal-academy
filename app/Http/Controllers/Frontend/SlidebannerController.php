<?php

namespace App\Http\Controllers\Frontend;

use Ramsey\Uuid\Uuid;
use App\Models\ImageResize;
use App\Models\Slidebanner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBannerRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class SlidebannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:slide-banner')->only(['index', 'show']);
        $this->middleware('can:slide-banner.create')->only(['create', 'store']);
        $this->middleware('can:slide-banner.edit')->only(['edit', 'update']);
        $this->middleware('can:slide-banner.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $qry = Slidebanner::orderBy('id', 'desc');

        $slidebanners = $qry->when($request->input('search'), function ($query, $search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%');
            });
        })
            ->paginate($limit);
        $title = 'Slide Banner';
        return view('backend.banner.index', compact('title', 'slidebanners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Banner';
        return view('backend.banner.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateBannerRequest $request)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $title = $request->input('title');
        $deskripsi = $request->input('deskripsi');

        $slug = SlugService::createSlug(Slidebanner::class, 'slug', $request->title);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extFile = $image->getClientOriginalExtension();
            // $fileSize = $image->getSize();
            // $fileSizeInKB = $fileSize / 1024;
            // $fileSizeInMB = $fileSizeInKB / 1024;

            // if (!in_array($extFile, ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp']) || $fileSizeInMB > 8) {
            //     return back()->with('error', 'File harus berupa image (jpeg, png, jpg, gif, svg, webp) max. size 8 MB')->withInput();
            // }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $image->storeAs('banner', $nameFile, 'public');
            $thumbnail = $image->storeAs('thumb/banner', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/banner/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                ImageResize::cropImage($smallthumbnailpath, 800, 300);
            }
            $smallthumbnailpath = public_path('storage/thumb/banner/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 200 || $height >= 185) {
                ImageResize::createThumbnail($smallthumbnailpath, 200, 185);
            }
        }
        Slidebanner::create([
            'iduser' => auth()->user()->id,
            'title' => $title,
            'deskripsi' => $deskripsi,
            'slug' => $slug,
            'image' => $imagePath,
            'status' => $request->input('status'),
        ]);

        DB::commit();
        return redirect(route('slidebanner.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slidebanner $slidebanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slidebanner $slidebanner)
    {
        $title = 'Edit Banner';
        return view('backend.banner.edit', compact('title', 'slidebanner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Slidebanner $slidebanner)
    {
        DB::beginTransaction();
        $validate = $request->validated();

        $title = $request->input('title');
        $slug = $slidebanner->slug;
        if ($slidebanner->title != $title) {
            $slug = SlugService::createSlug(Slidebanner::class, 'slug', $request->title);
        }
        $imagePath = $slidebanner->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extFile = $image->getClientOriginalExtension();
            // $fileSize = $image->getSize();
            // $fileSizeInKB = $fileSize / 1024;
            // $fileSizeInMB = $fileSizeInKB / 1024;

            // if (!in_array($extFile, ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp']) || $fileSizeInMB > 8) {
            //     return back()->with('error', 'File harus berupa image (jpeg, png, jpg, gif, svg, webp) max. size 8 MB')->withInput();
            // }
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Storage::disk('public')->delete('thumb/' . $imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $image->storeAs('banner', $nameFile, 'public');
            $thumbnail = $image->storeAs('thumb/banner', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/banner/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                ImageResize::cropImage($smallthumbnailpath, 800, 300);
            }

            $smallthumbnailpath = public_path('storage/thumb/banner/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
            }
            if ($width >= 200 || $height >= 185) {
                ImageResize::createThumbnail($smallthumbnailpath, 200, 185);
            }
        }
        $validate = $request->validated();
        $validate['slug'] = $slug;
        $validate['deskripsi'] = $request->input('deskripsi');
        $validate['status'] = $request->input('status');
        $validate['image'] = $imagePath;
        $slidebanner->update($validate);

        DB::commit();
        return redirect(route('slidebanner.index'))->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slidebanner $slidebanner)
    {
        DB::beginTransaction();
        $imagePath = $slidebanner->image;
        $clientIP = request()->ip();
        $log = [
            'iduser' => auth()->user()->id,
            'nama' => auth()->user()->username,
            'level' => auth()->user()->role,
            'datetime' => date('Y-m-d H:i:s'),
            'do' => 'delete ' . $slidebanner->title,
            'ipaddr' => $clientIP,
        ];
        DB::table('userlog')->insert($log);
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Storage::disk('public')->delete('thumb/' . $imagePath);
        }

        $slidebanner->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
}
