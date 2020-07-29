<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class pickUpForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** ID *************/
        $mform->addElement('text', 'place', 'Abholort:');
        $mform->setType('place', PARAM_NOTAGS);

        /* ****************** DUE *************/
        $mform->addElement('date_selector', 'date', 'Abholdatum:');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Speichern');
        $mform->addElement('cancel', 'cancelBtn', 'Zurück');
    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

