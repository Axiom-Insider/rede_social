<?php


 declare(strict_types=1);


 class Curtida{
    public function __construct(
        private ?int $id_curtida,
        private int $id_usuario,
        private int $id_postagem
    )
    {}

    

        /**
         * Get the value of id_curtida
         */ 
        public function getId_curtida()
        {
                return $this->id_curtida;
        }

        /**
         * Set the value of id_curtida
         *
         * @return  self
         */ 
        public function setId_curtida(int $id_curtida)
        {
                $this->id_curtida = $id_curtida;

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

        /**
         * Get the value of id_postagem
         */ 
        public function getId_postagem()
        {
                return $this->id_postagem;
        }

        /**
         * Set the value of id_postagem
         *
         * @return  self
         */ 
        public function setId_postagem(int $id_postagem)
        {
                $this->id_postagem = $id_postagem;

                return $this;
        }
 }