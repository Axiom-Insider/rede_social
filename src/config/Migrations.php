<?php


 declare(strict_types=1);


 class Migrations{

    public static function load(PDO $pdo):void{
        //criando a tabela de usuarios caso não exista
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS usuarios(
                id_usuario INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                senha VARCHAR(100) NOT NULL
            );
        ");
        //criando a tabela de postagens caso não exista
        $pdo->exec("
        CREATE TABLE IF NOT EXISTS postagens(
            id_postagem INT AUTO_INCREMENT PRIMARY KEY,
            id_usuario INT NOT NULL,
            titulo VARCHAR(50) NOT NULL,
            conteudo VARCHAR(300) NOT NULL,
            data DATE DEFAULT (CURRENT_DATE),

            FOREIGN KEY (id_usuario) REFERENCES  usuarios(id_usuario)
        );
        ");
        //criando a  tabela de curtida caso não exista
         $pdo->exec("
        CREATE TABLE IF NOT EXISTS curtidas(
            id_curtida INT AUTO_INCREMENT PRIMARY KEY,
            id_usuario INT NOT NULL,
            id_postagem INT NOT NULL,

            FOREIGN KEY (id_usuario) REFERENCES  usuarios(id_usuario),
            FOREIGN KEY (id_postagem) REFERENCES  postagens(id_postagem) ON DELETE CASCADE
        );
        ");
    }
 }