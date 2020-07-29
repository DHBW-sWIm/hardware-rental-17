<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class labRentalDetailForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** NAME *************/
        $mform->addElement('static', 'name', 'Borrower:');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', 'DEFAULT VALUE');

        /* ****************** STATUS *************/
        $mform->addElement('static', 'resource', 'Resource:');
        $mform->setType('resource', PARAM_NOTAGS);
        $mform->setDefault('resource', 'DEFAULT VALUE');

        /* ****************** TYPE *************/
        $mform->addElement('static', 'date', 'Due Date:');
        $mform->setType('date', PARAM_NOTAGS);
        $mform->setDefault('date', '11.11.2011');

        /* ****************** TYPE *************/
        $mform->addElement('static', 'status', 'Status:');
        $mform->setType('status', PARAM_NOTAGS);
        $mform->setDefault('status', 'DEFAULT VALUE');

        /* ****************** QUANTITY *************/
        $mform->addElement('static', 'reason', 'Reason:');
        $mform->setType('reason', PARAM_INT);
        $mform->setDefault('reason', 'LEFT EMPTY');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'taskid');
        $mform->setType('taskid', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Return without damage');
        $mform->addElement('cancel', 'cancelBtn', 'Return with damage');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

