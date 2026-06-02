<?php


declare(strict_types=1);


class UsuarioRepository
{
    public function __construct(private PDO $pdo) {}

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

    public function findByEmail(string $email) {
        try {
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
