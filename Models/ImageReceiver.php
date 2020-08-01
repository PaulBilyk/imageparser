<?php
class ImageReceiver
{

    public function getPostUrl($postNumber)
    {
        $data = json_decode(file_get_contents('https://picsum.photos/list'), true);
        return $data[$postNumber]['post_url'];
    }


    public function getHtml($postNumber)
    {

        $ch = curl_init($this->getPostUrl($postNumber));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookie.txt");

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }


    public function Parse($p1, $p2, $p3)
    {
        $num1 = strpos($p1, $p2);

        if ($num1 === false) {
            return 'Error';
        }
        $num2 = substr($p1, $num1);

        return strip_tags(substr($num2, 0, strpos($num2, $p3)));
    }

    public function getImageUrl($postNumber)
    {
        $string = $this->Parse($this->getHtml($postNumber), 'class="_2zEKz"', 'alt');
        $string = $this->Parse($string, 'srcSet="', ',') . 'end';
        $string = $this->Parse($string, 'http', 'end');
        return $string;
    }
}

