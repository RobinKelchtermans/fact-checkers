<?php

namespace App\Models\Feeds;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feed;
use Feeds;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class HetNieuwsbladFeed extends Feed
{    
    public function __construct()
    {
        $feed = Feeds::make([
            'http://feeds.nieuwsblad.be/nieuws/snelnieuws',         // Snelnieuws
            'http://feeds.nieuwsblad.be/nieuws/binnenland',         // Binnenland
            'http://feeds.nieuwsblad.be/nieuwsblad/buitenland',     // Buitenland
            'http://feeds.nieuwsblad.be/economie/home',             // Economie
            'http://feeds.nieuwsblad.be/economie/algemeen',         // Consument
            'http://feeds.nieuwsblad.be/economie/bedrijven',        // Bedrijven
            'http://feeds.nieuwsblad.be/economie/Werk',             // Werk
            'http://feeds.nieuwsblad.be/economie/beurs/',           // Beurs
            'http://feeds.nieuwsblad.be/nieuwsblad/sport/voetbal',  // Voetbal
            'http://feeds.nieuwsblad.be/nieuwsblad/sport/wielrennen',   // Wielrennen
            'http://feeds.nieuwsblad.be/nieuwsblad/sport/tennis',       // Tennis
            'http://feeds.nieuwsblad.be/nieuwsblad/sport/autosport',    // Autosport
            'http://feeds.nieuwsblad.be/nieuwsblad/sport/basketbal',    // Basketbal
            'http://feeds.nieuwsblad.be/nieuwsblad/sport/volleybal',    // Volleybal
            'http://feeds.nieuwsblad.be/nieuwsblad/sport/atletiek',     // Atletiek
        ]);
        $this->source = 'Het Nieuwsblad';
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
            'lig_nieuwsblad_news_smartbox_article',
        ]);
        $dom = $this->removeTags($dom, [
            // 'script',
            'footer',
        ]);
        $dom = $this->removeClasses($dom, [
            'link-complex',
            'article__share',
            'ad ',
            'section-title--adjacent',
            'article__tags',
            'related-articles',
            'widget__body',
            'nb-logo-f',
            'video--theoplayer',
            'Copy',
            'copy',
            'article__location',
            'qualifio_iframe_tag',
            'icon-pinit',
            'banner-she-traffic',
        ]);
        $dom = $this->removeWords($dom, [
            'LEES OOK.',
            'LEES MEER.',
            'bekijk ook',
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
            'source' => 'Het Nieuwsblad',
            'picture_link' => $this->getPictureLink($content),
        ];
    }
}