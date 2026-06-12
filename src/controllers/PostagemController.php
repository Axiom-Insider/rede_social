<?php


declare(strict_types=1);


class  PostagemController{
    public function __construct(private PostagemService $postagemService)
    {}


    public function postar(int $id_usuario):void {
        $postagem = new Postagem(
            null, 
            $id_usuario, 
            $_POST["titulo"],
            $_POST["conteudo"],
            null,
            );

        $res = $this->postagemService->postar($postagem);

        if($res["sucesso"]){
            Response::json(200, $res);
        }

         Response::json(400, $res);
    }

    public function buscar():void{
        $res = $this->postagemService->buscarFeed();

        if($res["sucesso"]){
              Response::json(200, $res);
        }

        Response::json(202, $res);
    }
}