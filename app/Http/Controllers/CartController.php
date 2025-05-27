<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartModel;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductModel;
class CartController extends Controller
{
    public function cartView()
    {
        $userID = auth()->id();
        // $user = Auth::user();
        $cartItems = CartModel::with('product')
            ->where('userID', $userID)
            ->get();

            $totalPrice = $cartItems->sum(function ($item) {
                return $item->product->productPrice * $item->quantity;
            });

        return view('user.cart', compact('cartItems', 'totalPrice'));
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartModel::findOrFail($id);

        if ($cartItem->userID !== Auth::id()) {
            abort(403);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('viewCart')->with('success', 'Quantity updated.');
    }

 // Remove from Cart
 public function removeItem($id)
 {
     $cartItem = CartModel::findOrFail($id);

     if ($cartItem->userID !== auth()->id()) {
         abort(403);

        // var_dump($cartItem);
     }

     $cartItem->delete();

     return redirect()->route('viewCart')->with('success', 'Item removed from cart.');
 }

 // Checkout Selected Items
 public function checkout(Request $request)
{
    $selectedItems = $request->input('selectedItems');

    if (!$selectedItems || count($selectedItems) === 0) {
        return redirect()->back()->with('error', 'Please select at least one item to proceed.');
    }

    // Retrieve selected cart items
    $cartItems = CartModel::whereIn('id', $selectedItems)->with('product')->get();

    // Pass to checkout form or process payment
    return view('user.checkout', compact('cartItems'));
}

}


