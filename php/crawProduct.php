<?php
    require_once "dbconnect.php";
    require_once "simple_dome_html.php";

    function xcurl($url) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'authority: www.journeys.com',
            'cache-control: max-age=0',
            'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="90", "Google Chrome";v="90"',
            'sec-ch-ua-mobile: ?0',
            'dnt: 1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'sec-fetch-site: same-origin',
            'sec-fetch-mode: navigate',
            'sec-fetch-user: ?1',
            'sec-fetch-dest: document',
            'referer: https://www.journeys.com/',
            'accept-language: en-US,en;q=0.9',
            'cookie: __cfduid=d8ca6453b70cde83bf2095477f384078c1619652041; ASP.NET_SessionId=jgh53bg1p4zider0lvzdtu1n; __rrRCSId=eF5j4cotK8lMETC0MDTRNdQ1ZClN9jC3MDIyNjRI0TUzTjXQNTGzTNI1MzdI0jVMM001MUtMtUg2TgIAgaIOAw; ku1-sid=LpwumBG0-PakalP5DbrtD; ku1-vid=41a71f08-8af9-2aaa-39b2-9639c8385b1d; forterToken=031e63341a29447c86f643a2061d388e_1619652222536_2322_UAL9_9ck; __rrRCSId=eF5j4cotK8lMETC0MDTRNdQ1ZClN9jC3MDIyNjRI0TUzTjXQNTGzTNI1MzdI0jVMM001MUtMtUg2TgIAgaIOAw'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    $html = file_get_html("https://www.journeys.com/women/mens-accessories?p=".$_GET['p']);
    foreach($html->find('.product-section-column') as $pro) {
        $a = rawurldecode(explode("ct=",$pro->find("a", 0)->href)[1]);
        $img = $pro->find("img", 0)->src;
        $name = $pro->find("span", 0)->plaintext;
        $price = $pro->find(".regular-price", 0)->plaintext;
        $html2 = file_get_html($a);
        $images = array();
        foreach($html2->find("#detailAltViewsWrap",0)->find("img") as $i) {
            $images[] = $i->src;
        }
        $r['summary'] = trim($html2->find("#panelDetails", 0)->plaintext);
        $r['detail'] = trim($html2->find("#panelFeatures", 0)->innertext . $html2->find("#panelDetails", 0)->innertext);
        $r['thumbnail'] = trim($img);
        $r['name'] = trim($name);
        $r['price'] = trim(str_replace("$", "", $price));
        $r['price'] = $r['price']?$r['price']:'99.99';
        $r['category'] = "mens-accessories";
        $r['images'] = json_encode($images);
        echo trim($name);
        echo "<br />";
        $myDB->insert("products", $r);
    }
    if($_GET['p'] == 3)die("Done");
    die("<script>window.location.href = '?p=".($_GET['p'] + 1)."';</script>");