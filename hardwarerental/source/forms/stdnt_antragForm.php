<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class stdntAntragForm extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'studentName', 'Your Name:',$attributes='size=“100”');
        $mform->setType('studentName', PARAM_NOTAGS);

        $mform->addElement('text', 'studentId', 'Borrower ID:');
        $mform->setType('studentId', PARAM_NOTAGS);

        $mform->addElement('text', 'studentEmail', 'E-Mail:');
        $mform->setType('studentEmail', PARAM_NOTAGS);

        $mform->addElement('textarea', 'grund', 'Reason:'); // Add elements to your form
        $mform->setType('grund', PARAM_NOTAGS);        //Default value


        $mform->addElement('date_selector', 'fromDate', 'From:');

        $mform->addElement('date_selector', 'returnDate', 'To:');

        $mform->addElement('text', 'anmerkung', 'Comment:');
        $mform->setType('anmerkung', PARAM_NOTAGS);


        $mform->addElement('select', 'assignee',
            'Responsible:', array('Prof. Martin', 'Prof. Koslowski'));

        // error_log("TEST FROM INSIDE FORM");

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'resourceid');
        $mform->setType('resourceid', PARAM_INT);

        $mform->addElement('hidden', 'resourceName');
        $mform->setType('resourceName', PARAM_NOTAGS);

        $mform->addElement('submit', 'btnSubmit', 'Request');
        $mform->addElement('cancel', 'cancelBtn', 'Back');

        // error_log("TEST FROM AFTER SUBMIT IN FORM");

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
