<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Student;
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
                'username' => Auth::user() ? ['required', 'string', 'max:255'] : ['required', 'string', 'max:255', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'email' => Auth::user() ? ['required', 'string', 'email', 'max:255'] : ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string'],
                'payment_method' => ['required'],
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
                Student::create([
                    'user_id' => $user->id,
                    'nama' => $request->name,
                    'email' => $request->email,
                    'telpon' => $request->phone,
                    'alamat' => $request->address,
                ]);
                // Login user baru
                Auth::login($user);
                $request->session()->regenerate();
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
                ->with('success', 'Order successfully created!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout Error: ' . $e->getMessage());

            return back()
                ->with('error', 'There is an error: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function checkoutSuccess()
    {
        $title = 'Checkout Successful';
        return view('checkout.success', compact('title'));
    }
}