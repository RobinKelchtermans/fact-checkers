<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class HBVLFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make([
            'https://www.hbvl.be/rss/section/D1618839-F921-43CC-AF6A-A2B200A962DC',    // Home
            
        ]);
        $this->source = 'Het Belang van Limburg';
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
            $article = $this->driver->findElement(WebDriverBy::xpath('//*/div[@data-mht-block="article-detail__article-main"]'))->getAttribute('innerHTML');
        } catch (\Throwable $th) {
            return null;
        }

        if ($this->isPlusArticle()) {
            return null;
        }

        return $this->sanitizeArticle($article);
    }

    private function isPlusArticle() {
        try {
            $body = $this->driver->findElement(WebDriverBy::xpath('//body[contains(@class,"is-closed-article")]'))->getAttribute('innerHTML');
            if (strlen($body) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function sanitizeArticle($article) {
        $article = $this->sanitize($article);

        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding('<!DOCTYPE html>' . $article, 'HTML-ENTITIES', 'UTF-8'));

        $dom = $this->removeIds($dom, [
            'iframe-optinbox',
            'lig_hbvl_desktop_smartbox_nieuws',
            'lig_hbvl_desktop_smartbox_she',
        ]);
        $dom = $this->removeTags($dom, [
            'script',
            'footer',
            'style',
        ]);
        $dom = $this->removeClasses($dom, [
            'link-complex',
            'article__share',
            'ad ',
            'section-title--adjacent',
            'article__tags',
            'widget-listwidget--plus',
            'header-2018',
            'widget',
            'article__location',
            'icon-pinit',
            'article__sidebar',
            'article__video__credits',
            'slideshow__controls',
        ]);
        $dom = $this->removeWords($dom, [
            'LEES OOK.',
            'LEES MEER.',
            'Klik hier voor',
            'Niet te missen',
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
            'source' => 'Het Belang van Limburg',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}