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
 * Prints a particular instance of checkdeadline
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_hardwarerental
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace checkdeadline with the name of your module and remove this line.

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
require_once(dirname(dirname(__FILE__)). '/lib.php');
require_once(dirname(dirname(__FILE__)) . '/locallib.php');
require_once(dirname(dirname(__FILE__))."/view_init.php");
require_once(dirname(dirname(__FILE__)).'/classes/resource_class.php');

if(!isset($usergroup[AUTH_LABORATORY_ENGINEER])) die("403 Unauthorized");

global $SESSION;

if($SESSION->formData1->resourcetype == 1){
    //Add database record
    $record = new Resource(
        $SESSION->formData1->name,
        "Bulk material",
        $SESSION->formData1->description,
        $SESSION->formData1->category,
        $SESSION->formData1->quantity,
        $cm->id,
        $SESSION->formData1->manufacturer,
        "",
        "",
        implode(";",$SESSION->formData1->tags)
    );
    //data_write: hardwarerental_resources
    $lastinsertid = $DB->insert_record('hardwarerental_resources', $record, false);
    redirect(new moodle_url('./lab_resourcelist_view.php', array('id' => $cm->id)));
}else {
    do_header(substr(__FILE__, strpos(__FILE__,'/mod')));
    $strName = "New Resource:";
    echo $OUTPUT->heading($strName);

    require_once(dirname(__DIR__) . '/forms/lab_pieceMaterialForm.php');
    $mform = new labPieceMaterialForm($SESSION->formData1->quantity);

//Form processing and displaying is done here
    if ($mform->is_cancelled()) {

        unset($SESSION->formData2);
        //Handle form cancel operation, if cancel button is present on form
        redirect(new moodle_url('./lab_new_resource_view.php', array('id' => $cm->id)));

    } else if ($fromform = $mform->get_data()) {
        for($i = 1; $i <= $SESSION->formData1->quantity; $i++) {
            $comment_prop = 'comment'.$i;
            $serial_prop = 'serial'.$i;
            $inventory_nr_prop = 'inventory_nr'.$i;
            //Add database record
            $record = new Resource(
                $SESSION->formData1->name,
                $fromform->$comment_prop,
                $SESSION->formData1->description,
                $SESSION->formData1->category,
                1,
                $cm->id,
                $SESSION->formData1->manufacturer,
                $fromform->$serial_prop,
                $fromform->$inventory_nr_prop,
                implode(";", $SESSION->formData1->tags)
            );
            //data_write: hardwarerental_resources
            $lastinsertid = $DB->insert_record('hardwarerental_resources', $record, false);
        }
        redirect(new moodle_url('./lab_resourcelist_view.php', array('id' => $cm->id)));

    } else {
        // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
        // or on the first display of the form.

        // Set default data (if any)
        // Required for module not to crash as a course id is always needed
        $formdata = array('id' => $id);
        $mform->set_data($formdata);
        //displays the form
        $mform->display();

    }

    // Finish the page.
    echo $OUTPUT->footer();
}
