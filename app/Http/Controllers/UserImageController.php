<?php

namespace App\Http\Controllers;

use App\Models\UserImage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserImageController extends Controller
{
    public function add_user_image(Request $request){

        $request->validate([
            'image' => 'required|image|max:2048', // Validate image upload
        ]);

        $get_user_image_count = UserImage::where('user_id', $request->user_id)->count();

        if ($get_user_image_count > 0){

            $imagePath = $request->file('image')->store('images', 'public');

            $user_image = UserImage::where('user_id', $request->user_id)->latest()->first();
            $user_image->filename = $request->file('image')->getClientOriginalName();
            $user_image->path = $imagePath;
            $user_image->save();

            return redirect()->back();
        }else{
            $imagePath = $request->file('image')->store('images', 'public');

            UserImage::create([
                'user_id' => $request->user_id,
                'filename' => $request->file('image')->getClientOriginalName(),
                'path' => $imagePath,
            ]);

            Alert::success("Added");
            return redirect()->back();
        }





    }
}
