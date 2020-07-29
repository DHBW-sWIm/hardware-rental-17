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
 * Prints a particular instance of hardwarerental
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_hardwarerental
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
require_once(dirname(dirname(__FILE__)). '/lib.php');
require_once(dirname(dirname(__FILE__)) . '/locallib.php');
require_once(dirname(dirname(__FILE__))."/view_init.php");

if(!isset($usergroup[AUTH_LABORATORY_ENGINEER])) die("403 Unauthorized");

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

// Conditions to show the intro can change to look for own settings or whatever.
if ($hardwarerental->intro) {
    echo $OUTPUT->box(format_module_intro('hardwarerental', $hardwarerental, $cm->id), 'generalbox mod_introbox', 'hardwarerentalintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading('Rückgabe:');


// Initialisierung und Vorbelegung des Formulars mit der RessourceID, dem Namen und dem aktuell vermerkten Schaden (ggf. leer)
require_once(dirname(__FILE__) . '/forms/lab_returnResource_form.php');
$mform = new labReturnResource_form();

$mform->render();

// Verarbeitung der Formulardaten
if ($mform->is_cancelled()) {
    redirect(new moodle_url('./lab_upload_return_view.php', array('id'=>$cm->id)));
} else if ($fromform = $mform->get_data()){
    redirect(new moodle_url('./lab_rentaldetail_view.php', array('id'=>$cm->id)));
}
else {
    $formdata = array('id'=>$id);
    $mform->set_data($formdata);
    $mform->display();
};
echo nl2br("\n");
// Navigation
echo html_writer::link(new moodle_url('./lab_rentaldetail_view.php', array('id'=>$cm->id)), 'Zurück');
echo html_writer::link(new moodle_url('/course/view.php', array('id'=>$cm->id)), 'Home');


/*********************** END CODE FOR SCHADENSDOKUMENTATION ***********************/

// Finish the page
echo $OUTPUT->footer();
