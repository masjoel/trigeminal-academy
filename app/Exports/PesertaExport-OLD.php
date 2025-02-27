<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PesertaExportOld implements FromCollection, WithHeadings, WithMapping
{
    protected $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    public function collection()
    {
        return Product::where('id', $this->product_id)
            ->with(['orderitems.order.customer'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Produk',
            'Nama Produk',
            'ID',
            'Nama',
            'Email',
            'No. HP',
            'Alamat',
            'Jumlah Dibeli',
            'Total Harga'
        ];
    }

    public function map($product): array
    {
        $data = [];

        foreach ($product->orderitems as $orderItem) {
            $order = $orderItem->order;
            $customer = $order->customer ?? null; // Pastikan ada customer

            if ($customer) {
                $data[] = [
                    $product->id,
                    $product->name,
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone,
                    $customer->address,
                    $orderItem->qty,
                    number_format($orderItem->qty * $orderItem->price, 2),
                ];
            }
        }

        return $data;
    }
}
