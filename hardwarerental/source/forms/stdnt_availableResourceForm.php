<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class stdntAvailableResourceForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** ID *************/
        $mform->addElement('static', 'ident', 'ID:');
        $mform->setType('ident', PARAM_INT);
        $mform->setDefault('ident', 'Unbekannt');

        /* ****************** NAME *************/
        $mform->addElement('static', 'name', 'Name:');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', 'Unbekannt');

        /* ****************** NAME *************/
        $mform->addElement('static', 'description', 'Description:');
        $mform->setType('description', PARAM_NOTAGS);
        $mform->setDefault('description', '-');

        $mform->addElement('static', 'category', 'Category:');
        $mform->setType('category', PARAM_NOTAGS);
        $mform->setDefault('category', '-');

        /* ****************** TYPE *************/
        $mform->addElement('static', 'type', 'Manufacturer:');
        $mform->setType('type', PARAM_NOTAGS);
        $mform->setDefault('type', '-');

        /* ****************** STATUS *************/
        $mform->addElement('static', 'comment', 'Comment:');
        $mform->setType('comment', PARAM_NOTAGS);
        $mform->setDefault('comment', '-');

        /* ****************** QUANTITY *************/
        $mform->addElement('static', 'quantity', 'Quantity:');
        $mform->setType('quantity', PARAM_INT);
        $mform->setDefault('quantity', '-');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'resourceid');
        $mform->setType('resourceid', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Next');
        $mform->addElement('cancel', 'cancelBtn', 'Back');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}
