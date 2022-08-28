<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*$this->middleware('auth');*/
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $credentials = array(
            'email' => 'sarwar@gmail.com',
            'password' => '!@#$1234',
        );
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = array(
            'token' => $token
        );
        return view('home', $data);
    }
    public function free_promotion()
    {
        $credentials = array(
            'email' => 'sarwar@gmail.com',
            'password' => '!@#$1234',
        );
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = array(
            'token' => $token
        );
        return view('free_promotion', $data);
    }

    public function shop()
    {
        $credentials = array(
            'email' => 'sarwar@gmail.com',
            'password' => '!@#$1234',
        );
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = array(
            'token' => $token
        );
        return view('shop', $data);
    }

    public function shop_details($shop_id)
    {
        $credentials = array(
            'email' => 'sarwar@gmail.com',
            'password' => '!@#$1234',
        );
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = array(
            'token' => $token,
            'shop_id' => $shop_id
        );
        return view('shop_details', $data);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 60 * 60
        ]);
    }
}
