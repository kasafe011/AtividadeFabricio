<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Compra de Tecidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menu Lateral -->
    <div class="sidebar">
        <a href="/Teste/Teste/Teste/estoque/estoque.php">Estoque</a>
        <a href="/Teste/Teste/Teste/cadastro/cadastro.php">Cadastro de Produtos</a>
    </div>

    <div class="content">
        <h1>Calculadora de Compra de Tecidos</h1>
        <form method="post">
            <label for="nome_tecido">Nome do tecido:</label>
            <select id="nome_tecido" name="nome_tecido" required>
                <option value="">Selecione um tecido</option>
                <?php
                // Configurações de conexão com o banco de dados
                $hostname = "localhost";
                $bancodedados = "textilgo";
                $usuario = "root";
                $senha = "";

                // Criar uma nova instância da classe mysqli
                $conn = new mysqli($hostname, $usuario, $senha, $bancodedados);

                // Verificar se houve algum erro na conexão
                if ($conn->connect_errno) {
                    die("Falha na conexão: (" . $conn->connect_errno . ") " . $conn->connect_error);
                }

                // Consulta SQL para obter os tecidos disponíveis
                $sql = "SELECT nome_tecido FROM tecidos";

                // Executar a consulta
                if ($result = $conn->query($sql)) {
                    if ($result->num_rows > 0) {
                        // Exibir as opções no <select>
                        while ($row = $result->fetch_assoc()) {
                            $selected = (isset($_POST['nome_tecido']) && $_POST['nome_tecido'] == $row['nome_tecido']) ? 'selected' : '';
                            echo "<option value=\"" . htmlspecialchars($row['nome_tecido']) . "\" $selected>" . htmlspecialchars($row['nome_tecido']) . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">Nenhum tecido disponível</option>";
                    }
                    $result->free();
                } else {
                    echo "<option value=\"\">Erro na consulta</option>";
                }

                // Fechar a conexão
                $conn->close();
                ?>
            </select>
            <br><br>
            <label for="metros">Quantidade de metros:</label>
            <input type="number" id="metros" name="metros" step="0.01" min="0" value="<?php echo isset($_POST['metros']) ? htmlspecialchars($_POST['metros']) : ''; ?>" required>
            <br><br>
            <input type="submit" value="Calcular">
        </form>

        <?php
        // Inicializar variáveis
        $valor_total = null;
        $nome_tecido = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Configurações de conexão com o banco de dados
            $conn = new mysqli($hostname, $usuario, $senha, $bancodedados);

            // Verificar se houve algum erro na conexão
            if ($conn->connect_errno) {
                die("Falha na conexão: (" . $conn->connect_errno . ") " . $conn->connect_error);
            }

            // Obter os dados do formulário
            $nome_tecido = $_POST['nome_tecido'];
            $metros = $_POST['metros'];

            // Consulta para obter o preço do tecido
            $sql = "SELECT preco_tecido FROM tecidos WHERE nome_tecido = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $nome_tecido);
            $stmt->execute();
            $stmt->bind_result($preco_tecido);

            if ($stmt->fetch()) {
                // Calcular o valor total
                $valor_total = $preco_tecido * $metros;
            } else {
                echo "<h2>Erro ao buscar o preço do tecido.</h2>";
            }

            $stmt->close();
            $conn->close();
        }

        if ($valor_total !== null) {
            echo "<h2>O valor total da compra de {$nome_tecido} é: R$" . number_format($valor_total, 2, ',', '.') . "</h2>";
        }
        ?>
    </div>
</body>
</html>
