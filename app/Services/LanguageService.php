<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class LanguageService
{
    public function addLanguage($languageName, $languageCode)
    {
        $path = resource_path('lang/' . $languageCode);
        $sourcePath = resource_path('lang/en/messages.php');

        // Check if the directory already exists
        if (!File::exists($path)) {
            // Create the directory
            File::makeDirectory($path, 0755, true);

            // Check if the source messages.php file exists
            if (File::exists($sourcePath)) {
                // Copy the content of the source messages.php file
                $messagesContent = File::get($sourcePath);
            } else {
                // Default content if source messages.php doesn't exist
                $messagesContent = "<?php\n\nreturn [\n    'welcome' => 'Welcome',\n];\n";
            }

            // Create the messages.php file with copied content
            File::put($path . '/messages.php', $messagesContent);

            return "Language folder and file created successfully.";
        } else {
            return "Language folder already exists.";
        }
    }

    public function updateLanguage($oldLanguageCode, $newLanguageCode, $newLanguageName)
    {
        // Update language folder name if language code changes
        if ($oldLanguageCode !== $newLanguageCode) {
            $oldFolder = resource_path('lang/' . $oldLanguageCode);
            $newFolder = resource_path('lang/' . $newLanguageCode);

            if (File::exists($oldFolder) && !File::exists($newFolder)) {
                File::move($oldFolder, $newFolder);
            }
        }
        // Update messages.php content
        $this->copyMessagesFile($newLanguageCode);                             
        return true; // Add error handling as needed
    }

    protected function copyMessagesFile($newLanguageCode)
    {
        $sourceFile = resource_path('lang/en/messages.php');
        $targetFile = resource_path('lang/' . $newLanguageCode . '/messages.php');

        if (File::exists($targetFile)) {
            File::copy($sourceFile, $targetFile);
        }
    }

    public function deleteLanguageFolder($languageCode)
    {
        $languageFolderPath = resource_path('lang/' . $languageCode);

        if (File::exists($languageFolderPath)) {
            File::deleteDirectory($languageFolderPath);
        }
    }
}
