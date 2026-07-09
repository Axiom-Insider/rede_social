<?php


declare(strict_types=1);


class  PostagemController{
    public function __construct(private PostagemService $postagemService)
    {}


    public function postar(int $id_usuario):void {

        $res = $this->postagemService->postar(
            $id_usuario, 
            $_POST["titulo"], 
            $_POST["conteudo"]
            );

        if($res["sucesso"]){
            Response::json(200, $res);
        }

         Response::json(400, $res);
    }

    public function buscarFeed(int $id_usuario):void{
        $res = $this->postagemService->buscarFeed($id_usuario);

        if($res["sucesso"]){
              Response::json(200, $res);
        }

        Response::json(404, $res);
    }

    public function buscarFeedPerfil(int $id_usuario):void{
        $res = $this->postagemService->buscarFeedPerfil($id_usuario);

        if($res["sucesso"]){
            Response::json(200, $res);
        }

         Response::json(404, $res);
    }

    public function delete(int $id_postagem):void{
        $res = $this->postagemService->delete($id_postagem);

        if($res["sucesso"]){
            Response::json(200, $res);
        }
        Response::json(404, $res);
    }
}