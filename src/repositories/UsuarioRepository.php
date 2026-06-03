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
            $sql = "SELECT * FROM usuarios WHERE email = :email";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([":email"=> $email]);
            
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            print_r($dados);

            return $dados;

        } catch (\Throwable $th) {
            Logger::erro($th->getMessage());
            return false;
        }
    }
}
