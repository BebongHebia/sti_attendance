<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function create_account(Request $request){
        if ($request->password == $request->c_password){

            $latest_no = User::latest('id')->first();

            $user = User::create([
                'complete_name' => $request->complete_name,
                'sex' => $request->sex,
                'bday' => $request->bday,
                'address' => $request->address,
                'phone' => $request->phone,
                'parent_name' => $request->parent_name,
                'parent_contact' => $request->parent_contact,
                'role' => "Student",
                'status' => "Active",
                'username' => $request->username,
                'system_no' => date("Ymd") . $latest_no->id,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            Alert::success('success', 'Account created successfully');

            Auth::login($user);
            return redirect('/student-dashboard');
        }
    }

    public function login(Request $request){
        $inputs = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($inputs)) {
            $request->session()->regenerate();
            $user_id = auth()->user()->id;
            $get_user_info = User::find($user_id);
            $user_role = $get_user_info['role'];

            if($user_role == "Super-Admin"){
                return redirect('/super-admin-dashboard');
            }elseif ($user_role == "Admin"){
                return redirect('/admin-dashboard');
            }elseif ($user_role == "Student"){
                return redirect('/student-dashboard');
            }elseif ($user_role == "Parent"){
                return redirect('/parent-dashboard');
            }

        }else{
            Alert::warning('Sorry, System didnt recognize any account, please check credentials and try again. Thank you');
            return redirect()->back()->withErrors(['message' => 'Sorry, System didnt recognize any account, please check credentials and try again. Thank you']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function add_attendance_admin(Request $request){
        if ($request->password == $request->c_password){

            $latest_no = User::latest('id')->first();

            $user = User::create([
                'complete_name' => $request->complete_name,
                'sex' => $request->sex,
                'bday' => $request->bday,
                'address' => $request->address,
                'phone' => $request->phone,
                'parent_name' => 'N/A',
                'parent_contact' => 'N/A',
                'role' => $request->role,
                'status' => "Active",
                'username' => $request->username,
                'system_no' => date("Ymd") . $latest_no->id,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return response()->json();
        }
    }
}
