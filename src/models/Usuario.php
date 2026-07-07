<?php


 declare(strict_types=1);



 class Usuario{

    public function __construct(
        private ?int $id_usuario,
        private string $nome,
        private string $email,
        private string $senha
    ) {
            $this->nome = trim($nome);
            $this->email = trim($email);

            if ($this->nome == "") {
                 throw UsuarioException::nomeInvalido();
            }

            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                 throw UsuarioException::emailInvalido();
            }

    }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail(string $email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of senha
         */ 
        public function getSenha()
        {
                return $this->senha;
        }

        /**
         * Set the value of senha
         *
         * @return  self
         */ 
        public function setSenha(string $senha)
        {
                $this->senha = $senha;

                return $this;
        }

        /**
         * Get the value of nome
         */ 
        public function getNome()
        {
                return $this->nome;
        }

        /**
         * Set the value of nome
         *
         * @return  self
         */ 
        public function setNome(string $nome)
        {
                $this->nome = $nome;

                return $this;
        }

        /**
         * Get the value of id_usuario
         */ 
        public function getId_usuario()
        {
                return $this->id_usuario;
        }

        /**
         * Set the value of id_usuario
         *
         * @return  self
         */ 
        public function setId_usuario(int $id_usuario)
        {
                $this->id_usuario = $id_usuario;

                return $this;
        }
}
 