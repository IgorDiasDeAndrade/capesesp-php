<?php
$formattedResponse = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';

    $url = "https://k1qrd5-tst-protheus.totvscloud.com.br:33389/api/WSDEMANDAS";

    $data = json_encode([
        "codigo" => $codigo
    ]);

    $username = 'candidato';
    $password = 'cape123';

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
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
                $formattedResponse = '<div style="color: red; border: 1px solid red; padding: 10px;">';
                $formattedResponse .= '<strong>Erro desconhecido:</strong> Resposta JSON inválida</div>';
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
    <h2 style="text-align: center;">Método DELETE</h2>
    <form method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="codigo" style="width: 30%; font-size: 14px;">Código:</label>
            <input type="text" id="codigo" name="codigo" required style="width: 65%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <button type="submit" style="width: 100%; padding: 10px; font-size: 16px; color: white; background-color: #FF0000; border: none; border-radius: 4px; cursor: pointer;">Excluir</button>
    </form>

    <div id="response" style="margin-top: 20px; font-size: 14px;">
        <?php echo $formattedResponse; ?>
    </div>
</section>
