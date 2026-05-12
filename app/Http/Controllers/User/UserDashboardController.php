<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Messages;
use App\Models\News;
use App\Models\User;
use App\Models\FamilyTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        // Count members across all family trees owned by the user (excluding deleted families)
        $ownedFamilyIds = FamilyTree::where('ownerId', $userId)
            ->where('Status', '!=', 2)
            ->pluck('id');
        $member = Member::whereIn('family_id', $ownedFamilyIds)->count();

        $recipent = Messages::where("recipient_id", $userId)->count();
        $folderPath = public_path('uploads/' . $userId);

        $photos = [];
        $fileCount = 0;

        if (File::exists($folderPath)) {
            $files = File::files($folderPath);
            $fileCount = count($files); // ✅ Count the files here
            foreach ($files as $file) {
                $photos[] = asset('uploads/' . $userId . '/' . $file->getFilename());
            }
        }
        // dd($fileCount);
        $news = News::where('user_id', $userId)->count();
        $newsList = News::where('user_id', $userId)->get();

        return view('user-view.dashboard.index', compact("newsList","member", 'recipent', "fileCount", "news"));
    }
}
