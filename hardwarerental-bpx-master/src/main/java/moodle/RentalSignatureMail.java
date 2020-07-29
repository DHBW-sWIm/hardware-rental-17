package moodle;

import org.camunda.bpm.engine.delegate.DelegateExecution;
import org.camunda.bpm.engine.delegate.JavaDelegate;

import javax.mail.MessagingException;
import java.io.IOException;
import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Date;

public class RentalSignatureMail implements JavaDelegate {

    public void execute(DelegateExecution execution) throws IOException {

        // Get Camunda variables to work with them
        String stdntName = (String) execution.getVariable("stdnt_name");
        String stdntEmail = (String) execution.getVariable("stdnt_mail");
        String document = (String) execution.getVariable("document");
        String coc = (String) execution.getVariable("coc");

        // Fill Mail with information
        String content = "<h1> Your borrowers note is ready! </h1>"
                + "<p>Hi "+stdntName+", the borrowers note for your rental is available!</p>"
                + "<p>You can find the details of your rental in your <a href='"+document+"'>borrowers note</a>."
                + "Please make sure to create a copy of your <a href='"+coc+"'>Certificate of Completion</a></p>"
                + "<p>We hope to work with you again</p>";
        String receiver = stdntEmail;
        String subject = "Your DHBW Borrowers note!";

        try {
            Mail.send(receiver, subject, content);
            Mail.send("johann.meister@moodle-dhbw.de", "Student "+stdntName+" borrowers note", content);
        } catch (MessagingException e) {
            CamundaLogger.log(execution, e, RentalSignatureMail.class.getName());
        }
    }
}
