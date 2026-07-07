<?php


declare(strict_types=1);


class PostagemService{
    public function __construct(private PostagemRepository $postagemRepository)
    {}

    public function postar(int $id_usuario, string $titulo, string $conteudo):array{
        try {
            $postagem = new Postagem(null, $id_usuario, $titulo, $conteudo, null);
        
            $postagem = $this->postagemRepository->criar($postagem);
            
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
            if(!$postagens)throw PostagemException::nenhumaEncontrada();
            foreach ($postagens as &$value) {
                $data = new DateTime($value["data"]);
                $value["data"] = $data->format("d/m/Y");
            }
            return ["sucesso" => true, $postagens];
        } catch (PostagemException $e) {
             Logger::erro($e->getMessage());
            return [
                "sucesso"=>false, "mensagem"=>$e->getMessage()
            ];
        }
    }

    public function delete(int $id_postagem):array{
        try {
            $postagens = $this->postagemRepository->delete($id_postagem);

            if(!$postagens) throw PostagemException::nenhumaEncontrada();

            return ["sucesso"=>true, "mensagem"=>"Postagem apagada com sucesso"];
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
            if(!$postagens)throw PostagemException::naoEncontrada();
            foreach ($postagens as &$value) {
                $data = new DateTime($value["data"]);
                $value["data"] = $data->format("d/m/Y");
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