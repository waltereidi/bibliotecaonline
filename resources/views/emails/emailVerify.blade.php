<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.cdnfonts.com/css/new-athena-unicode" rel="stylesheet">
    <title>Redefinição de Senha</title>
    <style>
        body{
            font-family: 'New Athena Unicode', sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
          }
    
          .botao-reset {
              width: 33% ;
          }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('https://icons-for-free.com/iconfiles/png/128/bookshelf+library+icon-1320087270870761354.png') }}" >
    </div>
    <div class="container">
        <br>
        <div class="container-interno">
            <h2>Verificação de email</h2>
            <br>
            <p>Olá {{ $nome }}, seja bem vindo a biblioteca online!<br>
            utilize o link abaixo para validar sua conta de email.</p>
            <div class="botao-reset">
                <a href="{{ $url }}">Verificar email</a>
            </div>
            <br>
            <br>
            <p><small>Se você não solicitou a criação da conta , pode ignorar este email.<br>
            Apenas a pessoa com acesso a seu email pode finalizar seu cadastro.
            </small></p>
        </div>
    </div>
</body>
</html>