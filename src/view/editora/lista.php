<?php

use app\lib\web\Session;

?>
<h1 class="page-header">Editoras</h1>

<?php if (Session::getFlash('error')): ?>
    <div class="alert error">
        <p class="text center"><?= Session::getFlash('error', true) ?></p>
    </div>
<?php elseif (Session::getFlash('success')): ?>
    <div class="alert success">
        <p class="text center"><?= Session::getFlash('success', true) ?></p>
    </div>
<?php endif ?>

<div class="row">
    <div class="col-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th class="col-3"><a class="btn btn-primary btn-block" href="/editora/cadastrar">Novo</a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($editoras as $editora) : ?>
                    <tr>
                        <td><?= $editora->nome ?></td>
                        <td><a href="<?= "/editora/editar/{$editora->id}" ?>">Editar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>