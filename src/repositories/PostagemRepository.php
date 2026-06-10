<?php


declare(strict_types=1);



class PostagemRepository{

    private Cache $cache;

    public function __construct(private PDO $pdo)
    {
        $this->cache = new Cache();
    }

    public function criar(int $id_usuario, Postagem $postagem):bool | array{
        try {
            $sql = "INSERT INTO postagens (id_usuario, titulo, conteudo) VALUES(:id_usuario, :titulo, :conteudo)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":id_usuario"=>$id_usuario, ":titulo"=>$postagem->getTitulo(), ":conteudo"=>$postagem->getConteudo()]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

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
        $sql = "DELETE FROM postagens WHERE id_postagem = :id_postagem";
        $stmt = $this->pdo->prepare($sql);
    
        return $stmt->execute([":id_postagem"=>$id_postagem]);
    } catch (PDOException $e) {
        Logger::erro($e->getMessage());
        return false;
    }
   }
}