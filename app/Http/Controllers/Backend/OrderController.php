<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Ramsey\Uuid\Uuid;
use App\Models\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
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
