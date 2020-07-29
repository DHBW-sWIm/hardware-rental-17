<?php
// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class newresponsibleform_form extends moodleform {
    // Add elements to form
    public function definition() {
        global $CFG;
        global $DB;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'responsibleName', 'Name des Verantwortlichen');
        $mform->setType('responsibleName', PARAM_NOTAGS);                   // Set type of element
        $mform->setDefault('responsibleName', 'Vollständiger Name des Verantwortlichen');        // Default value

        $mform->addElement('text', 'responsibleMail', 'E-Mail des Verantwortlichen');
        $mform->setType('responsibleMail', PARAM_NOTAGS);                   // Set type of element
        $mform->setDefault('responsibleMail', 'Mail an die Erinnerungsmails gesendet werden sollen');        // Default value

        // error_log("TEST FROM INSIDE FORM");

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Verantwortlichen speichern');

        // error_log("TEST FROM AFTER SUBMIT IN FORM");

    }
    // Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
