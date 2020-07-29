<?php
// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class labUploadReturnForm extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('filepicker', 'userfile', 'Leihschein', null,
            array('maxbytes' => '100', 'accepted_types' => '*'));

        /********** versteckt: ID ***********/
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        /****** versteckt: ResourceID *******/
        $mform->addElement('hidden', 'resourceid');
        $mform->setType('resourceid', PARAM_INT);

        /******** Button: Speichern ********/
        $mform->addElement('submit', 'btnSubmit', 'Leihschein abgeben');
        $mform->addElement('cancel', 'cancelBtn', 'Zurück');
    }

    function validation($data, $files) {
        return array();
    }
}
