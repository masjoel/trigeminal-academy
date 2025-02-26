<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Order;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\StoreOrderReq;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:orders')->only(['index', 'show']);
        $this->middleware('can:orders.create')->only(['create', 'store']);
        $this->middleware('can:orders.edit')->only(['edit', 'update']);
        $this->middleware('can:orders.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 12);
        $nomor = ($page - 1) * $limit + 1;
        $qry4 = Order::orderBy('id', 'desc');
        $totalPending = Order::where('payment_status', '1')->sum('total_price');
        $totalKonfirm = Order::where('payment_status', '2')->sum('total_price');
        $totalFinish = Order::where('payment_status', '4')->sum('total_price');
        $totalBatal = Order::where('payment_status', '5')->sum('total_price');

        $products = $qry4->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate($limit);
        $title = 'Order';
        return view('backend.e-commerce.order.index', compact('products', 'nomor', 'title', 'totalPending', 'totalKonfirm', 'totalFinish', 'totalBatal'));
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $detail = OrderItem::with('product')->where('order_id', $order->id)->get();
        $customer = User::where('id', $order->user_id)->first();
        return view('backend.e-commerce.order.edit')->with(['order' => $order, 'customer' => $customer, 'detail' => $detail, 'title' => 'Detail order']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrderReq $request, Order $order)
    {
        DB::beginTransaction();
        $validate = $request->validated();
        $imagePath = $order->bukti_bayar;
        if ($request->hasFile('bukti_bayar')) {
            $bukti_bayar = $request->file('bukti_bayar');
            $extFile = $bukti_bayar->getClientOriginalExtension();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $bukti_bayar->storeAs('product_img', $nameFile, 'public');
            $thumbnail = $bukti_bayar->storeAs('thumb/product_img', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/product_img/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 600 || $height >= 540) {
                    ImageResize::createThumbnail($smallthumbnailpath, 600, 540);
                }
            }
            $smallthumbnailpath = public_path('storage/thumb/product_img/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 150 || $height >= 150) {
                    ImageResize::createThumbnail($smallthumbnailpath, 150, 150);
                }
            }
        }
        $validate['bukti_bayar'] = $imagePath;
        $order->update($validate);
        DB::commit();
        return redirect()->route('order.index')->with('success', 'Update Order Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        if ($order->bukti_bayar && Storage::disk('public')->exists($order->bukti_bayar)) {
            Storage::disk('public')->delete($order->bukti_bayar);
            Storage::disk('public')->delete('thumb/' . $order->bukti_bayar);
        }
        $item = OrderItem::where('order_id', $order->id)->get();
        foreach ($item as $value) {
            $product = Product::where('in_stock', 0)->find($value->product_id);
            if ($product !== null) {
                $product->stock += $value->quantity;
                $product->save();
            }
        }
        $order->delete();
        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Succesfully Deleted Data'
        ]);
    }
    public function konfirmasiPembayaran($id)
    {
        $order = Order::with('orderItems', 'orderItems.product', 'orderItems.product.instruktur')->find($id);
        $title = 'Konfirmasi Pembayaran';
        return view('backend.e-commerce.konfirmasi', compact('title', 'order'));
    }
    public function konfirmasiPembayaranSuccess(Request $request)
    {
        DB::beginTransaction();
        $order = Order::find($request->order_id);
        $oldImage = $order->bukti_bayar;
        $imagePath = null;
        if ($request->hasFile('bukti_bayar')) {
            $photo = $request->file('bukti_bayar');
            $extFile = $photo->getClientOriginalExtension();
            $nameFile = Uuid::uuid1()->getHex() . '.' . $extFile;
            $imagePath = $photo->storeAs('bukti_bayar', $nameFile, 'public');

            $smallthumbnailpath = public_path('storage/bukti_bayar/' . $nameFile);
            $imageInfo = ImageResize::getFileImageSize($smallthumbnailpath);
            if ($imageInfo) {
                $width = $imageInfo['width'];
                $height = $imageInfo['height'];
                if ($width >= 400 || $height >= 400) {
                    ImageResize::createThumbnail($smallthumbnailpath, 400, 400);
                }
            }
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $validate['bukti_bayar'] = $imagePath;
            $validate['payment_status'] = 2;
            $order->update($validate);
        }
        DB::commit();
        return redirect(route('dashboard'))->with('success', 'Konfirmasi pembayaran berhasil disimpan');
    }
}
