<?php
namespace bl\cms\sitemap\console\controllers;

use bl\articles\common\entities\Article;
use bl\articles\common\entities\Category;
use bl\cms\gallery\models\entities\GalleryAlbum;
use bl\cms\shop\common\entities\Product;
use bl\multilang\entities\Language;
use yii\console\Controller;
use yii2tech\sitemap\File;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class SitemapController extends Controller
{
    // TODO: remove priority
    public function actionGenerate() {
        $siteMapFile = new File();
        $siteMapFile->fileBasePath = '@frontend/web';
        $languages = Language::findAll(['show' => true]);

        foreach($languages as $language) {
            // home page
            $siteMapFile->writeUrl(['site/index', 'language' => $language->lang_id]);

            $albums = GalleryAlbum::findAll(['show' => true]);

            if(!empty($albums)) {
                $siteMapFile->writeUrl(['/gallery/album/view', 'language' => $language->lang_id]);
                foreach ($albums as $album) {
                    $siteMapFile->writeUrl(['/gallery/album/view', 'id' => $album->id, 'language' => $language->lang_id]);
                }
            }

            $categories = Category::findAll(['show' => true]);

            if(!empty($categories)) {
                foreach ($categories as $category) {
                    $siteMapFile->writeUrl(['/articles/category/index', 'id' => $category->id, 'language' => $language->lang_id]);
                }
            }

            $articles = Article::findAll(['show' => true]);

            if(!empty($articles)) {
                foreach ($articles as $article) {
                    $siteMapFile->writeUrl(['/articles/article/index', 'id' => $article->id, 'language' => $language->lang_id]);
                }
            }

            $products = Product::find()->all();

            if(!empty($products)) {
                foreach ($products as $product) {
                    $siteMapFile->writeUrl(['/shop/product/show', 'id' => $product->id, 'language' => $language->lang_id]);
                }
            }

            $productCategories = \bl\cms\shop\common\entities\Category::find()->all();

            if(!empty($productCategories)) {
                $siteMapFile->writeUrl(['/shop/category/show', 'language' => $language->lang_id]);
                foreach ($productCategories as $productCategory) {
                    $siteMapFile->writeUrl(['/shop/category/show', 'id' => $productCategory->id, 'language' => $language->lang_id]);
                }
            }
        }


        $siteMapFile->close();
    }
}