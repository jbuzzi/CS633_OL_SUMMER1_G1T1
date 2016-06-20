<?php

class User extends DB\SQL\Mapper{

    public function __construct(DB\SQL $db) {
        parent::__construct($db,'user');
    }

    public function all() {
        $this->load();
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
        return $this->query;
    }

    public function getByEmail($email) {
        $this->load(array('email=?', $email));
        return $this->query;
    }

    public function add() {
        $post = Base::instance()->get('POST');
        $this->copyFrom('POST');
        // hash password
        $this->set('password', password_hash($post['password'], PASSWORD_DEFAULT));
        return $this->save();
    }

    public function edit($id) {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    public function delete($id) {
        $this->load(array('id=?',$id));
        $this->erase();
    }
}