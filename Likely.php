<?php

/**
 * @copyright Copyright &copy; Mooza, Mooza.ru, 2016
 * @package yii2-widgets
 * @subpackage yii2-widget-ilyabirman-likely
 * @version 1.0.0
 */

namespace mooza\likely;

use yii\base\Widget;

/** The Ilya Birman's Likely widget is a wrapper for the Likely Plugin designed by Ilya Birman.
 * This plugin is a simple and beautiful created for adding social sharing buttons that aren’t shabby.
 *
 * @see https://github.com/ilyabirman/Likely
 * @see https://github.com/mooza/yii2-widget-ilyabirman-likely
 * @author Mooza <info@mooza.ru>
 * @since 1.0
 */
class Likely extends Widget
{
    /**
     * @var array
     */
    public $pluginOptions = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
        $this->initOptions();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (count($this->errors) == 0) {
            echo $this->render('likely', ['options' => $this->options]);
        } else {
            echo "Likely errors: ";
            foreach ($this->errors as $error) {
                echo $error . ";";
            }
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        LikelyAsset::register($view);
    }

    /**
     * initOptions() checks PluginOptions property is correct and adds error to errors[] if it is not
     * and adds some initial values if PluginOptions[items] property is empty
     *
     * @return bool
     */
    public function initOptions()
    {
        if (array_key_exists('url', $this->pluginOptions) && $this->pluginOptions['url'] != '') {
            if (filter_var($this->pluginOptions['url'], FILTER_VALIDATE_URL) === FALSE) {
                $this->addError('url');
            } else {
                $this->options['url'] = $this->pluginOptions['url'];
            }
        }

        if (array_key_exists('title', $this->pluginOptions) && $this->pluginOptions['title'] != '') {
            $this->options['title'] = $this->pluginOptions['title'];
        }

        if (array_key_exists('colorClass', $this->pluginOptions) && $this->pluginOptions['colorClass'] != '') {
            if ($this->pluginOptions['colorClass'] == 'light') {
                $this->options['colorClass'] = 'likely-light';
            } else {
                $this->addError('colorClass');
            }
        }

        if (array_key_exists('sizeClass', $this->pluginOptions) && $this->pluginOptions['sizeClass'] != '') {
            if ($this->pluginOptions['sizeClass'] == 'small') {
                $this->options['sizeClass'] = 'likely-small';
            } elseif ($this->pluginOptions['sizeClass'] == 'big') {
                $this->options['sizeClass'] = 'likely-big';
            } else {
                $this->addError('sizeClass');
            }
        }

        if (array_key_exists('items', $this->pluginOptions)) {
            if (is_array($this->pluginOptions['items']) && count($this->pluginOptions['items']) > 0) {
                foreach ($this->pluginOptions['items'] as $i => $item) {
                    if (is_array($item)) {
                        if (array_key_exists('class', $item) && array_key_exists($item['class'], $this->getSocialNetworksList())) {
                            $this->options['items'][$i]['class'] = $item['class'];
                            if (array_key_exists('title', $item)) {
                                $this->options['items'][$i]['title'] = $item['title'];
                            } else {
                                $this->options['items'][$i]['title'] = $this->getSocialNetworksList()[$item['class']];
                            }

                            if ($item['class'] == 'twitter' && $item['via'] != '') {
                                $this->options['items'][$i]['via'] = $item['via'];
                            }

                            if ($item['class'] == 'facebook' && $item['imagePath'] != '') {
                                $this->registerFacebookImageMeta($item['imagePath'], $i);
                            }

                            if ($item['class'] == 'telegram' && $item['text'] != '') {
                                $this->options['items'][$i]['text'] = $item['text'];
                            }

                            if ($item['class'] == 'pinterest' && $item['media'] != '') {
                                if (file_exists($item['media'])) {
                                    $this->options['items'][$i]['media'] = $item['media'];
                                } else {
                                    $this->addError('items', $i, 'media');
                                }
                            }
                        } else {
                            $this->addError('items', $i, 'class');
                        }
                    } else {
                        $this->addError('items', '');
                    }
                }
            } else {
                $this->addError('items');
            }
        } else {
            $this->options['items'] = [
                [
                    'class' => 'twitter',
                    'title' => 'Tweet',
                    'via' => '',
                ],
                [
                    'class' => 'facebook',
                    'title' => 'Share',
                    'image' => '',
                ],
                [
                    'class' => 'gplus',
                    'title' => 'Share',
                ],
                [
                    'class' => 'vkontakte',
                    'title' => 'Поделиться',
                ],
                [
                    'class' => 'telegram',
                    'title' => 'Send',
                    'text' => '',
                ],
                [
                    'class' => 'odnoklasskini',
                    'title' => 'Класснуть',
                ],
                [
                    'class' => 'pinterest',
                    'title' => 'Pin',
                    'media' => '',
                ],
            ];
        }
        return true;
    }

    /**
     * @return array
     */
    protected function getSocialNetworksList()
    {
        return [
            'twitter' => 'Tweet',
            'facebook' => 'Share',
            'gplus' => 'Share',
            'vkontakte' => 'Поделиться',
            'telegram' => 'Send',
            'odnoklassniki' => 'Класснуть',
            'pinterest' => 'Pin',
        ];
    }

    /**
     * @param $path
     * @param $i
     */
    protected function registerFacebookImageMeta($path, $i)
    {
        if (file_exists($path)) {
            $view = $this->getView();
            $view->registerMetaTag(['property' => 'og:image', 'content' => $path]);
        } else {
            $this->addError('items', $i, 'image');
        }
    }

    /**
     * @param $first
     * @param null $second
     * @param null $third
     */
    protected function addError($first, $second = null, $third = null)
    {
        if ($second === null) {
            $this->errors[] = "Incorrect value in pluginOptions['$first'] property";
        } elseif ($third === null) {
            $this->errors[] = "Incorrect value in pluginOptions['$first']['$second'] property";
        } else {
            $this->errors[] = "Incorrect value in pluginOptions['$first']['$second']['$third'] property";
        }
    }
}
