<?php


declare(strict_types=1);



class PostagemRepository
{

    private Cache $cache;

    public function __construct(private PDO $pdo)
    {
        $this->cache = new Cache();
    }

    public function criar(Postagem $postagem): bool | array
    {
        try {

            $this->cache->delete("postagem_all");
            $this->cache->delete("postagem_" . $postagem->getId_usuario());

            $sql = "INSERT INTO postagens (id_usuario, titulo, conteudo) VALUES(:id_usuario, :titulo, :conteudo)";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":id_usuario" => $postagem->getId_usuario(), ":titulo" => $postagem->getTitulo(), ":conteudo" => $postagem->getConteudo()]);

            $id_postagem = (int) $this->pdo->lastInsertId();

            return $this->findById($id_postagem);
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findById(int $id_postagem): bool | array
    {
        try {
            $sql = "SELECT p.titulo, p.conteudo, p.data, u.nome, u.id_usuario FROM postagens p INNER JOIN usuarios u ON p.id_usuario = u.id_usuario WHERE p.id_postagem = :id_postagem";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_postagem" => $id_postagem]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findAllByDate(): bool | array
    {
        try {
            $dados = $this->cache->get("postagem_all");

            if ($dados) return $dados;

            $sql = "SELECT p.id_postagem, p.titulo, p.conteudo, p.data, u.nome, COUNT(uc.id_curtida) AS total_curtidas, c.id_curtida
            FROM postagens p 
            INNER JOIN curtidas uc
            ON p.id_postagem = uc.id_postagem
            LEFT JOIN curtidas c 
            ON p.id_postagem = c.id_postagem 
            AND c.id_usuario = :id_usuario
            INNER JOIN usuarios u 
            ON p.id_usuario = u.id_usuario 
            GROUP BY p.id_postagem, p.titulo, p.conteudo, p.data, u.nome, c.id_curtida
            ORDER BY p.data DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_usuario"=>"8"]);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($dados) $this->cache->set("postagem_all", $dados);
            
            return $dados;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findByUser(int $id_usuario): bool | array
    {
        try {
            $dados = $this->cache->get("postagem_$id_usuario");

            if ($dados) return $dados;

            $sql = "SELECT p.id_postagem, p.titulo, p.conteudo, p.data, u.nome, COUNT(c.id_curtida) AS total_curtidas, uc.id_curtida
                FROM postagens p
                INNER JOIN usuarios u
                ON p.id_usuario = u.id_usuario
                LEFT JOIN curtidas c
                ON p.id_postagem = c.id_postagem
                LEFT JOIN curtidas uc
                ON p.id_postagem = uc.id_postagem
                AND uc.id_usuario = :id_usuario
                WHERE p.id_usuario = :id_usuario
                GROUP BY p.id_postagem, p.titulo, p.conteudo, p.data, u.nome, uc.id_curtida
                ORDER BY p.data DESC;";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_usuario" => $id_usuario]);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($dados)$this->cache->set("postagem_$id_usuario", $dados);

            return $dados;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function delete(int $id_postagem): bool
    {
        try {
            $postagem = $this->findById($id_postagem);
            if (!$postagem) return false;
            $id_usuario = $postagem["id_usuario"];
            $this->cache->delete("postagem_$id_usuario");

            $sql = "DELETE FROM postagens WHERE id_postagem = :id_postagem";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_postagem" => $id_postagem]);
            return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }
}
