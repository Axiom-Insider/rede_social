<?php


declare(strict_types=1);



class PostagemRepository{

    private Cache $cache;

    public function __construct(private PDO $pdo)
    {
        $this->cache = new Cache();
    }

    public function criar(Postagem $postagem):bool | array{
        try {
            $sql = "INSERT INTO postagens (id_usuario, titulo, conteudo) VALUES(:id_usuario, :titulo, :conteudo)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":id_usuario"=>$postagem->getId_usuario(), ":titulo"=>$postagem->getTitulo(), ":conteudo"=>$postagem->getConteudo()]);

            $id_postagem = (int) $this->pdo->lastInsertId();

            return $this->findById($id_postagem);
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findById(int $id_postagem):bool | array{
        try {
            $sql = "SELECT p.titulo, p.conteudo, p.data, u.nome FROM postagens p INNER JOIN usuarios u ON p.id_usuario = u.id_usuario WHERE p.id_postagem = :id_postagem";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_postagem"=>$id_postagem]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findAllByDate():bool | array{
        try {
            $dados = $this->cache->get("postagem_all");

            if($dados)return $dados;

            $sql = "SELECT p.titulo, p.conteudo, p.data, u.nome FROM postagens p INNER JOIN usuarios u ON p.id_usuario = u.id_usuario ORDER BY p.data DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->cache->set("postagem_all", $dados);

            return $dados;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findByUser(int $id_usuario):bool | array{
        try {
            $dados = $this->cache->get("postagem_$id_usuario");
            
            if($dados)return $dados;

            $sql = "SELECT p.titulo, p.conteudo, p.data, u.nome FROM postagens p INNER JOIN usuarios u ON p.id_usuario = u.id_usuario WHERE p.id_usuario = :id_usuario ORDER BY p.data DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_usuario"=>$id_usuario]);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $this->cache->set("postagem_$id_usuario", $dados);

            return $dados;
        } catch (PDOException $e) {
             Logger::erro($e->getMessage());
            return false;
        }
    }

   public function delete(int $id_postagem):bool{
    try {
        $postagem = $this->findById($id_postagem);
        $id_usuario = $postagem["id_usuario"];
        $this->cache->delete("postagem_$id_usuario");

        $sql = "DELETE FROM postagens WHERE id_postagem = :id_postagem";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":id_postagem"=>$id_postagem]);
    } catch (PDOException $e) {
        Logger::erro($e->getMessage());
        return false;
    }
   }
}