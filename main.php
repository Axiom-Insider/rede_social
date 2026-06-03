<?php


 declare(strict_types=1);
 
require_once "src/autoload.php";

$pdo = Database::getConnection();

Migrations::load($pdo);


$usuario = new Usuario(null, "francisco martins", "teste@gmail.com", "123");
$usuarioRepository = new UsuarioRepository($pdo);


$usuarioRepository->findByEmail("teste@gmail.com");


echo "Banco pronto";


