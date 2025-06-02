<?php
require_once "../includes/classe-banco-de-dados.inc.php";

$banco = new BancoDeDados("localhost", "root", "", "pesquisa_produtos", "produtos");

$conexao = $banco->criarConexao();

$banco->criarBanco($conexao);

$banco->abrirBanco($conexao);

$banco->definirCharset($conexao);

$banco->criarTabela($conexao);

// Verifica se foi enviado algum termo de busca
$busca = isset($_GET['q']) ? trim($_GET['q']) : '';

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

$banco->desconectar($conexao);
?>
