<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste - Biblioteca</title>
    <link rel="stylesheet" href="/assets/style/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="brand">Header</div>
            <ul class="right">
                <li><a href="/">Home</a></li>
                <li><a href="/usuarios">Usuários</a></li>
                <li><a href="/livros">Livros</a></li>
                <li><a href="/editoras">Editoras</a></li>
                <li><a href="/emprestimo">Emprestimos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <p>Rodapé</p>
    </footer>
</body>
</html>