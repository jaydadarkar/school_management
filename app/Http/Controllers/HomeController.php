<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(\Auth::user()->role == 'admin'){
            return view('home', ['users' => User::paginate(20)]);
        }
        else{
            return view('home', ['users' => User::where('role', 'student')->paginate(20)]);
        }
    }

    public function generateToken(Request $request)
    {
        $validatedData = \Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);
        $user = User::where('id', $request->user_id)->first();
        if(!empty($user)){
            if($user->role == 'student'){
                if(empty($user->token)){
                    $user->token = bcrypt(now());
                    $user->save();
                    return redirect()->route('home')->with('success', 'A Token Has Been Generated For This User.');
                }
                else{
                    return redirect()->back()->with('warning', 'This User Already Has A Token.');
                }
            }
            else{
                return redirect()->back()->with('danger', 'Tokens Can Be Generated Only For Students.');
            }
        }
        return redirect()->back()->with('danger', 'User Not Found.');
    }

    public function updateStatus(Request $request)
    {
        $validatedData = \Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'user_status' => 'required|string|in:active,deactive'
        ]);

        $user = User::where('id', $request->user_id)->first();
        if(!empty($user)){
            $user->status = $request->user_status;
            $user->save();
            return redirect()->route('home')->with('success', 'User Status Changed.');
        }
        return redirect()->back()->with('danger', 'User Not Found.');
    }
}
