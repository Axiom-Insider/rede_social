<?php

require_once '../src/autoload.php';
Migrations::load(Database::getConnection());
require_once  "../src/routes/rotas.php";
require_once "./rotasHtml.php";
