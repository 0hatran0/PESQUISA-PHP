<?php
require_once "../includes/classe-banco-de-dados.inc.php";

// require_once "../includes/classe-produto.inc.php";

$banco = new BancoDeDados("localhost", "root", "", "pesquisa_produtos", "produtos");

$conexao = $banco->criarConexao();

$banco->criarBanco($conexao);

$banco->abrirBanco($conexao);

$banco->definirCharset($conexao);

$banco->criarTabela($conexao);

// Verifica se foi enviado algum termo de busca
$busca = isset($_GET['q']) ? trim($_GET['q']) : '';

$banco->desconectar($conexao);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Busca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 700px;
            margin: auto;
        }
        .produto {
            padding: 15px;
            border: 1px solid #ddd;
            background: white;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .produto h3 {
            margin: 0 0 5px;
        }
        .sem-resultado {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔍 Resultados da busca por: <em><?php echo htmlspecialchars($busca); ?></em></h2>

    <?php
    if ($busca !== '') {
        try {
            $stmt = $pdo->prepare("SELECT * FROM produtos WHERE marca LIKE :busca OR categoria LIKE :busca OR sexo LIKE :busca");
            $stmt->execute(['busca' => '%' . $busca . '%']);
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($produtos) > 0) {
                foreach ($produtos as $produto) {
                    echo '<div class="produto">';
                    echo '<p>Categoria: ' . htmlspecialchars($produto['categoria']) . '</p>';
                    echo '<p>Marca: ' . htmlspecialchars($produto['marca']) . '</p>';
                    echo '<p>Sexo: ' . htmlspecialchars($produto['sexo']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<div class="sem-resultado">⚠️ Nenhum produto encontrado.</div>';
            }
        } catch (PDOException $e) {
            echo '<p>Erro ao buscar produtos: ' . $e->getMessage() . '</p>';
        }
    } else {
        echo '<div class="sem-resultado">Por favor, digite algo para pesquisar.</div>';
    }
    ?>
</div>

</body>
</html>