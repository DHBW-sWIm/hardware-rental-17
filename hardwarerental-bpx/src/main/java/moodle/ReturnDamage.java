package moodle;

import org.camunda.bpm.engine.delegate.DelegateExecution;
import org.camunda.bpm.engine.delegate.JavaDelegate;
import org.joda.time.format.ISODateTimeFormat;

import javax.mail.MessagingException;
import java.io.IOException;
import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Date;

public class ReturnDamage implements JavaDelegate {

    public void execute(DelegateExecution execution) throws IOException {
        try{
            // Get Camunda variables to work with them
            String stdntName = ((String) execution.getVariable("stdnt_firstname")) + " " + (String) (execution.getVariable("stdnt_lastname"));
            String stdntMatnr = (String) execution.getVariable("stdnt_username");
            String stdntEmail = (String) execution.getVariable("stdnt_mail");
            String stdntResource = (String) execution.getVariable("resource_name");
            //Date from = (Date) execution.getVariable("applic_from");
            //Date until = (Date) execution.getVariable("applic_to");
            Long stdntQuantity = (Long) 1l;
            String pickupplace = (String) "DHBW";
            //Date pickupdate = (Date) execution.getVariable("applic_from");

            // formatting and converting the date - plase use LocalDateTime for Date or Time related stuff
           /* DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd.MM.yyyy");
            LocalDateTime pickupDate = new Timestamp(pickupdate.getTime()).toLocalDateTime();
            String string_pickupdate = pickupDate.format(formatter);
            LocalDateTime untilDate = new Timestamp(pickupdate.getTime()).toLocalDateTime();
            String stringUntil = untilDate.format(formatter);*/

            // Fill Mail with information
            String content = "<h1> You returned an item </h1>"
                    + "<p>Student: " + stdntName + "</p>"
                    + "<p>StudentId.: " + stdntMatnr + "</p>"
                    + "<p>Resource: " + stdntResource + "</p>"
                    + "<p>Amount: " + stdntQuantity.toString() + "</p>"
                    //  + "<p>Until: " + stringUntil + "</p>"
                    //  + "<p>Pickup date: " + string_pickupdate + "</p>"
                    + "<p>Thank you for returning your borrowed item, unfortunately it was damaged</p>";
            String receiver = stdntEmail;
            String subject = "You returned an item with damage";

            Mail.send(receiver, subject, content);
            Mail.send("clemens.martin@moodle-dhbw.de", "Student "+stdntName+" returned an item with damage", content);
        } catch (Exception e) {
            CamundaLogger.log(execution, e, RentalApprovalMail.class.getName());
        }
    }
}
