<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class stdntResourceFilterForm extends moodleform {

    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        //Dropwdown-Menü wird erstellt, um Hauptkategorie auszuwählen
        $mform->addElement('select', 'category',
            'Category:', array('', 'Smartphone', 'Tablet', 'Laptop', 'Computer','Software', 'Printer'));

        $mform->addElement('select', 'type',
            'Manufacturer:', array('', 'Apple', 'Samung', 'Huawei', 'Xiaomi'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Refresh');

    }
    //Custom validation should be added here
    function validation($data, $files) {

        return array();
    }
}

