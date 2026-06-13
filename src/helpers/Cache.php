<?php


 declare(strict_types=1);


 class Cache{
    private string $pasta = __DIR__ . "/../../cache/";
    private int $segundos = 300;


    public function set(string $chave, mixed $valor):void{
        $arquivo = $this->pasta . md5($chave);

        file_put_contents($arquivo, json_encode(["valor" => $valor, "expira" => time() + $this->segundos]));
    }

    public function delete(string $chave):void{
         $arquivo = $this->pasta . md5($chave);

        if(file_exists($arquivo)){
           unlink($arquivo);
           return;
        }
    }

    public function get(string $chave):mixed{
        $arquivo = $this->pasta . md5($chave);

        if(!file_exists($arquivo)){
            return null;
        }

        $dados = json_decode(file_get_contents($arquivo), true);

        if($dados["expira"] < time()){
            unlink($arquivo);
            return null;
        }

        return $dados["valor"];
    }
 }