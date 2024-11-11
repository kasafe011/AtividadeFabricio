<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque de Tecidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menu Lateral -->
    <div class="sidebar">
        <a href="/Teste/Teste/Teste/pedido/pedido.php">Pedido</a>
        <a href="/Teste/Teste/Teste/cadastro/cadastro.php">Cadastro de Produtos</a>
    </div>

    <div class="content">
        <h1>Estoque de Tecidos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID do Estoque</th>
                    <th>Nome do Tecido</th>
                    <th>Descrição do Tecido</th>
                    <th>Comprimento do Tecido</th>
                    <th>Cor do Tecido</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Configurações de conexão com o banco de dados
                $hostname = "localhost";
                $bancodedados = "textilgo";
                $usuario = "root";
                $senha = "";

                // Criar uma nova instância da classe mysqli
                $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

                // Verificar se houve algum erro na conexão
                if ($mysqli->connect_errno) {
                    die("Falha na conexão: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
                }

                // Consulta SQL para obter os dados detalhados do estoque e tecidos
                $sql = "SELECT e.id_estoque, t.nome_tecido, t.descricao_tecido, t.comprimento_tecido, t.cor_tecido, e.quantidade_estoque
                        FROM estoque e
                        JOIN tecidos t ON e.tecido_id = t.id_tecido";

                // Executar a consulta
                if ($result = $mysqli->query($sql)) {
                    if ($result->num_rows > 0) {
                        // Output dos dados de cada linha
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["id_estoque"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nome_tecido"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["descricao_tecido"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["comprimento_tecido"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["cor_tecido"]) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum resultado encontrado</td></tr>";
                    }
                    $result->free();
                } else {
                    echo "Erro na consulta: " . $mysqli->error;
                }

                // Fechar a conexão
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
