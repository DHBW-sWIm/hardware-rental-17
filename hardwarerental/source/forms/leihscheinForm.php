<?php
// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class leihschein_form extends moodleform {
    // Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('html', '<div class="header">
                                        <h1>Leihschein für ein Gerät der DHBW Mannheim</h1>
                                    </div>');

        $mform->addElement('html', '<div class="header">
                                        <h4>Daten der Ausleihenden Person</h4>
                                    </div>');

        $mform->addElement('text', 'leihschein', 'Leihschein Nr.:', $attributes='size="10"');         // Add elements to your form
        $mform->setType('leihschein', PARAM_NOTAGS);                          // Set type of element
        $mform->setDefault('leihschein', 'Leihschein Nr.');             // Default value

        $mform->addElement('text', 'name', get_string('name'));         // Add elements to your form
        $mform->setType('name', PARAM_NOTAGS);                          // Set type of element
        $mform->setDefault('name', 'Bitte Namen eingeben');             // Default value

        $mform->addElement('text', 'vorname', 'Vorname');
        $mform->setType('vorname', PARAM_NOTAGS);
        $mform->setDefault('vorname', 'Bitte Vornamen eingeben');

        $mform->addElement('text', 'straße', 'Straße');
        $mform->setType('straße', PARAM_NOTAGS);
        $mform->setDefault('straße', 'Bitte Straße eingeben');

        $mform->addElement('text', 'plz', 'PLZ');
        $mform->setType('plz', PARAM_NOTAGS);
        $mform->setDefault('plz', 'Bitte Postleitzahl eingeben');

        $mform->addElement('text', 'Wohnort', 'Wohnort');
        $mform->setType('Wohnort', PARAM_NOTAGS);
        $mform->setDefault('Wohnort', 'Bitte Wohnort eingeben');

        $mform->addElement('text', 'Telefon', 'Telefon');
        $mform->setType('Telefon', PARAM_NOTAGS);
        $mform->setDefault('Telefon', 'Bitte Telefon eingeben');

        $mform->addElement('text', 'Matrikelnummer', 'Matrikelnummer');
        $mform->setType('Matrikelnummer', PARAM_NOTAGS);
        $mform->setDefault('Matrikelnummer', 'Bitte Matrikelnummer eingeben');

        $mform->addElement('text', 'Kurs', 'Kurs');
        $mform->setType('Kurs', PARAM_NOTAGS);
        $mform->setDefault('Kurs', 'Bitte Kurs eingeben');

        $mform->addElement('text', 'email', get_string('email'));
        $mform->setType('email', PARAM_NOTAGS);
        $mform->setDefault('email', 'Bitte DHBW-Email angeben');

        $mform->addElement('html', '<div class="header">
                                        <h4>Auszuleihende Geräte</h4>
                                    </div>');

        $mform->addElement('html', '<table style="width: 100%">');
        $mform->addElement('html',      '<tr>');
        $mform->addElement('html',          '<td>');
        $mform->addElement('static', 'input', 'static1', 'val1');
        $mform->setType('input', PARAM_NOTAGS);
        $mform->addElement('html',          '</td>');
        $mform->addElement('html',          '<td></td>');
        $mform->addElement('static', 'input2', 'static2', 'hgjg');
        $mform->setType('input2', PARAM_NOTAGS);
        $mform->addElement('html',          '</td>');
        $mform->addElement('html',          '<td></td>');
        $mform->addElement('static', 'input3', 'static3');
        $mform->setType('input3', PARAM_NOTAGS);
        $mform->addElement('html',          '</td>');
        $mform->addElement('html',      '</tr>
                                    </table>');

        $mform->addElement('static', 'input4', 'static4');
        $mform->setType('input4', PARAM_NOTAGS);
        $mform->addElement('static', 'input5', 'static5');
        $mform->setType('input5', PARAM_NOTAGS);

        $mform->addElement('html', '<table>
                                        <tr>
                                          <th>Pos. </th>
                                          <th>Menge</th>
                                          <th>Artikelbezeichnung</th>
                                          <th>Seriennummer</th>
                                          <th>Inventarnr.</th>
                                          <th>Kommentare (Vorschäden o.Ä.)</th>
                                        </tr>
                                        <tr>
                                          <td>1.</td>
                                          <td><input type="text" class="form-control" size="1"/></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><textarea rows="1" cols="50" class="form-control"></textarea></td>
                                        </tr>
                                        <tr>
                                          <td>2.</td>
                                          <td><input type="text" class="form-control" size="1"/></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><textarea rows="1" cols="50" class="form-control"></textarea></td>
                                        </tr>
                                        <tr>
                                          <td>3.</td>
                                          <td><input type="text" class="form-control" size="1"/></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><textarea rows="1" cols="50" class="form-control"></textarea></td>
                                        </tr>
                                        <tr>
                                          <td>4.</td>
                                          <td><input type="text" class="form-control" size="1"/></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><textarea rows="1" cols="50" class="form-control"></textarea></td>
                                        </tr>
                                        <tr>
                                          <td>5.</td>
                                          <td><input type="text" class="form-control" size="1"/></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><textarea rows="1" cols="50" class="form-control"></textarea></td>
                                        </tr>
                                        <tr>
                                          <td>6.</td>
                                          <td><input type="text" class="form-control" size="1"/></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><input type="text" class="form-control" /></td>
                                          <td><textarea rows="1" cols="50" class="form-control"></textarea></td>
                                        </tr>
                                    </table>');

        $mform->addElement('date_selector', 'returnDate', 'Spätestes Rückgabedatum');

        $mform->addElement('textarea', 'usage', 'Verwendungszweck', 'wrap="virtual" rows="2" cols="60"');

        // error_log("TEST FROM INSIDE FORM");

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'btnSubmit', 'Absenden und Prozess starten');

        // error_log("TEST FROM AFTER SUBMIT IN FORM");

    }
    // Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
