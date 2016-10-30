yii2-widget-ilya-birman-likely
==================

The Likely widget is a wrapper for the [Likely Plugin](https://github.com/ilyabirman/Likely) JS Plugin designed by Ilya Birman. This plugin is a simple and beautiful created for adding social sharing buttons that aren’t shabby.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/mooza/yii2-widget-ilyabirman-likely/blob/master/composer.json) for this extension's requirements and dependencies.

To install, either run

```
$ php composer.phar require mooza/yii2-widget-ilyabirman-likely "*"
```

or add

```
"mooza/yii2-widget-ilya-birman-likely": "*"
```

to the ```require``` section of your `composer.json` file.

## Latest Release

> NOTE: The latest version of the module is v1.0.0. Refer the [CHANGE LOG](https://github.com/mooza/yii2-widget-ilyabirman-likely/blob/master/CHANGE.md) for details.

## Usage

```php
use mooza\likely\Likely;

echo Likely::widget([
    'pluginOptions' => [
        'colorClass' => 'light',
        'items' => [
            [
                'class' => 'facebook'
            ],
            [
                'class' => 'twitter',
                'title' => 'Share'
            ],
        ]
    ]
]);
```

## License

**yii2-widget-ilyabirman-likely** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.