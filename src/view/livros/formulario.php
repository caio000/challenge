<?php

use app\lib\web\Session;

?>

<!-- <pre><?php print_r(compact('livro', 'editoras')) ?></pre> -->

<h1 class="page-header"><?= $titulo ?></h1>

<?php if (Session::getFlash('error')) : ?>
    <div class="alert error">
        <p class="text center">
            <?= Session::getFlash('error', true) ?>
        </p>
    </div>
<?php endif ?>

<div class="row">
    <div class="col-12">
        <form action="/livro/salvar" method="POST">
            <input type="hidden" name="id" value="<?= $livro->id ?? '' ?>">

            <div class="form-group">
                <label for="nome">Título</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="ex..: Romeu e Julieta" value="<?= $livro->nome ?? '' ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="id_editora">Editora</label>
                <select name="id_editora" id="id_editora" class="form-control">
                    <option value="0">Selecione uma opção</option>
                    <?php foreach ($editoras as $editora) : ?>
                        <?php if ($editora->id == $livro->id_editora) : ?>
                            <option value="<?= $editora->id ?>" selected><?= $editora->nome ?></option>
                        <?php else : ?>
                            <option value="<?= $editora->id ?>"><?= $editora->nome ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>