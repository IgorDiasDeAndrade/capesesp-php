<?php
session_start(); // Inicia ou continua a sessão

$formattedResponse = '';

// Verifica se há dados na sessão
$demanda = isset($_SESSION['demanda']) ? $_SESSION['demanda'] : null;

// Se houver dados da sessão, preenche os campos
$codigo = $demanda['codigo'] ?? '';
$descricao = $demanda['descricao'] ?? '';
$descriweb = $demanda['descricaoweb'] ?? '';
$tipo = $demanda['tipo']['descricao'] ?? '';
$grupo = $demanda['grupo']['descricao'] ?? '';
$area = $demanda['area']['descricao'] ?? '';
$ativo = $demanda['ativo']['descricao'] ?? '';
$atendimento = $demanda['atendimento']['descricao'] ?? '';
$prazo = $demanda['prazo'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados recebidos do formulário
    $codigo = isset($_POST['codigo']) ? htmlspecialchars($_POST['codigo']) : '';
    $descricao = isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : '';
    $descriweb = isset($_POST['descriweb']) ? htmlspecialchars($_POST['descriweb']) : '';
    $tipo = isset($_POST['tipo']) ? htmlspecialchars($_POST['tipo']) : '';
    $grupo = isset($_POST['grupo']) ? htmlspecialchars($_POST['grupo']) : '';
    $area = isset($_POST['area']) ? htmlspecialchars($_POST['area']) : '';
    $ativo = isset($_POST['ativo']) ? htmlspecialchars($_POST['ativo']) : '';
    $atendimento = isset($_POST['atendimento']) ? htmlspecialchars($_POST['atendimento']) : '';
    $prazo = isset($_POST['prazo']) ? (int)$_POST['prazo'] : 0;

    $url = "https://k1qrd5-tst-protheus.totvscloud.com.br:33389/api/WSDEMANDAS";

    $data = json_encode([
        "codigo" => $codigo,
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
                $formattedResponse .= '<strong>Resposta da API:</strong><pre style="margin: 0;">Demanda atualizada com sucesso</pre></div>';
            }
        } else {
            $formattedResponse = '<div style="color: green; border: 1px solid green; padding: 10px;">';
            $formattedResponse = '' . str_replace(['<p>', '</p>'], '', $response) . '';
        }
    }

    curl_close($ch);
}
?>

<section style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center;">Método PUT</h2>
    <form method="POST" id="formDemanda" style="display: flex; flex-direction: column; gap: 10px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="codigo" style="width: 30%; font-size: 14px;">Código:</label>
            <input type="text" id="codigo" name="codigo" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
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

<script>
    // Carregar dados do Session Storage e preencher os campos do formulário
    document.addEventListener('DOMContentLoaded', function () {
        const demanda = sessionStorage.getItem('demanda');
        if (demanda) {
            const dados = JSON.parse(demanda);
            document.getElementById('codigo').value = dados.codigo || '';
            document.getElementById('descricao').value = dados.descricao || '';
            document.getElementById('descriweb').value = dados.descriweb || '';
            document.getElementById('tipo').value = dados.tipo || '';
            document.getElementById('grupo').value = dados.grupo || '';
            document.getElementById('area').value = dados.area || '';
            document.getElementById('ativo').value = dados.ativo || '';
            document.getElementById('atendimento').value = dados.atendimento || '';
            document.getElementById('prazo').value = dados.prazo || '';
        }
    });
</script>
