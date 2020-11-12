<?php

use app\lib\web\Session;

?>
<h1 class="page-header"><?= $titulo ?></h1>

<?php if (Session::getFlash('error')) : ?>
    <div class="alert error">
        <p class="text center"><?= Session::getFlash('error', true) ?></p>
    </div>
<?php endif ?>


<div class="row">
    <div class="col-11">
        <form action="/editora/salvar" method="post">
            <input type="hidden" name="id" value="<?= $editora->id ?? '' ?>">
            
            <div class="form-group">
                <label for="nome">Editora</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da Editora" value="<?= $editora->nome ?? '' ?>" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Salvar</button>
        </form>
    </div>
</div>