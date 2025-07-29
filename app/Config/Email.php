<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * The email address to send emails from.
     */
    public string $fromEmail = '';

    /**
     * The name to display in the "From" field of the email.
     */
    public string $fromName = '';

    /**
     * The email addresses to send emails to.
     */
    public string $recipients = '';

    /**
     * The "user agent" string to use in the email headers.
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol to use: 'mail', 'sendmail', or 'smtp'.
     */
    public string $protocol = 'mail';

    /**
     * The server path to the sendmail program.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * The hostname of the SMTP server.
     */
    public string $SMTPHost = '';

    /**
     * The username for SMTP authentication.
     */
    public string $SMTPUser = '';

    /**
     * The password for SMTP authentication.
     */
    public string $SMTPPass = '';

    /**
     * The port number for the SMTP server.
     */
    public int $SMTPPort = 25;

    /**
     * The timeout in seconds for SMTP connections.
     */
    public int $SMTPTimeout = 5;

    /**
     * Whether to enable persistent SMTP connections.
     */
    public bool $SMTPKeepAlive = false;

    /**
     * The encryption method for SMTP connections.
     * Possible values: '', 'tls', or 'ssl'.
     * 'tls' will issue a STARTTLS command to the server.
     * 'ssl' means implicit SSL. Connection on port 465 should set this to ''.
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Whether to enable word-wrapping in email bodies.
     */
    public bool $wordWrap = true;

    /**
     * The maximum number of characters per line in email bodies.
     */
    public int $wrapChars = 76;

    /**
     * The type of email content: 'text' or 'html'.
     */
    public string $mailType = 'text';

    /**
     * The character set for email content.
     */
    public string $charset = 'UTF-8';

    /**
     * Whether to validate email addresses.
     */
    public bool $validate = false;

    /**
     * The priority level for emails. 1 = highest, 5 = lowest, 3 = normal.
     */
    public int $priority = 3;

    /**
     * The newline character sequence to use in email bodies.
     * Use "\r\n" to comply with RFC 822.
     */
    public string $newline = "\r\n";

    /**
     * Whether to enable BCC batch mode for sending emails.
     */
    public bool $BCCBatchMode = false;

    /**
     * The maximum number of email addresses in each BCC batch.
     */
    public int $BCCBatchSize = 200;

    /**
     * Whether to enable delivery status notification from the email server.
     */
    public bool $DSN = false;
}