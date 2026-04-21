<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminTranslateController extends Controller
{
    public function index($language_code)
    {
        return view('admin-view.language.translate', compact('language_code'));
    }

    public function save(Request $request, $language_code)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        // Load existing translations
        $translations = include resource_path("lang/{$language_code}/messages.php");
        // Update the translation value
        $translations[$key] = $value;
        // Write updated translations back to the file
        $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
        $filePath = resource_path("lang/{$language_code}/messages.php");
        File::put($filePath, $content);
        return response()->json(['message' => 'Translation saved successfully']);
    }
}
