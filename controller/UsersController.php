<?php
require_once __DIR__ . "/../model/UsersModel.php";

class UsersController
{
    private $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function createUser($username, $password, $role)
    {
        return $this->usersModel->createUser($username, $password, $role);
    }

    public function updateUser($id, $username, $password, $role)
    {
        return $this->usersModel->updateUser($id, $username, $password, $role);
    }

    public function getUserAll()
    {
        return $this->usersModel->getUserAll();
    }

    public function getUserById($id)
    {
        return $this->usersModel->getUserById($id);
    }
}
?>