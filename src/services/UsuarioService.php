<?php


declare(strict_types=1);


class UsuarioService
{

    public function __construct(private UsuarioRepository $usuarioRepository) {}


    public function cadastrar(string $nome, string $email, string $senha): array {
        try { 

            $usuario = new Usuario(null, $nome, $email, $senha);

            if($this->usuarioRepository->findByEmail($usuario->getEmail()))throw UsuarioException::emailEmUso();

            if (strlen($usuario->getSenha()) < 6)throw UsuarioException::senhaCurta();
            
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
        } catch (UsuarioException $e) {
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
            if(!$usuario)UsuarioException::usuarioNaoEncontrado();

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

             if(!$usuario)UsuarioException::usuarioNaoEncontrado();

            if (!password_verify($senha, $usuario["senha"])) UsuarioException::senhaIncorreta();

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
