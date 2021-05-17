<?php

namespace App\Controllers;

use App\Core\MainController;
use App\Models\Admin as AdminModel;

class Admin extends MainController
{
    private function checkUser()
    {
        $user = (new AdminModel())->getById($this->session->getUserId());
        if (!$user->isAdmin()) {
            $this->redirect('/user/login');
        }
        $this->setUser($user);
    }

    public function users()
    {
        $this->checkUser();
        $pathTemplate = 'adminUsers.phtml';
        $users = $this->user->getUsers();
        return $this->view->render($pathTemplate, ['users' => $users]);
    }

    public function deleteUser()
    {
        $this->checkUser();
        $id = $_GET['id'];
        $this->user->deleteUserFromId($id);

        $this->redirect('/admin/users');
    }

    public function editUser()
    {
        $this->checkUser();
        $id = $_GET['id'];
        $userFind = $this->user->getById($id);
        return $this->view->render('adminEditUser.phtml', ['user' => $userFind]);
    }

    public function saveUser()
    {
        $this->checkUser();

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        $this->user->saveUser($id, $name, $email);
        $this->redirect('/admin/users');
    }

    public function createUser()
    {
        $this->checkUser();
        $name = $_POST['name'] ?? null;
        $password = $_POST['password'] ?? null;
        $email = $_POST['email'] ?? null;
        if ($name && $password && $email) {
            $date = date("Y-m-d H:i:s");
            $password = User::hashPassword($password);
            $this->user->createUser($name, $password, $email, $date);
            $this->redirect('/admin/users');
        }
        return $this->view->render('adminCreateUser.phtml');
    }
}
