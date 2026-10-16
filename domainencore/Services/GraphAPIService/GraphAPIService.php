<?php

namespace  domainencore\Services\GraphAPIService;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Microsoft\Graph\Model\Message;
use Microsoft\Graph\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use App\Models\OrganizationEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use App\Models\Contact;
use DateTime;
use DateTimeZone;


class GraphAPIService
{
    protected $client;
    protected $graph;


    public function __construct()
        {
            $this->client = new Client([
                'base_uri' => 'https://graph.microsoft.com/v1.0/',
                'timeout' => 10,
            ]);
            $this->graph = new Graph();

        }



    public function getInboxMessages($accessToken, $pageNumber)
        {
            try {
                $tz = Auth::user()->userDetails->timezone;
                $messagesPerPage = 50;
                // Calculate the $skip value based on the page number
                $skip = ($pageNumber - 1) * $messagesPerPage;

                // Get the user's email filter preference
                // $filter = 1;
                $filter = Auth::user()->emailFilter->filter ?? 0;

                // Define query parameters
                $queryParams = [
                    '$top' => $messagesPerPage, // Number of messages to retrieve per page
                    '$skip' => $skip, // Number of messages to skip (pagination)
                ];

                // If the filter is 1, add a query parameter to get only unread messages
                if ($filter == 1) {
                    $queryParams['$filter'] = 'isRead eq false';
                }

                $response = $this->client->request('GET', 'me/mailFolders/inbox/messages', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json',
                    ],
                    'query' => $queryParams,
                ]);

                $responseData = json_decode($response->getBody(), true);

                $messages = [];

                // Loop through each message and construct the message array
                foreach ($responseData['value'] ?? [] as $message) {
                    $subject = $message['subject'] ?? '';
                    $from = $message['from']['emailAddress']['name'] ?? '';
                    $replyTo = $message['replyTo'][0]['emailAddress']['address'] ?? '';
                    $receivedDateTime = $message['receivedDateTime'] ?? '';
                    $id = $message['id'] ?? '';
                    $importance = $message['importance'] ?? '';
                    $status = $message['isRead'] ?? '';
                    $flagStatus = $message['flag']['flagStatus'] ?? '';

                    // Format date if receivedDateTime is available
                    $date = '';
                    if ($receivedDateTime) {
                        try {
                            // Create DateTime object from receivedDateTime
                            $dateTime = new DateTime($receivedDateTime);

                            // Set the timezone you want to convert to
                            $timezone = new DateTimeZone($tz); // You can change this to any timezone
                            $dateTime->setTimezone($timezone);

                            // Format the date as needed
                            $date = $dateTime->format('Y-m-d H:i:s');
                        } catch (Exception $e) {
                            // Handle the exception if date conversion fails
                            $date = $receivedDateTime; // Fallback to original date string
                        }
                    }

                    // Construct the message array and add it to the messages array
                    $messages[] = [
                        'Subject' => $subject,
                        'From' => $from,
                        'To' => $replyTo,
                        'Date' => $date,
                        'Message_ID' => $id,
                        'Msgno' => $id,
                        'Importance' => $importance,
                        'Status' => $status,
                        'flagStatus' => $flagStatus
                    ];
                }

                // Sort messages by status and date
                usort($messages, function ($a, $b) {
                    // Sort by 'Status' with false values first
                    if ($a['Status'] !== $b['Status']) {
                        return ($a['Status'] === false) ? -1 : 1;
                    }
                    // If status is equal, sort by 'Date'
                    return strtotime($b['Date']) - strtotime($a['Date']);
                });

                // // Format the date for display
                // foreach ($messages as &$message) {
                //     if ($message['Date']) {
                //         $message['Date'] = date('d M', strtotime($message['Date']));
                //     }
                // }

