<?php

class UserController
{
    public $user, $roles;

    public function getUser() {
        $this->user = DB::table('users')->select('users.id', 'users.name', 'users.role_id as role_name', 'users.email', 'roles.name as role_name')->leftJoin('roles', 'roles.id', '=', 'users.role_id')->orderBy('users.id', 'ASC')->get();
    }

    public function edit() {
        $id = $_GET['id'];
        $this->user = DB::table('users')->select('id', 'name', 'email', 'role_id')->find($id);
    }

    public function getRoles() {
        $this->roles = DB::table('roles')->get();
    }
}