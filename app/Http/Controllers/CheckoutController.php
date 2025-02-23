<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

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
        DB::beginTransaction();
        $cart = session()->get('cart', []);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $userRole = Role::where('name', 'user')->first();
        // $user->assignRole($userRole);

        $dataUser = User::find(2);
        $permissions = $dataUser->getPermissionNames();
        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($userRole && $permission) {
                $user->assignRole($userRole);
                $user->givePermissionTo($permission);
            }
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        $order = [
            'invoice' => 'INV-' . date('YmdHis'),
            // 'total_budget' => 0,
            // 'total_price' => array_sum(array_column(session()->get('cart', []), 'price')),
            'total_price' => collect($cart)->sum(fn($item) => ($item['price'] * (1 - $item['discount']/100) * $item['quantity'])),
            // 'total_price' => collect($cart)->sum(fn($item) => ($item['price'] * $item['quantity']) - $item['discount']),
            // 'total_discount' => array_sum(array_column(session()->get('cart', []), 'discount')),
            'customer_id' => Auth::user()->id ?? null,
            'payment_status' => 1,
            'payment_method' => $request->payment_method,
            'name' => $request->name,
            'phone' => $request->phone,
            'delivery_address' => $request->address,
            'token' => csrf_token()
        ];
        $save = Order::create($order);
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $save->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount' => $item['discount'] ?? 0,
            ]);
        }
        session()->forget('cart'); // Hapus isi keranjang setelah checkout
        DB::commit();

        return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil dibuat!');
    }
    public function checkoutSuccess()
    {
        $title = 'Checkout Berhasil';
        return view('checkout.success', compact('title'));
    }
}
