<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

// Declare handler array
$declareHandler = [ "form1", "form2" ];

// Check POST request
if (isset($_POST["handlerAjaxForm"]) AND in_array($_POST["handlerAjaxForm"], $declareHandler))
{
    $api = new SendsAjaxForms($_POST["handlerAjaxForm"], $_POST);
    echo $api->response();
}
else
{
    echo "{ \"status\" : 0, \"message\" : \"handler not declared - " . $_POST["handlerAjaxForm"] . "\" }";
}


class SendsAjaxForms
{
    protected $requestHandler;          // Name get handler
    protected $requestPostData;         // Form data [$_POST]
    protected $mailSendContent = [];     // Content to send mail
    protected $response;

    public function __construct($handler, $post_data)
    {
        $this->requestHandler    = $handler;
        $this->requestPostData   = $post_data;

        $method_name = "handler_$this->requestHandler";

        if (method_exists($this, $method_name))
        {
            self::$method_name();
        }
        else
        {
            $this->response = [ "status" => 0, "message" => "handler not found as method in class" ];
        }
    }

    // =======================================
    // Pop-up form
    // =======================================

    protected function handler_form2()
    {
//        $this->mailSendContent["from_email"]    = "";
//        $this->mailSendContent["from_name"]     = "";
        $this->mailSendContent["to_email"]      = "zayats.and@gmail.com";
//        $this->mailSendContent["hidden_copy"]   = ["box1@mail.ru", "box2@mail.ru"];
        $this->mailSendContent["subject"]       = "Тестовое сообщение с лендинга";
        $this->mailSendContent["type_body"]     = "html";   // html or text
//        $this->mailSendContent["body"]          = file_get_contents('contents.html'), dirname(__FILE__);

        $this->mailSendContent["body"]  = "";
        $this->mailSendContent["body"] .= '
                                            <table border="0" cellpadding="0" cellspacing="0" class="body">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p>Заполнена форма обратной связи</p>
                                                            <p><b>Телефон: </b> ' . $this->requestPostData["modalUserPhoneNumber"] . '</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>';
//        $this->mailSendContent["body"] .= '
//                                            <html>
//                                                <head>
//                                                    <meta name="viewport" content="width=device-width" />
//                                                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
//                                                    <title>' . $this->mailSendContent["subject"] . '</title>
//                                                </head>
//                                                <body>
//                                                    <table border="0" cellpadding="0" cellspacing="0" class="body">
//                                                        <tbody>
//                                                            <tr>
//                                                                <td>
//                                                                    <p>Заполнена форма обратной связи</p>
//                                                                    <p><b>Телефон: </b> ' . $this->requestPostData["modalUserPhoneNumber"] . '</p>
//                                                                </td>
//                                                            </tr>
//                                                        </tbody>
//                                                    </table>
//                                                </body>
//                                            </html>';

        // Send
        $mail_send = $this->send_form();
        if ($mail_send == "Success send")
        {
            $this->response = [ "status" => 1, "message" => "success mail send" ];
        }
        else
        {
            $this->response = [ "status" => 0, "message" => "$mail_send" ];
        }
    }

    protected function send_form($smtp = NULL)
    {
        if ($smtp == NULL)
        {
            $smtp["host"] = SMTP_HOST;
            $smtp["port"] = SMTP_PORT;
            $smtp["user"] = SMTP_USER;
            $smtp["pass"] = SMTP_PASS;
        }

        $this->mailSendContent["from_email"] = (isset($this->mailSendContent["from_email"]) AND $this->mailSendContent["from_email"] !== "") ? $this->mailSendContent["from_email"] : SMTP_USER;
        $this->mailSendContent["from_name"] = (isset($this->mailSendContent["from_name"]) AND $this->mailSendContent["from_name"] !== "") ? $this->mailSendContent["from_name"] : SMTP_USER;

        //Create a new PHPMailer instance
        $mail = new PHPMailer;

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = SMTP_DEBUG;

        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        //Set the hostname of the mail server
        $mail->Host = $smtp["host"];

        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = $smtp["port"];

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = $smtp["user"];

        //Password to use for SMTP authentication
        $mail->Password = $smtp["pass"];

        //Charset
        $mail->CharSet = 'UTF-8';

        //Set who the message is to be sent from
        $mail->setFrom($this->mailSendContent["from_email"], $this->mailSendContent["from_name"]);

        //Set an alternative reply-to address
//        $mail->addReplyTo('replyto@example.com', 'First Last');

        //Set who the message is to be sent to
        $mail->addAddress($this->mailSendContent["to_email"]);

        //Set the subject line
        $mail->Subject = $this->mailSendContent["subject"];

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        if ($this->mailSendContent["type_body"] == "html")
        {
            $mail->isHTML(true);
            $mail->Body = $this->mailSendContent["body"];
        }
        else
        {
            //Replace the plain text body with one created manually
            $mail->msgHTML($this->mailSendContent["body"]);
//            $mail->AltBody = $this->mailSendContent["body"];
        }

        // hidden copy
        if (isset($this->mailSendContent["hidden_copy"]))
        {
            foreach($this->mailSendContent["hidden_copy"] as $email)
            {
                $mail->AddCC($email);
            }
        }

        //Attach an image file
//        $mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return "Success send";
        }
    }

    public function response()
    {
        $json_response = json_encode($this->response);
        return $json_response;
    }
}