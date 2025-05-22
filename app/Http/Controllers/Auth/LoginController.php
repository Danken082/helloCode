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

// Session Auth
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
    ]);

    // First, check if the user exists with that email
    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors([
            'email' => 'Invalid username or password',
        ]);
    }

    // Check if the account is active
    if ($user->status !== 'active') {
        return back()->withErrors([
            'email' => 'Your account has not been validated yet.',
        ]);
    }

    // Attempt to login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'admin' => redirect()->intended('/dashboard'),
            'customer' => redirect()->intended('shop/home'),
            'rider' => redirect()->intended('rider/dashboard'),
            default => redirect()->intended('/')
        };
    }

    return back()->withErrors([
        'email' => 'Login failed. Please try again.',
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
                 'status' => 'active',
                 'role' => 'customer'
                ];

        
        $user = User::create($data);

        Auth::login($user);

        return redirect('shop/home');
        }

        public function registerRider(Request $request)
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
                     'status' => $request->status,
                     'role' => 'rider'
                    ];
    
            
            $user = User::create($data);
               
            return redirect('/');
            }

            public function updateRider(Request $request, $id)
            {
                $request->validate([
                    'name' => 'required|string',
                    'email' => 'required|email',
                    'address' => 'required|string',
                    'contactNo' => 'required|regex:/^09\d{9}$/',
                    'status' => 'required|in:active,inactive',
                ]);

                $rider = User::findOrFail($id); // or Rider::findOrFail($id) if you're using a separate model
                $rider->update($request->only(['name', 'email', 'address', 'contactNo','status']));

                return redirect()->back()->with('success', 'Rider updated successfully.');
            }



            public function registerAdmin(Request $request)
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
                         'status' => $request->status,
                         'role' => 'admin'
                        ];
        
                
                $user = User::create($data);
                   

                // if($user)
                // {
                // echo 1;
                // }
                // else{
                //     echo 2;
                // }
                return redirect()->back()->with('success', 'Created successfully.');
                }

                public function profileView()
                {
                    $admin = User::where('role', 'admin')->get();

                    return view('admin.admin.profile', compact('admin'));
            
                }
    
                public function updateAdmin(Request $request, $id)
                {
                    $request->validate([
                        'name' => 'required|string',
                        'email' => 'required|email',
                        'address' => 'required|string',
                        'contactNo' => 'required|regex:/^09\d{9}$/',
                        'status' => 'required|in:active,inactive',
                    ]);
    
                    $rider = User::findOrFail($id); // or Rider::findOrFail($id) if you're using a separate model
                    $rider->update($request->only(['name', 'email', 'address', 'contactNo','status']));
    
                    return redirect()->back()->with('success', 'Admin updated successfully.');
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
