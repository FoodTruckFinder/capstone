<?php


require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once (dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once ("/etc/apache2/capstone-mysql/Secrets.php");

use \FoodTruckFinder\Capstone\Profile;

/**
 * API for handling sign-in
 *
 * @author dnakitare@cnm.edu
 */

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare and empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
	$pdo = $secrets->getPdoObject();

	// determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {
		// decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		var_dump($requestObject);

		// profile email is a required field
		if(empty($requestObject->profileEmail)  === true) {
			throw (new \InvalidArgumentException("No profile email present", 405));
		}

		// verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw (new	\InvalidArgumentException("Must input valid password", 405));
		}

		// verify that confirm password is present
		if(empty($requestObject->profilePasswordConfirm) === true) {
			throw (new	\InvalidArgumentException("Must input valid password", 405));
		}

		// verify that profile name is present
		if(empty($requestObject->profileName) === true) {
			throw (new	\InvalidArgumentException("Must input profile name", 405));
		}

		// make sure the password and confirm password match
		if($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw (new \InvalidArgumentException("Password do not match"));
		}

		$hash = password_hash($requestObject->profilePassword, PASSWORD_ARGON2I, ["time_cost" => 384]);

		$profileActivationToken = bin2hex(random_bytes(16));

		// create the profile object and prepare to insert into the database
		$profile = new Profile(generateUuidV4(), $profileActivationToken, $requestObject->profileEmail, $hash, 0, $requestObject->profileName);
		var_dump($profile);
		// insert the profile into the database
		$profile->insert($pdo);

		// compose the email message to sen with the activation token
		$messageSubject = "Food trucks spotted on the horizon -- Account Activation";

		// building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		// make sure URL is /public_html/pai/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		// create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;
		// create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		// compose message to send with email
		$message = <<< EOF
<h2>Welcome to 505 Food Truck Finder.</h2>
<p>In order to sign in you must confirm your account</p>
<p><a href="$confirmLink">Confirmation Link</a></p>
EOF;

		// create swift email
		$swiftMessage = new Swift_Message();
		// attach the sender to the message
		// this takes the form of associative array where the email is the key to a real name
		$swiftMessage->setFrom(["505foodtruckfinder@gmail.com" => "505FoodTruckFinder"]);

		/**
		 * attach recipients to the message
		 * notice this is an array that can include or omit the recipient's name
		 * use the recipient's real name where possible;
		 * this reduces the probability of the email is marked as spam
		 */
		//define who the recipient is
		$recipients = [$requestObject->profileEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);
		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);


		/**
		 * attach the message to the email
		 * set the two versions of the message: a html formatted version and a filter_var()ed version of the message, plain text
		 */
		// attach the html version of the message
		$swiftMessage->setBody($message, "text/html");
		// attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		/**
		 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
		 * this default may or may not be available on all web hosts; consult their documentation/support for details
		 *SwiftMailer supports many different transport methods; SMTP was chosen because it is the most compatible and has the best error handling
		 *@see http://swiftmailer.org/docs/sending.html Documentation
		 */
		// setup smtp
		$smtp = new Swift_SmtpTransport(
			"localhost", 25
		);
		$mailer = new Swift_Mailer($smtp);

		// send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);

		/**
		 * the send method returns the number of recipients that accepted the Email, if the number attempted is not he number accepted, this is an Exception
		 */
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains an array of Emails that failed
			throw (new RuntimeException("Unable to send email", 400));
		}

		// update reply
		$reply->message = "Thank you for creating a profile with 505 Food Truck Finder";
	} else {
		throw (new	InvalidArgumentException("invalid http request"));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}

// sets up the response header
header("Content-type: application/json");
// finally, JSON encode the $reply object and echo it back to the front end
echo json_encode($reply);