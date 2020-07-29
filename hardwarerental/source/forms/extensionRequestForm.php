<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class extensionRequestForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('date_selector', 'returnDate', 'New Return Date:');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Request');
        $mform->addElement('cancel', 'cancelBtn', 'Back');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

