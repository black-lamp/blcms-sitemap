<?php
namespace bl\cms\sitemap\console;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bl\cms\sitemap\console\controllers';
    public $defaultRoute = 'sitemap/generate';

    public function init()
    {
        parent::init();
    }
}