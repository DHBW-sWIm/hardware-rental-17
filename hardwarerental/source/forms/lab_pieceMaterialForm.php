<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class labPieceMaterialForm extends moodleform {

    public function __construct($quantity)
    {
        $this->quantity = $quantity;
        parent::__construct();
    }

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!
        for($i = 1; $i <= $this->quantity; $i++) {
            $mform->addElement('html', '<h3>Resource '.$i.'</h3>');
            /* ****************** ID *************/
            $mform->addElement('text', 'inventory_nr'.$i, 'Inventory Number:');
            $mform->setType('inventory_nr'.$i, PARAM_NOTAGS);

            /* ****************** SERIAL *************/
            $mform->addElement('text', 'serial'.$i, 'Serial Number:');
            $mform->setType('serial'.$i, PARAM_NOTAGS);

            /* ****************** NAME *************/
            $mform->addElement('text', 'comment'.$i, 'Comment:');
            $mform->setType('comment'.$i, PARAM_NOTAGS);
        }
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Add');
        $mform->addElement('cancel', 'cancelBtn', 'Back');
    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

