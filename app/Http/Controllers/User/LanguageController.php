<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\Services\LanguageService;
use App\Models\Language;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage($locale)
    {
        $language = Language::where('LanguageCode', $locale)->first();

        if ($language) {
            // Set application locale
            App::setLocale($locale);

            // Store the selected language in session or cookie for persistence
            Session::put('locale', $locale);
        }
        // dd($language);
        // Redirect back or to a specific route after switching
        return redirect()->back();
        
    }
}
