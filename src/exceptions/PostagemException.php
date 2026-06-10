<?php


declare(strict_types=1);


class  PostagemException extends Exception{
    public static function tituloVazio():self
    {
        return new self("O titulo da postagem é obrigatório");
    }
    public static function conteudoVazio():self
    {
        return new self("O conteúdo da postagem é obrigatório");
    }

    public static function naoEncontrada():self{
         return new self("O conteúdo da postagem é obrigatório");
    }
}