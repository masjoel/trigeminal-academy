<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $title = 'Checkout';
        return view('checkout.index', compact('cart', 'title'));
    }

    public function process(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get cart from session
            $cart = session()->get('cart', []);

            // Sesuaikan validasi dengan field yang ada
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => empty(Auth::user()) ? ['required', 'string', 'min:8'] : [], // Password hanya required untuk user baru
                'phone' => ['required', 'string'],
                'address' => ['required', 'string'],
                'payment_method' => ['required', 'in:transfer,ewallet,cod']
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (empty(Auth::user())) {
                // Create new user jika belum login
                $user = User::create([
                    'username' => $request->username,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'role' => 'user'
                ]);

                // Login user baru
                Auth::login($user);
                $request->session()->regenerate();
            } else {
                // Update data user yang sudah login
                $user = Auth::user();
                $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }

            // Create order
            $total = collect($cart)->sum(
                fn($item) => ($item['price'] * (1 - $item['discount'] / 100) * $item['quantity'])
            );

            $order = Order::create([
                'invoice' => 'INV-' . date('YmdHis'),
                'total_price' => $total,
                'customer_id' => Auth::id(),
                'payment_status' => 1,
                'payment_method' => $request->payment_method,
                'name' => $request->name,
                'phone' => $request->phone,
                'delivery_address' => $request->address,
                'token' => csrf_token()
            ]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'] ?? 0,
                ]);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('checkout.success')
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function checkoutSuccess()
    {
        $title = 'Checkout Berhasil';
        return view('checkout.success', compact('title'));
    }
}
