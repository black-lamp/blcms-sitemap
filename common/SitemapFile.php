<?php
namespace bl\cms\sitemap\common;
use yii2tech\sitemap\File;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class SitemapFile extends File
{
    public function writeUrl($url, array $options = [])
    {
        $this->incrementEntriesCount();

        if (!is_string($url)) {
            $url = $this->getUrlManager()->createAbsoluteUrl($url);
        }

        $xmlCode = '<url>';
        $xmlCode .= "<loc>{$url}</loc>";

        if(!empty($options) && is_array($options)) {
            if(array_key_exists('lastModified', $options)) {
                $xmlCode .= "<lastmod>{$options['lastModified']}</lastmod>";
            }
            if(array_key_exists('changeFrequency', $options)) {
                $xmlCode .= "<changefreq>{$options['changeFrequency']}</changefreq>";
            }
            if(array_key_exists('priority', $options)) {
                $xmlCode .= "<priority>{$options['priority']}</priority>";
            }
        }

        $xmlCode .= '</url>';
        return $this->write($xmlCode);
    }

}