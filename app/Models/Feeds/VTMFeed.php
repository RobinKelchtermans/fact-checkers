<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class VTMFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make('http://www.vtm.be/rss/nieuws.php');
        dd($feed);
        $this->source = 'VTM';
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
        $first = array_shift($articles);

        // Special treatment for the first article.
        $content = $this->getArticleContent($first->get_permalink(), true);
        // if null, paywall or error.
        if ($content != null) {
            array_push($articlesWitContent, $this->setupArticleInfoArray($first, $content));
        }

        foreach ($articles as $article) {
            $content = $this->getArticleContent($article->get_permalink());
            // if null, paywall or error.
            if ($content != null) {
                array_push($articlesWitContent, $this->setupArticleInfoArray($article, $content));
            }
        }
        return $articlesWitContent;
    }

    private function getArticleContent($url, $acceptCookies = false) {
        $this->driver->get($url);

        if ($acceptCookies) {
            $this->driver->findElement(WebDriverBy::className('fjs-set-consent'))->click();
        }

        try {
            $article = $this->driver->findElement(WebDriverBy::className('article-detail'))->getAttribute('innerHTML');
        } catch (\Throwable $th) {
            return null;
        }

        try {
            $title = $this->driver->findElement(WebDriverBy::className('article-title'))->getAttribute('innerHTML');
        } catch (\Throwable $th) {
            return null;
        }
        
        // if ($this->isPlusArticle($article)) {
        //     return null;
        // }
        dd($this->sanitizeArticle($title . $article));
        return $this->sanitizeArticle($title . $article);
    }

    private function isPlusArticle($article) {
        // $dom = new \DOMDocument;
        // @$dom->loadHTML('<!DOCTYPE html>' . $article);
        // $finder = new \DomXPath($dom);
        // $nodes = $finder->query("//*[contains(@class, 'paywall')]");
        // if (sizeof($nodes) > 0) {
        //     return true;
        // }
        return false;
    }

    private function sanitizeArticle($article) {
        // $article = $this->sanitize($article);

        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding('<!DOCTYPE html>' . $article, 'HTML-ENTITIES', 'UTF-8'));

        $dom = $this->removeTags($dom, [
           
        ]);
        $dom = $this->removeClasses($dom, [
            
        ]);

        $dom = $this->handleImages($dom);

        return $dom->savehtml($dom->documentElement);
    }

    private function setupArticleInfoArray($article, $content) {
        return [
            'article_id' => $this->sanitizeTitle($article->get_title()) . '-' . $this->generateRandomString(5),
            'title' => $article->get_title(),
            'url' => $article->get_permalink(),
            'description' => $this->sanitizeDescription($article),
            'published_on' => $article->get_date('Y-m-d H:i:s'),
            'content' => $content,
            'source' => 'VTM',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}