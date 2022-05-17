<?php

namespace App\Service;

use App\Models\Product;
use PhpQuery\PhpQuery as phpQuery;
use App\Models\ProductUrl;
use Goutte\Client;

class ParserService
{

    public function parser() {
//        $this->parseUrls();
//         $this->parseProducts();
        $products = \App\Models\Product::with('product_url')->get();
        //dd($products);
    }

    private function parseUrls() {
        $main_url = "https://zakaz.atbmarket.com";
        $product_links = array();

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $categories = ['https://zakaz.atbmarket.com/catalog/1016/287',
            'https://zakaz.atbmarket.com/catalog/1016/325',
            'https://zakaz.atbmarket.com/catalog/1016/285',
            'https://zakaz.atbmarket.com/catalog/1016/343',
            'https://zakaz.atbmarket.com/catalog/1016/315'
        ];

        foreach($categories as $category) {
            $file = file_get_contents($category, false, stream_context_create($arrContextOptions));
            $doc = phpQuery::newDocument($file);
            $links = $doc->find('.catalog-page__list .catalog-item .catalog-item__photo-link');

            foreach ($links as $link) {
                array_push($product_links, $link->getAttribute('href'));
                $this->addUrl($main_url . $link->getAttribute('href'));
            }

            while($doc->find('.product-pagination__list .next .product-pagination__link')->attr('href')) {
                $next_href = $doc->find('.product-pagination__list .next .product-pagination__link')->attr('href');

                if ($next_href) {
                    $file = file_get_contents($main_url . $next_href, false, stream_context_create($arrContextOptions));
                    $doc = phpQuery::newDocument($file);
                    $links = $doc->find('.catalog-page__list .catalog-item .catalog-item__photo-link');

                    foreach ($links as $link) {
                        array_push($product_links, $link->getAttribute('href'));
                        $this->addUrl($main_url . $link->getAttribute('href'));
                    }
                }
            }
        }

        dd($product_links);
    }

    private function parseProducts() {
        $product_link = 'https://zakaz.atbmarket.com/product/1016/2144';


        $products = ProductUrl::all();
        $pr_title = array();



        $i = 0;

        foreach($products as $product) {

            $newproduct = new Product;
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: en\r\n" .
                        "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                        "User-Agent: ".$this->getRandomUserAgent()."\r\n"
                )
            );


            $file = file_get_contents($product->link, false, stream_context_create($arrContextOptions));
            $doc = phpQuery::newDocument($file);

            foreach ($doc->find('.product-page') as $key => $value) {
                $pq = phpQuery::pq($value);
                $product_title = $pq->find('.page-title')->filter(':first')->text();
                $product_image = $pq->find('.product-main .product-slider picture img')->attr('src');
                array_push($pr_title,$product_title);
                $product_price_coins = $pq->find('.product-page__item .product-price .product-price__top span sup')->filter(':first')->text();
                $pq->find('.product-page__item .product-price .product-price__top span sup')->remove();
                $product_price_bills = $pq->find('.product-page__item .product-price .product-price__top span')->filter(':first')->text();
                $product_measuring = str_replace('/', '', trim(trim($pq->find('.product-page__item .product-price .product-price__top .product-price__unit')->filter(':first')->text(), "\n"), " "));
                $product_measuring = str_replace(html_entity_decode("&nbsp;"), "", $product_measuring);

                if(Product::where('product_url_id', $product->id)->count() > 0) {
                    $newproduct = Product::where('product_url_id', $product->id)->first();
                    $newproduct->title = $product_title;
                    $newproduct->image = $product_image;
                    $newproduct->bills = $product_price_bills;
                    $newproduct->coins = $product_price_coins;
                    $newproduct->measuring = $product_measuring;
                    $newproduct->product_url_id = $product->id;
                    $newproduct->save();
                }
                else {
                    $newproduct->title = $product_title;
                    $newproduct->image = $product_image;
                    $newproduct->bills = $product_price_bills;
                    $newproduct->coins = $product_price_coins;
                    $newproduct->measuring = $product_measuring;
                    $newproduct->product_url_id = $product->id;
                    $newproduct->product_url()->associate($product);
                    $newproduct->save();
                }



            }
            gc_collect_cycles();
            $i++;
//            if($i == 100 ) { break; }
        }

        dd($pr_title);
    }

    private function addUrl($link) {
        if(ProductUrl::where('link', '=', $link)->first() === null) {
            ProductUrl::create([
                'link' => $link
            ]);
        }
    }

    private function getRandomUserAgent() {
        $mass = [
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36 RuxitSynthetic/1.0 v2066382000230344516 t2919217341348717815',
            'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36 Hola/1.172.373',
            'Opera/9.80 (Windows NT 5.1; Edition DriverPack) Presto/2.12 Version/12.16',
            'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3064.118 Safari/537.36',
            'Mozilla/5.0 (Linux; Android 10; Power 3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.111 Mobile Safari/537.36',
            'Mozilla/5.0 (iPad; CPU OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0 EdgiOS/45.5.0 Mobile/15E148 Safari/605.1.15',
            'Mozilla/5.0 (Linux; Android 8.0.0; ASUS_Z012DC) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36 EdgA/45.06.4.5043',
            'Mozilla/5.0 (Linux; Andr0id 9; BRAVIA 4K UR2 Build/PTT1.190515.001.S74) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36 OPR/46.0.2207.0 OMI/4.11.2.40.DIA4.114 Model/Sony-BRAVIA-4K-UR2',
            'Mozilla/5.0 (Linux; Android 6.0; Wiko Fever / QMobile Z10 / MyPhone My36 / Micromax Canvas 5 E481 / BLU Life One X 2016) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.111 Mobile Safari/537.36',
            'Mozilla/5.0 (Linux; Android 8.0.0; BLN-L22) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.111 Mobile Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/609.3.5 (KHTML, like Gecko) Version/13.1.2 Safari/609.3.5 Maxthon/5.1.134',
            'Mozilla/5.0 (X11; U; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.110 Safari/537.36'
        ];

        return $mass[array_rand($mass)];
    }
}
