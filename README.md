# Anchor Text Checker

## Description
This package allows to crawl a website and check anchor text and nofollow.
Under the hood, this package uses [symfony/dom-crawler](https://symfony.com/doc/current/components/dom_crawler.html) and [symfony/css-selector](https://symfony.com/doc/current/components/css_selector.html) packages for crawling HTML dom.

## Installation
This package can be installed via composer
```php
edionme/anchortextchecker
```

## Usage
AnchorTextChecker can be use like this:
```php
AnchorTextChecker::crawl(url, linkingUrls)
```

**Params**

* url - `(string)` The url to crawl. Should be full url.
* linkingUrls - `(string|array)` The domain/s to check.

**Example**
```php
AnchorTextChecker::crawl('https://edionme.com', [
    'github.com',
    'twitter.com'
])
```

**Example Return**
```php
[
    [
        html: "<a class="link mr-3 text-gray-600 hover:text-blue-800" target="_blank" href="twitter.com/edionmelarosa">
                        <i class="fab fa-twitter"></i>
                    </a>",
        href: "twitter.com/edionmelarosa",
        rel: null,
        nofollow: false,
        anchor_text: "",
    ],
    [
        html: "<a class="link mr-3 text-gray-600 hover:text-blue-800" target="_blank" rel="nofollow" href="https://github.com/edionmelarosa">
                        <i class="fab fa-github"></i>
                    </a>",
        href: "https://github.com/edionmelarosa",
        rel: "nofollow",
        nofollow: 1,
        anchor_text: "",
    ],
]
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.