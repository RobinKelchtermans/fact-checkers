<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class DeStandaardFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make([
            'https://www.standaard.be/rss/section/1f2838d4-99ea-49f0-9102-138784c7ea7c',    // Binnenland
            'https://www.standaard.be/rss/section/e70ccf13-a2f0-42b0-8bd3-e32d424a0aa0',    // Buitenland
            'https://www.standaard.be/rss/section/ab8d3fd8-bf2f-487a-818b-9ea546e9a859',    // Cultuur
            'https://www.standaard.be/rss/section/eb1a6433-ca3f-4a3b-ab48-a81a5fb8f6e2',    // Media
            'https://www.standaard.be/rss/section/451c8e1e-f9e4-450e-aa1f-341eab6742cc',    // Economie
            'https://www.standaard.be/rss/section/8f693cea-dba8-46e4-8575-807d1dc2bcb7',    // Sport
            'https://www.standaard.be/rss/section/113a9a78-f65a-47a8-bd1c-b24483321d0f',    // Beroemd & Bizar
        ]);
        $this->source = 'De Standaard';
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

        try {
            $article = $this->driver->findElement(WebDriverBy::className('article-full'))->getAttribute('innerHTML');
        } catch (\Throwable $th) {
            return null;
        }
        
        if ($this->isPlusArticle($article)) {
            return null;
        }

        try {
            $title = $this->driver->findElement(WebDriverBy::className('article__header'))->getAttribute('innerHTML');
        } catch (\Throwable $th) {
            return null;
        }
        return $this->sanitizeArticle($title . $article);
    }

    private function isPlusArticle($article) {
        try {
            $body = $this->driver->findElement(WebDriverBy::xpath('//*[contains(@class,"is-closed-article")]'))->getAttribute('innerHTML');
            if ($body != "") {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
        // //todo: check this
        // $dom = new \DOMDocument;
        // @$dom->loadHTML('<!DOCTYPE html>' . $article);
        // $finder = new \DomXPath($dom);
        // $nodes = $finder->query("//*[contains(@class, 'plusheader')]");
        // if (sizeof($nodes) > 0) {
        //     return true;
        // }
        // return false;
    }

    private function sanitizeArticle($article) {
        $article = $this->sanitize($article);

        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding('<!DOCTYPE html>' . $article, 'HTML-ENTITIES', 'UTF-8'));

        $dom = $this->removeTags($dom, [
            // 'iframe',
        ]);
        $dom = $this->removeClasses($dom, [
            'ad',
            'icon--white',
            'slideshow__controls',
        ]);
        $dom = $this->removeWords($dom, [
            'Klik hier voor',
            'LEES OOK.',
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
            'source' => 'De Standaard',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}