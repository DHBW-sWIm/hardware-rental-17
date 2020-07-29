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

$taskid = optional_param("taskid","",PARAM_NOTAGS);
$document = optional_param("documentId","",PARAM_NOTAGS);
$coc = optional_param("cocId","",PARAM_NOTAGS);

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

global $SESSION;

echo $OUTPUT->heading("Successfully completed the signature process");
echo '<br>';

$document = dirname(dirname("https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"))."/pdf_from_string.php?id=".$document;
$coc = dirname(dirname("https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"))."/pdf_from_string.php?id=".$coc;

$task = get_all_tasks(['processInstanceId' => $taskid]);

complete_task($task[0]['id'], [
        'document' => camunda_string($document),
        'coc' => camunda_string($coc)
    ]);

echo $OUTPUT->single_button(
    new moodle_url('./lab_approved_list_view.php', array('id'=>$cm->id)),
    "Back to the signature list"
);

echo $OUTPUT->footer();