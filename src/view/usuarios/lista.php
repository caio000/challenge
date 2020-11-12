<?php

use app\lib\web\Session;

?>
<h1 class="page-header">Lista de Usuários</h1>

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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-Mail</th>
                    <th><a class="btn btn-primary btn-block" href="/usuario/cadastrar">Novo</a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaUsuarios as $usuario) : ?>
                    <tr>
                        <td><?= $usuario->nome ?></td>
                        <td><?= $usuario->email ?></td>
                        <td><a href="<?= "/usuario/editar/{$usuario->id}" ?>">Editar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>