<?php

class UserController extends Controller{
    function render(){
        $this->f3->set('content','login.htm');
    }

    function beforeroute(){
        if ($this->f3->get('ALIAS') === 'profile' && $this->f3->get('SESSION.user') === null ) {
            $this->f3->reroute('/login');
            exit;
        }
    }

    function authenticate() {
        // trim POST values
        foreach ($this->f3->get('POST') as $key => $val) {
            $this->f3->set('POST.' . $key, trim($val));
        }

        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');

        $user = new User($this->db);
        $user->getByEmail($email);

        if($user->dry()) {
            $this->f3->set('SESSION.alert', 'USER_NOT_FOUND');
            $this->f3->set('SESSION.alert_type', 'warning');
            $this->f3->set('content','login.htm');
        } else if(password_verify($password, $user->password)) {
            $this->f3->set('SESSION.user.id', $user->id);
            $this->f3->set('SESSION.user.fname', $user->fname);
            $this->f3->set('SESSION.user.lname', $user->lname);
            $this->f3->set('SESSION.user.email', $user->email);
            $this->f3->set('SESSION.user.user_type', $user->user_type);
            $this->f3->set('SESSION.loggedIn', true);
            $this->f3->reroute('@home');
        } else {
            $this->f3->set('SESSION.alert', 'INVALID_CREDENTIALS');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('content','login.htm');
        }
    }

    function isValid() {
        $audit = Audit::instance();
        // trim POST values
        foreach ($this->f3->get('POST') as $key => $val) {
            $this->f3->set('POST.' . $key, trim($val));
        }
        $values = $this->f3->get('POST');

        if (!$audit->email($values['email'])) {
            $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'INVALID_EMAIL');
            return false;
        }
        if (empty($values['fname'])) {
            $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'INVALID_FIRST_NAME');
            return false;
        }
        if (empty($values['lname'])) {
            $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'INVALID_LAST_NAME');
            return false;
        }
        if (strcmp($values['password'], $values['password_confirm']) != 0) {
            $this->f3->set('SESSION.alert', 'PASSWORD_MISMATCH');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'PASSWORD_MISMATCH');
            return false;
        }
        $user = new User($this->db);
        $user->getByEmail($values['email']);
        if (!$user->dry()) {
            $this->f3->set('SESSION.alert', 'ACCOUNT_EXISTS');
            $this->f3->set('SESSION.alert_type', 'info');
            return false;
        }
        return true;
    }

    function logout() {
        $this->f3->clear('SESSION');
        $this->f3->reroute('@login');
    }

    function displayRegistration() {
        $this->f3->set('content','register.htm');
    }

    function displayProfile() {
        $this->f3->set('content','profile.htm');
    }

    function registerUser() {
        if ($this->isValid()) {
            $user = new User($this->db);
            $new_user = $user->add();
            $this->f3->clear('SESSION.error');
            $this->f3->set('SESSION.alert', 'REGISTERED');
            $this->f3->set('SESSION.alert', 'success');
            $this->f3->reroute('@login');
        } else {
            $this->f3->set('content','register.htm');
        }
    }
}