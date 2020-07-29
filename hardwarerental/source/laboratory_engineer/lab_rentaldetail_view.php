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

if(!isset($usergroup[AUTH_LABORATORY_ENGINEER])) die("403 Unauthorized");
$taskid = optional_param('taskid', 0, PARAM_NOTAGS);
do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

$strName = "Leihdetails:";
echo $OUTPUT->heading($strName);

echo '<br>';

// Implement form for user
require_once(dirname(__DIR__ ). '/forms/lab_rentalDetailForm.php');
$mform = new labRentalDetailForm();
$mform->render();

$data = array();

if ($taskid) {
    //Create a client
    $variables = get_all_task_variables_by_id($taskid);

    //Set Data from variables
    $data = array(
        'id' => $cm->id,
        'taskid' => $taskid,
        "name" => $variables['stdnt_firstname']['value']." ".$variables['stdnt_lastname']['value'],
        "matr" => $variables['stdnt_id']['value'],
        "email" => $variables['stdnt_mail']['value'],
        "date" => date("Y-m-d", $variables['applic_to']['value']),
        "resource" => $variables['resource_name']['value'],
        "reason" => $variables['stdnt_reason']['value'],
        "comment" => $variables['stdnt_comment']['value'],
    );
}
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on 
    //print($taskid);
    //data_read: hardwarerental_applications
    if(!isset($SESSION->applicationList)) $SESSION->applicationList = array();

    //data_read: hardwarerental_applications
    foreach ($SESSION->applicationList as $application){
        if($application->studentId == $data->matr){
            $application->status = 'Returned';
        }
    }
    $response_dmg = complete_task($taskid, ['damage_free' => new camunda_variable(false, 'boolean')]);
    //print($response_dmg);
    redirect(new moodle_url('./lab_rentallist_view.php', array('id' => $cm->id)));
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    foreach ($SESSION->applicationList as $application){
        if($application->studentId == $data->matr && $application->status == 'Accepted'){
            $application->status = 'Returned';
        }
    }
    $response_no_dmg = complete_task($taskid, ['damage_free' => new camunda_variable(true, 'boolean')]);
    redirect(new moodle_url('./lab_rentallist_view.php', array('id' => $cm->id)));
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    // Set default data (if any)
    // Required for module not to crash as a course id is always needed
    $formdata = $data;
    $mform->set_data($formdata);
    //displays the form
    $mform->display();
}

echo $OUTPUT->single_button(new moodle_url('./main_lab_view.php', array('id' => $cm->id)), 'Home');

echo $OUTPUT->footer();
