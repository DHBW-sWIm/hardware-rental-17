<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of ausleihantrag
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_hardwarerental
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace ausleihantrag with the name of your module and remove this line.


require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
require_once(dirname(dirname(__FILE__)). '/lib.php');
require_once(dirname(dirname(__FILE__)) . '/locallib.php');
require_once(dirname(dirname(__FILE__))."/view_init.php");

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

global $SESSION;

$strName = "Resource Details:";
echo $OUTPUT->heading($strName);

echo '<br>';

require_once(dirname(__DIR__ ). '/forms/stdnt_availableResourceBulkForm.php');
$mform = new stdntAvailableResourceBulkForm();
$mform->render();
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect(new moodle_url('./borr_available_resource_view.php', array('id' => $cm->id)));
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    echo ('Form1: '.$fromform->name);
    echo ('Form2: '.$fromform-resourceNname);
    echo ('Global: '.$resourceName);
    redirect(new moodle_url('./borr_rentalapplication_view.php', array('id' => $cm->id, 'resourceName' => $fromform->resourceName)));
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    // Set default data (if any)
    // Required for module not to crash as a course id is always needed

    $resource = new stdClass();
    //data_read: hardwarerental_resources
    foreach($SESSION->resourceList as $item) {
        if ($resourceName == $item->name) {
            $resource = $item;
            break;
        }
    }

    $formdata = array('id' => $id, 'resourceName' => $resourceName,'name' => $resource->name, 'type' => $resource->type, 'category' => $resource->category, 'description' => $resource->description, 'status' => $resource->status, 'quantity' => $resource->quantity, 'comment' => $resource->comment);
    $mform->set_data($formdata);
    //displays the form
    $mform->display();
}

echo $OUTPUT->single_button(new moodle_url('./main_borrower_view.php', array('id' => $cm->id)), 'Home');

echo $OUTPUT->footer();