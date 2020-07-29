package moodle;

import org.camunda.bpm.engine.delegate.DelegateExecution;
import org.camunda.bpm.engine.delegate.JavaDelegate;
import org.joda.time.format.ISODateTimeFormat;

import javax.mail.MessagingException;
import java.io.IOException;
import java.sql.Timestamp;
import java.util.Date;

import java.time.LocalDateTime;
import java.time.Period;
import java.time.format.DateTimeFormatter;

public class RemindStudent implements JavaDelegate {

    public void execute(DelegateExecution execution) throws IOException {
        try{
            // Read Camunda variables
            StudentData newStudentData = new StudentData(
                (String) execution.getVariable("stdnt_firstname"),
                (String) execution.getVariable("stdnt_lastname"),
                (String) execution.getVariable("stdnt_username"),
                (String) execution.getVariable("stdnt_mail")
            );
            
            RentalData newRentalData = new RentalData(
                newStudentData,
                (String) execution.getVariable("resource_name"),
                (Date) execution.getVariable("applic_from"),
                (Date) execution.getVariable("applic_to")
            );
            
            // get current date
            LocalDateTime currentDate = LocalDateTime.now();
            
            // get rental end date
            Date endDate = newRentalData.getEndDate();
            LocalDateTime rentedUntil = new Timestamp(endDate.getTime()).toLocalDateTime();
            
            String reminderSubject = "";
            String emailContent = "";
 
            // if the rental period is past
            if( currentDate.isAfter( rentedUntil ) ) {
                reminderSubject = SUBJECT_REMINDER_LATE;
                emailContent = createReminder(newRentalData, true );
            }
            else {
                Period timespan = Period.between(currentDate.toLocalDate(), rentedUntil.toLocalDate());
                
                // if the rental period expires tomorrow
                if( timespan.getDays() == 1 ) {
                    reminderSubject = SUBJECT_REMINDER_1DAY_LEFT;
                    emailContent = createReminder(newRentalData, false );
                }
                else
                    return;
            }
            
            Mail.send(newStudentData.getEmail(), reminderSubject, emailContent);
            Mail.send("clemens.martin@moodle-dhbw.de", "Sent reminder to student: " + newStudentData.studentFullName(), emailContent);
        } catch (Exception e) {
            CamundaLogger.log(execution, e, RemindStudent.class.getName());
        }
    }
    
    private static String createReminder(RentalData specifiedData, boolean returnIsOverdue) {
        if( returnIsOverdue )
            return createReminderOverdue(specifiedData);
        else
            return createReminderOneDayLeft(specifiedData);
    }
    
    private static String createReminderOverdue(RentalData specifiedData) {
        StringBuilder msg = new StringBuilder();
        
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd.MM.yyyy");
        
        msg.append( "<h1>Rental period expired!</h1>" );
        msg.append( "<p>You should have returned the device rented (" );
        msg.append( specifiedData.getResourceRented() );
        msg.append( ") by " );
        msg.append( specifiedData.getEndDate() ); //format(formatter)
        msg.append(".</p>");
        
        msg.append("<p>Please return the device as soon as possible!</p>");
        
        return msg.toString();
    }
    
    private static String createReminderOneDayLeft(RentalData specifiedData) {
        StringBuilder msg = new StringBuilder();
        
        msg.append( "<h1>Rental period expires tomorrow!</h1>" );
        msg.append( "<p>You should return the device rented (" );
        msg.append( specifiedData.getResourceRented() );
        msg.append( ") by tomorrow.</p>" );
        
        return msg.toString();
    }
    
    private static final String SUBJECT_REMINDER_LATE = "Hardware rented not returned yet!";
    private static final String SUBJECT_REMINDER_1DAY_LEFT = "One day left to return rented hardware!";
}

class StudentData {
    public StudentData(String firstName, String lastName, String userName, String email) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.userName = userName;
        this.email = email;
    }
    
    public String getFirstName() { return this.firstName; }
    public String getLastName() { return this.lastName; }    
    public String studentFullName() { return this.firstName + " " + this.lastName; }
    public String getUserName() { return this.userName; }
    public String getEmail() { return this.email; }
    
    private String firstName;
    private String lastName;
    private String userName;
    private String email;
}

class RentalData {
    public RentalData(StudentData studentData, String resourceRented, Date startDate, Date endDate) {
        this.studentData = studentData;
        this.resourceRented = resourceRented;
        this.startDate = startDate;
        this.endDate = endDate;
    }
    
    public StudentData getStudentDate() { return this.studentData; }
    public String getResourceRented() { return this.resourceRented; }
    public Date getStartDate() { return this.startDate; }
    public Date getEndDate() { return this.endDate; }
    
    private StudentData studentData;
    private String resourceRented;
    private Date startDate;
    private Date endDate;
}
