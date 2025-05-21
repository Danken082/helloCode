<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ProductModel;

use App\Models\User;

class LoginController extends Controller
{

    //Session Auth
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials))
        {

            
            $request->session()->regenerate();

            return match (Auth::user()->role )
            {
                'admin' => redirect()->intended('/dashboard'),
                'customer' => redirect()->intended('shop/home'),
                'rider' => redirect()->intended('rider/dashboard'),
                default => redirect()->intended('/')
            };

        }

        return back()->withErrors([
            'email' => 'Invalid Credentials'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    //registration for user

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'address' => ['required'],
            'contactNo' => [ 'required',
            'regex:/^(\+?63|0)9\d{9}$/', // Philippines format: +639XXXXXXXXX or 09XXXXXXXXX
            'unique:users'],
            // 'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $data = ['name' => $request->name,
                 'email' => $request->email,
                 'address' => $request->address,
                 'contactNo' => $request->contactNo,
                 'password' => Hash::make($request->password),
                 'role' => 'customer'
                ];

        
        $user = User::create($data);

        Auth::login($user);

        return redirect('shop/home');
        }

        //guest view

        public function guestView()
        {
            $product = ProductModel::all();

            $categories = ProductModel::select('productCategory')
            ->distinct()
            ->get();
        


            return view('user.login', compact('product', 'categories'));
        }

}
