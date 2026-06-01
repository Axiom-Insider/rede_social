<?php

declare(strict_types=1);

spl_autoload_register(function($nome){
    $caminhos = [
        __DIR__ . "$nome.php",
         __DIR__ . "/config/$nome.php",
         __DIR__ . "/models/$nome.php",
         __DIR__ . "/repositories/$nome.php",
         __DIR__ . "/controllers/$nome.php",
         __DIR__ . "/helpers/$nome.php",
         __DIR__ . "/exceptions/$nome.php",
         __DIR__ . "/services/$nome.php",
         __DIR__ . "/routes/$nome.php",
    ];

    foreach ($caminhos as $value) {
        if(file_exists($value)){
            require_once $value;
            return;
        }
    }
});