                return $messages;
            } catch (\Exception $e) {
                // Handle exceptions here
                return $e;
            }
        }

    public function getFolderMessages($accessToken, $folderId, $pageNumber)
        {
            try {
                $messagesPerPage = 50;
                // Calculate the $skip value based on the page number
                $skip = ($pageNumber - 1) * $messagesPerPage;

                // Get the user's email filter preference
                // $filter = 1;
                $filter = Auth::user()->emailFilter->filter ?? 0;

                // Define query parameters
                $queryParams = [
                    '$top' => $messagesPerPage, // Number of messages to retrieve per page
                    '$skip' => $skip, // Number of messages to skip (pagination)
                ];

                // If the filter is 1, add a query parameter to get only unread messages
                if ($filter == 1) {
                    $queryParams['$filter'] = 'isRead eq false';
                }

                $response = $this->client->request('GET', "me/mailFolders/$folderId/messages", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json',
                    ],
                    'query' => $queryParams,
                ]);

                $responseData = json_decode($response->getBody(), true);
                $messages = [];

                // Loop through each message and construct the message array
                foreach ($responseData['value'] ?? [] as $message) {
                    $subject = $message['subject'] ?? '';
                    $from = $message['from']['emailAddress']['name'] ?? '';
                    $replyTo = $message['toRecipients'][0]['emailAddress']['address'] ?? '';
                    $receivedDateTime = $message['receivedDateTime'] ?? '';
                    $id = $message['id'] ?? '';
                    $importance = $message['importance'] ?? '';
                    $status = $message['isRead'] ?? '';
                    $flagStatus = $message['flag']['flagStatus'] ?? '';

                    // Format date if receivedDateTime is available
                    $date = '';
                    if ($receivedDateTime) {
                        $date = $receivedDateTime;
                    }

                    // Construct the message array and add it to the messages array
                    $messages[] = [
                        'Subject' => $subject,
                        'From' => $from,
                        'To' => $replyTo,
                        'Date' => $date,
                        'Message_ID' => $id,
                        'Msgno' => $id,
                        'Importance' => $importance,
                        'Status' => $status,
                        'flagStatus' => $flagStatus
                    ];
                }

                // Sort messages by status and date
                usort($messages, function ($a, $b) {
                    // Sort by 'Status' with false values first
                    if ($a['Status'] !== $b['Status']) {
                        return ($a['Status'] === false) ? -1 : 1;
                    }
                    // If status is equal, sort by 'Date'
                    return strtotime($b['Date']) - strtotime($a['Date']);
                });

                // Format the date for display
                foreach ($messages as &$message) {
                    if ($message['Date']) {
                        $message['Date'] = date('d M', strtotime($message['Date']));
                    }
                }

                return $messages;
            } catch (\Exception $e) {
                // Handle exceptions here
                return $e;
            }
        }

    public function searchAllMail($accessToken, $searchText, $pageNumber)
    {
        try {
            $messagesPerPage = 50;
            $messages = [];
            $searchQuery =  "?\$search=\"$searchText\"";
            $nextLink = null;
            $pagedData = [];
            do {
                $graphApiUrl = $nextLink ?: "https://graph.microsoft.com/v1.0/me/messages" . $searchQuery;
                $response = Http::withToken($accessToken)->get($graphApiUrl);
                $data = $response->json()['value'];
                $pagedData = array_merge($pagedData, $data);
                $nextLink = isset($response->json()['@odata.nextLink']) ? $response->json()['@odata.nextLink'] : null;
                // $nextLink = null;

            } while ($nextLink );
            $totalItemCount = count($pagedData);


            // Calculate start and end index for pagination
            $start = ($pageNumber - 1) * $messagesPerPage;
            $end = $start + $messagesPerPage;

            // Slice the messages array to get the relevant subset of data
            $messages = array_slice($pagedData, $start, $messagesPerPage);

            foreach ($messages as $message) {
                // Add message to the array if within the desired range

                    $subject = $message['subject'] ?? '';
                    $from = $message['from']['emailAddress']['name'] ?? '';
                    $replyTo = $message['replyTo'][0]['emailAddress']['address'] ?? '';
                    $receivedDateTime = $message['receivedDateTime'] ?? '';
                    $id = $message['id'] ?? '';
                    $importance = $message['importance'] ?? '';
                    $status = $message['isRead'] ?? '';
                    $flagStatus = $message['flag']['flagStatus'] ?? '';

                    // Format date if receivedDateTime is available
                    $date = '';
                    if ($receivedDateTime) {
                        $date = date('d M', strtotime($receivedDateTime));
                    }

                    // Construct the message array and add it to the messages array
                    $chats[] = [
                        'Subject' => $subject,
                        'From' => $from,
                        'To' => $replyTo,
                        'Date' => $date,
                        'Message_ID' => $id,
                        'Msgno' => $id,
                        'Importance' => $importance,
                        'Status' => $status,
                        'flagStatus' => $flagStatus
                    ];

            }
            return [
                'messages' => $chats,
                'totalItemCount' => $totalItemCount
            ];
        } catch (\Exception $e) {
            // Handle exceptions here
            return $e;
        }
    }







    public function get($url, $headers)
    {
        return Http::withHeaders($headers)->get($url);
    }

    public function GetMailFolders($accessToken){

        $graphApiUrl = "https://graph.microsoft.com/v1.0/me/mailFolders";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        // Set the $top parameter to a high number to get all mail folders
        $queryParameters = [
            '$top' => 999, // Replace 999 with the maximum number of folders you expect
            '$select' => 'id,displayName,TotalItemCount,unreadItemCount',
            '$expand' => 'childFolders',
        ];

        $response = Http::withHeaders($headers)->get($graphApiUrl, $queryParameters);

        if ($response->successful()) {
            $mailFolders = $response->json();
            // dd($mailFolders['value']);
            return $mailFolders['value'];
        }
    }
    public function getEmailThread($accessToken, $messageId, $mailbox_id)
    {
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        // Fetch the specific message by its ID
        $message = $graph->createRequest("GET", "/me/messages/{$messageId}")
                        ->setReturnType(Message::class)
                        ->execute();

        // Retrieve the thread ID from the conversation ID of the message
        $conversationId = $message->getConversationId();

        function fetchAllMessages($graph, $url) {
            $allMessages = [];

            do {
                // Fetch messages from the current URL
                $response = $graph->createRequest("GET", $url)
                                  ->execute(); // This returns a GraphResponse object

                // Convert the GraphResponse to an array using getBody()
                $responseBody = $response->getBody();

                // Check if the response contains the 'value' key with messages
                if (isset($responseBody['value'])) {
                    // Loop through each raw message and cast it into a Message object
                    foreach ($responseBody['value'] as $rawMessage) {
                        // Create a Message object from the raw data
                        $message = new Message($rawMessage);
                        // Add the Message object to the array
                        $allMessages[] = $message;
                    }
                }

                // Check if there's a next page (@odata.nextLink)
                $nextLink = $responseBody['@odata.nextLink'] ?? null;

                // Set the URL to the next page if available
                $url = $nextLink;

            } while ($nextLink);

            return $allMessages; // Return the array of Message objects
        }
        // Fetch all received messages in the thread
        $receivedMessagesUrl = "/me/mailFolders/{$mailbox_id}/messages?\$filter=conversationId eq '{$conversationId}'";
        $receivedMessages = fetchAllMessages($graph, $receivedMessagesUrl);

        // Fetch all sent messages in the thread
        $sentMessagesUrl = "/me/mailFolders/SentItems/messages?\$filter=conversationId eq '{$conversationId}'";
        $sentMessages = fetchAllMessages($graph, $sentMessagesUrl);

        // Combine received and sent messages
        $threadMessages = array_merge($receivedMessages, $sentMessages);

        // Deduplicate messages based on message ID
        $uniqueMessages = [];
        $uniqueMessages2 = [];
        $unlinkedMessageIds = [];
        $orglinkedstatus = false;
        $org_id = null ;


        foreach ($threadMessages as $message) {

            $messageId =  $message->getId();
            $Sender =  $message->getSender();
            $senderAddress = $Sender->getEmailAddress()->getAddress();

            if (empty($org_id) && $org_id == null) {

                $internetmessage_id =  $message->getInternetMessageId();
                $existingEmail = OrganizationEmail::where('message_no', $messageId)->orWhere('internetmessage_id', $internetmessage_id)->orWhere('conversation_id', $conversationId)->latest('updated_at')->first();

                if ($existingEmail) {
                    $org_id = $existingEmail->organization_id;
                    $orglinkedstatus = true;
                }else if(!empty($senderAddress) && strpos($senderAddress, '@encorebrand.com') === false && strpos($senderAddress, '@encorecustom.com') === false){
                    $contact = Contact::with('contactOrganizations')->where('email', $senderAddress)->where('active', 1)->first();

                    if ($contact && $contact->contactOrganizations->count() == 1) {
                        $organization = $contact->contactOrganizations->first();
                        $org_id = $organization ? $organization->organization_id : null;
                        $organization ? $orglinkedstatus = true : $orglinkedstatus = false;
                    } else {
                        $org_id = null;
                    }
                }else{
                    $org_id = null;
                }

            }

            $IsthisMailLinked = OrganizationEmail::where('message_no', $messageId)->exists();
            if(!$IsthisMailLinked){
                $unlinkedMessageIds[] = $messageId;
            }
            if (!isset($uniqueMessages[$messageId])) {
                $uniqueMessages[$messageId] = $message;
                $uniqueMessages2[] = $message;
            }
        }

        $syncingDetails=[
            'unlinkedMessageIds'=>$unlinkedMessageIds,
            'organizationId'    =>$org_id,
            'orglinkedstatus'   =>$orglinkedstatus,
            'countOfRecMessage' =>count($receivedMessages)
        ];

        usort($uniqueMessages2, function($a, $b) {
            // Assuming $a and $b are instances of Message class and you want to sort them based on receivedDateTime
            $receivedDateTimeA = $a->getReceivedDateTime()->format('Y-m-d H:i:s');
            $receivedDateTimeB = $b->getReceivedDateTime()->format('Y-m-d H:i:s');
            // Compare $receivedDateTimeA and $receivedDateTimeB
            return strcmp($receivedDateTimeB, $receivedDateTimeA);
        });

        // Process attachments and modify message body content
        $resultMessages = [];
        $allAttachments = []; // Initialize an empty array to store all attachments
        $tz = Auth::user()->userDetails->timezone;
        $timezone = new DateTimeZone($tz);


        foreach ($uniqueMessages2 as $message) {
            // dd($message);
            $messageNo = $message->getId();
            $bodyContent = $message->getBody()->getContent();
            $receivedDateTime = $message->getReceivedDateTime();
            if ($receivedDateTime) {
                $receivedDateTime->setTimezone($timezone);
                $formattedDate = $receivedDateTime->format('m/d/Y H:i');
            } else {
                $formattedDate = '';
            }

            $resultMessages[] = [
                    'message' => $message,
                    'formatted_date' => $formattedDate,
                ];

        }

        return [
            'resultMessages' => $resultMessages,
            'syncingDetails' => $syncingDetails,
        ];
    }

    public function getUserSignature($accessToken) {
        // Make a request to Microsoft Graph API to fetch user's mailbox settings
        $client = new Client([
            'base_uri' => 'https://graph.microsoft.com/v1.0/',
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ],
        ]);

        // Example: Get mailbox settings
        $response = $client->get('me/mailboxSettings');
        $mailboxSettings = json_decode($response->getBody()->getContents(), true);

        return $mailboxSettings;
    }
    public function moveMessage($accessToken, $messageId, $destinationFolderId)
    {
        $graphApiUrl = "https://graph.microsoft.com/v1.0/me/messages/$messageId/move";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        $data = [
            'destinationId' => $destinationFolderId,
        ];

        $response = Http::withHeaders($headers)->post($graphApiUrl, $data);

        if ($response->successful()) {
            // Message moved successfully
            return true;
        } else {
            // Handle the case where the request is not successful
            return false;
        }
    }
    public function deleteMessage($accessToken, $messageId)
    {
        $graphApiUrl = "https://graph.microsoft.com/v1.0/me/messages/$messageId";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        $response = Http::withHeaders($headers)->delete($graphApiUrl);

        return $response->successful();
    }
    public function markAsUnreadMessage($accessToken, $messageId)
    {
        $graphApiUrl = "https://graph.microsoft.com/v1.0/me/messages/$messageId";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        // Request body to mark the message as unread
        $data = [
            'isRead' => false,
        ];

        $response = Http::withHeaders($headers)->patch($graphApiUrl, $data);

        return $response->successful();
    }
    public function markAsReadMessage($accessToken, $messageId)
    {
        $graphApiUrl = "https://graph.microsoft.com/v1.0/me/messages/$messageId";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        // Request body to mark the message as unread
        $data = [
            'isRead' => true,
        ];

        $response = Http::withHeaders($headers)->patch($graphApiUrl, $data);

        return $response->successful();
    }
    public function toggleFlag($accessToken, $messageId)
    {
        // Check if the message is currently flagged
        $isFlagged = $this->isMessageFlagged($accessToken, $messageId);

        // Toggle the flag status
        if ($isFlagged) {
            // If the message is flagged, remove the flag
            return $this->removeFlag($accessToken, $messageId);
        } else {
            // If the message is not flagged, add the flag
            return $this->addFlag($accessToken, $messageId);
        }
    }

    private function isMessageFlagged($accessToken, $messageId)
    {
        // Retrieve message details to check flag status
        $graphApiUrl = "https://graph.microsoft.com/v1.0/me/messages/$messageId";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        $response = Http::withHeaders($headers)->get($graphApiUrl);

        if ($response->successful()) {
            $message = $response->json();
            return isset($message['flag']) && $message['flag']['flagStatus'] === 'flagged';
        } else {
            // Handle unsuccessful response
            throw new \Exception('Failed to retrieve message details');
        }
    }
    public function addFlag($accessToken, $messageId)
    {
        return $this->setFlagStatus($accessToken, $messageId, true);
    }

    public function removeFlag($accessToken, $messageId)
    {
        return $this->setFlagStatus($accessToken, $messageId, false);
    }

    private function setFlagStatus($accessToken, $messageId, $flagStatus)
    {
        $graphApiUrl = "https://graph.microsoft.com/v1.0/me/messages/$messageId";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        $data = [
            'flag' => [
                'flagStatus' => $flagStatus ? 'flagged' : 'notFlagged',
            ],
        ];

        $response = Http::withHeaders($headers)->patch($graphApiUrl, $data);

        return $response->successful();
    }

    public function getUserProfile($accessToken)
    {
        try {
            // Make the request to Microsoft Graph API
            $response = $this->client->request('GET', 'me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);

            // Handle the successful response
            $data = json_decode($response->getBody(), true);

            // Process the response data
            // ...

            // Return the response data
            return true;

        } catch (ClientException $exception) {
            // Handle client exceptions (e.g., 401 Unauthorized)
            if ($exception->getResponse() && $exception->getResponse()->getStatusCode() === 401) {
                // Token expired, return an error response
                return  false;
            } else {
                // Handle other client exceptions
                // Log the exception or return a generic error response
                return  false;
            }
        }
    }
    public function getEmailMessageDetails($messageId, $accessToken)
    {
        $graph = new Graph();
        $graph->setAccessToken($accessToken);


        // Get the logged user's email address
        $graphApiUrlUser = "https://graph.microsoft.com/v1.0/me";
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        // Create context options including headers
        $contextOptions = [
            'http' => [
                'header' => implode("\r\n", $headers),
            ],
        ];

        // Create context
        $context = stream_context_create($contextOptions);

        try {
            // Make the HTTP request to get the logged user's email address
            $responseUser = file_get_contents($graphApiUrlUser, false, $context);

            // Check if the request was successful
            if ($responseUser === false) {
                return "Error occurred while fetching user details.";
            }

            // Parse the JSON response
            $userDetails = json_decode($responseUser, true);
            $loggedUserEmail = $userDetails['mail'];

            // Make the HTTP request to get the message details
            $graphApiUrlMessage = "https://graph.microsoft.com/v1.0/me/messages/{$messageId}";
            $responseMessage = file_get_contents($graphApiUrlMessage, false, $context);

            // Check if the request was successful
            if ($responseMessage === false) {
                return "Error occurred while fetching message details.";
            }

            // Parse the JSON response
            $messageDetails = json_decode($responseMessage, true);

            // Extract the necessary details from $messageDetails
            $subject = $messageDetails['subject'];
            $sender = isset($messageDetails['sender']) ? $messageDetails['sender']['emailAddress']['address'] : '';
            $senderName = isset($messageDetails['sender']) ? $messageDetails['sender']['emailAddress']['name'] : '';
            $date = $messageDetails['receivedDateTime'] ?? '';
            $toRecipientsfull = $messageDetails['toRecipients'];
            $ccRecipientsfull = $messageDetails['ccRecipients'];
            $bccRecipientsfull = $messageDetails['bccRecipients'];
            $parentFolderId = $messageDetails['parentFolderId'];

            // Filter recipients to exclude the logged user's email
            $toRecipients = array_filter($messageDetails['toRecipients'], function($recipient) use ($loggedUserEmail) {
                return $recipient['emailAddress']['address'] !== $loggedUserEmail;
            });

            $ccRecipients = array_filter($messageDetails['ccRecipients'], function($recipient) use ($loggedUserEmail) {
                return $recipient['emailAddress']['address'] !== $loggedUserEmail;
            });

            $bccRecipients = array_filter($messageDetails['bccRecipients'], function($recipient) use ($loggedUserEmail) {
                return $recipient['emailAddress']['address'] !== $loggedUserEmail;
            });

            $body = $messageDetails['body']['content']; // Assuming you want the content of the body

            // Fetch attachments
            $responseAtt = $graph->createRequest('GET', "/me/messages/{$messageId}/attachments")
                ->execute();

            $attachments = $responseAtt->getBody()['value'];

            // Process attachments for each message
            foreach ($attachments as $attachment) {
                $attachmentId = $attachment['id'];
                $attachmentName = $attachment['name'];
                $contentType = $attachment['contentType'];
                $contentId = $attachment['contentId'] ?? "";

                if (isset($attachment['contentBytes'])) {
                    // Get the base64-encoded content of the attachment
                    $attachmentContent = $attachment['contentBytes'];

                    // Ensure contentId is present and referenced correctly in the email body
                    if (!empty($contentId)) {
                        // Replace cid references in the email body with base64 encoded attachment content
                        $body = str_replace("cid:{$contentId}", "data:$contentType;base64,".$attachmentContent, $body);
                    }
                }
            }

            // Construct the details array
            $details = [
                'subject' => $subject,
                'sender' => $sender,
                'to' => array_values($toRecipients), // Re-index the array
                'cc' => array_values($ccRecipients), // Re-index the array
                'bcc' => array_values($bccRecipients), // Re-index the array
                'body' => $body,
                'date' => $date,
                'toRecipientsfull' =>$toRecipientsfull,
                'ccRecipientsfull' =>$ccRecipientsfull,
                'bccRecipientsfull' =>$bccRecipientsfull,
                'parentFolderId' => $parentFolderId,
                'senderName' => $senderName,
                // Add more fields as needed
            ];

            return $details;
        } catch (\Exception $e) {
            // Handle exceptions here
            return $e->getMessage(); // Return the error message for debugging
        }
    }
    public function getEmailMessageAttachments($messageId, $accessToken)
    {
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        try {
            // Make the HTTP request to get the message attachments
            $graphApiUrlAttachments = "https://graph.microsoft.com/v1.0/me/messages/{$messageId}/attachments";
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ];

            // Create context options including headers
            $contextOptions = [
                'http' => [
                    'header' => implode("\r\n", $headers),
                ],
            ];

            // Create context
            $context = stream_context_create($contextOptions);

            // Fetch attachments
            $responseAttachments = file_get_contents($graphApiUrlAttachments, false, $context);

            // Check if the request was successful
            if ($responseAttachments === false) {
                return "Error occurred while fetching attachments.";
            }

            // Parse the JSON response
            $attachments = json_decode($responseAttachments, true)['value'];

            // Initialize an array to store attachment details
            $attachmentDetails = [];

            // Process each attachment
            foreach ($attachments as $attachment) {
                $attachmentId = $attachment['id'];
                $attachmentName = $attachment['name'];
                $isInline = $attachment['isInline'] ?? false;
                $contentId = $attachment['contentId'] ?? '';

                // Fetch attachment content
                $graphApiUrlContent = "https://graph.microsoft.com/v1.0/me/messages/{$messageId}/attachments/{$attachmentId}/\$value";
                $responseContent = file_get_contents($graphApiUrlContent, false, $context);

                if ($responseContent === false) {
                    return "Error occurred while fetching attachment content.";
                }

                // Generate a unique filename for the attachment
                $filename = uniqid() . '_' . $attachmentName;

                // Add attachment details to array
                $attachmentDetails[] = [
                    'id' => $attachmentId,
                    'name' => $attachmentName,
                    'filename' => $filename,
                    'isInline' => $isInline,
                    'contentId' => $contentId,
                    'content' => base64_encode($responseContent), // Optionally encode to base64
                ];
            }

            // Return the array of attachment details
            return $attachmentDetails;

        } catch (\Exception $e) {
            // Handle exceptions here
            return $e->getMessage(); // Return the error message for debugging
        }
    }


    public function getConversationDetails($messageId, $accessToken) {
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        // Get the logged user's email address
        $graphApiUrlUser = "https://graph.microsoft.com/v1.0/me";
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        // Create context options including headers
        $contextOptions = [
            'http' => [
                'header' => implode("\r\n", $headers),
            ],
        ];

        // Create context
        $context = stream_context_create($contextOptions);

        try {
            // Make the HTTP request to get the logged user's email address
            $responseUser = file_get_contents($graphApiUrlUser, false, $context);

            // Check if the request was successful
            if ($responseUser === false) {
                return "Error occurred while fetching user details.";
            }

            // Parse the JSON response
            $userDetails = json_decode($responseUser, true);
            $loggedUserEmail = $userDetails['mail'];

            // Make the HTTP request to get the message details
            $graphApiUrlMessage = "https://graph.microsoft.com/v1.0/me/messages/{$messageId}";
            $responseMessage = file_get_contents($graphApiUrlMessage, false, $context);

            // Check if the request was successful
            if ($responseMessage === false) {
                return "Error occurred while fetching message details.";
            }

            // Parse the JSON response
            $messageDetails = json_decode($responseMessage, true);

            // Extract the conversation ID from the message details
            $conversationId = $messageDetails['conversationId'];

            // Make the HTTP request to get messages in the conversation
            $receivedMessages = $graph->createRequest("GET", "/me/messages?\$filter=conversationId eq '{$conversationId}'")
                                        ->setReturnType(Message::class)
                                        ->execute();

            // Initialize arrays for recipients
            $toRecipients = [];
            $ccRecipients = [];
            $bccRecipients = [];

            $subject = $receivedMessages[0]->getSubject();

            // Loop through all messages in the conversation
            foreach ($receivedMessages as $message) {

                // Skip if the message is not in the inbox or sent items
                // if (!in_array($message->getParentFolderId(), ["inbox", "sentitems"])) {
                //     continue;
                // }
                $sender = $message->getSender()->getEmailAddress()->getAddress();


                if ($sender !== $loggedUserEmail) {
                    $toRecipients[] = $sender;
                }
                // Add to recipients

                foreach ($message->getToRecipients() as $recipient) {

                    if ($recipient['emailAddress']['address'] !== $loggedUserEmail) {
                        $toRecipients[] = $recipient['emailAddress']['address'];
                    }
                }
                // Add cc recipients
                foreach ($message->getCcRecipients() as $recipient) {
                    if ($recipient['emailAddress']['address'] !== $loggedUserEmail) {
                        $ccRecipients[] = $recipient['emailAddress']['address'];
                    }
                }
                // Add bcc recipients
                foreach ($message->getBccRecipients() as $recipient) {
                    if ($recipient['emailAddress']['address'] !== $loggedUserEmail) {
                        $bccRecipients[] = $recipient['emailAddress']['address'];
                    }
                }
            }

            // Remove duplicates from recipients arrays
            $toRecipients = array_unique($toRecipients);
            $ccRecipients = array_unique($ccRecipients);
            $bccRecipients = array_unique($bccRecipients);

            // Construct the details array
            $details = [
                'subject' => $subject,
                'to' => $toRecipients,
                'cc' => $ccRecipients,
                'bcc' => $bccRecipients,

                // Add more fields as needed
            ];

            return $details;
        } catch (\Exception $e) {
            // Handle exceptions here
            return $e->getMessage(); // Return the error message for debugging
        }
    }
    public function linkAllChatToOrg($messageNo,$receivedMessages_count,$org_id,$orglinkedstatus,$accessToken){

        $tz = Auth::user()->userDetails->timezone;
        $timezone = new DateTimeZone($tz);
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $allAttachments =[];
        $message = $graph->createRequest("GET", "/me/messages/{$messageNo}")
                        ->setReturnType(Message::class)
                        ->execute();

        $responseAtt = $graph->createRequest('GET', "/me/messages/{$messageNo}/attachments")
                                ->execute();

        $attachments = $responseAtt->getBody()['value'];

        // Append the attachments to the allAttachments array
        $allAttachments = array_merge($allAttachments, $attachments);



        $bodyContent = $message->getBody()->getContent();
        $receivedDateTime = $message->getReceivedDateTime();
        if ($receivedDateTime) {
            $receivedDateTime->setTimezone($timezone);
            $formattedDate = $receivedDateTime->format('m/d/Y H:i');
        } else {
            $formattedDate = '';
        }

        $attachmentDetails = [];
        // Process attachments for each message
        foreach ($attachments as $attachment) {
            $attachmentId = $attachment['id'];
            $attachmentName = $attachment['name'];
            $contentId = $attachment['contentId'] ?? "";
            $isInline = $attachment['isInline'] ?? false;
            $contentType = $attachment['contentType'];
            // Fetch attachment content using Microsoft Graph SDK
            $responseContent = $graph->createRequest('GET', "/me/messages/{$messageNo}/attachments/{$attachmentId}/\$value")
                                    ->execute();

            $attachmentContent = $responseContent->getRawBody();

            // Generate a unique filename for the attachment
            $filename = uniqid() . '_' . $attachmentName;

            // Add attachment details to array
            $attachmentDetails[] = [
                'id' => $attachmentId,
                'name' => $attachmentName,
                'contentId' => $contentId,
                'filename' => $filename,
                'content' => base64_encode($attachmentContent), // Optionally encode to base64
                'isInline' => $isInline,
            ];

            // // Replace cid references in the email body with attachment content
            // if ($contentId) {
            //     $bodyContent = str_replace("cid:{$contentId}", "data:image/png;base64," . base64_encode($attachmentContent), $bodyContent);
            // }
            if (isset($attachment['contentBytes'])) {
                // Get the base64-encoded content of the attachment
                $attachmentContent = $attachment['contentBytes'];

                // Ensure contentId is present and referenced correctly in the email body
                if (!empty($contentId)) {
                    // Replace cid references in the email body with base64 encoded attachment content
                    $bodyContent = str_replace("cid:{$contentId}", "data:$contentType;base64,".$attachmentContent, $bodyContent);
                }
            }
        }
        $message->getBody()->setContent($bodyContent);


        foreach ($allAttachments as $attachment) {
            if ($attachment['contentId']) {
                $contentId = $attachment['contentId'];
                $attachmentContent = $attachment['contentBytes'];
                $bodyContent = str_replace("cid:$contentId", "data:image/png;base64," . $attachmentContent, $bodyContent);
            }
        };
        $message->getBody()->setContent($bodyContent);

        $ccRecipients = [];
        foreach ($message->getCcRecipients() as $recipient) {
            $ccRecipients[] = [
                'emailAddress' => [
                    'name' => $recipient['emailAddress']['name'],
                    'address' => $recipient['emailAddress']['address']
                ]
            ];
        }

        $toRecipients = [];
        foreach ($message->getToRecipients() as $recipient) {
            $toRecipients[] = [
                'emailAddress' => [
                    'name' => $recipient['emailAddress']['name'],
                    'address' => $recipient['emailAddress']['address']
                ]
            ];
        }

        $bccRecipients = [];
        foreach ($message->getBccRecipients() as $recipient) {
            $bccRecipients[] = [
                'emailAddress' => [
                    'name' => $recipient['emailAddress']['name'],
                    'address' => $recipient['emailAddress']['address']
                ]
            ];
        }

        $toRecipientsJson = empty($toRecipients) ? null : json_encode($toRecipients);
        $ccRecipientsJson = empty($ccRecipients) ? null : json_encode($ccRecipients);
        $bccRecipientsJson = empty($bccRecipients) ? null : json_encode($bccRecipients);
        $internetmessage_id =  $message->getInternetMessageId();
        $conversationId = $message->getConversationId();
        if( $orglinkedstatus){
            $existingEmail = OrganizationEmail::where('message_no', $messageNo)
                            ->first();
            if (!$existingEmail) {
                // Create new OrganizationEmail instance and populate it
                $newOrganizationMail = new OrganizationEmail();
                $newOrganizationMail->user_id = Auth::user()->id;
                $newOrganizationMail->conversation_id = $conversationId;
                $newOrganizationMail->internetmessage_id = $internetmessage_id;
                $newOrganizationMail->organization_id = $org_id;
                $newOrganizationMail->message_no = $messageNo;
                $newOrganizationMail->subject = $message->getSubject();
                $newOrganizationMail->sender_email = $message->getSender()->getEmailAddress()->getAddress();
                $newOrganizationMail->sender = $message->getSender()->getEmailAddress()->getName();
                $newOrganizationMail->body = $bodyContent;
                $newOrganizationMail->date = $message->getReceivedDateTime();

                // Handle recipients

                $newOrganizationMail->toRecipients = $toRecipientsJson;

                $newOrganizationMail->ccRecipients = $ccRecipientsJson;

                $newOrganizationMail->bccRecipients = $bccRecipientsJson;

                $newOrganizationMail->active = 1;
                $newOrganizationMail->save();

            }
        }

        return true;

    }







}
