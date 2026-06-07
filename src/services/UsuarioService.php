<?php


declare(strict_types=1);


class UsuarioService
{

    public function __construct(private UsuarioRepository $usuarioRepository) {}


    public function cadastrar(
        string $nome,
        string $email,
        string $senha
    ): array {
        try {


            $nome = trim($nome);
            $email = trim($email);

            if ($nome == "") {
                return [
                    "sucesso" => false,
                    "mensagem" => "Campo nome inválido"
                ];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    "sucesso" => false,
                    "mensagem" => "Campo email inválido"
                ];
            }

            if (strlen($senha) < 6) {
                return [
                    "sucesso" => false,
                    "mensagem" => "Campo senha muito curta"
                ];
            }


            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $usuario = new Usuario(null, $nome, $email, $senhaHash);

            $criado = $this->usuarioRepository->criar($usuario);


            if (!$criado) {
                Logger::erro("Falha ao cadastra usuario email: $email");
                return [
                    "sucesso" => false,
                    "mensagem" => "Falha ao cadastrar ususario"
                ];
            }

            Logger::sucesso("Usuario cadastrado $email");
            return [
                "sucesso" => true,
                "mensagem" => "Usuario cadastrado com sucesso"
            ];
        } catch (Throwable $e) {
            Logger::erro($e->getMessage());
            return [
                "sucesso" => false,
                "mensagem" => $e->getMessage()
            ];
        }
    }

    public function perfil(int $id_usuario):array{
        try {
            $dados = $this->usuarioRepository->findById($id_usuario);
            if(!$dados){
                return [
                    "sucesso"=>false, "mensagem"=>"Usuário não encontrado"
                    ];
            }
            return [
                "sucesso"=>true, $dados
            ];
        } catch (Throwable $e) {
             Logger::erro($e->getMessage());
            return [
                "sucesso" => false,
                "mensagem" => $e->getMessage()
            ];
        }
    }

    public function login(string $senha, string $email): array
    {
        try {

            $usuario = $this->usuarioRepository->findByEmail($email);

            if (!$usuario) {
                return [
                    "sucesso" => false,
                    "mensagem" => "Usuário não encontrado"
                ];
            }

            if (!password_verify($senha, $usuario->getSenha())) {
                return [
                    "sucesso" => false,
                    "mensagem" => "Senha incorreta"
                ];
            }

            $token = AutenticacaoUsuario::gerarToken($usuario);

            return [
                "sucesso" => true,
                "mensagem" => "Logado com sucesso",
                "token" => $token
            ];
        } catch (Throwable $e) {
            Logger::erro($e->getMessage());
            return [
                "sucesso" => false,
                "mensagem" => $e->getMessage()
            ];
        }
    }
}
