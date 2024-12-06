<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function add_support_message(Request $request){
        Support::create([
            'user_id' => $request->user_id,
            'admin_id' => '0',
            'message' => $request->message,
        ]);

        return response()->json();
    }
}
