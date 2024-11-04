<?php

use App\Models\User;
use App\Models\SySection;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SySectionController;

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

Route::get('/get-student', function(){
    $students = User::where('role', 'Student')->get();
    return response()->json($students);
});
Route::get('/get-parent', function(){
    $parent = User::where('role', 'Parent')->get();
    return response()->json($parent);
});

Route::get('/get-sections', function(){
    $sections = SySection::all();
    return response()->json($sections);

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
Route::post('/add-user', [UserController::class, 'add_user']);
Route::post('/edit-user', [UserController::class, 'edit_user']);
Route::post('/delete-user', [UserController::class, 'delete_user']);

Route::post('/add-section', [SySectionController::class, 'add_section']);
Route::post('/edit-section', [SySectionController::class, 'edit_section']);
Route::post('/delete-section', [SySectionController::class, 'delete_section']);

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

Route::get('/super-admin-parents', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.parents');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-parents/view-parent/{parent_id}', function($parent_id){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){

        $parent = User::find($parent_id);

        return view('SuperAdmin.view_parent', ['parent' => $parent]);
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

Route::get('/super-admin-sy-sections/section_member/{section_id}', function($section_id){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){

        $section = SySection::find($section_id);
        return view('SuperAdmin.section_details', ['section' => $section]);
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
