<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menu Lateral -->
    <div class="sidebar">
        <a href="/Teste/Teste/Teste/pedido/pedido.php">Venda</a>
        <a href="/Teste/Teste/Teste/estoque/estoque.php">Estoque</a>
    </div>

    <div class="content">
        <?php
        // Apenas execute o código PHP se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Configurações de conexão com o banco de dados
            $hostname = "localhost";
            $bancodedados = "textilgo";
            $usuario = "root";
            $senha = "";

            // Criar uma nova instância da classe mysqli
            $conn = new mysqli($hostname, $usuario, $senha, $bancodedados);

            // Verifique se a conexão foi bem-sucedida
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Obtenha os dados do formulário
            $nome_tecido = $_POST['nome_tecido'];
            $descricao_tecido = $_POST['descricao_tecido'];
            $comprimento_tecido = $_POST['comprimento_tecido'];
            $cor_tecido = $_POST['cor_tecido'];
            $preco_tecido = $_POST['preco_tecido']; // Novo campo

            // Prepare a consulta SQL para inserir o tecido
            $sql_tecido = "INSERT INTO tecidos (nome_tecido, descricao_tecido, comprimento_tecido, cor_tecido, preco_tecido) VALUES (?, ?, ?, ?, ?)";
            $stmt_tecido = $conn->prepare($sql_tecido);

            // Verifique se a preparação da consulta foi bem-sucedida
            if (!$stmt_tecido) {
                die("Erro na preparação da consulta: " . $conn->error);
            }

            // Vincule os parâmetros à consulta SQL
            $stmt_tecido->bind_param('ssssd', $nome_tecido, $descricao_tecido, $comprimento_tecido, $cor_tecido, $preco_tecido);

            // Execute a consulta
            if ($stmt_tecido->execute()) {
                // Obter o ID do tecido recém-inserido
                $tecido_id = $conn->insert_id;

                // Preparar e executar a consulta para inserir o estoque
                $sql_estoque = "INSERT INTO estoque (quantidade_estoque, tecido_id) VALUES (0, ?)";
                $stmt_estoque = $conn->prepare($sql_estoque);

                if (!$stmt_estoque) {
                    die("Erro na preparação da consulta de estoque: " . $conn->error);
                }

                // Vincule os parâmetros à consulta SQL de estoque
                $stmt_estoque->bind_param('i', $tecido_id);

                // Execute a consulta
                if ($stmt_estoque->execute()) {
                    echo "Cadastro realizado com sucesso! O estoque foi atualizado.";
                } else {
                    echo "Erro ao adicionar registro na tabela estoque: " . $stmt_estoque->error;
                }

                // Fechar a declaração de estoque
                $stmt_estoque->close();

            } else {
                echo "Erro ao executar a consulta: " . $stmt_tecido->error;
            }

            // Fechar a declaração de tecido e a conexão
            $stmt_tecido->close();
            $conn->close();
        }
        ?>

        <!-- Formulário de Cadastro -->
        <form method="POST" action="">
            <label for="nome_tecido">Nome do Tecido:</label>
            <input type="text" name="nome_tecido" id="nome_tecido" required><br>
            
            <label for="descricao_tecido">Descrição:</label>
            <input type="text" name="descricao_tecido" id="descricao_tecido" required><br>
            
            <label for="comprimento_tecido">Comprimento do Produto:</label>
            <input type="number" name="comprimento_tecido" id="comprimento_tecido" required><br>
            
            <label for="cor_tecido">Cor do Tecido:</label>
            <input type="text" name="cor_tecido" id="cor_tecido" required><br>
            
            <label for="preco_tecido">Preço do Tecido:</label>
            <input type="number" step="0.01" name="preco_tecido" id="preco_tecido" required><br>
            
            <input type="submit" value="Cadastrar" name="cadastrar" id="cadastrar">
        </form>
    </div>
</body>
</html>
