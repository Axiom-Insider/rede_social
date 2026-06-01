<?php


 declare(strict_types=1);
 
require_once "src/autoload.php";

$pdo = Database::getConnection();

Migrations::load($pdo);


$usuario = new Usuario(null, "francisco martins", "teste@gmail.com", "123");
$usuarioRepository = new UsuarioRepository($pdo);

$retorno = $usuarioRepository->criar($usuario);

echo $retorno == true ? 'criado com sucesso' : "erro"; 

echo "Banco pronto";


