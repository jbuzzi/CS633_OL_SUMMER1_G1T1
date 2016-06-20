<?php

class StudySessionController extends Controller{
    function render() {
        $study_sessions = new StudySession($this->db);
        $this->f3->set('StudySession', new StudySession($this->db, 'study_session'));
        $this->f3->set('study_sessions', $study_sessions->all());
        $this->f3->set('content','studysessions.htm');
    }

    function addStudySession() {
        $locations = new Location($this->db);
        $this->f3->set('locations', $locations->all());
        $this->f3->set('content','addsession.htm');
    }

    function viewStudySession() {
        $study_sessions = new StudySession($this->db);
        $this->f3->set('StudySession', new StudySession($this->db));
        $this->f3->set('study_sessions', $study_sessions->all());
        $this->f3->set('content','studysessions.htm');
    }

    function isValid() {
        $audit = Audit::instance();
        // trim POST values
        foreach ($this->f3->get('POST') as $key => $val) {
            $this->f3->set('POST.' . $key, trim($val));
        }
        $values = $this->f3->get('POST');

        // if edit, search for ID. If not there, reroute to home
        if (isset($values['id']) && !empty($values['id'])) {
            $study_session = new StudySession($this->db);
            $study_session->getById($values['id']);
            if ($study_session->dry()) {
                $this->f3->set('SESSION.alert', 'STUDY_SESSION_NOT_FOUND');
                $this->f3->set('SESSION.alert_type', 'danger');
                $this->f3->set('SESSION.error', 'INVALID_STUDY_SESSION');
                $this->f3->reroute('@home');
                exit;
            }
        }
        if (empty($values['start_time'])) {
            $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'EMPTY_START_TIME');
            return false;
        } else {
            $start_time = DateTime::createFromFormat('M j, Y h:i A', $values['start_time']);
            var_dump($start_time);
            if ($start_time === false) {
                $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
                $this->f3->set('SESSION.alert_type', 'danger');
                $this->f3->set('SESSION.error', 'INVALID_START_TIME');
                return false;
            }
        }
        if (empty($values['end_time'])) {
            $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'EMPTY_END_TIME');
            return false;
        } else {
            $end_time = DateTime::createFromFormat('M j, Y h:i A', $values['end_time']);
            var_dump($end_time);
            if ($end_time === false) {
                $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
                $this->f3->set('SESSION.alert_type', 'danger');
                $this->f3->set('SESSION.error', 'INVALID_END_TIME');
                return false;
            }
        }
        if (empty($values['location'])) {
            $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'EMPTY_LOCATION');
            return false;
        }
        if (empty($values['max_attendees']) || $values['max_attendees'] == 0) {
            $this->f3->set('POST.max_attendees', NULL);
        }
        if (empty($values['description'])) {
            $this->f3->set('SESSION.alert', 'CORRECT_ERRORS_BELOW');
            $this->f3->set('SESSION.alert_type', 'danger');
            $this->f3->set('SESSION.error', 'EMPTY_DESCRIPTION');
            return false;
        }
        return true;
    }

    function saveStudySession() {
        if ($this->isValid()) {
            $study_sessions = new StudySession($this->db, 'study_session');
            $study_sessions->add();
            $this->f3->clear('SESSION.error');
            $this->f3->set('SESSION.alert', 'STUDY_SESSION_ADDED');
            $this->f3->set('SESSION.alert_type', 'success');
            $this->f3->reroute('@home');
        } else {
            $this->addStudySession();
        }
    }
}