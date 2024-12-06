<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Support;
use App\Models\SySection;
use App\Models\Attendance;
use App\Models\ParentStudent;
use App\Models\AttendanceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\SchoolYearSectionDetails;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SySectionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ParentStudentController;
use App\Http\Controllers\AttendanceDetailController;
use App\Http\Controllers\SchoolYearSectionDetailsController;

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

Route::get('/search-student/key={search_text}', function($search_text){
    $students = User::where('role', 'Student')->where('complete_name', 'like', "%{$search_text}%")->get();
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

Route::get('/fetch-section-details/sys={sys_id}', function($sys_id){
    $section_member = SchoolYearSectionDetails::where('sys_id', $sys_id)->with(['get_student'])->get();
    return response()->json($section_member);
});

Route::get('/fetch-section-member/section-id={sec_id}', function($sec_id){
    $section_member = SchoolYearSectionDetails::where('sys_id', $sec_id)->with(['get_student'])->get();
    return response()->json($section_member);
});

Route::get('/get-parent-student/parent-id={parent_id}', function($parent_id){
    $parent_student = ParentStudent::where('parent_id', $parent_id)->with(['get_student_section.get_section', 'get_student_section.get_student'])->get();
    return response()->json($parent_student);
});

Route::get('/fetch-events', function(){
    $events = Event::all();
    return response()->json($events);
});

Route::get('/get-selected-event/event-id={event_id}', function($event_id){
    $event = Event::find($event_id);
    return response()->json($event);

});

Route::get('/fetch-attendance-sheet', function(){
    $attendance = Attendance::with(['get_event'])->get();

    return response()->json($attendance);
});

Route::get('/filter-attendance-sheet/event-id={event_id}', function($event_id){
    $attendance = Attendance::where('event_id', $event_id)->with(['get_event'])->get();

    return response()->json($attendance);
});

Route::get('/fetch-attendance-details/att-d-id={att_id}', function($att_id){
    $attendance_details = AttendanceDetail::where('attendance_id', $att_id)->with(['get_section_details.get_student', 'get_attendance.get_event'])->get();
    return response()->json($attendance_details);
});

Route::get('/get_event_attendance/event-id={event_id}', function($event_id){
    $attendance = Attendance::where('event_id', $event_id)->get();
    return response()->json($attendance);
});

Route::get('/get-attendance/event-id={event_id}/sys-d-id={sys_d_id}/attendance-id={attendance_id}', function($event_id, $sys_d_id, $attendance_id) {
    $attendance = App\Models\AttendanceDetail::where('attendance_id', $attendance_id)
                                              ->where('sys_d_id', $sys_d_id)
                                              ->count();

    return response()->json($attendance); // Return the count as a JSON response
});

Route::get('/get-my-message/user-id={user_id}', function($user_id){
    $message = Support::where('user_id', $user_id)->with(['get_user'])->get();
    return response()->json($message);
});

Route::get('/get-section-members/section-id={section_id}', function($section_id){
    $section_members = SchoolYearSectionDetails::where('sys_id', $section_id)->with(['get_student', 'get_section'])->get();
    return response()->json($section_members);
});

Route::get('/super-admin-reports/event-id={event_id}', function($event_id){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        $events = Event::find($event_id);

        return view('SuperAdmin.event_reports', ['events' => $events]);
    }else{
        return redirect('/');
    }

});

Route::get('/admin-reports/event-id={event_id}', function($event_id){
    if (Auth::check() && auth()->user()->role == "Admin"){
        $events = Event::find($event_id);

        return view('Admin.event_reports', ['events' => $events]);
    }else{
        return redirect('/');
    }

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

Route::post('/add-student-sysd', [SchoolYearSectionDetailsController::class, 'add_sys_details']);
Route::post('/remove-sys-details', [SchoolYearSectionDetailsController::class, 'remove_sys_details']);

Route::post('/add-student-parent', [ParentStudentController::class, 'add_parent_student']);
Route::post('/remove-student-parent', [ParentStudentController::class, 'remove_parent_student']);

Route::post('/add-event', [EventController::class, 'add_event']);
Route::post('/edit-event', [EventController::class, 'edit_event']);
Route::post('/delete-event', [EventController::class, 'delete_event']);

Route::post('/add-attendance', [AttendanceController::class, 'add_attendance']);
Route::post('/edit_attendance', [AttendanceController::class, 'edit_attendance']);
Route::post('/delete-attendance', [AttendanceController::class, 'delete_attendance']);

Route::post('/delete-attendance-details', [AttendanceDetailController::class, 'delete_att_de']);

Route::post('/add-support-message', [SupportController::class, 'add_support_message']);

Route::post('/add-attendee', [AttendanceDetailController::class, 'add_attendee']);

Route::post('/save-profile', [UserController::class, 'save_profile']);

Route::post('/save-user-security', [UserController::class, 'save_security_details']);

Route::post('/reset-account', [UserController::class, 'account_reset']);

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

Route::get('/super-admin-students/qr-codes', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.qr_codes');
    }else{
        return redirect('/');
    }
});

Route::get('/admin-students/qr-codes', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.qr_codes');
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



Route::get('/admin-parent', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){Route::get('/super-admin-parents', function(){
        if (Auth::check() && auth()->user()->role == "Super-Admin"){
            return view('SuperAdmin.parents');
        }else{
            return redirect('/');
        }
    });
        return view('Admin.parents');
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

Route::get('/admin-parents/view-parent/{parent_id}', function($parent_id){
    if (Auth::check() && auth()->user()->role == "Admin"){

        $parent = User::find($parent_id);

        return view('Admin.view_parent', ['parent' => $parent]);
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

Route::get('/admin-sy-sections', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.sy_sections');
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

Route::get('/admin-sy-sections/section_member/{section_id}', function($section_id){
    if (Auth::check() && auth()->user()->role == "Admin"){

        $section = SySection::find($section_id);
        return view('Admin.section_details', ['section' => $section]);
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

Route::get('/super-admin-attendace/attendance-id={att_id}', function($att_id){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){

        $attendance_details = Attendance::find($att_id);

        $attendance = AttendanceDetail::where('attendance_id', $att_id)->get();

        return view('SuperAdmin.attendance_details', ['attendance' => $attendance, 'attendance_details' => $attendance_details]);

    }else{
        return redirect('/');
    }
});

Route::get('/admin-attendace/attendance-id={att_id}', function($att_id){
    if (Auth::check() && auth()->user()->role == "Admin"){

        $attendance_details = Attendance::find($att_id);

        $attendance = AttendanceDetail::where('attendance_id', $att_id)->get();

        return view('Admin.attendance_details', ['attendance' => $attendance, 'attendance_details' => $attendance_details]);

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

Route::get('/super-admin-support', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.support');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-support/details/user-id={user_id}', function($user_id){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.support_details', ['user_id' => $user_id]);
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


Route::get('/parent-my-student', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Parent.my_student');
    }else{
        return redirect('/');
    }
});

Route::get('/parent-supports', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Parent.support');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-profile', function(){
    if (Auth::check() && auth()->user()->role == "Super-Admin"){
        return view('SuperAdmin.profile');
    }else{
        return redirect('/');
    }
});

Route::get('/admin-profile', function(){
    if (Auth::check() && auth()->user()->role == "Admin"){
        return view('Admin.profile');
    }else{
        return redirect('/');
    }
});

Route::get('/parent-profile', function(){
    if (Auth::check() && auth()->user()->role == "Parent"){
        return view('Parent.profile');
    }else{
        return redirect('/');
    }
});

Route::get('/student-profile', function(){
    if (Auth::check() && auth()->user()->role == "Student"){
        return view('Student.profile');
    }else{
        return redirect('/');
    }
});

Route::get('/super-admin-reports/event-id={event_id}/section-id={section_id}', function($event_id, $section_id ){

    return view('print_attendance', ['event_id' => $event_id, 'section_id' => $section_id]);
});
