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

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

if(!isset($usergroup[AUTH_LABORATORY_ENGINEER])) die("403 Unauthorized");

global $SESSION;

$strName = "Add new Resource";
echo $OUTPUT->heading($strName);

require_once(dirname(__DIR__) . '/forms/lab_newResourceForm.php');
//data_read: hardwarerental_category
$categories = $DB->get_records('hardwarerental_category',array());
//data_read: hardwarerental_manufacturer
$manufacturers = $DB->get_records('hardwarerental_manufacturer',array());
//data_read: hardwarerental_tags
$tags = $DB->get_records('hardwarerental_tags',array());

$resourceform = new labNewResourceForm(
    array_map(function($value){return $value->category;},$categories),
    array_map(function($value){return $value->manufacturer;},$manufacturers),
    array_map(function($value){return $value->name;},$tags)
);

$resourceform ->render();

//Form processing and displaying is done here
if ($resourceform ->is_cancelled()) {

    unset($SESSION->formData1);
    //Handle form cancel operation, if cancel button is present on form
    redirect(new moodle_url('./lab_resourcelist_view.php', array('id' => $cm->id)));

 } else if ($fromform = $resourceform ->get_data()) {
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
            array_push($normalized_tags,array_map(function($value){return $value->name;},$tags)[$tag]);
        }else{
            $record = new stdClass();
            $record->name = $tag;
            //data_write: hardwarerental_tags
            $DB->insert_record('hardwarerental_tags', $record, false);
            array_push($normalized_tags, $tag);
        }
    }
    $fromform->tags = $normalized_tags;
    $SESSION->formData1 = $fromform;
    redirect(new moodle_url('./lab_pieceMaterial_view.php', array('id' => $cm->id)));

 
 } else {
    $formdata = array('id' => $id);
    $resourceform ->set_data($formdata);
    //displays the form
    $resourceform ->display();
 }

// Finish the page.
echo $OUTPUT->footer();
