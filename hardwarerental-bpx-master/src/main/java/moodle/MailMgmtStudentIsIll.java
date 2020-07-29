package moodle;

import org.camunda.bpm.engine.delegate.DelegateExecution;
import org.camunda.bpm.engine.delegate.JavaDelegate;

import javax.mail.MessagingException;
import java.io.IOException;
import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Date;

public class MailMgmtStudentIsIll implements JavaDelegate {

//    private final Logger LOGGER = Logger.getLogger(LoggerDelegate.class.getName());

    public void execute(DelegateExecution execution) throws IOException {

        // [EXAMPLE] Get Camunda variables and work with them
        String studentName = (String) execution.getVariable("student_name");
        String studentMatnr = (String) execution.getVariable("student_matnr");
        String studentReason = (String) execution.getVariable("student_reason");
        Date sickUntilDate = (Date) execution.getVariable("student_length");

        // formatting and converting the date - plase use LocalDateTime for Date or Time related stuff
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd.MM.yyyy");
        LocalDateTime localSickUntil = new Timestamp(sickUntilDate.getTime()).toLocalDateTime();
        String sickUntil = localSickUntil.format(formatter);

        String content = "<h1>Sie haben eine neue Krankschreibung erhalten</h1>"
                + "<p>Student: " + studentName + "</p>"
                + "<p>Matrikelnummer: " + studentMatnr + "</p>"
                + "<p>Grund der Krankschreibung: " + studentReason + "</p>"
                + "<p>Bis: " + sickUntil  + "</p>"
                + "<a href='https://www.moodle.com'>Link (not working) zum Moodle Bestätigungsform</a>";


        // [EXAMPLE] setting a test variable
        execution.setVariable("testvar", true);

        // [EXAMPLE] Send Email with simple HTML Content
        String receiver = "test@test.com";
        String subject = "Test Mail";
        try {
            Mail.send(receiver, subject, content);
        } catch (MessagingException e) {
            CamundaLogger.log(execution, e, MailMgmtStudentIsIll.class.getName());
        }
    }
}
