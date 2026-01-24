<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $cart = Session::get('cart', []);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return view('pages.cart.index', compact('cart', 'totalPrice'));
    }

    // Add item to cart
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Product is out of stock.');
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Not enough stock available.');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    // Update cart item quantity
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = Session::get('cart');
            $product = Product::findOrFail($request->id);

            if ($request->quantity > $product->stock) {
                session()->flash('error', 'Not enough stock available.');
                return response()->json(['status' => 'error']);
            }

            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    // Remove item from cart
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = Session::get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    // Checkout and store order
    public function checkout(Request $request)
    {
        $cart = Session::get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        // Calculate totals
        $totalPrice = 0;
        $totalItem = 0;
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
            $totalItem += $details['quantity'];
        }

        // Database Transaction
        DB::beginTransaction();

        try {
            // Create Order
            $order = Order::create([
                'transaction_time' => now(),
                'total_price' => $totalPrice,
                'total_item' => $totalItem,
                'kasir_id' => auth()->id(), // Assuming logged in user via Breeze
                'payment_method' => $request->payment_method ?? 'cash', // Default or from request
            ]);

            foreach ($cart as $id => $details) {
                $product = Product::lockForUpdate()->find($id); // Lock for concurrency

                if (!$product) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Product ID $id not found.");
                }

                if ($product->stock < $details['quantity']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Product {$product->name} stock is insufficient.");
                }

                // Create Order Item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'total_price' => $details['price'] * $details['quantity'],
                ]);

                // Reduce Stock
                $product->decrement('stock', $details['quantity']);
            }

            DB::commit();

            // Clear Cart
            Session::forget('cart');

            return redirect()->route('order.index')->with('success', 'Transaction successful!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transaction failed: ' . $e->getMessage());
        }
    }
}
