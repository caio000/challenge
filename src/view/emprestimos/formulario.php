<?php

use app\lib\web\Session;

?>

<h1 class="page-header">Emprestar Livro</h1>

<?php if (Session::getFlash('error')) : ?>
    <div class="alert error">
        <p class="text center"><?= Session::getFlash('error', true) ?></p>
    </div>
<?php endif ?>

<div class="row">
    <div class="col-12">
        <form action="/emprestimo/salvar" method="post">

            <div class="form-group">
                <label for="id_usuario">Usuário</label>
                <select name="id_usuario" id="id_usuario" class="form-control" required>
                    <option value="">Selecione um usuário</option>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?= $usuario->id ?>"><?= ucwords($usuario->nome) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_livro">Livro</label>
                <select name="id_livro" id="id_livro" class="form-control" required>
                    <option value="">Selecione um livro</option>
                    <?php foreach ($livros as $livro) : ?>
                        <option value="<?= $livro->id ?>"><?= ucwords($livro->nome) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>