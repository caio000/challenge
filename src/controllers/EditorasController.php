<?php

namespace app\controllers;

use app\lib\exception\ValidateException;
use app\lib\Request;
use app\lib\web\Controller;
use app\lib\web\Session;
use app\models\Editoras;
use Exception;

class EditorasController extends Controller
{
    /**
     * tela que lista todos as editoras cadastradas
     */
    public function actionLista()
    {
        $editoras = Editoras::findAll();
        $this->render('editora/lista', compact(
            'editoras'
        ));
    }

    /**
     * tela com o formulário de cadastro da editora
     */
    public function actionCadastrar()
    {
        $this->render('editora/formulario',[
            'titulo' => 'Cadastrar Editora'
        ]);
    }

    /**
     * tela com o formulário de edição da editora
     */
    public function actionEditar()
    {
        $dados = Request::get();
        
        $editora = Editoras::findOne($dados['id']);

        $this->render('editora/formulario', [
            'titulo' => 'Editar',
            'editora' => $editora
        ]);
    }

    /**
     * Salva as informações da editora
     */
    public function actionSalvar()
    {
        try{
            $route = '/editoras';
            $dadosFormulario = Request::post();
            $editora = new Editoras;
            $editora->load($dadosFormulario);
    
            // validação do formulário
            if (empty($editora->nome)) {
                throw new ValidateException("Informe o nome da editora", 400);
            }

            // verifica se a editora informada já existe
            if ($editora->alreadyExistsBy('nome')) {
                throw new ValidateException('A editora informada já existe', 400);
            }

            $editora->save();

            Session::setFlash('success', 'Os dados foram salvos com sucesso!');
        } catch (ValidateException $e) {
            Session::setFlash('error', $e->getMessage());
            
            $route = (isset($editora->id) && !empty($editora->id)) ? "/editora/editar/{$editora->id}" : '/editora/cadastrar';
        } catch (Exception $e) {
            Session::setFlash('error', 'Ocorreu um erro inesperado, tente novamente mais tarde!');
        } finally {
            $this->redirectTo($route);
        }
    }
}