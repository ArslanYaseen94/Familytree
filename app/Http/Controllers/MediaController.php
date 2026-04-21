<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function index(){
        // dd("here");

        $user = Auth::user();
        // dd($user);

        $socials = SocialMedia::where("user_id",$user->id)->first();
        return view("user-view.configuration.socialmedia",compact("socials"));
    }
}
