<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto CAPESESP</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header style="background-color: #ffffff; text-align: center; padding: 10px 0;">
        <img src="/capesesp-php/public/assets/icons/capesesp_logo.png" alt="Capesesp Logo" style="height: 60px; margin: 10px">
        <nav style="background-color: #00502f; padding: 20px 0; border-bottom: 2px solid #a4d24f; margin-bottom: 0;">
            <ul style="display: flex; justify-content: center; list-style: none; margin: 0; padding: 0;">
                <li style="margin: 0 15px; position: relative;">
                    <a href="?page=home" onclick="limparSessionStorage(event)" style="color: white; text-decoration: none; font-family: Arial, sans-serif; font-weight: bold; padding: 0 10px;">Principal</a>
                    <span style="border-left: 1px solid #a4d24f; height: 20px; position: absolute; right: -10px; top: 5px;"></span>
                </li>
                <li style="margin: 0 15px; position: relative;">
                    <a href="?page=sobre" onclick="limparSessionStorage(event)" style="color: white; text-decoration: none; font-family: Arial, sans-serif; font-weight: bold; padding: 0 10px;">Quem sou</a>
                    <span style="border-left: 1px solid #a4d24f; height: 20px; position: absolute; right: -10px; top: 5px;"></span>
                </li>
                <li style="margin: 0 15px; position: relative;">
                    <a href="?page=GET" onclick="limparSessionStorage(event)" style="color: white; text-decoration: none; font-family: Arial, sans-serif; font-weight: bold; padding: 0 10px;">GET</a>
                    <span style="border-left: 1px solid #a4d24f; height: 20px; position: absolute; right: -10px; top: 5px;"></span>
                </li>
                <li style="margin: 0 15px; position: relative;">
                    <a href="?page=POST" onclick="limparSessionStorage(event)" style="color: white; text-decoration: none; font-family: Arial, sans-serif; font-weight: bold; padding: 0 10px;">POST</a>
                    <span style="border-left: 1px solid #a4d24f; height: 20px; position: absolute; right: -10px; top: 5px;"></span>
                </li>
                <li style="margin: 0 15px; position: relative;">
                    <a href="?page=PUT" onclick="limparSessionStorage(event)" style="color: white; text-decoration: none; font-family: Arial, sans-serif; font-weight: bold; padding: 0 10px;">PUT</a>
                    <span style="border-left: 1px solid #a4d24f; height: 20px; position: absolute; right: -10px; top: 5px;"></span>
                </li>
                <li style="margin: 0 15px;">
                    <a href="?page=DELETE" onclick="limparSessionStorage(event)" style="color: white; text-decoration: none; font-family: Arial, sans-serif; font-weight: bold; padding: 0 10px;">DELETE</a>
                </li>
            </ul>
        </nav>
    </header>

    <script>

        function limparSessionStorage(event) {
            sessionStorage.clear();
        }
        
    </script>


    <main>