<?php


 declare(strict_types=1);


 class Postagem{
    public function __construct(
        private ?int $id_postagem,
        private int $id_usuario,
        private string $titulo,
        private string $conteudo,
        private ?DateTime $data
    )
    {}

    

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
         * Get the value of titulo
         */ 
        public function getTitulo()
        {
                return $this->titulo;
        }

        /**
         * Set the value of titulo
         *
         * @return  self
         */ 
        public function setTitulo(string $titulo)
        {
                $this->titulo = $titulo;

                return $this;
        }

        /**
         * Get the value of conteudo
         */ 
        public function getConteudo()
        {
                return $this->conteudo;
        }

        /**
         * Set the value of conteudo
         *
         * @return  self
         */ 
        public function setConteudo(string $conteudo)
        {
                $this->conteudo = $conteudo;

                return $this;
        }

        /**
         * Get the value of data
         */ 
        public function getData()
        {
                return $this->data;
        }

        /**
         * Set the value of data
         *
         * @return  self
         */ 
        public function setData(DateTime $data)
        {
                $this->data = $data;

                return $this;
        }
 }