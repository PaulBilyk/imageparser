<?php
class ImageReceiver
{
    public static array $imagePostUrlArray;

    public function __construct()
    {
        self::$imagePostUrlArray= $this->imagePostUrlToArray();
    }

    /**
     * @return array
     */
    public function imagePostUrlToArray()
    {
        $imagePostUrlArray = array();
        foreach ($data =json_decode(file_get_contents('https://picsum.photos/list'), true) as $value)
        {
              array_push($imagePostUrlArray,$value['post_url']);
        }

        return $imagePostUrlArray;
    }


    /**
     * @param $postNumber
     * @return bool|string
     */
    public function getHtml($postNumber)
    {
        $ch = curl_init(self::$imagePostUrlArray[$postNumber]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookie.txt");

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        switch ($httpCode) {
            case '404':
                        return $this->getHtml(rand(0, count(self::$imagePostUrlArray)));
                        break;
            case '503':
                        return 'Error 503';
                        break;
            default:
                        return $response;
                        break;
        }
    }

    /**
     * @param $p1
     * @param $p2
     * @param $p3
     * @return string
     */
    public function parse($p1, $p2, $p3)
    {
        $num1 = strpos($p1, $p2);
        $num2 = substr($p1, $num1);

        return strip_tags(substr($num2, 0, strpos($num2, $p3)));
    }

    /**
     * @param $postNumber
     * @return string
     */
    public function getImageUrl($postNumber)
    {
        if ($this->getHtml($postNumber)==='Error 503') {

            return "Service unavailable";
        }
        else{
            $string = $this->parse($this->getHtml($postNumber), 'class="_2zEKz"', 'alt');
            $string = $this->parse($string, 'srcSet="', ',') . 'end';
            $string = $this->parse($string, 'http', 'end');

            return $string;
        }
    }

}

