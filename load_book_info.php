<?php 
include 'simple_html_dom.php';

function filter($data) {
    // $data = trim(htmlentities(strip_tags($data)));//fuck htmlentities,not for chinese
    $data = trim(htmlspecialchars(strip_tags($data)));

    if (get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }

    $data = mysql_real_escape_string($data);

    return $data;
}



foreach ($_GET as $key => $value) {
    $data[$key] = filter($value);
}


$books = array();
$keyword = $data['keyword'];


function get_amazon_list($keyword)
{
    $search_base_url = "http://www.amazon.cn/s/ref=nb_sb_noss_1?__mk_zh_CN=亚马逊网站&url=search-alias=stripbooks&field-keywords=";
    $url = $search_base_url . $keyword;
    $html = file_get_html($url);
    global $books;

    $i = 1;
    foreach ($html->find('li[class=s-result-item]') as $li) {

        $book = array(
            'img' => '',
            'title'=>'',
            'price'=>'',
            'origin_price'=>'',
            'pid'=>'',
            'url'=>'',
            'site'=>'1',
         );

        foreach ($li->find('img[class=s-access-image]') as $img) {
            $book['img'] = $img->src;
        }

        foreach ($li->find('a[class=s-access-detail-page]') as $link) {
            $book['title'] = $link->title;
            $book['url'] = $link->href;
            $book['pid'] = parse_zid($link->href);
        }
        foreach ($li->find('span[class=s-price]') as $price) {
            $book['price'] = $price->plaintext;
        }

        foreach ($li->find('span[class=a-text-strike]') as $origin_price) {
            $book['origin_price'] = $origin_price->plaintext;
        }

        $books[] = $book;


        $i++;
        if($i>3){
            return $books;
            break;
        }

    }

}

function parse_zid($url)
{
    preg_match("/dp\/([A-Z0-9]+)\/ref/", $url,$matches);
    return $matches[1];
}

function get_dangdang_list($keyword)
{
    $url = "http://search.dangdang.com/?key=" .  rawurlencode(mb_convert_encoding($keyword, 'gb2312', 'utf-8'));

    $html = file_get_html($url);

    global $books;

    foreach ($html->find('ul[class=bigimg]') as $ul) {
        foreach ($ul->find('li') as $key => $li) {
            $book = array(
                    'img' => '',
                    'title'=>'',
                    'price'=>'',
                    'pre_price'=>'',
                    'discount'=>'',
                    'pid'=>'',
                    'url'=>'',
                    'site'=>'2',
                 );
            $book['pid'] = $li->id;

            foreach ($li->find('a[class=pic]') as $link) {
                $book['title'] = $link->title;
                $book['url'] = $link->href;
                foreach ($li->find('img') as $img) {
                    $book['img'] = $img->getAttribute('data-original');
                }
            }

            foreach ($li->find('span[class=search_now_price]') as $price) {
                $book['price'] = $price->plaintext;
            }

            foreach ($li->find('span[class=search_pre_price]') as $pre_price) {
                $book['pre_price'] = $pre_price->plaintext;
            }

            foreach ($li->find('span[class=search_discount]') as $discount) {
                $book['discount'] = $discount->plaintext;
            }

            $books[] = $book;

            if($key > 2){
                break;
            }

        }
    }
}

function get_list($keyword)
{
    get_amazon_list($keyword);
    get_dangdang_list($keyword);
}

get_list($keyword);
echo json_encode($books);

 ?>