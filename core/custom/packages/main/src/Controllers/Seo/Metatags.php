<?php

namespace EvolutionCMS\Main\Controllers\Seo;

use EvolutionCMS\Facades\HelperProcessor;

/**
 * Трейт формирует
 * метатеги
 */
trait Metatags
{
    /**
     * Шаблон документа для внутренних нужд
     */
    private $template;

    /**
     * Создать теги
     */
    public function metatags()
    {
        $this->template = evo()->documentObject['template'];
        $this->data['metatitle'] = $this->createMetaTitle();
        $this->data['metadescription'] = $this->createMetaDesc();
        $this->data['ogImage'] = $this->createOgImage();
        $this->data['ogType'] = $this->createOgType();
    }

    /**
     * Делаем тайтл
     */
    private function  createMetaTitle()
    {
        $metatitle =  trim(evo()->documentObject['metatitle'][1]);

        //  metatitle не пуст
        if (!empty($metatitle)) {
            return  $metatitle;
        } else {
            //  пустой, генерим
            switch ($this->template) {
                case 1:     // главная
                    $metatitle = evo()->documentObject['pagetitle'];
                    break;

                case evo()->getConfig('product_template_id'):      // товар
                    $metatitle = 'Купить ' . evo()->documentObject['pagetitle'];
                    break;
                case evo()->getConfig('articles_template_id'):      // статья
                    $metatitle = 'Читать ' . evo()->documentObject['pagetitle'];
                    break;
                default:
                    $metatitle = evo()->documentObject['pagetitle'];
                    break;
            }
        }
        return $metatitle;
    }

    /**
     * Делаем дескрипшн
     */
    private function  createMetaDesc()
    {
        $metadescription =  trim(evo()->documentObject['metadescription'][1]);
        //  metadescription не пуст
        if (!empty($metadescription)) {
            return  $metadescription;
        } else {
            //  пустой, генерим
            switch ($this->template) {
                case 2:     // главная
                    $metadescription = evo()->documentObject['pagetitle'];
                    break;

                case evo()->getConfig('product_template_id'):      // товар
                    $metadescription = 'Покупайте ' .  evo()->documentObject['pagetitle'];
                    break;
                case evo()->getConfig('articles_template_id'):      // статья
                    $metadescription = 'Читайте ' .  evo()->documentObject['pagetitle'];

                    break;
                default:
                    $metadescription = evo()->documentObject['pagetitle'];
                    break;
            }
        }
        return $metadescription;
    }


    /**
     * og:image
     */
    public function createOgImage()
    {
        $site_url = evo()->getConfig('site_url');
        $ogImage =  trim(evo()->documentObject['ogImage'][1]);

        //  ogImage не пуст
        if (!empty($ogImage)) {
            return  $site_url . $ogImage;
        } else {
            //  пустой, генерим
            switch ($this->template) {
                case evo()->getConfig('product_template_id'):      // товар
                    $ogImage = evo()->documentObject['product_photo'][1];
                    break;
                case evo()->getConfig('articles_template_id'):      // статья
                    $ogImage = evo()->documentObject['article_photo'][1];

                    break;
                default:
                    $ogImage = 'assets/images/ogdefault.png';
                    break;
            }
        }

        $ogImage = HelperProcessor::phpthumb($ogImage, 'w=1200');
        return $site_url . $ogImage;
    }

    /**
     * og:type
     */
    public function createOgType()
    {
        if (!empty($ogType)) {
            return $ogType;
        } else {
            switch ($this->template) {
                case evo()->getConfig('product_template_id'): //  товар
                    $ogType = 'product';
                    break;
                case evo()->getConfig('articles_template_id'):      // статья
                    $ogType = 'article';
                    break;
                default:
                    $ogType = 'website';
                    break;
            }
        }
        return $ogType;
    }
}
