<?php

declare(strict_types=1);

namespace Edionme\AnchorTextChecker;

use Exception;
use Symfony\Component\DomCrawler\Crawler;

class AnchorTextChecker
{
    /**
     * Crawl url
     * 
     * @param string $url 
     * @param string|array $linkingUrls 
     * @return array|void 
     * @throws Exception 
     */
    public static function crawl($url, $linkingUrls)
    {
        if (!$url) {
            throw new Exception('Url not valid');
        }

        if (!$linkingUrls) {
            throw new Exception('Linking urls not valid');
        }

        try {
            if (!is_array($linkingUrls)) {
                $linkingUrls = [$linkingUrls];
            }

            $html = file_get_contents($url);
            $crawler = new Crawler($html);

            $anchorTexts =  $crawler
                ->filter('a')
                ->reduce(function (Crawler $node, $key) use ($linkingUrls) {
                    $href = $node->attr('href');
                    $parseUrls = parse_url($href);

                    $host = $parseUrls['host'] ?? $parseUrls['path'];
                    $host = explode('/', $host)[0];

                    return in_array($host, $linkingUrls);
                })
                ->each(function (Crawler $node, $key) {
                    $rel = $node->attr('rel');

                    return [
                        'html'        => $node->outerHtml(),
                        'href'        => $node->attr('href'),
                        'rel'         => $rel,
                        'nofollow'    => ($rel) ? preg_match('/nofollow/', $rel) : false,
                        'anchor_text' => $node->text()
                    ];
                });

            return $anchorTexts;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
