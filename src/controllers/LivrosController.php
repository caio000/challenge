<?php

namespace app\controllers;

use app\lib\exception\ValidateException;
use app\lib\Request;
use app\lib\web\Controller;
use app\lib\web\Session;
use app\models\Editoras;
use app\models\Livros;
use Exception;

class LivrosController extends Controller
{

    /**
     * tela para listar os livros cadastrado no sitema
     */
    public function actionLista()
    {
        $filtros = Request::get();

        if (isset($filtros['nome'])) {
            $filtros['nome'] = '%'. $filtros['nome'] .'%';
        }

        // remove filtros vazios
        $filtros = array_filter($filtros, function ($filtro) {
            return !empty($filtro);
        });

        $editoras = Editoras::findAll();
        $livros = Livros::findByFilter($filtros);

        $this->render('livros/lista', [
            'livros' => $livros,
            'editoras' => $editoras,
        ]);
    }

    /**
     * tela com o formulário de cadastro de livro
     */
    public function actionCadastrar()
    {
        $editoras = Editoras::findAll();

        $this->render('livros/formulario', [
            'titulo' => 'Cadastrar Livro',
            'editoras' => $editoras,
        ]);
    }

    /**
     * tela com o formulário de edição do livro
     */
    public function actionEditar()
    {
        $dadosFormulario = Request::get();
        $livro = Livros::findOne($dadosFormulario['id']);
        $editoras = Editoras::findAll();

        $this->render('livros/formulario', [
            'titulo' => 'Editar',
            'livro' => $livro,
            'editoras' => $editoras,
        ]);
    }

    /**
     * Salva as informações do livro
     */
    public function actionSalvar()
    {
        try{
            $route = '/livros';

            $dadosFormulario = Request::post();

            $livro = new Livros;
            $livro->load($dadosFormulario);

            // validação do formulário
            if (empty($livro->nome)) {
                throw new ValidateException("Informe o título do livro", 400);
            }
            if (!is_numeric($livro->id_editora) || (int) $livro->id_editora === 0) {
                throw new ValidateException("Selecione uma editora", 400);
            }

            $livro->save();

            Session::setFlash('success', 'Os dados foram salvos com sucesso!');

        } catch (ValidateException $e) {
            Session::setFlash('error', $e->getMessage());

            $route = (isset($livro->id) && !empty($livro->id)) ? "livro/editar/{$livro->id}" : "/livro/cadastrar";
        } catch (Exception $e) {
            Session::setFlash('error', 'Ocorreu um erro inesperado, tente novamente mais tarde!');
        } finally {
            $this->redirectTo($route);
        }
    }
}