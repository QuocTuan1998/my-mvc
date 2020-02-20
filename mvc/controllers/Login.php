<?php

class Login extends Controller
{
    private $userModel;
    function __construct()
    {
        $this->userModel = $this->model("User");
    }
    function loginForm()
    {
        $view = $this->view("login");
    }

    function register()
    {
        $view = $this->view("register");
    }

    function submitLogin() {
        if (isset($_POST["btnLogin"])) {
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $user = $this->userModel->getUserByUsername($username);

            if($user) {
                if(password_verify($password, $user->getPasword()){
                    
                }
            }
        }
    }

    function submitRegister()
    {
        if (isset($_POST["btnSubmit"])) {
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $user = $this->userModel->getUserByUsername($username);

            $data = [];

            if ($user) {
                $data = ["status" => "fail"];
            } else {
                if ($this->userModel->insertUser($username, $password) == true) {
                    $data = ["status" => "success"];
                    $view = $this->view("login");
                } else {
                    $data = ["status" => "fail"];
                }
            }
        }

        
    }
}
