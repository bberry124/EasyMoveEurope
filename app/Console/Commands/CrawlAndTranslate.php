<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Translation;
use GuzzleHttp\Client as GuzzleClient;

class CrawlAndTranslate extends Command
{
    protected $signature = 'crawl:translate';
    protected $description = 'Crawl the website, translate content, and store in the database';

    public function handle()
    {
        $baseUrl = 'https://easymoveeurope.com';
        // $baseUrl = 'https://easymoveeurope.com/whosignup';
        // $baseUrl = 'https://easymoveeurope.com/service';
        // $baseUrl = 'https://easymoveeurope.com/contact';
        // $baseUrl = 'https://easymoveeurope.com/about';
        // $baseUrl = 'https://easymoveeurope.com/whosignup';
        // $baseUrl = 'https://easymoveeurope.com/comsignup';
        // $baseUrl = 'https://easymoveeurope.com/login';
        // $baseUrl = 'https://easymoveeurope.com/register';
        // $baseUrl = 'https://easymoveeurope.com/password/reset';
        // $baseUrl = 'https://easymoveeurope.com/privacy';
        
        $languages = ['de', 'it','fr','es','pt','pl','ro'];
        // $languages = ['ro'];
        foreach ($languages as $targetLanguage) {
            $translatedContent = $this->translateWebsite($baseUrl, $targetLanguage);
            $this->storeTranslations($targetLanguage, $translatedContent);
        }

        $this->info('Website content translated and stored in the database.');
    }

    private function translateWebsite($baseUrl, $targetLanguage)
    {
        $guzzleClient = new GuzzleClient();
        $crawler = new \Symfony\Component\DomCrawler\Crawler();

        $response = $guzzleClient->get($baseUrl);
        $crawler->addContent($response->getBody());

        $translatedContent = [];

        // Add the specific selectors of the elements you want to translate.
        $selectors = [
            'h1', 'h2', 'h3', 'h4','h5','h6','p', 'a', 'span','strong','b','i','u','ul','li','nav','body','div','ol','head','button','input','placeholder','select'
        ];

        foreach ($selectors as $selector) {
            $crawler->filter($selector)->each(function ($node) use (&$translatedContent, $targetLanguage) {
                $originalText = $node->text();
                $translatedText = $this->translateText($originalText, $targetLanguage);

                // You may need to modify the key format to match your database structure.
                // $key = $targetLanguage . '.' . $node->getNode(0)->getNodePath();
                $key = $node->text();
                $translatedContent[$key] = $translatedText;
            });
        }

        return $translatedContent;
    }

    private function translateText($text, $targetLanguage)
    {
        // Implement the logic to use the translation API (Google Cloud Translation in this example).
        // Replace 'YOUR_GOOGLE_TRANSLATE_API_KEY' with your actual API key.
        // $apiKey = env('GOOGLE_TRANSLATE_API_KEY');
        $apiKey = "AIzaSyATVw2Cw51yzQsWQGOEmjJHcDDcE5w8peM";

        $guzzleClient = new GuzzleClient();
        $response = $guzzleClient->post('https://translation.googleapis.com/language/translate/v2', [
            'query' => ['key' => $apiKey],
            'json' => [
                'q' => $text,
                'target' => $targetLanguage,
            ],
        ]);

        $translatedData = json_decode($response->getBody(), true);
        return $translatedData['data']['translations'][0]['translatedText'];
    }

    private function storeTranslations($targetLanguage, $translations)
    {
        foreach ($translations as $key => $value) {
            Translation::updateOrCreate(
                ['locale' => $targetLanguage, 'key' => $key],
                ['value' => $value]
            );
        }
    }
}
