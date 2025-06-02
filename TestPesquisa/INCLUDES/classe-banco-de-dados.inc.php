<?php
 //criando a classe que vai implementar todas as operações de conexão de nossa aplicação web com o banco de dados MySQL

 class BancoDeDados
  {
  public $nomeDoBanco;
  public $nomeDaTabela;
  public $servidor;
  public $usuario;
  public $senha;

  //construtor dessa classe
  function __construct($umServidor, $umUsuario, $umaSenha, $umBanco, $umaTabela)
   {
   $this->servidor     = $umServidor;
   $this->usuario      = $umUsuario;
   $this->senha        = $umaSenha;
   $this->nomeDoBanco  = $umBanco;
   $this->nomeDaTabela = $umaTabela;   
   }

   //método que cria a ligação do código em PHP com o MySQL no servidor
  function criarConexao() 
   {
   $conexao = new mysqli($this->servidor, $this->usuario, $this->senha) or exit($conexao->error);
   return $conexao;
   }

  //criar o banco de dados físico no servidor - este método é opcional
  function criarBanco($conexao)
   {
   $sql = "CREATE DATABASE IF NOT EXISTS $this->nomeDoBanco";
   $conexao->query($sql) or exit($conexao->error);
   }

  //método para abrir o banco de dados
  function abrirBanco($conexao)
   {
   /*$sql = "USE $this->nomeDoBanco";
   $conexao->query($sql) or $conexao->error;*/
   $conexao->select_db($this->nomeDoBanco);
   }

  //método para criar a tabela no banco de dados
  function criarTabela($conexao)
   {
   $sql = "CREATE TABLE IF NOT EXISTS $this->nomeDaTabela (
            id INT AUTO_INCREMENT PRIMARY KEY,
            categoria VARCHAR(100) NOT NULL,
            marca VARCHAR(100) NOT NULL,
            sexo ENUM('masculino', 'feminino', 'unissex') NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
   $conexao->query($sql) or exit($conexao->error);
   }

  //método para padronizar a tabela de símbolos para toda a aplicação
  function definirCharset($conexao)
   {
   $conexao->set_charset("utf8");
   }

  //fechar a conexão com o banco
  function desconectar($conexao)
   {
   $conexao->close();
   }
  }