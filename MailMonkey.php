<?php 

require_once("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require_once("vendor/phpmailer/phpmailer/src/Exception.php");
require_once("vendor/phpmailer/phpmailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;

class MailMonkey {
    private PHPMailer $mail;
    private string $error;
    private string $templateFolder;
    private $config = "./config.json";

    public function __construct()
    {
        $this->config = json_decode(file_get_contents($this->config, true));
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPAuth = true; 
        $this->mail->SMTPSecure = 'tsl';
        $this->mail->Host = 'email-ssl.com.br'; 
        $this->mail->Port = 587;
        $this->mail->Username = $this->config->user;
        $this->mail->Password = $this->config->password;
        $this->mail->SetFrom($this->config->user, 'Projeto Tormenta');
        $this->mail->addReplyTo($this->from, 'Projeto Tormenta');
        $this->mail->IsHTML(true);
        $this->mail->CharSet = 'UTF-8';
    }

    /**
     * Method to set all necessary parametes to send an email
     * @param $sendTo string The email address to send to
     * @param $targeName string Name of the receiver
     * @param $subject string The email subject
     */
    public function prepare(string $sendTo, string $targeName, string $subject)
    {
        $this->mail->addAddress($sendTo, $targeName);
        $this->mail->Subject = $subject;
    }

    /**
     * Method used to set a simple message into the email body. Can also be a HTML text
     * @param $body string The message body
     */
    public function setMessage(string $body) 
    {
        $this->mail->Body = $body;
    }

    /**
     * Method to use an HTML page as a template for the email body
     * @param $templateName string The template name
     * @param $params array The parameters as an associated array
     */
    public function sendMessageUsingTemplate(string $templateName, array $params)
    {
        $templateToUse = file_get_contents($this->templateFolder . "/" . $templateName . ".html");
        foreach($params as $param => $value) { $templateToUse = str_replace($param, $value, $templateToUse); }
        $this->mail->Body = $templateToUse;
    }

    public function send()
    {
        if (!$this->mail->send()) {
            $this->error = $this->mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    public function getError()
    {
        return $this->error;
    }
}

?>