package moodle;

import org.camunda.bpm.engine.delegate.DelegateExecution;
import org.camunda.bpm.engine.delegate.JavaDelegate;

import java.util.Date;
import java.util.logging.Logger;

public class ServiceFakeDBWrite implements JavaDelegate {
    private final Logger LOGGER = Logger.getLogger(LoggerDelegate.class.getName());

    public void execute(DelegateExecution execution) throws Exception {


        try {
            String var = (String) execution.getVariable("student_name");
            var = var.toUpperCase();
            execution.setVariable("uppercase_name", var);
        } catch (Exception e) {            // fails if variable ("student_name") does not exist
            e.printStackTrace();
        }

        String studentName = (String) execution.getVariable("student_name");
        String studentMatnr = (String) execution.getVariable("student_matnr");
        String studentReason = (String) execution.getVariable("student_reason");
        Date studentLength = (Date) execution.getVariable("student_length");
        Boolean managementApproval = (Boolean) execution.getVariable("management_approval");

        execution.setVariable("db_write_success", true);

        LOGGER.info("\n\n  ... LoggerDelegate invoked by "
                + "processDefinitionId=" + execution.getProcessDefinitionId()
                + ", activityId=" + execution.getCurrentActivityId()
                + ", activityName='" + execution.getCurrentActivityName() + "'"
                + ", processInstanceId=" + execution.getProcessInstanceId()
                + ", businessKey=" + execution.getProcessBusinessKey()
                + ", executionId=" + execution.getId()
                + "studentName"         +  studentName + "\n\n"
                + "studentMatnr"        +  studentMatnr + "\n\n"
                + "studentReason"       +  studentReason + "\n\n"
                + "studentLength"       +  studentLength + "\n\n"
                + "managementApproval"  +  managementApproval + "\n\n"
                + " \n\n");

    }

}
