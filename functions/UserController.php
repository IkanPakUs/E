<?php

class UserController
{
    public $user, $roles, $meta;

    public function getUser() {
        $limit = 10;
        $this->user = DB::table('users')->select('users.id', 'users.name', 'users.role_id as role_name', 'users.email', 'roles.name as role_name')->leftJoin('roles', 'roles.id', '=', 'users.role_id')->orderBy('users.id', 'ASC')->limit($limit)->offset(0)->get();
        $user_count = DB::table('users')->count();

        $this->meta["total"] = ceil($user_count / $limit);
        $this->meta["page"] = 1;
    }

    public function edit() {
        $id = $_GET['id'];
        $this->user = DB::table('users')->select('id', 'name', 'email', 'role_id')->find($id);
    }

    public function getRoles() {
        $this->roles = DB::table('roles')->get();
    }
}