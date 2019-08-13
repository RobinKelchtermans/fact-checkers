<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class VRTFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make('https://www.vrt.be/vrtnws/nl.rss.articles.xml');
        $this->source = 'VRT';
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
            $article = $this->driver->findElement(WebDriverBy::className('article__content-wrapper'))->getAttribute('innerHTML');
            $main_image = $this->driver->findElement(WebDriverBy::tagName('img'))->getAttribute('srcset');
            $main_image = explode(" ", $main_image);
            $main_image = $main_image[0];
        } catch (\Throwable $th) {
            return null;
        }

        // try {
        //     $video = $this->driver->findElement(WebDriverBy::className('vrtvideo'))->getAttribute('outerHTML');
        // } catch (\Throwable $th) {
        //     $video = "";
        // }
        $video = "";

        if ($this->isJournaal($article)) {
            return null;
        }
        
        // Geen plus voor VRT?
        // if ($this->isPlusArticle($article)) {
        //     return null;
        // }

        return $this->sanitizeArticle($article . $video, $main_image);
    }

    private function isJournaal($article) {
        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding('<!DOCTYPE html>' . $article, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new \DOMXpath($dom);
        $node = $xpath->query('//h1[contains(text(), "LIVE : Het Journaal")]');
        if ($node->length > 0) {
            return true;
        }
        $node = $xpath->query('//p[contains(text(), "Herbekijk het weerbericht van")]');
        if ($node->length > 0) {
            return true;
        }
        $node = $xpath->query('//p[contains(text(), "Herbekijk hier Het Journaal")]');
        if ($node->length > 0) {
            return true;
        }
        $node = $xpath->query('//p[contains(text(), "Herbekijk Het Journaal")]');
        if ($node->length > 0) {
            return true;
        }
        return false;
    }

    // private function isPlusArticle($article) {
    //     $dom = new \DOMDocument;
    //     @$dom->loadHTML('<!DOCTYPE html>' . $article);
    //     $finder = new \DomXPath($dom);
    //     $nodes = $finder->query("//*[contains(@class, 'paywall')]");
    //     if (sizeof($nodes) > 0) {
    //         return true;
    //     }
    //     return false;
    // }

    private function sanitizeArticle($article, $main_image) {
        $article = $this->sanitize($article);

        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding('<!DOCTYPE html>' . $article, 'HTML-ENTITIES', 'UTF-8'));

        // Add image after title
        $xpath = new \DOMXpath( $dom );
        $node = $xpath->query('//div[contains(@class, "article__intro")]')->item(0);
        $frag = $dom->createDocumentFragment();
        $frag->appendXML( "<img src='$main_image' />" );
        $node->parentNode->insertBefore( $frag, $node );


        $dom = $this->removeTags($dom, [
            'footer',
        ]);
        $dom = $this->removeClasses($dom, [
            'article__meta',
            'vrt-social-links',
            'article__services',
            'vrtlist--related-article',
            'cq-placeholder',
            'quote',
            'teaser',
            'article__disclaimer',
            'article__tag',
        ]);

        // Remove video's and text above video
        $finder = new \DomXPath($dom);
        $nodes = $finder->query("//*[contains(@class, 'videoplayer')]");
        foreach ($nodes as $item) {
            $item->parentNode->removeChild($item); 
        }

        $dom = $this->handleImages($dom);

        $dom = $this->removeWords($dom, [
            'Herbekijk hieronder',
            'Bekijk hieronder',
            'Beluister hieronder',
            'Herbekijk hier',
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
            'source' => 'VRT',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}