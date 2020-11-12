<?php

namespace app\controllers;

use app\lib\exception\ValidateException;
use app\lib\Request;
use app\lib\web\Controller;
use app\lib\web\Session;
use app\models\Usuarios;
use Exception;

class UsuariosController extends Controller
{
    /**
     * tela que lista todos os usuário cadastrados no sistema
     */
    public function actionLista ()
    {
        $listaUsuarios = Usuarios::findAll();

        $this->render('usuarios/lista', compact(
            'listaUsuarios'
        ));
    }

    /**
     * tela com o formulário de cadastro de usuário
     */
    public function actionCadastrar ()
    {
        $this->render('usuarios/formulario', [
            'titulo' => 'Cadastrar Usuário'
        ]);
    }

    /**
     * tela com o formulário de edição do usuário
     */
    public function actionEditar()
    {
        $dados = Request::get();
        $usuario = Usuarios::findOne($dados['id']);

        $this->render('usuarios/formulario', [
            'titulo' => 'Editar',
            'usuario' => $usuario,
        ]);
    }

    /**
     * Salva as informações do usuário
     */
    public function actionSalvar ()
    {
        try{
            $route = '/usuarios';
            $dadosFormulario = Request::post();

            $usuario = new Usuarios;
            $usuario->load($dadosFormulario);

            // validação do formulário
            if (empty($usuario->nome)) {
                throw new ValidateException("Informe o nome completo", 400);
            }
            if (preg_match('/[^A-z\s]/', $usuario->nome)) {
                throw new ValidateException("O nome não aceita caracteres especiais ou números", 400);
            }
            if (empty($usuario->email)) {
                throw new ValidateException("Informe o E-mail", 400);
            }
            if (!filter_var($usuario->email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidateException('Informe um E-mail válido', 400);
            }
            if ($usuario->alreadyExistsBy('email')) {
                throw new ValidateException('O E-mail informado já existe', 400);
            }

            $usuario->save();

            Session::setFlash('success', 'Os dados foram salvos com sucesso!');

        } catch (ValidateException $e) {
            Session::setFlash('error', $e->getMessage());

            $route = (isset($usuario->id) && !empty($usuario->id)) ? "/usuario/editar/{$usuario->id}" : "/usuario/cadastrar";
        } catch (Exception $e) {
            Session::setFlash('error', 'Ocorreu um erro inesperado, tente novamente mais tarde!');
        } finally {
            $this->redirectTo($route);
        }
    }
}