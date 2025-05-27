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

        //     $totalPrice = $cartItems->sum(function ($item) {
        //         return $item->product-> * $item->quantity;
        //     });

        // return view('user.cart', compact('cartItems', 'totalPrice'));

        var_dump($cartItems);
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
 public function checkout(Request $request, $id)
 {
     $request->validate([
         'selected_items' => 'required|array',
         'selected_items.*' => 'integer|exists:carts,id',
     ]);

     $userId = Auth::id();

    // return 1;
     $selectedItems = CartModel::with('product')
         ->where('userID', $userId)
         ->whereIn('id', $request->selected_items)
         ->get();

     if ($selectedItems->isEmpty()) {
         return redirect()->route('viewCart')->with('error', 'No items selected for checkout.');

        return 1;
     }
    //  return 1;

     $totalAmount = $selectedItems->sum(function ($item) {
         return $item->product->productPrice * $item->quantity;
     });

     // Proceed with your order placement logic
     // For demo:
     return view('user.checkout', compact('selectedItems', 'totalAmount'));
 }
}


