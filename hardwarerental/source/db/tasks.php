<?php
/**
 * User: Sven
 * Date: 29.06.18
 * Time: 14:03
 */

defined('MOODLE_INTERNAL') || die();
$tasks = array(
            array(
                //run after every Day at 10am
                'classname' => 'mod_checkdeadline\task\checkDeadlineTask',
                'blocking' => 0,
                'minute' => '0',
                'hour' => '10',
                'day' => '*',
                'dayofweek' => '*',
                'month' => '*'
                )
            );
?>