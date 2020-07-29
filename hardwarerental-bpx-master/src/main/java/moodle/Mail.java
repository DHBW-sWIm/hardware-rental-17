package moodle;

import javax.mail.*;
import javax.mail.internet.*;
import java.util.Properties;

public class Mail {

    // set your SMTP Host
    private static final String SMTP_HOST = "hardware-rental-swim-process-mailhog";
    // set your email address. Be aware, that the email address does not exists, which should be made clear.
    private static final String SENDER = "noreply@moodle-dhbw.de";

    public static void send(String receiver, String subject, String content) throws MessagingException
    {
        Properties properties = System.getProperties();
        properties.setProperty( "mail.smtp.host", SMTP_HOST );
        properties.setProperty("mail.smtp.port", "1025");
        Session session = Session.getDefaultInstance( properties );
        MimeMessage message = new MimeMessage( session );
        message.setFrom( new InternetAddress( SENDER ) );
        message.addRecipient( Message.RecipientType.TO, new InternetAddress( receiver ) );
        message.setSubject( subject, "ISO-8859-1" );

        MimeBodyPart mimeBodyPart = new MimeBodyPart();
        mimeBodyPart.setContent(content, "text/html");

        Multipart multipart = new MimeMultipart();
        multipart.addBodyPart(mimeBodyPart);

        //TODO: send attachments - is that needed?
        message.setContent(multipart);

        Transport.send( message );
    }
}
