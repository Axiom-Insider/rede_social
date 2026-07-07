<?php


declare(strict_types=1);



class CurtidaRepository
{
    private Cache $cache;
    public function __construct(private PDO $pdo)
    {
        $this->cache = new Cache();
    }


    public function create(Curtida $curtida): bool
    {
        try {
            $this->cache->delete("postagem_all");
            $this->cache->delete("postagem_" . $curtida->getId_usuario());
            $sql = "INSERT INTO curtidas (id_usuario, id_postagem) VALUES (:id_usuario, :id_postagem)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([":id_usuario" => $curtida->getId_usuario(), ":id_postagem" => $curtida->getId_postagem()]);
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function delete(int $id_curtida): bool
    {
        try {
            $this->cache->delete("postagem_all");
            $curtida = $this->findById($id_curtida);
            if ($curtida) $this->cache->delete("postagem_" . $curtida["id_usuario"]);
            $sql = "DELETE FROM curtidas WHERE id_curtida = :id_curtida";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_curtida" => $id_curtida]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findById(int $id_curtida): array | bool
    { {
            try {
                $sql = "SELECT * FROM curtidas WHERE id_curtida = :id_curtida";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([":id_curtida" => $id_curtida]);
                $dados = $stmt->fetch();
                return $dados;
            } catch (PDOException $e) {
                Logger::erro($e->getMessage());
                return false;
            }
        }
    }

    public function findByIdUserAndIdPost(int $id_usuario, int $id_postagem): array | bool
    {
        try {
            $sql = "SELECT * FROM curtidas WHERE id_usuario = :id_usuario AND id_postagem = :id_postagem";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id_usuario" => $id_usuario, ":id_postagem" => $id_postagem]);
            $dados = $stmt->fetch();
            return $dados;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findQnt(int $id_postagem): array | bool
    {
        try {
            $sql = "SELECT COUNT(*) AS total_curtidas FROM curtidas WHERE id_postagem = :id_postagem";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([":id_postagem" => $id_postagem]);
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }
}
