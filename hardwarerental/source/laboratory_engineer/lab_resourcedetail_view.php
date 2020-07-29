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

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

$resourceid = optional_param('resourceid', 0, PARAM_INT);

$strName = "Resource Details:";
echo $OUTPUT->heading($strName);

echo '<br>';
//data_read: hardwarerental_resources
$resource = $DB->get_record('hardwarerental_resources',array('id'=>$resourceid));

// Implement form for user
require_once(dirname(__DIR__ ) . '/forms/lab_ResourceDetailForm.php');
$mform = new labResourceDetailForm();
$mform->render();
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect(new moodle_url('./lab_resourcelist_view.php', array('id' => $cm->id)));
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form

    redirect(new moodle_url('./lab_resource_edit_view.php', array('id' => $cm->id, 'resourceid' => $fromform->resourceid)));
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    // Set default data (if any)
    // Required for module not to crash as a course id is always needed
    $formdata = array(
        'id' => $id,
        'ident' => ''.$resource->id,
        'resourceid' => $resourceid,
        'serial' => ''.$resource->serial,
        'name' => $resource->name,
        //data_read: hardwarerental_manufacturer
        'manufacturer' => $DB->get_record(
            'hardwarerental_manufacturer',array('id'=>$resource->manufacturer)
        )->manufacturer,
        //data_read: hardwarerental_manufacturer
        'category' => $DB->get_record(
            'hardwarerental_category',array('id'=>$resource->category)
        )->category,
        'description' => $resource->description,
        'quantity' => ''.$resource->quantity,
        'comment' => $resource->comment,
        'status' => '-',
        'date' => '-',
        'tags' => ''.$resource->tags,
        'inventory_nr' => $resource->inventory_nr
    );
    $mform->set_data($formdata);
    //displays the form
    $mform->display();
}

echo $OUTPUT->footer();
