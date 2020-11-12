<?php

use app\lib\web\Session;

?>

<h1 class="page-header">Lista de livros</h1>

<?php if (Session::getFlash('error')) : ?>
    <div class="alert error">
        <p class="text center"><?= Session::getFlash('error', true) ?></p>
    </div>
<?php elseif (Session::getFlash('success')) : ?>
    <div class="alert success">
        <p class="text center"><?= Session::getFlash('success', true) ?></p>
    </div>
<?php endif ?>

<div class="row">
    <div class="col-12">
        <form action="/livros" method="get">
            <div class="form-row">
                <div class="col col-3">
                    <label for="nome">Título</label>
                    <input type="text" name="nome" id="" class="form-control">
                </div>

                <div class="col col-3">
                    <label for="editora">Editora</label>
                    <select name="editora" id="editora" class="form-control">
                        <option value="">Selecione uma editora</option>
                        <?php foreach ($editoras as $editora) : ?>
                            <option value="<?= $editora->id ?>"><?= ucwords($editora->nome) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>

            <div class="form-group">
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Editora</th>
                    <th class="col-3"><a class="btn btn-primary btn-block" href="/livro/cadastrar">Novo</a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro) : ?>
                    <tr>
                        <td><?= $livro->nome ?></td>
                        <td><?= $livro->getEditora()->nome ?></td>
                        <td><a href="<?= "/livro/editar/{$livro->id}" ?>">Editar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>