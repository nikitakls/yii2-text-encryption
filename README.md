nikitakls/yii2-text-encryption
=============================
Encryption text for protect from crawl

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist nikitakls/yii2-text-encryption "*"
```

or add

```
"nikitakls/yii2-text-encryption": "*"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply use it in your code by  :


```php
JsEncryption::encode("text");
```