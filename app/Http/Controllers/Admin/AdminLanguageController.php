<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LanguageService;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class AdminLanguageController extends Controller
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index()
    {
        $languages = Language::where('Status' , '=' , '0')->get();
        return view('admin-view.language.index', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|max:3|unique:tbl_language,LanguageCode',
        ]);

        $languageName = $request->input('name');
        $languageCode = $request->input('code');

        $message = $this->languageService->addLanguage($languageName, $languageCode);
        Language::create(['LanguageName' => $languageName, 'LanguageCode' => $languageCode]);

        return response()->json(['message' => 'Language added successfully!']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tbl_language,id',
            'name' => 'required|string',
            'code' => 'required|string|max:3',
        ]);

        $language = Language::findOrFail($request->id);
        // Retrieve the old code
        $oldCode = $language->LanguageCode;

        $this->languageService->updateLanguage($oldCode, $request->code, $request->name);
        $language->LanguageName = $request->name;
        $language->LanguageCode = $request->code;
        $language->save();

        return response()->json(['message' => 'Language updated successfully!']);
    }

    public function destroy($id)
    {
        try {
            $language = Language::findOrFail($id);
            $this->languageService->deleteLanguageFolder($language->LanguageCode);
            $language->Status = 2;
            $language->save();

            return response()->json(['message' => 'Language Remove Successfully!']);
        } catch (\Exception $e) {

        }
    }

    public function switch($language_code)
    {
        // Validate if the language exists in the database or some other source
        $language = Language::where('LanguageCode', $language_code)->first();

        if ($language) {
            // Set application locale
            App::setLocale($language_code);

            // Store the selected language in session or cookie for persistence
            Session::put('locale', $language_code);
        }

        // Redirect back or to a specific route after switching
        return redirect()->back();
    }
}
