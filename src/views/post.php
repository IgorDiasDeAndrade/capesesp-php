<?php
$formattedResponse = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $descriweb = isset($_POST['descriweb']) ? $_POST['descriweb'] : '';
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
    $grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';
    $area = isset($_POST['area']) ? $_POST['area'] : '';
    $ativo = isset($_POST['ativo']) ? $_POST['ativo'] : '';
    $atendimento = isset($_POST['atendimento']) ? $_POST['atendimento'] : '';
    $prazo = isset($_POST['prazo']) ? (int)$_POST['prazo'] : 0; 
    $url = "https://k1qrd5-tst-protheus.totvscloud.com.br:33389/api/WSDEMANDAS";


    $data = json_encode([
        "descricao" => strtoupper($descricao),
        "descriweb" => strtoupper($descriweb),
        "tipo" => $tipo,
        "grupo" => $grupo,
        "area" => strtoupper($area),
        "ativo" => $ativo,
        "atendimento" => $atendimento,
        "prazo" => $prazo
    ]);

    $username = 'candidato';
    $password = 'cape123';

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $formattedResponse = '<div style="color: red;">Erro ao acessar a API: ' . curl_error($ch) . '</div>';
    } else {

        $responseData = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE) {

            if (isset($responseData['errorCode']) && isset($responseData['errorMessage'])) {
                $formattedResponse = '<div style="color: red; border: 1px solid red; padding: 10px;">';
                $formattedResponse .= '<strong>Erro:</strong> ' . htmlspecialchars($responseData['errorMessage']) . '</div>';
            } else {
                $formattedResponse = '<div style="color: green; border: 1px solid green; padding: 10px;">';
                $formattedResponse .= '<strong>Resposta:</strong> ' . htmlspecialchars($response) . '</div>';
            }
        } else {
            $formattedResponse = '<div style="color: green; border: 1px solid green; padding: 10px;">';
            $formattedResponse = '' . str_replace(['<p>', '</p>'], '',$response) . '';
            
        }
    }

    curl_close($ch);
}
?>

<section style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center;">Método POST</h2>
    <form method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="descricao" style="width: 30%; font-size: 14px;">Descrição:</label>
            <input type="text" id="descricao" name="descricao" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="descriweb" style="width: 30%; font-size: 14px;">Descrição Web:</label>
            <input type="text" id="descriweb" name="descriweb" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="tipo" style="width: 30%; font-size: 14px;">Tipo:</label>
            <input type="text" id="tipo" name="tipo" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="grupo" style="width: 30%; font-size: 14px;">Grupo:</label>
            <input type="text" id="grupo" name="grupo" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="area" style="width: 30%; font-size: 14px;">Área:</label>
            <input type="text" id="area" name="area" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="ativo" style="width: 30%; font-size: 14px;">Ativo:</label>
            <input type="text" id="ativo" name="ativo" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="atendimento" style="width: 30%; font-size: 14px;">Atendimento:</label>
            <input type="text" id="atendimento" name="atendimento" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="prazo" style="width: 30%; font-size: 14px;">Prazo:</label>
            <input type="number" id="prazo" name="prazo" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <button type="submit" style="width: 100%; padding: 10px; font-size: 16px; color: white; background-color: #00502f; border: none; border-radius: 4px; cursor: pointer;">Enviar</button>
    </form>

    <div id="response" style="margin-top: 20px; font-size: 14px;">
        <?php echo $formattedResponse; ?>
    </div>
</section>
