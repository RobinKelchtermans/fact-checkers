<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class HLNFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make('https://www.hln.be/rss.xml');
        $this->source = 'Het Laatste Nieuws';
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
            $article = $this->driver->findElement(WebDriverBy::className('fjs-article'))->getAttribute('innerHTML');
        } catch (\Throwable $th) {
            return null;
        }

        if ($this->isPlusArticle($article)) {
            return null;
        }
        return $this->sanitizeArticle($article);
    }

    private function isPlusArticle($article) {
        $dom = new \DOMDocument;
        @$dom->loadHTML('<!DOCTYPE html>' . $article);
        $finder = new \DomXPath($dom);
        $nodes = $finder->query("//*[contains(@class, 'paywall')]");
        if (sizeof($nodes) > 0) {
            return true;
        }
        return false;
    }

    private function sanitizeArticle($article) {
        $article = $this->sanitize($article);

        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding('<!DOCTYPE html>' . $article, 'HTML-ENTITIES', 'UTF-8'));

        $dom = $this->removeTags($dom, [
            'aside',
        ]);
        $dom = $this->removeClasses($dom, [
            'article__metadata',
            'related-content',
            'article__tag-list',
            'article__social',
            'widget',
            'article-divider',
            'article__snippet',
            'article__quote'
        ]);

        $dom = $this->handleImages($dom);

        $dom = $this->removeWords($dom, [
            'Bekijk ook:',
            'De tekst gaat verder onder de afbeelding',
        ]);

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
            'source' => 'Het Laatste Nieuws',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}