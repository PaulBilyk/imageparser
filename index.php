<?php
include_once 'Controllers/Controller.php';

$varController = new Controller();

$varController->changeDir($_SERVER['REQUEST_URI'] );




