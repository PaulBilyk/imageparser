<?php
class ImageReceiver
{
    /**
     * @param $postNumber
     * @return mixed
     */
    public function getPostUrl($postNumber)
    {
        $data = json_decode(file_get_contents('https://picsum.photos/list'), true);
        return $data[$postNumber]['post_url'];
    }

    /**
     * @param $postNumber
     * @return bool|string
     */
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

    /**
     * @param $p1
     * @param $p2
     * @param $p3
     * @return string
     */
    public function parse($p1, $p2, $p3)
    {
        $num1 = strpos($p1, $p2);

        if ($num1 === false) {
            return 'Error';
        }
        $num2 = substr($p1, $num1);

        return strip_tags(substr($num2, 0, strpos($num2, $p3)));
    }

    /**
     * @param $postNumber
     * @return string
     */
    public function getImageUrl($postNumber)
    {
        if ($this->parse($this->getHtml($postNumber), 'class="_2zEKz"', 'alt') === 'Error') {
            do {
                $postNumber = rand(0, 900);
            } while ($this->parse($this->getHtml($postNumber), 'class="_2zEKz"', 'alt') === 'Error');
        }
        $string = $this->parse($this->getHtml($postNumber), 'class="_2zEKz"', 'alt');
        $string = $this->parse($string, 'srcSet="', ',') . 'end';
        $string = $this->parse($string, 'http', 'end');

        return $string;
    }

}