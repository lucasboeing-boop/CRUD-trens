<?php

session_start();

require 'conexao.php';

$resultado = $conexao->query('SELECT * FROM trens ORDER BY prefixo_trem');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trens</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="titulo">
        <h1>Frota Ferroviária</h1>
    </div>

    <?php
    if ($resultado->num_rows === 0):
    ?>
        <p class="vazio">Nenhum trem cadastrado.</p>
    <?php
    else:
    ?>
        <table>
            <thead>
                <tr>
                    <th>Prefixo</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Capacidade</th>
                    <th>Situação</th>
                    <th colspan='2'>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($linha = $resultado->fetch_assoc()) :
                ?>
                    <tr>
                        <td><?= htmlspecialchars($linha['prefixo_trem']) ?></td>
                        <td><?= htmlspecialchars($linha['modelo_trem']) ?></td>
                        <td><?= (int) $linha['ano_fabricacao'] ?></td>
                        <td><?= number_format((float) $linha['capacidade_toneladas'], 2, ',', '.') ?></td>
                        <td>
                            <span class="etiqueta etiqueta-<?= htmlspecialchars($linha['situacao_trem']) ?>">
                                <?= htmlspecialchars($linha['situacao_trem']) ?>
                            </span>
                        </td>
                        <td class="acoes">
                            <a href="formulario.php?id=<? (int) $linha['id_trem'] ?>" class="botao botao-secundario">Editar</a>

                            <form method="post" onsubmit="return confirm('Confirma a exclusão do trem?');">
                                <input type="hidden" name="excluir_id" value="<?= (int) $linha['id_trem'] ?>">
                                <button type="submit" class="botao botao-perigo">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
    <?php
    endif;
    ?>
</body>

</html>