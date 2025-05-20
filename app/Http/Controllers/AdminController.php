<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\SellerModel;
use App\Models\OrderHistoryModel;
use App\Models\orderModel;
use App\Models\CartModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Support\Facades\Crypt;

class AdminController extends Controller
{
    

    //admindashboard

    public function adminDash()
    {
        $totalSellers = SellerModel::where('shopStatus', 'shopAccepted')->count();
        $applyingSellers = SellerModel::where('shopStatus', 'underReview')->count();
        $totalProducts = ProductModel::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRiders = User::where('role', 'rider')->count();
        

        $sellerPagenotations = SellerModel::with('user')->paginate(7);

        $getPendingSellers = SellerModel::where('shopStatus', 'underReview')->get();

        
        $getSellers = SellerModel::all();

        return view('admin.dashboard', compact('totalSellers', 'applyingSellers', 'totalCustomers', 'getPendingSellers', 'getSellers', 'totalProducts',
                                                'sellerPagenotations', 'totalRiders'));
    }

    public function viewPendingSellers()
    {

        $sellers = SellerModel::where('shopStatus', 'underReview')->get();
        return view('admin.seller.profile', compact('sellers'));
    }


    public function viewAcceptedSellers()
    {

        $sellers = SellerModel::where('shopStatus', 'shopAccepted')->with('user')  // if you want seller's name/email
        ->withCount('product')  // gives products_count
        ->get();
        return view('admin.seller.activeSeller', compact('sellers'));
    }

    



    public function updateVendorStatus(Request $request, $id)
    {
        $userID = auth()->id();


        $seller = SellerModel::findOrFail($id);

        $seller->shopStatus = $request->status;

        $seller->save();

        return response()->json(['message' => 'Seller application submitted successfully.']);



    }
   

    public function shopHome(Request $request)
    {

        $userID = Auth::user()->id;
        $product = ProductModel::all();

        $categories = ProductModel::where('userID', $userID)
        ->select('productCategory')
        ->distinct()
        ->get();
    
        return view('user.shop.home', compact('product', 'categories'));
    }

    public function viewProduct(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $product = ProductModel::findOrFail($id);
            return view('user.shop.viewProduct', compact('product'));
        } catch (\Exception $e) {
            abort(404); // If the encrypted ID is invalid or can't be decrypted
        }
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1',
            'totalPrice' => 'required|numeric|min:0.01',
        ]);
    
        $orderCode = 'ORD-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
        $userID = auth()->id();
    
        $prod = ProductModel::findOrFail($request->product_id);
    
        // Check stock availability
        if ($request->quantity > $prod->productQuantity) {
            return back()->with('error', 'Not enough stock available.');
        }
    
        // Reduce product quantity
        $prod->productQuantity -= $request->quantity;
        $prod->save();
    
        // Create the order
        $data = [
            'userID' => $userID,
            'prod_id' => $request->product_id,
            'quantity' => $request->quantity,
            'totalPrice' => $request->totalPrice,
            'orderCode' => $orderCode,
            'status' => 'Pending',
        ];
    
        orderModel::create($data);
    
        return redirect()->to('shop/home')->with('msg', 'Order Successful');
    }
    


    public function addtoCart(Request $request)
    {

        $userID = auth()->id();

        $data = [
            'prod_id' => $request->product_id,
            'userID'  => $userID,
            'totalPrice' => $request->totalPrice,
            'quantity' => $request->quantity
        ];

        $cartSave = CartModel::create($data);

        return redirect()->to('shop/home')->with('msg', 'Product is Added to cart');
    }

    public function registerseller(Request $request)
    {
        $userID = Auth::id();
    
        // Validate the request (optional but recommended)
        $request->validate([
            'shopName' => 'required|string|max:191',
            'address' => 'required|string|max:191',
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

    public function showregisterCenter(Request $request)
    {


        $userID = auth()->id();
    
        $filter = $request->input('filter', 'month'); // default to month

        // Date range logic
        $startDate = $filter === 'day' 
            ? Carbon::now()->startOfDay() 
            : Carbon::now()->startOfMonth();
    

    
        // Total products

        // Total sales
        $totalSales = OrderHistoryModel::
             where('userID', $userID)
            ->where('created_at', '>=', $startDate)
            ->sum('totalPrice');
    
        // Best sellers (top 5)
        $bestSellers = OrderHistoryModel::select('product.productName', DB::raw('SUM(orderhistory.quantity) as total_sold'))
    ->join('product', 'orderhistory.prod_id', '=', 'product.id')
    ->where('orderhistory.userID', $userID)
    ->where('orderhistory.created_at', '>=', $startDate)
    ->groupBy('orderhistory.prod_id', 'product.productName')
    ->orderByDesc('total_sold')
    ->take(5)
    ->get();

        // Fetch product names for display
        $bestSellers = $bestSellers->map(function ($item) {
            $product = ProductModel::find($item->prod_id);
            $item->productName = $product->productName ?? 'Unknown';
            return $item;
        });




        // Find the seller record for the current user
        $seller = SellerModel::where('userID', $userID)->first();
        $product = ProductModel::where('userID', $userID)
        ->select('productCategory')
        ->distinct()
        ->get();
    
        $orderPending = orderModel::where('userID', $userID)
                        ->where('status', 'pending')
                        ->get();


        //counting the data
        $totalPending = $orderPending->count();
        $totalProducts = $product->count();
    
        $orderHist = OrderHistoryModel::where('userID', $userID)->get();

        $orders = orderModel::all();
    
        // Redirect based on shopStatus
        if ($seller) {
            if ($seller->shopStatus === 'shopAccepted') {
                return view('seller.dashboard', compact('seller', 'product',
                'orderHist', 'totalProducts', 'bestSellers', 'totalSales','totalPending', 'orders'));
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


    //reviewOrders
    public function updateStatus(Request $request, $id)
    {

        $userID = auth()->id();
    $order = orderModel::findOrFail($id);
    
    $order->status = $request->status;
    $order->save();



        // Move to order history if status becomes 'Completed'
        if ($order->status === 'Completed') {
            OrderHistoryModel::create([
                'userID' => $userID,
                // 'order_id' => $order->id,
                'prod_id' => $request->productId,
                'orderCode' => $request->orderCode,
                'quantity' => $request->quantity,
                'totalPrice' => $request->totalPrice,
                // 'status' => $order->status,
            ]);
        }
    // Optional: Log or process more data
    if ($request->status !== 'Pending') {
        \Log::info('Order updated', [
            'orderCode' => $request->orderCode,
            'productId' => $request->productId,
            'quantity' => $request->quantity,
            'totalPrice' => $request->totalPrice
        ]);
    }

    return response()->json(['message' => 'Order status updated successfully']);
    }


    //view Products
    public function viewProducts($categ)
    {
        $prod = ProductModel::where('productCategory', $categ)->get();


        return view('seller.productList', compact('prod'));

    }

    //add products

    public function addProduct(Request $request)
    {
        $userID = Auth::user()->id;


                // Upload the image to storage/app/public/seller_images
                if ($request->hasFile('productImage')) {
                    $file = $request->file('productImage');
                    $filePath = $file->store('productImage', 'public'); // returns path like 'seller_images/abc123.jpg'
                } else {
                    $filePath = null;
                }

        $data = ['userID' => $userID,
                 'productName' => $request->productName,
                 'productImage' => $filePath,
                 'productQuantity' => $request->productQuantity,
                 'productCategory' => $request->productCategory,
                 'productDetails' => $request->productDetails
                ];


            
       $prod = ProductModel::create($data);

    }


    
}
