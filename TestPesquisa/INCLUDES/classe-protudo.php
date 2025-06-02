<?php
 //vamos criar a classe Alunos. Essa classe conterá métodos e atributos que o PHP necessita para interagir com o banco de dados e executar as operações pedidas no exercício

 class Alunos
  {
  public $categoria;
  public $marca;
  public $sexo;

  //implementar o método que recebe os dados do formulário e insere esses dados em cada atributo do objeto
//   function receberDadosDoFormulario($conexao)
//    {
//    //AVISO: cuidado ao receber dados de um formulário e enviá-los ao banco de dados. Se o seu código não contiver os comandos apropriados, o servidor estará sujeito ao tipo de invasão conhecido como INJEÇÃO DE SQL
//    $this->categoria  = trim($conexao->escape_string($_POST["categoria"]));
//    $this->marca       = trim($conexao->escape_string($_POST["marca"]));
//    $this->sexo = trim($conexao->escape_string($_POST["sexo"]));
//    }

  //método que cadastra os dados do objeto aluno no banco de dados
//   function cadastrar($conexao, $nomeDaTabela)
//    {
//    $sql = "INSERT $nomeDaTabela VALUES(
//             '$this->categoria',
//             '$this->marca',
//             '$this->sexo')";
//    $conexao->query($sql) or die($conexao->error);
//    }

  //implementar o método que tabula os dados de todos os alunos na página web
  function pesquisarProduto($conexao, $nomeDaTabela)
   {
   $sql = "SELECT * FROM $nomeDaTabela";
   $resultado = $conexao->query($sql) or die($conexao->error);

   //criar um laço de repetição para percorrermos a matriz $resultado
   echo "<table>
           <caption> Dados dos alunos cadastrados no banco de dados </caption>
           <tr>
            <th> Categoria </th>
            <th> Marca </th>
            <th> Sexo </th>";

   while($vetorLinha = $resultado->fetch_array())   
    {
    $categoria = $vetorLinha[0];
    $marca  = $vetorLinha[1];
    $sexo  = $vetorLinha[2];

    echo "<tr>
           <td> $categoria </td>
           <td> $marca </td>
           <td> $sexo </td>
          </tr>";    
    }
   echo "</table>";
   }

  }