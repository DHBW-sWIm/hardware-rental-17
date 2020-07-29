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
require_once(dirname(dirname(__FILE__)).'/classes/resource_class.php');

if(!isset($usergroup[AUTH_LABORATORY_ENGINEER])) die("403 Unauthorized");

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

$resourceid = optional_param('resourceid', 0, PARAM_INT);

$strName = "Resource Details:";
echo $OUTPUT->heading($strName);

echo '<br>';
//data_read: hardwarerental_resources
$resource = $DB->get_record('hardwarerental_resources',array('id'=>$resourceid));

// Implement form for user
require_once(dirname(__DIR__ ) . '/forms/lab_resourceEditForm.php');

//data_read: hardwarerental_category
$categories = $DB->get_records('hardwarerental_category',array());
//data_read: hardwarerental_manufacturer
$manufacturers = $DB->get_records('hardwarerental_manufacturer',array());
//data_read: hardwarerental_tags
$tags = array_map(function($value){return $value->name;},$DB->get_records('hardwarerental_tags',array()));

$mform = new labResourceEditForm(
    array_map(function($value){return $value->category;},$categories),
    array_map(function($value){return $value->manufacturer;},$manufacturers),
    $tags
);
$mform->render();
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect(new moodle_url('./lab_resourcedetail_view.php', array('id' => $cm->id, 'resourceid' => $resourceid)));
} else if ($fromform = $mform->get_data()) {
    //Handle form successful operation, if button is present on form
    if(!array_key_exists($fromform->category, $categories)){
        $record = new stdClass();
        $record->category = $fromform->category;
        //data_write: hardwarerental_category
        $lastinsertid = $DB->insert_record('hardwarerental_category', $record, true);
        $fromform->category = $lastinsertid;
    }
    if(!array_key_exists($fromform->manufacturer, $manufacturers)){
        $record = new stdClass();
        $record->manufacturer = $fromform->manufacturer;
        //data_write: hardwarerental_manufacturer
        $lastinsertid = $DB->insert_record('hardwarerental_manufacturer', $record, true);
        $fromform->manufacturer = $lastinsertid;
    }
    $normalized_tags = array();
    if(!empty($fromform->tags))
        foreach ($fromform->tags as $tag){
            if(array_key_exists($tag,$tags)){
                array_push($normalized_tags,$tags[$tag]);
            }else{
                $record = new stdClass();
                $record->name = $tag;
                //data_write: hardwarerental_tags
                $DB->insert_record('hardwarerental_tags', $record, false);
                array_push($normalized_tags, $tag);
            }
        }
    $fromform->tags = $normalized_tags;
    $record = new Resource(
        $fromform->name,
        $fromform->comment,
        $fromform->description,
        $fromform->category,
        $fromform->quantity,
        $cm->id,
        $fromform->manufacturer,
        $fromform->serial,
        $fromform->inventory_nr,
        implode(";",$fromform->tags)
    );
    $record->id = $fromform->resourceid;
    //data_write: hardwarerental_resources
    $lastinsertid = $DB->update_record('hardwarerental_resources', $record, false);
    redirect(new moodle_url('./lab_resourcelist_view.php', array('id' => $cm->id)));

} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.
    // Set default data (if any)
    // Required for module not to crash as a course id is always needed
    $formdata = array(
        'ident' => ''.$resource->id,
        'id' => $id,
        'resourceid' => $resourceid,
        'serial' => ''.$resource->serial,
        'name' => $resource->name,
        'manufacturer' => $resource->manufacturer,
        'category' => $resource->category,
        'description' => $resource->description,
        'quantity' => ''.$resource->quantity,
        'comment' => $resource->comment,
        'status' => '-',
        'date' => '-',
        'tags' => empty($resource->tags)?array():
            array_map(
                function($input){global $tags; return array_search($input, $tags);},
                explode(';',$resource->tags)
            )
    );
    $mform->set_data($formdata);
    //displays the form
    $mform->display();
}

echo $OUTPUT->footer();
