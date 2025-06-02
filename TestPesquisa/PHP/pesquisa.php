<!DOCTYPE html>
<html lang="pt-BR">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title> Test Pesquisa </title>
 <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1> Test de Pesquisa </h1>

    <div class="form-box">
        <h2>🔍 Buscar Produto</h2>
        <form action="pesquisa.php" method="GET">
            <input type="text" name="q" placeholder="Digite o nome do produto..." required>
            <button type="submit">Buscar</button>
        </form>
    </div>

</body>

<?php
//vamos incluir o arquivo que define e classe da conexão com o banco de dados
require_once "../includes/classe-banco-de-dados.inc.php";

//criar o objeto banco de dados que, nesse momento, armazena a conexão com o servidor, inicializando o construtor da nossa classe
$banco = new BancoDeDados("localhost", "root", "", "pesquisa_produtos", "produtos");

//criar a conexão física com o servidor MySQL
$conexao = $banco->criarConexao();

//o próximo passo é criar o banco de dados, de fato, no servidor
$banco->criarBanco($conexao);

//agora, vamos abrir o banco de dados criado
$banco->abrirBanco($conexao);

//definindo o utf-8 como tabela de símbolos do MySQL
$banco->definirCharset($conexao);

//invocando o método para criar a tabela
$banco->criarTabela($conexao);

// Verifica se foi enviado algum termo de busca
$busca = isset($_GET['q']) ? trim($_GET['q']) : '';

// Verifica se o input está vazio
if (empty($busca)) {
    echo "<p>🔍 Nenhum termo de busca informado.</p>";
    exit;
}

// Escapa o valor para evitar injeção de SQL
$termo = $conexao->real_escape_string($busca);

// Consulta com LIKE para busca parcial
$sql = "SELECT * FROM produtos WHERE marca LIKE '%$busca%'
        OR categoria LIKE '%$busca%'
        OR sexo LIKE '%$busca%'";

$resultado = $conexao->query($sql) or die($conexao->error);

// Verifica se retornou algum registro
if ($resultado->num_rows === 0) {
    echo "<p>❌ Nenhum produto encontrado com o termo <strong>$busca</strong>.</p>";
    exit;
}

// Exibe os resultados em tabela
echo "<h2>🔎 Resultados para: <em>$busca</em></h2>";
echo "<table border='1'>
        <tr>
            <th>Marca</th>
            <th>Categoria</th>
            <th>Sexo</th>
        </tr>";

while ($registro = $resultado->fetch_array()) {
    $marca     = htmlentities($registro['marca'], ENT_QUOTES, "UTF-8");
    $categoria = htmlentities($registro['categoria'], ENT_QUOTES, "UTF-8");
    $sexo      = htmlentities($registro['sexo'], ENT_QUOTES, "UTF-8");

    echo "<tr>
            <td>$marca</td>
            <td>$categoria</td>
            <td>$sexo</td>
          </tr>";
}

echo "</table>";

//após finalizar toda a execução da nossa aplicação, "matamos" a conexão com o MySQL
$banco->desconectar($conexao);
?>
</html>