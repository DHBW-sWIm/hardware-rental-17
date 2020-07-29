<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class labApplicationDetailForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** ID *************/
        $mform->addElement('static', 'type', 'Type:');
        $mform->setType('type', PARAM_NOTAGS);
        $mform->setDefault('type', 'Rental Application');

        /* ****************** NAME *************/
        $mform->addElement('static', 'name', 'Borrower:');
        $mform->setType('name', PARAM_NOTAGS);

        /* ****************** MATRNR *************/
        $mform->addElement('static', 'matr', 'Marticulation Nr.:');
        $mform->setType('matr', PARAM_NOTAGS);

        /* ****************** MATRNR *************/
        $mform->addElement('static', 'email', 'Email:');
        $mform->setType('email', PARAM_NOTAGS);

        /* ****************** STATUS *************/
        $mform->addElement('static', 'resource', 'Ressource:');
        $mform->setType('resource', PARAM_NOTAGS);

        /* ****************** DATE *************/
        $mform->addElement('static', 'date', 'Return date:');
        $mform->setType('date', PARAM_NOTAGS);
        $mform->setDefault('date', '21.05.2019');

        /* ****************** QUANTITY *************/
        $mform->addElement('static', 'reason', 'Reason:');
        $mform->setType('reason', PARAM_NOTAGS);
        $mform->setDefault('reason', '-');

        $mform->addElement('static', 'comment', 'Note:');
        $mform->setType('comment', PARAM_NOTAGS);
        $mform->setDefault('comment', '-');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'taskid');
        $mform->setType('taskid', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Accept');
        $mform->addElement('cancel', 'cancelBtn', 'Reject');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

