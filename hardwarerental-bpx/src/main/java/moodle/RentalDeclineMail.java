package moodle;

import org.camunda.bpm.engine.delegate.DelegateExecution;
import org.camunda.bpm.engine.delegate.JavaDelegate;

import javax.mail.MessagingException;
import java.io.IOException;
import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Date;

public class RentalDeclineMail implements JavaDelegate {

    public void execute(DelegateExecution execution) throws IOException {
        try{
            String stdntName = ((String) execution.getVariable("stdnt_firstname")) +" "+ (String) (execution.getVariable("stdnt_lastname"));
            String stdntMatnr = (String) execution.getVariable("stdnt_username");
            String stdntEmail = (String) execution.getVariable("stdnt_mail");
            String stdntResource = (String) execution.getVariable("resource_name");
            Long stdntQuantity = (Long) 1l;
            String pickupplace = (String) "DHBW";

            // Fill Mail with information
            String content = "<h1> Unfortunately your application was rejected! </h1>"
                    + "<p>Student: " + stdntName + "</p>"
                    + "<p>StudentId.: " + stdntMatnr + "</p>"
                    + "<p>Resource: " + stdntResource + "</p>"
                    + "<p>Amount: " + stdntQuantity.toString() + "</p>"
                    + "<p>Pickup location: " + pickupplace + "</p>"
                    + "<p>We hope to work with you again!</p>";
            String receiver = stdntEmail;
        String subject = "Your application was rejected!";


            Mail.send(receiver, subject, content);
        } catch (Exception e) {
            CamundaLogger.log(execution, e, RentalDeclineMail.class.getName());
        }
    }
}
