<?php


declare(strict_types=1);


class PostagemService{
    public function __construct(private PostagemRepository $postagemRepository)
    {}

    public function postar(int $id_usuario, Postagem $postagem):array{
        try {
            $postagem = $this->postagemRepository->criar($id_usuario, $postagem);

            if(!$postagem)return ["sucesso"=> false, "mensagem"=>"Não foi possível fazer postagem"];

            return ["sucesso"=>true, $postagem];
        } catch (Exception $e) {
             Logger::erro($e->getMessage());
            return [
                "sucesso"=>false, "mensagem"=>$e->getMessage()
            ];
        }
    }

    public function buscarFeedPerfil(int $id_usuario):array{
        try {
            

            return [];
        } catch (Exception $e) {
             Logger::erro($e->getMessage());
            return [
                "sucesso"=>false, "mensagem"=>$e->getMessage()
            ];
        }
    }

    public function buscarFeed():array{
        try {
            $postagens = $this->postagemRepository->findAllByDate();
            if(!$postagens)return[ "sucesso"=> false, "mensagem"=>"Problema ao buscar postagens"];

            return ["sucesso"=>true, $postagens];
        } catch (Exception $e) {
             Logger::erro($e->getMessage());
            return [
                "sucesso"=>false, "mensagem"=>$e->getMessage()
            ];
        }
    }

}