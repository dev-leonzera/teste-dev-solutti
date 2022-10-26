<html lang="pt-BR">
    <body>
    <h2>Produto atualizado!!</h2>
    <h3>Dados:</h3>
    <p>Nome: {{ $mailData['nome'] }}</p>
    <p>Valor: R$ {{ number_format($mailData['valor'], 2, ',', '') }}</p>
    <p>Ativo: {{ $mailData['ativo'] }}</p>
    </body>
</html>