<?php


declare(strict_types=1);

class CurtidaService{

    public function __construct(private CurtidaRepository $curtidaRepository)
    {
        
    }

    public function adicionarCurtida(int $id_usuario, int $id_postagem):array{
        try {
            $curtida = new Curtida(null, $id_usuario, $id_postagem);
    
            $dados = $this->curtidaRepository->findByIdUserAndIdPost($curtida->getId_usuario(), $curtida->getId_postagem());
    
            if($dados)return ["sucesso"=> false, "mensagem"=>"Curtida já foi registrada"];
    
            $dados = $this->curtidaRepository->create($curtida);
            if(!$curtida) return ["sucesso"=>false, "mensagem"=>"Erro ao registrar curtida"];
    
            return ["sucesso"=>true, "mensagem"=>"Curtida registrada"];
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return ["sucesso"=>false, "mensagem"=>$e->getMessage()];
        }
    }

    public function removerCurtida(int $id_curtida):array{
         try {
            $curtida = $this->curtidaRepository->delete($id_curtida);
            if(!$curtida)return ["sucesso"=>false];

            return ["sucesso"=>true, "mensagem"=>"Descurtido com sucesso"];
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return ["sucesso"=>false, "mensagem"=>$e->getMessage()];
        }
    }


}