<?php


declare(strict_types=1);


class UsuarioService
{

    public function __construct(private UsuarioRepository $usuarioRepository) {}


    public function cadastrar(string $nome, string $email, string $senha): array {
        try { 

            $usuario = new Usuario(null, $nome, $email, $senha);

            if($this->usuarioRepository->findByEmail($usuario->getEmail())){
                return [
                    "sucesso" => false,
                    "mensagem" => "Esse email já está em uso"
                ];
            }

                 if (strlen($usuario->getSenha()) < 6) {
               throw new InvalidArgumentException("Senha muito curta");
            }

            $usuario->setSenha(password_hash($usuario->getSenha(), PASSWORD_DEFAULT));

            $criado = $this->usuarioRepository->criar($usuario);


            if (!$criado) {
                Logger::erro("Falha ao cadastra usuario email:". $usuario->getEmail());
                return [
                    "sucesso" => false,
                    "mensagem" => "Falha ao cadastrar ususario"
                ];
            }

            Logger::sucesso("Usuario cadastrado " . $usuario->getEmail());
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
            $usuario = $this->usuarioRepository->findById($id_usuario);
            if(!$usuario){
                return [
                    "sucesso"=>false, "mensagem"=>"Usuário não encontrado"
                    ];
            }
            return [
                "sucesso"=>true, $usuario
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

            if (!password_verify($senha, $usuario["senha"])) {
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
