<?php
/**
 * Cadastro de Novo Funcionário
 * Processa formulário e insere dados no banco
 */

require_once 'config.php';

$mensagem = '';
$tipo_mensagem = '';

// Processar formulário quando submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validar campos obrigatórios
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cargo = trim($_POST['cargo'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $uf = trim($_POST['uf'] ?? '');
    
    if (empty($nome) || empty($email) || empty($cargo)) {
        $mensagem = "Nome, Email e Cargo são obrigatórios!";
        $tipo_mensagem = 'erro';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Email inválido!";
        $tipo_mensagem = 'erro';
    } else {
        // Prepared statement para evitar SQL Injection
        $sql = "INSERT INTO funcionarios (nome, email, cargo, telefone, cidade, uf) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($con, $sql);
        
        if ($stmt) {
            // Bind dos parâmetros
            mysqli_stmt_bind_param($stmt, "ssssss", $nome, $email, $cargo, $telefone, $cidade, $uf);
            
            // Executar
            if (mysqli_stmt_execute($stmt)) {
                $mensagem = "Funcionário cadastrado com sucesso!";
                $tipo_mensagem = 'sucesso';
                
                // Limpar formulário
                $nome = '';
                $email = '';
                $cargo = '';
                $telefone = '';
                $cidade = '';
                $uf = '';
            } else {
                $mensagem = "Erro ao cadastrar: " . mysqli_stmt_error($stmt);
                $tipo_mensagem = 'erro';
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $mensagem = "Erro na preparação da query: " . mysqli_error($con);
            $tipo_mensagem = 'erro';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionário</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .formulario {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .mensagem {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>

<div class="formulario">
    <h2>Cadastro de Funcionário</h2>
    
    <?php if (!empty($mensagem)): ?>
        <div class="mensagem <?php echo $tipo_mensagem; ?>">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="cargo">Cargo:</label>
            <input type="text" id="cargo" name="cargo" value="<?php echo htmlspecialchars($cargo ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($cidade ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="uf">UF:</label>
            <select id="uf" name="uf">
                <option value="">Selecione</option>
                <option value="SP" <?php echo ($uf === 'SP') ? 'selected' : ''; ?>>SP</option>
                <option value="RJ" <?php echo ($uf === 'RJ') ? 'selected' : ''; ?>>RJ</option>
                <option value="MG" <?php echo ($uf === 'MG') ? 'selected' : ''; ?>>MG</option>
                <option value="BA" <?php echo ($uf === 'BA') ? 'selected' : ''; ?>>BA</option>
                <option value="RS" <?php echo ($uf === 'RS') ? 'selected' : ''; ?>>RS</option>
                <option value="PR" <?php echo ($uf === 'PR') ? 'selected' : ''; ?>>PR</option>
                <option value="PE" <?php echo ($uf === 'PE') ? 'selected' : ''; ?>>PE</option>
                <option value="CE" <?php echo ($uf === 'CE') ? 'selected' : ''; ?>>CE</option>
                <option value="PA" <?php echo ($uf === 'PA') ? 'selected' : ''; ?>>PA</option>
                <option value="SC" <?php echo ($uf === 'SC') ? 'selected' : ''; ?>>SC</option>
                <option value="GO" <?php echo ($uf === 'GO') ? 'selected' : ''; ?>>GO</option>
                <option value="PB" <?php echo ($uf === 'PB') ? 'selected' : ''; ?>>PB</option>
                <option value="MA" <?php echo ($uf === 'MA') ? 'selected' : ''; ?>>MA</option>
                <option value="ES" <?php echo ($uf === 'ES') ? 'selected' : ''; ?>>ES</option>
                <option value="PI" <?php echo ($uf === 'PI') ? 'selected' : ''; ?>>PI</option>
                <option value="RN" <?php echo ($uf === 'RN') ? 'selected' : ''; ?>>RN</option>
                <option value="AL" <?php echo ($uf === 'AL') ? 'selected' : ''; ?>>AL</option>
                <option value="MT" <?php echo ($uf === 'MT') ? 'selected' : ''; ?>>MT</option>
                <option value="MS" <?php echo ($uf === 'MS') ? 'selected' : ''; ?>>MS</option>
                <option value="DF" <?php echo ($uf === 'DF') ? 'selected' : ''; ?>>DF</option>
                <option value="SE" <?php echo ($uf === 'SE') ? 'selected' : ''; ?>>SE</option>
                <option value="AC" <?php echo ($uf === 'AC') ? 'selected' : ''; ?>>AC</option>
                <option value="RO" <?php echo ($uf === 'RO') ? 'selected' : ''; ?>>RO</option>
                <option value="AM" <?php echo ($uf === 'AM') ? 'selected' : ''; ?>>AM</option>
                <option value="RR" <?php echo ($uf === 'RR') ? 'selected' : ''; ?>>RR</option>
                <option value="AP" <?php echo ($uf === 'AP') ? 'selected' : ''; ?>>AP</option>
                <option value="TO" <?php echo ($uf === 'TO') ? 'selected' : ''; ?>>TO</option>
            </select>
        </div>
        
        <input type="submit" value="Cadastrar">
        
    </form>
</div>

</body>
</html>

<?php
// Fechar conexão
mysqli_close($con);
?>
