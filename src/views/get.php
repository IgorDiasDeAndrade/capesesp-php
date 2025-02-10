<?php
$formattedResponse = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
    $info = isset($_POST['info']) ? $_POST['info'] : '';

    $url = "https://k1qrd5-tst-protheus.totvscloud.com.br:33389/api/WSDEMANDAS?TIPO=$tipo&INFO=$info";

    $username = 'candidato';
    $password = 'cape123';

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $formattedResponse = '<p>Erro ao acessar a API: ' . curl_error($ch) . '</p>';
    } else {
        $responseData = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            if (isset($responseData['errorCode']) && isset($responseData['errorMessage'])) {
                $formattedResponse = '<div style="color: red; border: 1px solid red; padding: 10px;">';
                $formattedResponse .= '<strong>Erro:</strong> ' . htmlspecialchars($responseData['errorMessage']) . '</div>';
            } elseif (!empty($responseData)) {
                foreach ($responseData as $item) {
                    $formattedResponse .= '<div style="border: 2px solid #ccc; margin-bottom: 10px; padding: 10px;">';
                    $formattedResponse .= '<h4>Código: ' . htmlspecialchars($item['codigo']) . '</h4>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Descrição:</strong> ' . htmlspecialchars($item['descricao']) . '</p>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Descrição Web:</strong> ' . htmlspecialchars($item['descricaoweb']) . '</p>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Tipo:</strong> ' . htmlspecialchars($item['tipo']['descricao']) . '</p>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Grupo:</strong> ' . htmlspecialchars($item['grupo']['descricao']) . '</p>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Área:</strong> ' . htmlspecialchars($item['area']['descricao']) . '</p>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Status:</strong> ' . htmlspecialchars($item['ativo']['descricao']) . '</p>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Atendimento:</strong> ' . htmlspecialchars($item['atendimento']['descricao']) . '</p>';
                    $formattedResponse .= '<p style="margin: 0"><strong>Prazo:</strong> ' . htmlspecialchars($item['prazo']) . ' dias</p>';
                    
                    // Adiciona o botão "Editar"
                    $formattedResponse .= '<button onclick="editarDemanda(
                        \'' . htmlspecialchars($item['codigo']) . '\',
                        \'' . htmlspecialchars($item['descricao']) . '\',
                        \'' . htmlspecialchars($item['descricaoweb']) . '\',
                        \'' . htmlspecialchars($item['tipo']['descricao']) . '\',
                        \'' . htmlspecialchars($item['grupo']['descricao']) . '\',
                        \'' . htmlspecialchars($item['area']['descricao']) . '\',
                        \'' . htmlspecialchars($item['ativo']['descricao']) . '\',
                        \'' . htmlspecialchars($item['atendimento']['descricao']) . '\',
                        \'' . htmlspecialchars($item['prazo']) . '\'
                    )" style="padding: 8px 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; margin: 10px;">
                        Editar
                    </button>';
                    $formattedResponse .= '<button onclick="ExcluirDemanda(
                        \'' . htmlspecialchars($item['codigo']) . '\',
                    )" style="padding: 8px 12px; background-color: #333; color: white; border: none; border-radius: 4px; cursor: pointer; margin: 10px;">
                        Excluir
                    </button>';
                    $formattedResponse .= '</div>';
                }
            } else {
                $formattedResponse = '<p>Nenhum dado encontrado.</p>';
            }
        } else {
            $formattedResponse = '<p>Erro ao decodificar a resposta JSON.</p>';
        }
    }

    curl_close($ch);
}
?>

<section style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center;">Método GET</h2>
    <form method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
            <label for="tipo" style="width: 30%; font-size: 14px;">Tipo:</label>
            <input type="text" id="tipo" name="tipo" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
            <label for="info" style="width: 30%; font-size: 14px;">Info:</label>
            <input type="text" id="info" name="info" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <button type="submit" style="width: 100%; padding: 10px; font-size: 16px; color: white; background-color: #00502f; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 6px;">Enviar</button>
    </form>

    <div>
        <?php echo $formattedResponse; ?>
    </div>
</section>

<script>
    function editarDemanda(codigo, descricao, descriweb, tipo, grupo, area, ativo, atendimento, prazo) {
        const dados = {
            codigo,
            descricao,
            descriweb,
            tipo,
            grupo,
            area,
            ativo,
            atendimento,
            prazo
        };
        // Salva os dados no Session Storage
        sessionStorage.setItem('demanda', JSON.stringify(dados));

        // Redireciona para a página desejada
        window.location.href = 'http://localhost:8080/capesesp-php/public/?page=PUT';
    }
    function ExcluirDemanda(codigo){
        const dados = {
            codigo
        }
        sessionStorage.setItem('demanda', JSON.stringify(dados))
        window.location.href = 'http://localhost:8080/capesesp-php/public/?page=DELETE';
    }
</script>