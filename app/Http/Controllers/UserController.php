<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
                'system_no' => date("Ymdhis"),
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            Alert::success('success', 'Account created successfully');
            return redirect('/');
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

    public function add_user(Request $request){

        $user = User::create([
            'complete_name' => $request->complete_name,
            'sex' => $request->sex,
            'bday' => $request->bday,
            'address' => $request->address,
            'phone' => $request->phone,
            'parent_name' => $request->parent_name,
            'parent_contact' => $request->parent_contact,
            'role' => $request->role,
            'status' => "Active",
            'username' => date("Ymdhis"),
            'system_no' => date("Ymdhis"),
            'email' => $request->email,
            'password' => bcrypt("12345678"),
        ]);


        // $student_data = [
        //     'complete_name' => $user->complete_name,
        //     'username' => $user->username,
        //     'password' => '12345678',
        //     'system_no' => $user->system_no,
        // ];

        // Mail::to($user->email)->send(new StudentInfo($student_data));




        return response()->json();
    }

    public function edit_user(Request $request){
        $users = User::find($request->user_id);
        $users->complete_name = $request->complete_name;
        $users->sex = $request->sex;
        $users->bday = $request->bday;
        $users->address = $request->address;
        $users->phone = $request->phone;
        $users->parent_name = $request->parent_name;
        $users->parent_contact = $request->parent_contact;
        $users->status = $request->status;
        $users->username = $request->username;
        $users->email = $request->email;
        $users->save();
        return response()->json();

    }

    public function delete_user(Request $request){
        $users = User::find($request->user_id);
        $users->delete();
        return response()->json();
    }

    public function save_profile(Request $request){
        $user = User::find($request->user_id);
        $user->complete_name = $request->complete_name;
        $user->sex = $request->sex;
        $user->bday = $request->bday;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->parent_name = $request->parent_name;
        $user->parent_contact = $request->parent_contact;
        $user->email = $request->email;
        $user->save();

        Alert::success('Success', 'Account Edited Successfully');

        return redirect()->back();
    }

    public function save_security_details(Request $request){
        $inputs = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->n_password == $request->cn_password){


            if (Auth::attempt($inputs)) {

                if ($request->n_username == null || $request->n_username == ""){
                    $user = User::find($request->user_id);
                    $user->password = bcrypt($request->n_password);
                    $user->save();
                }else{
                    $user = User::find($request->user_id);
                    $user->password = bcrypt($request->n_password);
                    $user->username = $request->n_username;
                    $user->save();
                }

                Alert::success('Success');
                return redirect()->back();
            }else{
                Alert::warning('Faild', 'Sory, cannot find account, please check credentials and try again');
                return redirect()->back();
            }


        }else{
            Alert::warning('Faild', 'Password does not match.');
            return redirect()->back();
        }


    }


    public function account_reset(Request $request){
        $user = User::find($request->user_id);
        $user->username = $user->system_no;
        $user->password = bcrypt('12345678');
        $user->save();
        return response()->json();

    }

}
