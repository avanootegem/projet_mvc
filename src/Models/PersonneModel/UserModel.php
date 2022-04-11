<?php

namespace App\Models\PersonneModel;

class UserModel extends PersonneModel 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password) 
    {
        $sql = "SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL";
        $req = $this->pdo->prepare($sql);
        $req->execute(["username" => $username]);
        $auth = $req->fetch();

        if (password_verify($password, $auth['password']) && $auth) {
            $_SESSION['auth'] = $auth;
        } else {
            $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte";
        }
    }

    public function selectAccount($compte) 
    {
        $sql = "SELECT * FROM users WHERE (email = :compte OR username = :compte) AND confirmed_at IS NOT NULL";
        $req = $this->pdo->prepare($sql);
        $req->execute(["compte" => $compte]);
        return $req->fetch();
    }

    public function forget($id_reset, $reset_token) 
    {
        $sql = "UPDATE users SET reset_token = :reset_token, reset_at = NOW() WHERE id_user = :id_user";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "reset_token" => $reset_token,
            "id_user" => $id_reset
        ]);
    }

    public function verifReset($id_user, $reset_token)
    {
        $sql = "SELECT * FROM users WHERE id_user = :id_user AND reset_token = :reset_token";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "id_user" => $id_user,
            "reset_token" => $reset_token
        ]);
        $verif = $req->fetch();
        if ($verif) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function reset($id_user, $password)
    {
        $sql = "UPDATE users SET password = :password, reset_token = NULL, reset_at = NULL WHERE id_user = :id_user";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "password" => $password,
            "id_user" => $id_user
        ]);
    }

    public function getUser($id_user) 
    {
        $sql = "SELECT * FROM users WHERE id_user = :id_user";
        $req = $this->pdo->prepare($sql);
        $req->execute(["id_user" => $id_user]);
        return $req->fetch();
    }

    public function create_account($username, $email, $password) {
        $sql = "INSERT INTO users (`id_user`, `username`, `email`, `password`, `confirmed_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`) VALUES (NULL, :username, :email, :password, NULL, NOW(), NULL, NULL, NULL)";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "username" => $username,
            "email" => $email,
            "password" => $password
        ]);
    }

    public function change_password($password) {
        $id = $_SESSION['auth']['id_user'];

        $sql = "UPDATE users SET password = :password WHERE id_user = :id";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "password" => $password,
            "id" => $id
        ]);
    }
}