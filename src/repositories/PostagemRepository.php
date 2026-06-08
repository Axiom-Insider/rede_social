<?php


declare(strict_types=1);



class PostagemRepository{

    public function __construct(private PDO $pdo)
    {}

    public function criar(int $id_usuario, Postagem $postagem):bool | array{
        try {
            $sql = "INSERT INTO postagens (id_usuario, titulo, conteudo) VALUES(:id_usuario, :titulo, :conteudo)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":id_usuario"=>$id_usuario, ":titulo"=>$postagem->getTitulo(), ":conteudo"=>$postagem->getConteudo()]);

            return $stmt->fetch();

        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findAllByDate():bool | array{
        try {
            $sql = "SELECT p.titulo, p.conteudo, u.nome FROM postagens p INNER JOIN usuarios u ON p.id_usuario = u.id_usuario ORDER BY p.data DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

   public function delete(int $id_postagem):bool{
    try {
        $sql = "DELETE FROM postagens WHERE id_postagem = :id_postagem";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":id_postagem"=>$id_postagem]);
    } catch (PDOException $e) {
        Logger::erro($e->getMessage());
        return false;
    }
   }
}