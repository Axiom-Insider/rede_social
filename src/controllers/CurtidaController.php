<?php


declare(strict_types=1);
class  CurtidaController{
    public function __construct(private CurtidaService $curtidaService)
    {}


    public function adicionarCurtida(int $id_usuario):void {

        $id_postagem = (int) $_POST["id_postagem"];
        $res = $this->curtidaService->adicionarCurtida($id_usuario, $id_postagem);

        if($res["sucesso"]){
            Response::json(200, $res);
        }

         Response::json(400, $res);
    }

     public function removerCurtida(int $id_curtida):void {
        $res = $this->curtidaService->removerCurtida($id_curtida);

        if($res["sucesso"]){
            Response::json(200, $res);
        }

         Response::json(400, $res);
    }
 }