<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Feeds;
use App\Models\Article;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;

class Feed extends Model
{
    protected $RSS;
    protected $driver;
    protected $source;              // set this value in the child class
    protected $timeSinceLastUpdate; // set this value in the child class

    public function __construct($feed)
    {
        date_default_timezone_set('Europe/Brussels');

        // start Chrome with 5 second timeout
        $host = 'http://bellows.experiments.cs.kuleuven.be:3504/wd/hub';
        // $host = 'http://localhost:4444/wd/hub'; // this is the default
        $options = new ChromeOptions();
        $options->addArguments(array(
            '--headless',   // don't open a real instance of chrome
        ));
        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        $this->driver = RemoteWebDriver::create($host, $caps, 5 * 1000, 120 * 1000);

        // If latest article is older than x hours, just get the latest articles.
        // Otherwise retrieve articles since last in database.
        $max_time = (12*60*60);
        $lastUpdateTime = time() - strtotime($this->getLatestPublishedTime());
        if ($lastUpdateTime > $max_time) {
            $this->timeSinceLastUpdate = $max_time;
        } else {
            $this->timeSinceLastUpdate = $lastUpdateTime;
        }

        echo "We found " . count($feed->get_items()) . " articles in the rss feed of $this->source.\n";

        // get only the latest articles
        $new = array();
        foreach ($feed->get_items() as $item) {
            $yesterday = time() - $this->timeSinceLastUpdate; 
        
            if ($item->get_date('U') > $yesterday) {
                $new[] = $item;
            }
        }

        echo "Retrieving " . count($new) . " articles that are recent enough.\n";

        $this->RSS = $new;
    }

    function __destruct() {
        $this->driver->quit();
    }

    protected function getLatestPublishedTime() {
        return Article::where('source', $this->source)->orderBy('published_on', 'desc')->first()->published_on;
    }

    /**
     * Remove tabs, dubbel new lines and comments
     *
     * @return void
     */
    protected function sanitize($string) {
        $string =  trim(preg_replace('<!--(.*?)-->', '', $string));
        $string =  trim(preg_replace('/\t+/', '', $string));
        $string =  trim(preg_replace('/\n\n+/', '', $string));
        return $string;
    }

    protected function removeTags($dom, $tags) {
        foreach ($tags as $tag) {
            $elements = $dom->getElementsByTagName($tag);
            $remove = [];
            foreach ($elements as $item) {
                $remove[] = $item;
            }
            foreach ($remove as $item) {
                $item->parentNode->removeChild($item); 
            }
        }
        return $dom;
    }

    protected function removeClasses($dom, $classes) {
        foreach ($classes as $class) {
            $finder = new \DomXPath($dom);
            $nodes = $finder->query("//*[contains(@class, '$class')]");
            foreach ($nodes as $item) {
                $item->parentNode->removeChild($item); 
            }
        }
        return $dom;
    }

    protected function removeWords($dom, $words) {
        foreach ($words as $word) {
            $domx = new \DOMXPath($dom);
            $nodes = $domx->query("//*[contains(text(), '$word')]");
            foreach ($nodes as $item) {
                $item->parentNode->removeChild($item); 
            }
        }
        return $dom;
    }

    protected function removeIds($dom, $ids) {
        foreach ($ids as $id) {
            $finder = new \DomXPath($dom);
            $nodes = $finder->query("//*[contains(@id, '$id')]");
            foreach ($nodes as $item) {
                $item->parentNode->removeChild($item); 
            }
        }
        return $dom;
    }

    protected function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function sanitizeTitle($string) {
        $string = mb_strimwidth($string, 0, 150);
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /**
     * Add bootstrap class to images
     *
     * @param [type] $dom
     * @return void
     */
    protected function handleImages($dom) {
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $img->setAttribute('class', 'img-fluid img-stretch');
        }

        $frames = $dom->getElementsByTagName('iframe');
        foreach ($frames as $frame) {
            $frame->setAttribute('class', 'img-fluid img-stretch');
        }

        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            try {
                $sibling = $link->firstChild;
                do {
                    $next = $sibling->nextSibling;
                    $link->parentNode->insertBefore($sibling, $link);
                } while ($sibling = $next);
                $link->parentNode->removeChild($link);   
            } catch (\Throwable $th) {
                //skip
            }
        }

        // if some link are still there, remove the reference
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            try {
                $link->setAttribute('href', '#');
            } catch (\Throwable $th) {
                // skip
            }
        }

        // remove styles from images
        $domx = new \DOMXPath($dom);
        $items = $domx->query("//picture[@style]");
        foreach($items as $item) {
            $item->removeAttribute("style");
        }

        $items = $domx->query("//*[contains(@class, 'video-embed')]");
        foreach($items as $item) {
            $item->setAttribute('class', 'video-embed img-fluid img-stretch');
        }

        // // add classes to video tags
        // // $videos = $dom->getElementsByClassName('video');
        // $finder = new \DomXPath($dom);
        // $videos = $finder->query("//*[contains(@class, 'video')]");
        // foreach ($videos as $video) {
        //     $video->setAttribute('class', 'img-fluid img-stretch');
        //     // $video->removeAttribute("style");
        // }

        return $dom;
    }

    protected function getPictureLink($content) {
        $dom = new \DOMDocument;
        @$dom->loadHTML($content);
        try {
            $picture_link = @$dom->getElementsByTagName('img')->item(0)->getAttribute('src');
        } catch (\Throwable $th) {
            return "";
        }
        return $picture_link;
    }

    protected function sanitizeDescription($article) {
        $dom = new \DOMDocument;
        @$dom->loadHTML(mb_convert_encoding("<!DOCTYPE html>" . $article->get_description(), 'HTML-ENTITIES', 'UTF-8'));
        $description = @$dom->getElementsByTagName('p')->item(0)->nodeValue;

        if ($description == null) {
            if ($article->get_description() == null) {
                $description = "";
            } else {
                $description = $article->get_description();
            }
        }
        return $description;
    }

    // protected function setupArticleInfoArray($article, $content) {
    //     return [
    //         'article_id' => $this->sanitizeTitle($article->get_title()) . '-' . $this->generateRandomString(5),
    //         'title' => $article->get_title(),
    //         'url' => $article->get_permalink(),
    //         'description' => $this->sanitizeDescription($article),
    //         'published_on' => $article->get_date('Y-m-d H:i:s'),
    //         'content' => $content,
    //         'source' => $this->source,
    //         'picture_link' => $this->getPictureLink($content),
    //     ];
    // }

    protected function saveArticlesToDB($articles) {
        foreach ($articles as $article) {
            $articles = Article::where('title', $article['title'])->get();
            if (count($articles) > 0) {
                continue;
            }
            Article::create([
                'article_id' => $article['article_id'],
                'title' => $article['title'],
                'description' => $article['description'],
                'content' => $article['content'],
                'published_on' => $article['published_on'],
                'source' => $article['source'],
                'url' => $article['url'],
                'picture_link' => $article['picture_link'],
            ]);
        }
    }

}