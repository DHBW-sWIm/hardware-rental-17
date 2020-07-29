<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class labNewResourceForm extends moodleform {
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

        /* ****************** NAME *************/
		$mform->addElement('text', 'name', 'Name:');
		$mform->setType('name', PARAM_NOTAGS);

        //Dropwdown-Menü wird erstellt, um Hauptkategorie auszuwählen
        $mform->addElement('autocomplete', 'category', 'Category',
            $this->categories,
            array('tags'=>true)
        );
        //Radiobuton um Stückgut oder Schüttgut auszuwählen

        $mform->addElement('select', 'resourcetype',
            'Type:', array('Piece Material', 'Bulk Material'));

        $mform->addElement('autocomplete', 'manufacturer', 'Manufacturer',
            $this->manufacturers,
            array('tags' => true)
        );

        $mform->addElement('autocomplete', 'tags', 'Add tags', $this->tags, array('multiple' => true, 'tags' => true));

        $mform->addElement('text', 'description', 'Description:');
        $mform->setType('description', PARAM_NOTAGS);

        $mform->addElement('text', 'quantity', 'Quantity:');
        $mform->setType('quantity', PARAM_INT);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Next');
        $mform->addElement('cancel', 'cancelBtn', 'Cancel');

    }
    //Custom validation should be added here
    function validation($data, $files) {
   
        return array();
    }
}

