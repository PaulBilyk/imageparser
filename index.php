<?php
include_once 'Controllers/Controller.php';

$varController = new Controller();

$varController->sendToDirectPage($_SERVER['REQUEST_URI'] );




