<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PhotosController extends Controller
{
    public function delete(Request $request)
    {
        $photoUrl = $request->input('photo');
        $userId = Auth::id();
        $userFolder = 'uploads/' . $userId;

        // Parse path from the full URL
        $parsedUrl = parse_url($photoUrl, PHP_URL_PATH); // e.g., /uploads/1/media123.jpg
        $relativePath = ltrim($parsedUrl, '/'); // remove leading slash
        $fullPath = public_path($relativePath); // e.g., /var/www/html/public/uploads/1/media123.jpg

        // Validate the file is inside the user's folder
        if (str_starts_with($fullPath, public_path($userFolder)) && File::exists($fullPath)) {

            // Determine the type based on extension
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
            $videoExtensions = ['mp4', 'mov', 'webm', 'ogg'];

            $type = 'unknown';
            if (in_array($extension, $imageExtensions)) {
                $type = 'image';
            } elseif (in_array($extension, $videoExtensions)) {
                $type = 'video';
            }

            File::delete($fullPath);

            return response()->json([
                __('messages.success') => true,
                'message' => ucfirst($type) . ' deleted successfully.',
                'type' => $type,
            ]);
        }

        return response()->json([
            __('messages.success') => false,
            'message' => 'File not found or not allowed.',
        ]);
    }
    public function index()
    {
        $userId = Auth::id();
        $folderPath = public_path('uploads/' . $userId);

        $photos = [];

        if (File::exists($folderPath)) {
            $files = File::files($folderPath);
            foreach ($files as $file) {
                $photos[] = asset('uploads/' . $userId . '/' . $file->getFilename());
            }
        }

        return view('user-view.photos.index', compact('photos'));
    }
    public function uploadPhoto(Request $request)
    {

        $userId = Auth::id();
        $folderPath = public_path('uploads/' . $userId);

        // Create the folder if it doesn't exist
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Get existing file count
        $existingFiles = File::files($folderPath);
        $existingCount = count($existingFiles);

        $uploads = $request->file('media');
        $uploadCount = count($uploads);

        // Check if folder limit exceeded
        if (($existingCount + $uploadCount) > 300) {
            return redirect()->back()->withErrors(['media' => 'Upload limit exceeded. You can only have up to 300 files.']);
        }

        // Process each file
        foreach ($uploads as $file) {
            $extension = $file->getClientOriginalExtension();
            $type = $file->getMimeType();
            $prefix = str_contains($type, 'video') ? 'video_' : 'media_';
            $fileName = $prefix . time() . '_' . uniqid() . '.' . $extension;

            $file->move($folderPath, $fileName);
        }

        return redirect()->back()
        ->with(__('messages.success'), __('messages.Media uploaded successfully!'));
    }
}
