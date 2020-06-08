<?php

namespace Edionme\AnchorTextChecker\Test;

use Edionme\AnchorTextChecker\AnchorTextChecker;
use Exception;
use PHPUnit\Framework\TestCase;

class AnchorTextCheckerTest extends TestCase
{
    /** @test */
    public function should_return_exception_for_not_valid_url()
    {
        $this->expectException(Exception::class);
        AnchorTextChecker::crawl('', [
            'github.com',
            'twitter.com'
        ]);
    }

    /** @test */
    public function should_return_exception_for_not_valid_linking_urls()
    {
        $this->expectException(Exception::class);
        AnchorTextChecker::crawl('http://personal-site-laravel.test', null);
    }

    /** @test */
    public function should_return_complete_fields()
    {
        $links = AnchorTextChecker::crawl('http://personal-site-laravel.test', [
            'github.com',
            'twitter.com',
        ]);

        $this->assertIsArray($links);
        $this->assertEquals(array_keys($links['0']), [
            'html',
            'href',
            'rel',
            'nofollow',
            'anchor_text'
        ]);
    }
}
