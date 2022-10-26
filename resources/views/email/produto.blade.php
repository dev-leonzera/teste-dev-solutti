<html lang="pt-BR">
    <body>
    @if($dadosEmail['tipo'] == 'create')
    <h2>Novo produto cadastrado!!</h2>
    @else
    <h2>Produto atualizado!!</h2>
    @endif
    <h3>Dados:</h3>
    <p>Nome: {{ $dadosEmail['nome'] }}</p>
    <p>Valor: R$ {{ number_format($dadosEmail['valor'], 2, ',', '') }}</p>
    <p>Ativo: {{ $dadosEmail['ativo'] }}</p>
    </body>
</html>