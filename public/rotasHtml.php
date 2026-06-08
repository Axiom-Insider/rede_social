<?php

declare(strict_types=1);



$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

switch ($url) {

        case "/login":
                tipo("GET");
                require_once "./login.html";
                break;

        case "/registrar":
                tipo("GET");
                require_once "./registrar.html";
                break;

        case "/home":
                tipo("GET");
                require_once "./home.html";
                break;

        case "/perfil":
                tipo("GET");
                require_once "./perfil.html";
                break;
}
