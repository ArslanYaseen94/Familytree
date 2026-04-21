<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Messages;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserDashboardController extends Controller
{
    public function index()
    {
        $auth = Auth::user()->id;
        $member = Member::where("family_id", $auth)->count();
        $recipent = Messages::where("recipient_id", $auth)->count();
        $folderPath = public_path('uploads/' . $auth);

        $photos = [];
        $fileCount = 0;

        if (File::exists($folderPath)) {
            $files = File::files($folderPath);
            $fileCount = count($files); // ✅ Count the files here
            foreach ($files as $file) {
                $photos[] = asset('uploads/' . $auth . '/' . $file->getFilename());
            }
        }
        // dd($fileCount);
        $news = News::where('user_id', $auth)->count();
        $newsList = News::where('user_id', $auth)->get();

        return view('user-view.dashboard.index', compact("newsList","member", 'recipent', "fileCount", "news"));
    }
}
