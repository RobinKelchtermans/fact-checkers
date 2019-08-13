<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class GVAFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make([
            'https://www.gva.be/rss/section/ca750cdf-3d1e-4621-90ef-a3260118e21c', // Home
            'https://www.gva.be/rss/section/19950B9F-8A8E-4ED3-A4BD-A2AC00E91A57', // Stad & Regio
            'https://www.gva.be/rss/section/8B7011DF-CAD2-4474-AA90-A2AC00E31B55', // Economie
            'https://www.gva.be/rss/section/5685D99C-D24E-4C8A-9A59-A2AC00E293B1', // Binnenland
            'https://www.gva.be/rss/section/472C34EB-D1BC-4E10-BDE7-A2AC00E2D820', // Buitenland
            'https://www.gva.be/rss/section/49478206-DE39-41C5-A04F-A2AC00E72CFF', // Media en cultuur
            'https://www.gva.be/rss/section/4DFF3E33-6C32-4E60-803C-A2AC00EDE26C', // Sport
        ]);
        $this->source = 'Gazet van Antwerpen';
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
            'lig_gva_desktop_smartbox_nieuws',
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
            'article__sidebar',
            'article__video__credits',
        ]);
        $dom = $this->removeWords($dom, [
            'LEES OOK.',
            'Klik hier voor',
            'LEES MEER.',
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
            'source' => 'Gazet van Antwerpen',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}