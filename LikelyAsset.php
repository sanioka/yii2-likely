<?php

/**
 * @copyright Copyright &copy; Mooza, mooza.ru, 2016
 * @package yii2-widgets
 * @subpackage yii2-widget-ilyabirman-likely
 * @version 1.0.0
 */

namespace frontend\widgets\mooza\likely;

use yii\web\AssetBundle;

/**
 * Asset bundle for Likely Widget
 *
 * @author Mooza <info@mooza.ru>
 * @since 1.0
 */
class LikelyAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/bower/ilyabirman-likely/release';

    /**
     * @inheritdoc
     */
    public $js = [
        'likely.js',
        'likely-commonjs.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'likely.css',
    ];
}
