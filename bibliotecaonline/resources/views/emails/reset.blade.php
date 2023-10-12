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
            <h2>Resetar senha</h2>
            <br>
            <p>Olá {{ $nome }}, você esqueceu sua senha e deseja reseta-la<br>
            utilize o link abaixo.</p>
            <div class="botao-reset">
                <a href="{{ $url }}">Resetar senha</a>
            </div>
            <br>
            <br>
            <p><small>Se você não solicitou o reset de senha , pode ignorar este email.<br>
            Apenas a pessoa com acesso a seu email pode resetar sua senha.
            </small></p>
        </div>
    </div>
</body>
</html>