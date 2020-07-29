<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class stdntApplicationDetailForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** ID *************/
        $mform->addElement('static', 'type', 'Type:');
        $mform->setType('type', PARAM_NOTAGS);
        $mform->setDefault('type', '-');

        /* ****************** NAME *************/
        $mform->addElement('static', 'name', 'Application By:');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', '-');

        /* ****************** TYPE *************/
        $mform->addElement('static', 'status', 'Status:');
        $mform->setType('status', PARAM_NOTAGS);
        $mform->setDefault('status', '-');

        /* ****************** STATUS *************/
        $mform->addElement('static', 'resource', 'Resource:');
        $mform->setType('resource', PARAM_NOTAGS);
        $mform->setDefault('resource', '-');

        /* ****************** DATE *************/
        $mform->addElement('static', 'date', 'Due Date:');
        $mform->setType('date', PARAM_NOTAGS);
        $mform->setDefault('date', '-');

        /* ****************** QUANTITY *************/
        $mform->addElement('static', 'quantity', 'Quantity:');
        $mform->setType('quantity', PARAM_INT);
        $mform->setDefault('quantity', '1');

        /* ****************** DATE *************/
        $mform->addElement('static', 'assignee', 'Responsible:');
        $mform->setType('assignee', PARAM_NOTAGS);
        $mform->setDefault('assignee', '-');

        /* ****************** DATE *************/
        $mform->addElement('static', 'grund', 'Reason:');
        $mform->setType('grund', PARAM_NOTAGS);
        $mform->setDefault('grund', '-');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'applicationid');
        $mform->setType('applicationid', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Revoke Application');
        $mform->addElement('cancel', 'cancelBtn', 'Back');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

