<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class DeTijdFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make('https://www.tijd.be/rss/nieuws.xml');
        $this->source = 'De Tijd';
        parent::__construct($feed);
    }

    function __destruct() {
        $this->driver->quit();
    }

    public function getAndSaveLatestArticles() {
        $articles = $this->fetchArticles($this->RSS);
        $this->saveArticlesToDB($articles);
        return $articles;
    }

    /**
     * Fetch content of all articles
     *
     * @param array $articles
     * @return array with content
     */
    private function fetchArticles($articles) {
        if (sizeof($articles) < 1) {
            return [];
        }
        $articlesWitContent = []; 

        foreach ($articles as $article) {
            $content = $this->getArticleContent($article->get_permalink());
            // if null, paywall or error.
            if ($content != null) {
                array_push($articlesWitContent, $this->setupArticleInfoArray($article, $content));
            }
        }
        return $articlesWitContent;
    }

    private function getArticleContent($url) {
        $this->driver->get($url);
        // $this->driver->get('https://www.tijd.be/ondernemen/luchtvaart/Nederland-doet-het-op-zijn-Frans-bij-Air-France-KLM/10102560');

        try {
            // $this->driver->findElement(WebDriverBy::tagName('h1'))->click();
            $article = $this->driver->findElement(WebDriverBy::className('o-mainarticle'))->getAttribute('innerHTML');
        } catch (\Throwable $th) {
            return null;
        }
        
        if ($this->isPlusArticle()) {
            return null;
        }

        // dd($this->sanitizeArticle($article));
        return $this->sanitizeArticle($article);
    }

    private function isPlusArticle() {
        try {
            $body = $this->driver->findElement(WebDriverBy::xpath('//*[contains(@id,"paywall-overlay")]'))->getAttribute('innerHTML');
            // echo $body . "<br><br><br>";
            if ($body != "") {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            // dd($th);
            return false;
        }
    }

    private function sanitizeArticle($article) {
        $article = $this->sanitize($article);

        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding('<!DOCTYPE html>' . $article, 'HTML-ENTITIES', 'UTF-8'));

        $dom = $this->removeTags($dom, [
            'footer',
            'script',
        ]);
        $dom = $this->removeClasses($dom, [
            'c-articlehead__detail',
            'c-articlehead__detail__share',
            'c-adcontainer',
            'o-articleinset-left',
            'o-articleinset-right',
            'o-articleinset-center',
            'o-artdetailreadmore',
            'o-articlebody-right',
            'c-articlehead__labels',
            'c-articleimage__button',
        ]);

        $dom = $this->handleImages($dom);

        return $dom->savehtml($dom->documentElement);
    }

    protected function getPictureLink($content) {
        $dom = new \DOMDocument;
        @$dom->loadHTML($content);
        try {
            $main_image = @$dom->getElementsByTagName('img')->item(0)->getAttribute('data-srcset');            
            $main_image = explode(", ", $main_image);
            $picture_link = $main_image[count($main_image) - 1];
            $picture_link = explode(" ", $picture_link);
            $picture_link = $picture_link[0];
        } catch (\Throwable $th) {
            return "";
        }
        return $picture_link;
    }

    private function setupArticleInfoArray($article, $content) {
        return [
            'article_id' => $this->sanitizeTitle($article->get_title()) . '-' . $this->generateRandomString(5),
            'title' => $article->get_title(),
            'url' => $article->get_permalink(),
            'description' => $this->sanitizeDescription($article),
            'published_on' => $article->get_date('Y-m-d H:i:s'),
            'content' => $content,
            'source' => 'De Tijd',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}