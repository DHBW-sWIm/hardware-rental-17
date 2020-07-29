<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");


class labResourceEditForm extends moodleform {

    public function __construct($categories, $manufacturers, $tags)
    {
        $this->categories = $categories;
        $this->manufacturers = $manufacturers;
        $this->tags = $tags;
        parent::__construct();
    }

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        /* ****************** SERIAL *************/
        $mform->addElement('text', 'serial', 'Serial Number:');
        $mform->setType('serial', PARAM_NOTAGS);
        $mform->setDefault('serial', '-');

        /* ****************** NAME *************/
        $mform->addElement('text', 'name', 'Name:');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', '-');

        /* ****************** TYPE *************/
        $mform->addElement('autocomplete', 'category', 'Category',
            $this->categories,
            array('tags'=>true)
        );

        $mform->addElement('autocomplete', 'manufacturer', 'Manufacturer',
            $this->manufacturers,
            array('tags' => true)
        );

        /* ****************** DESCRIPTION *************/
        $mform->addElement('text', 'description', 'Description:');
        $mform->setType('description', PARAM_NOTAGS);
        $mform->setDefault('description', '-');


        /* ****************** QUANTITY *************/
        $mform->addElement('text', 'quantity', 'Quantity:');
        $mform->setType('quantity', PARAM_INT);
        $mform->setDefault('quantity', '0');

        /* ****************** COMMENT *************/
        $mform->addElement('text', 'comment', 'Comment:');
        $mform->setType('comment', PARAM_NOTAGS);
        $mform->setDefault('comment', '-');


        $mform->addElement('autocomplete', 'tags', 'Add tags', $this->tags, array('multiple' => true, 'tags' => true));

        $mform->addElement('hidden', 'resourceid');
        $mform->setType('resourceid', PARAM_INT);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        /* ****************** ID *************/
        $mform->addElement('text', 'inventory_nr', 'Inventory Number:');
        $mform->setType('inventory_nr', PARAM_NOTAGS);

        $mform->addElement('submit', 'btnSubmit', 'Change');
        $mform->addElement('cancel', 'cancelBtn', 'Cancel');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

