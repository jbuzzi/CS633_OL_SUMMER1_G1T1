<?php

class UserController extends Controller{
    function render(){
        $this->f3->set('content','login.htm');
    }

    function beforeroute(){
    }

    function authenticate() {

        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');

        $user = new User($this->db);
        $user->getByEmail($email);

        if($user->dry()) {
            $this->f3->reroute('/login');
        }

        if(password_verify($password, $user->password)) {
            $this->f3->set('SESSION.user', $user->id);
            $this->f3->reroute('/');
        } else {
            $this->f3->reroute('/login');
        }
    }

    function displayRegistration() {
        $this->f3->set('content','register.htm');
    }

    function registerUser() {
        $user = new User($this->db);
        $new_user = $user->add();
        var_dump($new_user);
    }
}