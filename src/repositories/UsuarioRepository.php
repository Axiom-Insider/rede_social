<?php


declare(strict_types=1);


class UsuarioRepository
{
    private Cache $cache;

    public function __construct(private PDO $pdo) {
        $this->cache = new Cache();
    }

    public function criar(Usuario $usuario): bool
    {
        try {

            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES(:nome, :email, :senha)";


            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([":nome" => $usuario->getNome(), ":email" => $usuario->getEmail(), ":senha" => $usuario->getSenha()]);
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findById(int $id_usuario): array | false
    {
        try {

            $usuario = $this->cache->get("usuario_$id_usuario");

            if($usuario){
                return $usuario;
            }

            $sql = "SELECT nome, email FROM usuarios WHERE id_usuario = :id_usuario";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":id_usuario" => $id_usuario]);

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->cache->set("usuario_$id_usuario", $dados);

            return $dados;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }

    public function findByEmail(string $email): Usuario | false
    {
        try {

            $usuario = $this->cache->get("usuario_$email");

            if($usuario){
                return new Usuario($usuario["id_usuario"], $usuario["nome"], $usuario["email"], $usuario["senha"]);
            }

            $sql = "SELECT * FROM usuarios WHERE email = :email";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":email" => $email]);

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->cache->set("usuario_$email", $dados);

            return new Usuario($dados["id_usuario"], $dados["nome"], $dados["email"], $dados["senha"]);
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            return false;
        }
    }
}
