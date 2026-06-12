<?php


declare(strict_types=1);


class PostagemService{
    public function __construct(private PostagemRepository $postagemRepository)
    {}

    public function postar(Postagem $postagem):array{
        try {
            $postagem = $this->postagemRepository->criar($postagem->getId_usuario(), $postagem);
            
            if(!$postagem)return ["sucesso"=> false, "mensagem"=>"Não foi possível fazer postagem"];

            return ["sucesso"=>true, $postagem];
        } catch (PostagemException $e) {
             Logger::erro($e->getMessage());
            return [
                "sucesso"=>false, "mensagem"=>$e->getMessage()
            ];
        }
    }

    public function buscarFeedPerfil(int $id_usuario):array{
        try {
            $postagens = $this->postagemRepository->findByUser($id_usuario);

            if(!$postagens)return["sucesso"=>false, "mensagem"=>"Problema ao buscar postagens"];

            return ["sucesso" => true, $postagens];
        } catch (PostagemException $e) {
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
            foreach ($postagens as &$value) {
                list($ano, $mes ,$dia) = explode("-", $value["data"]);
                $value["data"] = "$dia/$mes/$ano";
            }
            return ["sucesso"=>true, $postagens];
        } catch (PostagemException $e) {
             Logger::erro($e->getMessage());
            return [
                "sucesso"=>false, "mensagem"=>$e->getMessage()
            ];
        }
    }

}