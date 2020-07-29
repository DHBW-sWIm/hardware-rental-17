<?php
// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class labReturnResource_form extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;   

        /**************** ID ***************/
        $mform->addElement('static', 'serial', 'ID:', '563984');
        $mform->setType('serial', PARAM_INT);

        /************** Name ***************/
        $mform->addElement('static', 'name', 'Name:', 'iPhone X');
        $mform->setType('name', PARAM_NOTAGS);
       
        /************* Schaden **************/
        $mform->addElement('text', 'defect', 'Schaden:', 'Leichte Kratzer - Rückseite');
        $mform->setType('defect', PARAM_NOTAGS);

        /************* Status **************/
        $mform->addElement('select', 'available', 'Ressource wieder zur Ausleihe verfügbar:', array('Ja', 'Nein'));

        /********** versteckt: ID ***********/
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        /****** versteckt: ResourceID *******/
        $mform->addElement('hidden', 'resourceid');
        $mform->setType('resourceid', PARAM_INT);

        /******** Button: Speichern ********/
        $mform->addElement('submit', 'btnSubmit', 'Leihschein ausdrucken');
        $mform->addElement('cancel', 'cancelBtn', 'Leihschein hochladen');
    }

    function validation($data, $files) {
        return array();
    }
}
