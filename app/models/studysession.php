<?php

class StudySession extends DB\SQL\Mapper{

    public function __construct(DB\SQL $db, $table = 'session_locations') {
        parent::__construct($db,$table);
    }
    
    public function all() {
        $this->load(NULL, array('order' => 'start_time ASC'));
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
        return $this->query;
    }

    public function getByCreator($id) {
        $this->load(array('creator=?',$id));
        return $this->query;
    }

    public function getByAttendee($id) {
        $attendees = new Attendee($this->db);
        return $attendees->getByUser($id);
    }

    public function getByLocation($id) {
        $this->load(array('location_id=?', $id));
        return $this->query;
    }

    public function add() {
        $f3 = Base::instance();
        $start_time = DateTime::createFromFormat('M j, Y h:i A', $f3->get('POST.start_time'));
        $f3->set('POST.start_time', $start_time->format('Y-m-d H:i:s'));
        $end_time = DateTime::createFromFormat('M j, Y h:i A', $f3->get('POST.end_time'));
        $f3->set('POST.end_time', $end_time->format('Y-m-d H:i:s'));
        $this->copyFrom('POST');
        $this->save();
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

    public function countAttendees($id) {
        $attendees = new Attendee($this->db);
        $num_attendees = $attendees->count(array('study_session_id=?', $id));
        return $num_attendees;
    }

    public function isAttendee($user, $study_session) {
        $attendees = new Attendee($this->db);
        $attendees->load(array('study_session_id=?', $id));
        return $num_attendees;
    }

    public function isFull($id) {
        $study_session = $this->getById($id);
        $num_attendees = $this->countAttendees($id);
        $max_attendees = $study_session[0]->get('max_attendees');
        if (!empty($max_attendees) && $num_attendees == $max_attendees) {
            return true;
        }
        return false;
    }
}