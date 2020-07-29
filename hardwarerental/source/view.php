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
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');
require_once(dirname(__FILE__)."/view_init.php");

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));

global $SESSION;
global $USER;

$strName = "Login as borrower:";
echo $OUTPUT->heading($strName);
echo $OUTPUT->single_button(new moodle_url('./borrower/main_borrower_view.php', array('id' => $cm->id)), 'Login');
echo '<br>';
echo '<br>';

if(isset($usergroup[AUTH_LABORATORY_ENGINEER]) || isset($usergroup[AUTH_DHBW_AUTHORITY])){
    $strName = "Login as DHBW-authority:";
    echo $OUTPUT->heading($strName);
    echo $OUTPUT->single_button(new moodle_url('./laboratory_engineer/main_lab_view.php', array('id' => $cm->id)), 'Login');
    echo '<br>';
    echo '<br>';

    /*$strName = "Generate PDF";
    echo $OUTPUT->heading($strName);
    echo $OUTPUT->single_button(new moodle_url('./pdf_generate.php', array('id' => $cm->id)), 'Generate');
    echo '<br>';
    echo '<br>';*/
}


// Finish the page.
echo $OUTPUT->footer();
