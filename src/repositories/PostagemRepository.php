<?php


declare(strict_types=1);



class PostagemRepository{

    public function __construct(private PDO $pdo)
    {}

    public function criar(int $id_usuario, Postagem $postagem):bool{
        try {
            $sql = "INSERT INTO postagens (id_usuario, titulo, conteudo) VALUES(:id_usuario, :titulo, :conteudo)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":id_usuario"=>$id_usuario]);

            $dados = $stmt->fetch();

            return false;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }
}