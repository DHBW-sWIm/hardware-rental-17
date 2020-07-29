<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class labEditApplicationForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** ID *************/
        $mform->addElement('static', 'type', 'Typ:');
        $mform->setType('type', PARAM_NOTAGS);
        $mform->setDefault('type', 'Ausleihantrag');

        /* ****************** NAME *************/
        $mform->addElement('text', 'name', 'Borrower:');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', 'Stemmi');

        /* ****************** TYPE *************/
        $mform->addElement('static', 'status', 'Status:');
        $mform->setType('status', PARAM_NOTAGS);
        $mform->setDefault('status', 'Angefragt');

        /* ****************** STATUS *************/
        $mform->addElement('text', 'resource', 'Ressource:');
        $mform->setType('resource', PARAM_NOTAGS);
        $mform->setDefault('resource', 'iPhone 8');

        /* ****************** DUE *************/
        $mform->addElement('date_selector', 'date', 'Rückgabedatum:');

        /* ****************** QUANTITY *************/
        $mform->addElement('text', 'quantity', 'Anzahl');
        $mform->setType('quantity', PARAM_INT);
        $mform->setDefault('quantity', '1');

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

