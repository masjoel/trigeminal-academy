<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PesertaKelasExport implements FromCollection, WithHeadings
{
    protected $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    public function collection()
    {
        $product = Product::with(['instruktur','orderitems.order.customer'])
            ->findOrFail($this->product_id);

        $rows = $product->orderitems
            ->map(function ($orderItem) use ($product) {
                $customer = $orderItem->order->customer;
                $status = $orderItem->order->payment_status == '4' ? 'Lunas' : 'Belum Lunas';

                return [
                    'product_name' => $product->name,
                    'instruktur'   => $product->instruktur->nama ?? '',
                    'customer_name'=> $customer->name ?? '',
                    'email'        => $customer->email ?? '',
                    'phone'        => $customer->phone ?? '',
                    'address'      => $customer->address ?? '',
                    'status'      => $status,
                ];
            })
            ->unique('email')
            ->values();

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Instruktur',
            'Nama',
            'Email',
            'No. HP',
            'Alamat',
            'Status Pembayaran',
        ];
    }
}
