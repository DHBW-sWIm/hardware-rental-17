<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
 
class ablageleihschein_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
 
        $mform = $this->_form; // Don't forget the underscore! 
 
        $mform->addElement('filepicker', 'userfile', get_string('file'), null, array('maxbytes' => 10485760, 'accepted_types' => '*'));

        // error_log("TEST FROM INSIDE FORM");
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Leihschein hochladen');

        // error_log("TEST FROM AFTER SUBMIT IN FORM");

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
