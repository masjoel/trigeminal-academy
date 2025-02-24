<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Artikel;
use App\Models\Product;
use App\Models\Student;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\LapakProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Can;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:dashboard-website')->only(['webdesa_dashboard']);
        $this->middleware('can:dashboard-website.create')->only(['webdesa_dashboard']);
        $this->middleware('can:dashboard')->only(['dashboard']);
        $this->middleware('can:dashboard.create')->only(['dashboard']);
    }

    public function index(Request $request)
    {
        $cek1 = cekAktivasi()['cek1'];
        $cek2 = cekAktivasi()['cek2'];
        if ($cek1 == 0 || $cek2 == 0) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route('login'));
        }
        $statistics = Student::selectRaw('SUM(CASE WHEN approval = "approved" THEN 1 ELSE 0 END) as total_pdd')->first();
        $dataArtikel = Artikel::where('jenis', 'post')->limit(5)->latest()->get();
        $dataStudent = Student::limit(5)->latest()->get();
        $courses = Product::with('productCategory', 'instruktur')->where('publish', '1')->limit(3)->latest()->get();
        $totalCourses = Product::where('publish', '1')->count();
        // $myCourses = Order::with('orderItems', 'orderItems.product')->where('customer_id', Auth::user()->id)->get();
        $myCourses = OrderItem::with('product','order')->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')->where('orders.customer_id', Auth::user()->id)->get();
        // dd($myCourses);
        $title = 'Dashboard';
        $halaman = Auth::user()->role == 'user' ? 'dashboard-student' : 'dashboard';
        return view('backend.' . $halaman, compact('title', 'statistics', 'dataArtikel', 'courses', 'totalCourses', 'dataStudent', 'myCourses'));
    }
}
