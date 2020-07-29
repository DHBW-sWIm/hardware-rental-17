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
require_once(dirname(dirname(__FILE__))."/classes/pdf_class.php");

if(!isset($usergroup[AUTH_LABORATORY_ENGINEER])) die("403 Unauthorized");


//Get url parameter taskid
$taskid = optional_param('taskid', 0, PARAM_NOTAGS); // Task ID

do_header(substr(__FILE__, strpos(__FILE__,'/mod')));


$strName = "Request Details:";
echo $OUTPUT->heading($strName);


echo '<br>';

// Implement form for user
require_once(dirname(__DIR__ ). '/forms/lab_applicationDetailForm.php');
$mform = new labApplicationDetailForm();
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
    //Handle form cancel operation, if cancel button is present on form
    $response6 = complete_task($taskid, ['application_approval' => new camunda_variable(false, 'boolean')]);
    redirect(new moodle_url('./lab_applicationlist_view.php', array('id' => $cm->id)));
} else if ($fromform = $mform->get_data()) {
    $client3 = new GuzzleHttp\Client();

    $resourceid = get_all_task_variables_by_id($taskid)['resource_id']['value'];
    $response5 = complete_task($taskid, ['application_approval' => new camunda_variable(true, 'boolean')]);

    //print_r($response5);

    $pdf = new PDF();
    $pdf->BasicInfo($variables['stdnt_firstname']['value'], $variables['stdnt_lastname']['value'], $variables['stdnt_address']['value'], "", $variables['stdnt_city']['value'], $variables['stdnt_phone']['value'], $variables['stdnt_username']['value'], $variables['stdnt_course']['value'], $variables['stdnt_mail']['value']);
    //data_read: hardwarerental_resources
    $pdf->Resources($DB->get_record('hardwarerental_resources',array('id'=>$resourceid)));
    $pdf->Signatures("");

    $pdfString = $pdf->Output("", "S");

    $SESSION->pdf = $pdfString;

    $url = 'https://hardware-rental.swimdhbw.de/webservice/restjson/server.php';


    $response = start_process('hardwarerental-signature', [
        'stdnt_name' => camunda_string($variables['stdnt_firstname']['value'] . " " . $variables['stdnt_lastname']['value']),
        'stdnt_mail' => camunda_string($variables['stdnt_mail']['value'])
    ]);

    $response_due = start_process("Process_19mnhoo",[
        'stdnt_firstname' => camunda_string($variables['stdnt_firstname']['value']),
        'stdnt_lastname' => camunda_string($variables['stdnt_lastname']['value']),
        'stdnt_id' => camunda_string($variables['stdnt_id']['value']),
        'stdnt_reason' => camunda_string($variables['stdnt_reason']['value']),
        'stdnt_comment' => camunda_string($variables['stdnt_comment']['value']),
        'stdnt_mail' => camunda_string($variables['stdnt_mail']['value']),
        'stdnt_username' => camunda_string('PLACEHOLDER'),
        'resource_name' => camunda_string($variables['resource_name']['value']),
        'applic_to' => camunda_string($variables['applic_to']['value']),
        'applic_from' => camunda_string($variables['applic_to']['value'])
    ]);

    $response_return = start_process("Process_16l7asn",[
        'stdnt_firstname' => camunda_string($variables['stdnt_firstname']['value']),
        'stdnt_lastname' => camunda_string($variables['stdnt_lastname']['value']),
        'stdnt_id' => camunda_string($variables['stdnt_id']['value']),
        'stdnt_reason' => camunda_string($variables['stdnt_reason']['value']),
        'stdnt_comment' => camunda_string($variables['stdnt_comment']['value']),
        'stdnt_mail' => camunda_string($variables['stdnt_mail']['value']),
        'stdnt_username' => camunda_string('PLACEHOLDER'),
        'resource_name' => camunda_string($variables['resource_name']['value']),
        'applic_to' => camunda_string($variables['applic_to']['value']),
        'applic_from' => camunda_string($variables['applic_to']['value'])
    ]);
    $response2 = get_all_tasks(['processInstanceId' => $response['id']]);
    
    //data_read: hardwarerental_applications
    if(!isset($SESSION->applicationList)) $SESSION->applicationList = array();

    //data_read: hardwarerental_applications
    foreach ($SESSION->applicationList as $application){
        if($application->studentId == $data->matr && $application->status == 'Requested'){
            $application->status = 'Accepted';
        }
    }
    $base_pdf = base64_encode($pdfString);

    $response3 = $client3->post($url,
        [GuzzleHttp\RequestOptions::JSON =>
            [
                "wstoken" => "629076e597543bfd194d1d6797f321ae",
                "wsfunction" => "local_digitalsignature_createEnvelope",
                "pdfDocument" => $base_pdf,
                "documentName" => "Antrag.pdf",
                "returnUrl" => dirname("https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}")."/lab_postsignature_view.php?id=".$cm->id."&taskid=".$response['id'],
                "signers" => [
                    [
                        "email" => $variables['stdnt_mail']['value'],
                        "firstName" => $variables['stdnt_firstname']['value'],
                        "lastName" => $variables['stdnt_lastname']['value'],
                        "tabs" => [
                            [
                                "type" => "Signature",
                                "xPos" => "394",
                                "yPos" => "600",
                                "page" => "1"
                            ],
                            [
                                "type" => "Date",
                                "xPos" => "119",
                                "yPos" => "620",
                                "page" => "1"
                            ]
                        ]
                    ]
                ],
                "moodlewsrestformat" => "json",
            ]
        ]
    );

    $docusignLink = str_replace(array('"', '\\'), '', $response3->getBody());

    $response4 = complete_task($response2[0]['id'], ['docusign_link' => camunda_string($docusignLink)]);
    //print_r($response4);
    //print($response2[0]['id']);
    //print($docusignLink);

    // Redirect to the course result page.
    $returnurl = new moodle_url('./lab_applicationlist_view.php', array('id' => $cm->id));
    redirect($returnurl);
    //redirect($returnurl);
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

echo $OUTPUT->single_button(new moodle_url('./lab_edit_application_view.php', array('id' => $cm->id)), 'Antrag bearbeiten');
echo $OUTPUT->single_button(new moodle_url('./main_lab_view.php', array('id' => $cm->id)), 'Home');

echo $OUTPUT->footer();
