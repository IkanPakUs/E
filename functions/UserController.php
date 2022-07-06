<?php

class UserController
{
    public $user, $roles;

    public function __construct() {

        if ($this->getLastPathSegment() == 'user.php') {
            $this->getUser();
        } else {
            if (isset($_GET['id'])) {
                $this->edit();
            }
    
            $this->getRoles();
        }
    }

    protected function getUser() {
        $this->user = DB::table('users')->select('users.id', 'users.name', 'users.role_id as role_name', 'users.email', 'roles.name as role_name')->leftJoin('roles', 'roles.id', '=', 'users.role_id')->orderBy('users.id', 'ASC')->get();
    }

    protected function edit() {
        $id = $_GET['id'];
        $this->user = DB::table('users')->select('id', 'name', 'email', 'role_id')->find($id);
    }

    protected function getRoles() {
        $this->roles = DB::table('roles')->get();
    }

    protected function getLastPathSegment() {
        $url = $_SERVER['REQUEST_URI'];

        $path = parse_url($url, PHP_URL_PATH);
        $pathTrimmed = trim($path, '/');
        $pathTokens = explode('/', $pathTrimmed); 

        return end($pathTokens);
    }
}

$User = new UserController;