package moodle;

import org.camunda.bpm.engine.delegate.DelegateExecution;

import java.util.Arrays;
import java.util.logging.Logger;

public class CamundaLogger {
    public static void log(DelegateExecution execution, Exception e, String className) {

        Logger logger = Logger.getLogger(className);

        logger.info("\n\n  ... LoggerDelegate invoked by "
                + "processDefinitionId=" + execution.getProcessDefinitionId()
                + ", activtyId=" + execution.getCurrentActivityId()
                + ", activtyName='" + execution.getCurrentActivityName() + "'"
                + ", processInstanceId=" + execution.getProcessInstanceId()
                + ", businessKey=" + execution.getProcessBusinessKey()
                + ", executionId=" + execution.getId()
                + " \n\n"
                + "STACKTRACE\n"
                + Arrays.toString(e.getStackTrace()));
    }
}
