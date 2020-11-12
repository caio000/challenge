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
    <div class="col-12">
        <form action="/usuario/salvar" method="POST">
            <input type="hidden" name="id" value="<?= $usuario->id ?? '' ?>">

            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= $usuario->nome ?? '' ?>" required autofocus>
            </div>
        
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $usuario->email ?? '' ?>" required>
            </div>
        
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
