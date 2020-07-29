<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class resource_detail_form extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** ID *************/
        $mform->addElement('static', 'resourceid', 'ID:');
        $mform->setType('resourceid', PARAM_INT);
        $mform->setDefault('resourceid', '6534');

        /* ****************** NAME *************/
        $mform->addElement('static', 'name', 'Name:');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', 'iPhone 8');

        /* ****************** TYPE *************/
        $mform->addElement('static', 'type', 'Type:');
        $mform->setType('type', PARAM_NOTAGS);
        $mform->setDefault('type', 'Smartphone');

        /* ****************** STATUS *************/
        $mform->addElement('static', 'status', 'Status:');
        $mform->setType('status', PARAM_NOTAGS);
        $mform->setDefault('status', 'Rented');

        /* ****************** DUE *************/
        $mform->addElement('date_selector', 'date', 'Return Date:');

        /* ****************** QUANTITY *************/
        $mform->addElement('static', 'quantity', 'Quantity:');
        $mform->setType('quantity', PARAM_INT);
        $mform->setDefault('quantity', '1');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Extend');
        $mform->addElement('cancel', 'cancelBtn', 'Back');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

