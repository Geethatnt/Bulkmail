<?php
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';

include 'includes/header.php';

/* Include PHPMailer autoloader */
require_once '../phpmailer/PHPMailerAutoload.php';

/*$formerror="";

$email="";
$password="";
$error_auth="";
$error_name="";
$error_passwd="";
$error_email="";
$validate=new Validation(); */

function sendmail($subject,$message){
    
    $mail = new PHPMailer(true);                // Passing `true` enables exceptions
    $mail = new PHPMailer;						//Create a new PHPMailer instance
    $mail->isSMTP();							//Tell PHPMailer to use SMTP
    $mail->SMTPDebug = 0;						//Enable SMTP debugging // 0 = off (for production use), 1 = client messages, 2 = client and server messages
    $mail->Host = 'smtp.gmail.com';				//Set the hostname of the mail server
    $mail->Port = 587;							//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->SMTPSecure = 'tls';					//Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPAuth = true;						//Whether to use SMTP authentication
    $mail->Username = "geethaacwd@gmail.com";	//Username to use for SMTP authentication - use full email address for gmail
    $mail->Password = "*******";			//Password to use for SMTP authentication
    $mail->setFrom('geethaacwd@gmail.com', 'ACWD Mailer');	//Set who the message is to be sent from
    $mail->addAddress('geethaacwd@gmail.com', 'ACWD Mailer');	//Set who the message is to be sent to
    
    $mail->isHTML(true);
    //Set the subject line
    //$subject = $_POST["subject"];
    $mail->Subject = $subject;
    //$message = $_POST["message"];
    $rootlink="http://localhost/phpcrudsample/public/";
    $link=$rootlink."unsubscribe.php";
    $mail->Body = $message . "<br><br>" . "To stop receiving newsletters and updates click <a href=" . $link . ">Unsubscribe</a>" . "<br>";
    $conn = mysqli_connect("127.0.0.1", "root", "******", "phpcrudsample");
    $sql = "SELECT  email FROM  tb_user WHERE  is_subscribed ='0' ";
    $result = $conn->query($sql);
    foreach ($result as $row){
        $mail->addBCC($row["email"]);
    }
    
    
    //$mail->addReplyTo('replyto@example.com', 'First Last');	//Set an alternative reply-to address
    //$mail->addAddress('acwdcapstone@gmail.com', 'ACWD Mailer');	//Set who the message is to be sent to
    
    
    
    if (!$mail->send()) {
        echo "Message could not be sent.";
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {echo "Email sent successfully <br><br>";}
    
    
}




//$mail->addBCC($email);	//data taken from table
//Everything needed for each email iteration needs to be in the parentheses







//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);



//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');




//send the message, check for errors



if ($_SERVER['REQUEST_METHOD']=='POST'){
    //$email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    //sendmail($email, $subject, $message);
    sendmail($subject,$message);
    //send bulk email
}

?>


<html>

<h1>Send a Newsletter</h1>
		<form method="POST" action="">
        	
			<!--<p><label for="email">Email:</label><br/>
			<input type="text" name="email">
			   </p>-->
			
			
        	<p><label for="subject">Subject:</label><br/>
        	<input type="text" id="subject" name="subject" size="50" /></p>
        	
        	<p><label for="message">Message Body:</label>
        	<textarea rows="5" cols="50" maxlength="256" name="message"></textarea>
			
        	<button type="submit" name="submit" value="submit">Submit</button>
        	</form>
</html>
<?php
include 'includes/footer.php';
?><?php
