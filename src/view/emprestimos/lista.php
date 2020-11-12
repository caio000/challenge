<?php

use app\lib\web\Session;

?>
<h1 class="page-header">Emprestimos</h1>

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
                    <th>
                        Usuário
                    </th>
                    <th>
                        Livro
                    </th>
                    <th>
                        Emprestado em
                    </th>
                    <th class="col-2">
                        <a class="btn btn-primary" href="/emprestimo/novo">Novo Emprestimo</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprestimos as $emprestimo) : ?>
                    <tr>
                        <td><?= ucwords($emprestimo->getUsuario()->nome) ?></td>
                        <td><?= ucwords($emprestimo->getLivro()->nome) ?></td>
                        <td><?= (new DateTime($emprestimo->criado_em))->format('d/m/Y H:i:s') ?></td>
                        <td><a href="<?= "/emprestimo/devolver/{$emprestimo->id}" ?>">Devolver</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>