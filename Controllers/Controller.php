<?php
class Controller
{
    function changeDir($param)
    {
        switch ($param)
        {
            case '/':
                    $url='Views/index.php';
                    break;

            default: $url ='Views/404.php';
            break;

        }

        return header('Location:'.$url);

    }
}