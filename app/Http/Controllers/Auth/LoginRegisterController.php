<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LoggerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginRegisterController extends Controller
{

    protected $logger;

    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct(LoggerService $logger)
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);

        $this->logger = $logger;
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('order.service')
            ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'name' => 'required',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('dashboard')
                    ->withSuccess('You have successfully logged in!');
            }

            return back()->withErrors([
                'error' => 'Login failed, user or password wronk!',
            ])->onlyInput('email');

        } catch (\Exception $e) {

            $msgerr = $e->getMessage();
            $this->logger->logMessage($msgerr);
            
            return back()->withErrors([
                'error' => "Login failed, please try again!",
            ])->onlyInput('name');
        }
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            try {
                return view('pages.dashboard', compact('quotas'));
            } catch (\Exception $e) {
                echo  $e->getMessage();
            }
        }
        return redirect('login');
    }
}
