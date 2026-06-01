<?php


 declare(strict_types=1);



 class Logger{
    public static function sucesso(string $mensagem):void{
        self::salvar("[SUCESSO]: $mensagem");
    }

    public static function erro(string $mensagem):void{
        self::salvar("[ERRO]: $mensagem");
    }

    public static function info(string $mensagem):void{
        self::salvar("[info]: $mensagem");
    }

    private static function salvar(string $mensagem):void{
        $data = "[". date("d-m-Y H:i:s") . "] ";
        $linha = "$data - $mensagem \n" ;

        file_put_contents(__DIR__ . "/../../logs/app.log", $linha, FILE_APPEND);
    }
 }