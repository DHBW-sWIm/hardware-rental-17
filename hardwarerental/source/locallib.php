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
 * Internal library of functions for module hardwarerental
 *
 * All the hardwarerental specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package    mod_hardwarerental
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/lib/autoload.php');

defined('MOODLE_INTERNAL') || die();

//Global Client Variable
global $client;
//Fetch Camunda URL
$ini = parse_ini_file(__DIR__ . '/.ini');
$camunda_url = $ini['camunda_url'];
$camunda_api = $camunda_url . 'engine-rest/';
//Create Guzzle Client
$client = new GuzzleHttp\Client([
    'base_uri' => $camunda_api,
]);
//======================================================================
// PROCESS FUNCTIONS FOR CAMUNDA
//======================================================================
function get_all_camunda_users() {
    global $client;
    $res = $client->get('user');
    $body = $res->getBody();
    $data = json_decode($body, true);
    return ($data);
}
function start_process($key, $variables) {
    global $client;
    $process_url = 'process-definition/key/' . $key . '/start';
    $res = $client->post($process_url, [
        GuzzleHttp\RequestOptions::JSON =>
            ['variables' => $variables]
    ]);
    $body = $res->getBody();
    $data = json_decode($body, true);
    return ($data);
}
// get all tasks for one taskDefinitionKey. Needs to be set in Camunda Modeler as Id on one task.
// Example: 'bpxtest.verify_illness'
// filter is optional
function get_tasks_by_key($taskDefinitionKey, $filters = []) {
    global $client;
    $taskKeyFilter = ['taskDefinitionKey' => $taskDefinitionKey];
    $merged_filters = array_merge($filters, $taskKeyFilter);
    $res = $client->get('task', [
        'query' => $merged_filters
    ]);
    $body = $res->getBody();
    $data = json_decode($body, true);
    return ($data);
}
// optional query params as filters
function get_all_tasks($filters = []) {
    global $client;
    $res = $client->get('task', [
        'query' => $filters
    ]);
    $body = $res->getBody();
    $data = json_decode($body, true);
    return ($data);
}
// get a single tasks
function get_task_by_id($id) {
    global $client;
    $res = $client->get('task/' . $id);
    $body = $res->getBody();
    $data = json_decode($body, true);
    return ($data);
}
function get_all_task_variables_by_id($id) {
    global $client;
    $res = $client->get('task/' . $id . '/variables');
    $body = $res->getBody();
    $data = json_decode($body, true);
    return ($data);
}
function complete_task($id, $variables) {
    global $client;
    $task_url = 'task/' . $id . '/complete';
    $res = $client->post($task_url, [
        GuzzleHttp\RequestOptions::JSON =>
            ['variables' => $variables]
    ]);
    $body = $res->getBody();
    $data = json_decode($body, true);
    return ($data);
}
//======================================================================
// VARIABLE TYPE HELPERS FOR CAMUNDA
//======================================================================
require_once(__DIR__ . '/classes/camunda/camunda_var.php');
function camunda_string($value) {
    return new camunda_variable($value, 'string');
}
function camunda_int($value) {
    return new camunda_variable($value, 'integer');
}
function camunda_double($value) {
    return new camunda_variable($value, 'double');
}
function camunda_boolean($value) {
    return new camunda_variable($value, 'boolean');
}
function camunda_date($iso_date_string) {
    return new camunda_variable($iso_date_string, 'date');
}
// convert epoch timestamp to ISO format (1561417200 -> 2019-06-25T00:00:00.000+0000)
function epoch_to_iso_date($epoch_timestamp) {
    return strftime('%Y-%m-%dT%H:%M:%S.000+0000', $epoch_timestamp);
}
function camunda_date_from_form($epoch_timestamp) {
    $iso_date_string = epoch_to_iso_date($epoch_timestamp);
    return camunda_date($iso_date_string);
}