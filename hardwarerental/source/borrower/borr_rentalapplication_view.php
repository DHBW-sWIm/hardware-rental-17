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


$resourceid = optional_param('resourceid', 0, PARAM_INT);

$strName = "Personal Information:";
echo $OUTPUT->heading($strName);

echo '<br>';

require_once(dirname(__DIR__ ). '/forms/stdnt_antragForm.php');
$mform = new stdntAntragForm();
$mform->render();
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect(new moodle_url('./borr_available_resource_view.php', array('id' => $cm->id)));
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    $resource = new stdClass();
    /*foreach($SESSION->resourceList as $item) {
        if ($fromform->resourceName == $item->name) {
            $resource = $item;
            break;
        }
    }*/
    //data_read: hardwarerental_resources
    $resource = $DB->get_record('hardwarerental_resources',array('id'=>$fromform->resourceid));

    $appId = rand(1,10000);
    $responsibles = array('Prof. Martin', 'Prof. Koslowski', 'Gzuz', 'Tichy');
    $responsible = $responsibles[$fromform->assignee];
    $SESSION->applicationList[] = (object) array('id' => $appId, 'student_name' => $fromform->studentName, 'student_id' => $fromform->studentId, 'mail' => $fromform->studentEmail, 'resource' => $resource->name, 'grund' => $fromform->grund, 'returndate' => $fromform->returnDate, 'anmerkung' => $fromform->anmerkung, 'assignee' => $responsible, 'applicationtype' => 'Rental Application', 'status' => 'Requested');

    // redirect(new moodle_url('./borr_applicationlist_view.php', array('id' => $cm->id)));

    start_process("hardwarerental-request-approval",[
        'stdnt_firstname' => new camunda_variable($USER->firstname, 'string'),
        'stdnt_lastname' => new camunda_variable($USER->lastname, 'string'),
        'stdnt_id' => new camunda_variable($fromform->studentId, 'string'),
        'stdnt_reason' => new camunda_variable($fromform->grund, 'string'),
        'stdnt_comment' => new camunda_variable($fromform->anmerkung, 'string'),
        'stdnt_mail' => new camunda_variable($fromform->studentEmail, 'string'),
        'stdnt_address' => new camunda_variable($USER->address, 'string'),
        'stdnt_city' => new camunda_variable($USER->city, 'string'),
        'stdnt_phone' => new camunda_variable($USER->phone1, 'string'),
        'stdnt_username' => new camunda_variable($USER->username, 'string'),
        'stdnt_course' => new camunda_variable('WWI16SCB', 'string'),
        'resource_name' => new camunda_variable($resource->name, 'string'),
        'resource_id' => new camunda_variable($resource->id, 'string'),
        'applic_from' => new camunda_variable($fromform->fromDate, 'string'),
        'applic_to' => new camunda_variable($fromform->returnDate, 'string'),
        'req_date' => new camunda_variable(time(), 'string')
    ]);

    $returnurl = new moodle_url('./borr_applicationlist_view.php', array('id' => $cm->id));
    redirect($returnurl);

} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    // Set default data (if any)
    // Required for module not to crash as a course id is always needed

    $formdata = array('id' => $id, 'resourceid' => $resourceid, 'studentName' => ($USER->firstname . " " . $USER->lastname), 'studentId' => $USER->id, 'studentEmail' => $USER->email );
    $mform->set_data($formdata);
    //displays the form
    $mform->display();
}

echo $OUTPUT->single_button(new moodle_url('./main_borrower_view.php', array('id' => $cm->id)), 'Home');

echo $OUTPUT->footer();