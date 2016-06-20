<?php

class Attendee extends DB\SQL\Mapper{

    public function __construct(DB\SQL $db, $table = 'session_attendees') {
        parent::__construct($db,$table);
    }
    
    public function all() {
        $this->load();
        return $this->query;
    }

    public function getBySession($id) {
        $this->load(array('study_session_id=?',$id));
        return $this->query;
    }

    public function getByCreator($id) {
        $this->load(array('study_session_creator=?',$id));
        return $this->query;
    }

    public function getByAttendee($id) {
        $this->load(array('attendee_id=?',$id));
        return $this->query;
    }

    public function add($user, $study_session) {
        $this->set('user', $user);
        $this->set('study_session', $study_session);
        $this->save();
    }
    
    public function edit($id) {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }
    
    public function delete($user, $session) {
        $this->load(array('user=? and study_session=?',$user,$session));
        $this->erase();
    }
}