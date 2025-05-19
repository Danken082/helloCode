<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\SellerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function addProduct(Request $request)
    {
        $userID = Auth::user()->id;


        $data = ['userID' => $userID,
                 'productName' => $request->productName,
                 'productImage' => $request->productImage,
                 'productQuantity' => $request->productQuantity,
                 'productCategory' => $request->productCategory,
                 'productDetails' => $request->productDetails
                ];
            
       $prod = ProductModel::create($data);

    }

    public function registerseller(Request $request)
    {
        $userID = Auth::id();
    
        // Validate the request (optional but recommended)
        $request->validate([
            'shopName' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'prodPics' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'shopAge' => 'required|string',
        ]);
    
        // Upload the image to storage/app/public/seller_images
        if ($request->hasFile('prodPics')) {
            $file = $request->file('prodPics');
            $filePath = $file->store('seller_images', 'public'); // returns path like 'seller_images/abc123.jpg'
        } else {
            $filePath = null;
        }
    
        // Prepare data for the model
        $data = [
            'userID'        => $userID,
            'bussinessName' => $request->shopName,
            'address'       => $request->address,
            'productImage'  => $filePath,
            'businessAge'   => $request->shopAge,
            'shopStatus'    => 'underReview',
        ];
    
        // Save seller data
        $seller = SellerModel::create($data);
    
        return response()->json(['message' => 'Seller application submitted successfully.']);
    }

    public function showregisterCenter()
    {
        $userID = auth()->id();
    
        // Find the seller record for the current user
        $seller = SellerModel::where('userID', $userID)->first();
    
        // Redirect based on shopStatus
        if ($seller) {
            if ($seller->shopStatus === 'shopAccepted') {
                return view('seller.dashboard', compact('seller'));
            } elseif ($seller->shopStatus === 'underReview') {
                return view('seller.register', compact('seller'));
            } else {
                // Optional: handle other statuses
                return redirect('/')->with('error', 'Your shop status is not recognized.');
            }
        }
    
        // If no seller record found, show registration page
        return view('seller.register');
    }
    
}
