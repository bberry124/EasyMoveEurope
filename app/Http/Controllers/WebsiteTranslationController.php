<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WebsiteTranslationController extends Controller
{
    public function crawlAndTranslate()
    {
        Artisan::call('crawl:translate');
        return "Crawling and translation process initiated. Check the logs for details.";
    }

    public function create_json_file(){

    	// Fetch translations from the database
		$translations = DB::table('translations')->get();

		// Organize translations by language and key
		$localizedTranslations = [];
		foreach ($translations as $translation) {
		    $language = $translation->locale;
		    $key = $translation->key;
		    $text = $translation->value;

		    $localizedTranslations[$language][$key] = $text;
		}

		// Delete existing JSON files
		foreach (File::files(resource_path('lang')) as $file) {
		    if ($file->getExtension() === 'json') {
		        File::delete($file);
		    }
		}

		// Generate and save JSON files
		foreach ($localizedTranslations as $language => $translations) {
		    $jsonContent = json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		    $filePath = resource_path("lang/{$language}.json"); // Save in resources/lang directory
		    file_put_contents($filePath, $jsonContent);
		}

		return "Files created successfully";
	}
}
