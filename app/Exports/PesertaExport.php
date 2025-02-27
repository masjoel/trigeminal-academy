<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PesertaExport implements FromCollection, WithHeadings
{
    protected $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    public function collection()
    {
        $customers = Product::where('id', $this->product_id)
            ->with(['orderitems.order.customer'])
            ->get()
            ->flatMap(function ($product) {
                return $product->orderitems->map(function ($orderItem) {
                    return $orderItem->order->customer->email ?? '';
                });
            })
            ->unique()
            ->values(); 

        $formattedCustomers = $customers->implode(', ');

        return collect([
            ['Email Peserta'],
            [$formattedCustomers]
        ]);
    }

    public function headings(): array
    {
        return [];
    }
}
