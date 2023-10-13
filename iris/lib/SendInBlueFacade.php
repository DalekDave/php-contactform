<?php
namespace Iris;

/**
 * Connection facade class for SendInBlue service.
 * Curl is used to communicate with SendInBlue
 * Curl part is not externalized, as it is not used anywhere else in the project.
 * If the need arises, externalize the Curl part to a common class.
 */
class SendInBlueFacade
{

    private $url = 'https://api.sendinblue.com/v3/smtp/email';

    private $apiKey = '';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    // $subject, $htmlBody, $senderName, $senderEmail, $recipient
    public function send($replyToEmail, $replyToName, $subject, $emailBodyHtml, $recipientArray, $ccArray, $bccArray, $attachmentArray, $senderEmail, $senderName)
    {
        $data = array(
            "htmlContent" => $emailBodyHtml,
            "subject" => $subject,
            "sender" => array(
                "name" => $senderName,
                "email" => $senderEmail
            ),
            "to" => [
                array(
                    "email" => $recipientArray[0]
                )
            ]
        );

        $encodedData = json_encode($data);
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

        $headers = array(
            "api-key: " . $this->apiKey,
            "accept: application/json",
            "Content-Type: application/json"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);

        // Uncomment the below block to debug
        // Debugging STARTS HERE
        // curl_setopt($curl, CURLOPT_VERBOSE, true);

        // $streamVerboseHandle = fopen('php://temp', 'w+');
        // curl_setopt($curl, CURLOPT_STDERR, $streamVerboseHandle);

        $result = curl_exec($curl);
        // $info = curl_getinfo($curl);

        // if ($result === FALSE) {
        // printf("cUrl error (#%d): %s<br>\n", curl_errno($curl), htmlspecialchars(curl_error($curl)));
        // }

        // rewind($streamVerboseHandle);
        // $verboseLog = stream_get_contents($streamVerboseHandle);

        // echo "cUrl verbose information:\n", "<pre>", htmlspecialchars($verboseLog), "</pre>\n";
        // print $result;
        // echo "<pre>";
        // print_r($info);
        // echo "</pre>\n";
        // Debugging ENDS HERE

        $isMailSent = true;

        if (curl_errno($curl)) {
            // curl level error like network or transport error
            $isMailSent = false;
            $errorMessage = 'Error: ' . curl_error($curl);
        } else {
            // now lets check for error spit from SendInBlue
            // error response format from sendinblue
            // Ref: https://developers.sendinblue.com/docs/how-it-works#format
            // {
            // "code": "invalid_parameter",
            // "message": "Invalid email address"
            // }
            $resultArray = json_decode($result, true);
            if (isset($resultArray["code"])) {
                $isMailSent = false;
                $errorMessage = 'Error: ' . $resultArray["message"];
            }
        }

        if (! $isMailSent) {
            $resultArray = array(
                'type' => 'error',
                'text' => $errorMessage
            );
        } else {
            $resultArray = array(
                'type' => 'message',
                'text' => 'Hi, thank you for the message.'
            );
        }
        curl_close($curl);
        $mailResult = json_encode($resultArray);
        return $mailResult;
    }
}
