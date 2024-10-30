<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Fetching
Route::get('/get-attendance-admin', function(){
    $att_admin = User::where('role', 'Admin')->get();
    return response()->json($att_admin);
});

Route::get('/', function () {
    return view('login');
});


Route::get('/create-account-page', function(){
    return view('create_account');
});

Route::post('/create-account', [UserController::class, 'create_account']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/add-attendance-admin', [UserController::class, 'add_attendance_admin']);

//Routings
Route::get('/student-dashboard', function(){
    if (Auth::check() && auth()->user()->role == "Student"){
        return view('student.dashboard');
    }else{
        return redirect('/');
    }
});

Route::get('/student-events', function(){
    if (Auth::check() && auth()->user()->role == "Student"){
        return view('student.events');
    }else{
        return redirect('/');
    }
});

Route::get('/student-attendance', function(){
    if (Auth::check() && auth()->user()->role == "Student"){
        return view('student.attendance');
    }else{
        return redirect('/');
    }
});

Route::get('/student-parent', function(){
    if (Auth::check() && auth()->user()->role == "Student"){
        return view('student.parent');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-dashboard', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.dashboard');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-attendance-admin', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.attendance_admin');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-students', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.students');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-sy-sections', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.sy_sections');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-events', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.events');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-attendace', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.attendance');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-reports', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.reports');
    }else{
        return redirect('/');
    }
});

Route::get('/admin-dashboard', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.dashboard');
    }else{
        return redirect('/');
    }
});

Route::get('/admin-students', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.student');
    }else{
        return redirect('/');
    }
});

Route::get('/admin-events', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.events');
    }else{
        return redirect('/');
    }
});

Route::get('/parent-dashboard', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Admin.parent');
    }else{
        return redirect('/');
    }
});

Route::get('/admin-attendace', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.attendance');
    }else{
        return redirect('/');
    }
});

Route::get('/admin-reports', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.reports');
    }else{
        return redirect('/');
    }
});

Route::get('/parent-dashboard', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Parent.dashboard');
    }else{
        return redirect('/');
    }
});

Route::get('/parent-events', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Parent.events');
    }else{
        return redirect('/');
    }
});

Route::get('/parent-attendance', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Parent.attendance');
    }else{
        return redirect('/');
    }
});

Route::get('/parent-my-student', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Parent.my_student');
    }else{
        return redirect('/');
    }
});
