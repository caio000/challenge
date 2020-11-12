<?php

namespace app\controllers;

use app\lib\exception\ValidateException;
use app\lib\Request;
use app\lib\web\Controller;
use app\lib\web\Session;
use app\models\Emprestimos;
use app\models\Livros;
use app\models\Usuarios;
use Exception;

class EmprestimosController extends Controller
{
    /**
     * tela para listar os emprestimos ativos
     */
    public function actionLista()
    {
        $emprestimos = Emprestimos::getLivrosEmprestados();

        $this->render('emprestimos/lista', [
            'emprestimos' => $emprestimos,
        ]);

    }

    /**
     * tela com o formulário de emprestimo de livro
     */
    public function actionCadastro()
    {
        $usuarios = Usuarios::findAll();
        $livros = Livros::findAll();
        $this->render('emprestimos/formulario', [
            'usuarios' => $usuarios,
            'livros' => $livros,
        ]);
    }

    /**
     * salva as informações do emprestimo
     */
    public function actionSalvar()
    {
        try {
            $route = '/emprestimo';
            $dados = Request::post();

            $emprestimo = new Emprestimos;
            $emprestimo->load($dados);

            // validação do formulário
            if (!is_numeric($emprestimo->id_usuario) || empty($emprestimo->id_usuario)){
                throw new ValidateException('Selecione um usuário', 400);
            }
            if (!is_numeric($emprestimo->id_livro) || empty($emprestimo->id_livro)){
                throw new ValidateException('Selecione um livro', 400);
            }
            if (!$emprestimo->checkDisponibilidade()) {
                throw new ValidateException('O livro não está disponível', 400);
            }

            $emprestimo->save();

            Session::setFlash('success', 'Livro emprestado com sucesso!');
        } catch (ValidateException $e) {
            Session::setFlash('error', $e->getMessage());

            $route = (isset($emprestimo->id) && !empty($emprestimo->id)) ? '' : '/emprestimo/novo';
        } catch (Exception $e) {
            Session::setFlash('error', 'Ocorreu um erro inesperado, tente novamente mais tarde!');
        } finally {
            $this->redirectTo($route);
        }
    }

    /**
     * executa as ações de devolução do livro
     */
    public function actionDevolver()
    {
        try {
            $route = '/emprestimo';
            $dados = Request::get();

            $emprestimo = Emprestimos::findOne($dados['id']);

            // validação
            if (!$emprestimo) {
                throw new ValidateException('Emprestimo de livro não encontrado', 400);
            }

            $emprestimo->situacao = Emprestimos::SITUACAO_DEVOLVIDO;

            $emprestimo->save();

            Session::setFlash('success', 'Livro devolvido');
        } catch (ValidateException $e) {
            Session::setFlash('error', $e->getMessage());
        } catch (Exception $e) {
            Session::setFlash('error', 'Ocorreu um erro inesperado, tente novamente mais tarde!');
        } finally {
            $this->redirectTo($route);
        }
    }
}