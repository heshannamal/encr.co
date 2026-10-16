<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use Mail;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Http\Request;
use App\Models\WebmailAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\OrderLayout;
use App\Models\EmailDeal;
use App\Models\Organization;
use App\Models\OrganizationEmail;
use App\Models\Sport;
use App\Models\User;
use App\Models\WebmailCount;
use App\Models\ColorMaster;
use App\Models\ContactOrganization;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;
use Microsoft\Graph\Graph;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Graph\Model;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Model\Message;
use App\Models\EmailTemplate;
use App\Models\UserEmailTemplate;
use App\Models\EmailSignature;
use App\Models\LeadSource;
use App\Models\DraftEmail;
use App\Models\EmailFilter;
use Illuminate\Support\Facades\Session;


use domainencore\Services\GraphAPIService\GraphAPIService;


class EmailController extends Controller
{

    protected $graphService;


    public function __construct(GraphAPIService $graphService)
        {
            $this->graphService = $graphService;

        }
    public function getAccessToken($refreshToken)
        {


            $clientId = env('AZURE_CLIENT_ID');
            $clientSecret = env('AZURE_CLIENT_SECRET');
            $tenantId = env('AZURE_TENANT_ID');
            $redirectUri = env('AZURE_REDIRECT_URI');

            $tokenEndpoint = 'https://login.microsoftonline.com'.$tenantId.'/oauth2/token';

            $client = new Client();
            $response = $client->post($tokenEndpoint, [
                'form_params' => [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'refresh_token' => $refreshToken,
                    'grant_type' => 'refresh_token',
                    'redirect_uri' => $redirectUri,
                    'scope' => 'https://graph.microsoft.com/.default'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            session(['azure_access_token' => $data['access_token']]);
            session(['azure_refresh_token' => $data['refresh_token']]);
            return $data['access_token'];
        }

    public function test12($messageId = null)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }

                $showHeading = "All Inbox Mails";
                $inboxMessages = $this->graphService->getInboxMessages($accessToken,1);
                // dd($inboxMessages);

                // Fetch sidebar items
                $sidebarItems = $this->graphService->GetMailFolders($accessToken);
                $folderPriority = [
                    "Inbox",
                    "Sent Items",
                    "Drafts",
                    "Deleted Items",
                    // Add more folder names here in the desired order
                ];
                // Sort sidebar items
                usort($sidebarItems, function($a, $b) use ($folderPriority) {
                    $nameA = $a['displayName'];
                    $nameB = $b['displayName'];

                    $priorityA = array_search($nameA, $folderPriority);
                    $priorityB = array_search($nameB, $folderPriority);

                    // If both folders are in the priority list or both aren't, compare their positions in the list
                    if ($priorityA !== false && $priorityB !== false) {
                        return $priorityA - $priorityB;
                    }

                    // If only one folder is in the priority list, it comes before the other
                    if ($priorityA !== false) {
                        return -1;
                    } elseif ($priorityB !== false) {
                        return 1;
                    }

                    // If neither folder is in the priority list, maintain the original order
                    return 0;
                });

                $filter  = Auth::user()->emailFilter->filter ?? 0;
                // dd($filter);
                $loadmessageId = NULL;
                if($messageId){
                    $loadmessageId =$messageId;
                }

                $organizations = Organization::where('active', 1)->get();
                $sports = Sport::where('active', 1)->get();
                $users = User::where('active', 1)->get();
                $userGroups = Role::where('active','1')->orderBy('name')->get();
                $colorMasters = ColorMaster::all();
                $peoples = Contact::where('active', 1) ->orderBy('first_name')->get();
                $lead_sources = LeadSource::where('active', 1)->get();
                $peoples_organization = ContactOrganization::all();
                $userId = Auth::user()->id;
                // Retrieve email templates belonging to the authenticated user
                $emailTemplates = EmailTemplate::where('user_id', $userId)->get();
                $AddedEmailTemplates = UserEmailTemplate::where('user_id', $userId)
                                            ->with('emailTemplate') // Eager load the associated email template details
                                            ->get();
                $mergedEmailTemplates = $emailTemplates->merge($AddedEmailTemplates->pluck('emailTemplate'));
                $emailTemplates = $mergedEmailTemplates->unique('id');
                // $linkedOrganizaton = OrganizationEmail::with('organizationDetail')->where('message_no', $messageNo)->first();i
                // $linkedActivities = Activity::where('email_message_no', $messageNo)->get();

                return view('pages.mail.view',compact('sidebarItems', 'showHeading','inboxMessages','organizations','sports','users','userGroups','colorMasters','peoples','peoples_organization','emailTemplates','AddedEmailTemplates', 'lead_sources','loadmessageId','filter'));

        }

    public function getSidebarCounts()
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }
            $sidebarItems = $this->graphService->GetMailFolders($accessToken);

                $folderPriority = [
                    "Inbox",
                    "Sent Items",
                    "Drafts",
                    "Deleted Items",
                    // Add more folder names here in the desired order
                ];
                // Sort sidebar items
                usort($sidebarItems, function($a, $b) use ($folderPriority) {
                    $nameA = $a['displayName'];
                    $nameB = $b['displayName'];

                    $priorityA = array_search($nameA, $folderPriority);
                    $priorityB = array_search($nameB, $folderPriority);

                    // If both folders are in the priority list or both aren't, compare their positions in the list
                    if ($priorityA !== false && $priorityB !== false) {
                        return $priorityA - $priorityB;
                    }

                    // If only one folder is in the priority list, it comes before the other
                    if ($priorityA !== false) {
                        return -1;
                    } elseif ($priorityB !== false) {
                        return 1;
                    }

                    // If neither folder is in the priority list, maintain the original order
                    return 0;
                });
            return response()->json($sidebarItems);
        }
    public function searchcontact(Request $request)
        {
            $query = $request->input('q');
            $contacts = Contact::where('email', 'like', '%' . $query . '%')->get();

            $formattedContacts = [];
            foreach ($contacts as $contact) {
                $formattedContacts[] = [
                    'id' => $contact->id,
                    'text' => $contact->email
                ];
            }

            return response()->json($formattedContacts);
        }

    public function getConversation($message_Id)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }

            $emailDetails = $this->graphService->getConversationDetails($message_Id, $accessToken);

            return response()->json($emailDetails);
        }
    public function getMessage($message_Id)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }

            $emailDetails = $this->graphService->getEmailMessageDetails($message_Id, $accessToken);

            return response()->json($emailDetails);
        }
    public function getMessageAttachments($message_Id)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }

            $emailAttachments = $this->graphService->getEmailMessageAttachments($message_Id, $accessToken);

            return response()->json($emailAttachments);
        }

    public function viewMessage($mailbox_id,$message_Id)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }
                $this->graphService->markAsReadMessage($accessToken, $message_Id);
                $inboxMessages = $this->graphService->getEmailThread($accessToken, $message_Id,$mailbox_id);

                return ($inboxMessages);

        }
    public function getMessageBody(Request $request)
        {
            $messageID = $request->messageId;
            $allattchmentdata = $request->allattchmentdata;
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }

            $emailDetails = $this->graphService->getEmailMessageDetails($messageID, $accessToken);

            return response()->json($emailDetails);

        }
    public function get_organization_act($messageNo,$email)
        {
            $linkedOrganization = OrganizationEmail::with('organizationDetail')->where('message_no', $messageNo)->first();
            $linkedActivities = Activity::where('email_message_no', $messageNo)->get();
            $contact = Contact::where('email', $email)->first();

            if ($contact) {
                $contact_org = ContactOrganization::where('contact_id', $contact->id)->pluck('organization_id')->toArray();
                if ($contact_org) {
                    $contact_org_detail = Organization::whereIn('id', $contact_org)->get();
                } else {
                    $contact_org_detail = null;
                }
            } else {
                $contact_org_detail = null;
            }

            $data = [
                'linkedOrganization' => $linkedOrganization,
                'linkedActivities' => $linkedActivities,
                'contact_org_detail' => $contact_org_detail,
                'contact' => $contact
            ];
            return ($data);
        }
    public function getEmailsignature()
        {
            $userId = Auth::user()->id;
            // Retrieve email templates belonging to the authenticated user
            $Emailsignature = EmailSignature::where('user_id', $userId)->get() ?? '';

            return response()->json($Emailsignature);
        }
    public function getMailboxChat(Request $request)
        {

            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }
                $folderId = $request->mailbox_id;
                $pageNumber = $request->page_number;

                try {
                    $messages = $this->graphService->getFolderMessages($accessToken, $folderId, $pageNumber);

                    return response()->json($messages);

                } catch (\Exception $e) {

                    return response()->json(['error' => $e->getMessage()], 500);
                }

        }
    public function mailActions(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }
                try {
                    // Get the selected mailbox ID from the request
                    $destinationFolderId = $request->move_to;

                    // Get the array of message IDs from the request
                    $messageIds = $request->chat_id_set;

                    // Initialize an array to store responses
                    $responses = [];

                    // Iterate over each message ID and move the message
                    foreach ($messageIds as $messageId) {
                        // Move the message using the graph service
                        if($request->action == 'move'){
                            $response =  $this->graphService->moveMessage($accessToken, $messageId, $destinationFolderId);
                        }elseif($request->action == 'delete'){
                            OrganizationEmail::where('message_no',$messageId)->delete();
                            $response =  $this->graphService->deleteMessage($accessToken, $messageId);
                        }elseif($request->action == 'unread'){
                            $response =  $this->graphService->markAsUnreadMessage($accessToken, $messageId);
                        }elseif($request->action == 'read'){
                            $response =  $this->graphService->markAsReadMessage($accessToken, $messageId);
                        }elseif($request->action == 'flag'){
                            $response =  $this->graphService->toggleFlag($accessToken, $messageId);
                        }


                    }

                    // Return success response
                    return response()->json("success");
                } catch (\Exception $e) {
                    // Return error response if an exception occurs
                    return response()->json(['error' => $e->getMessage()], 500);
                }

        }

    public function savesignature(Request $request)
        {

            EmailSignature::updateOrCreate(
                ['user_id' => Auth::user()->id],
                ['signature' => $request->signature,'active' => $request->active]
            );

            return response()->json(['message' => 'Signature create/update successfully']);

        }



    public function mailSend(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;

            if ($accessToken == null && $refreshToken == null) {
                return redirect('/login/azure');
            } else {
                $validresponse = $this->graphService->getUserProfile($accessToken);
            }

            if (!$validresponse) {
                $accessToken = $this->getAccessToken($refreshToken);
            }

            // Retrieve necessary data from the form
            $subject = $request->input('subject');
            $emailBody = $request->input('email_body');
            $to = $request->input('recipient');
            $cc = $request->input('cc');
            $bcc = $request->input('bcc');
            $images = $request->file('attachments');
            $draftMessageId = $request->input('Draftmessageid') ?? $request->input('SavedDraftId');
            //$draftId = $request->input('SavedDraftId');//

            // Initialize an array to store attachments for Graph API
            $graphAttachments = [];

            // Process each attachment
            if ($images) {
                foreach ($images as $attachment) {
                    if ($attachment->isValid()) {
                        $fileContent = file_get_contents($attachment->getPathname());
                        $base64Content = base64_encode($fileContent);

                        $graphAttachments[] = [
                            '@odata.type' => '#microsoft.graph.fileAttachment',
                            'name' => $attachment->getClientOriginalName(),
                            'contentBytes' => $base64Content,
                            'isInline' => false,
                        ];
                    }
                }
            }

            // Find all img tags in the email body
            preg_match_all('/<img[^>]+src="([^"]+)"/', $emailBody, $matches);

            // Loop through each matched image URL
            foreach ($matches[1] as $imageUrl) {
                if (strpos($imageUrl, 'https://') === 0) {
                    continue; // Skip this URL
                }

                // Fetch the image from the URL
                $imageData = file_get_contents($imageUrl);

                // Generate a unique CID for the image
                $cid = md5(uniqid());

                // Add the image as an attachment
                $graphAttachments[] = [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => basename($imageUrl),
                    'contentBytes' => base64_encode($imageData),
                    'isInline' => true,
                    'contentId' => $cid,
                    'contentType' => mime_content_type($imageUrl),
                ];

                // Replace the img tag with a CID reference
                $emailBody = str_replace($imageUrl, 'cid:' . $cid, $emailBody);
            }

            $toRecipients = [];
            foreach ($to as $recipient) {
                $toRecipients[] = ['emailAddress' => ['address' => $recipient]];
            }

            // Prepare the payload for the email
            $messagePayload = [
                'subject' => $subject,
                'body' => [
                    'contentType' => 'HTML',
                    'content' => $emailBody // Use the updated body content with CID references
                ],
                'toRecipients' => $toRecipients,
                'attachments' => $graphAttachments,
            ];

            // Add CC recipients if provided
            if (!empty($cc)) {
                $ccRecipients = [];
                foreach ($cc as $recipient) {
                    $ccRecipients[] = ['emailAddress' => ['address' => $recipient]];
                }
                $messagePayload['ccRecipients'] = $ccRecipients;
            }

            // Add BCC recipients if provided
            if (!empty($bcc)) {
                $bccRecipients = [];
                foreach ($bcc as $recipient) {
                    $bccRecipients[] = ['emailAddress' => ['address' => $recipient]];
                }
                $messagePayload['bccRecipients'] = $bccRecipients;
            }

            // Sanitize the payload content to ensure it contains only valid UTF-8 characters
            $messagePayload = $this->sanitizeUtf8($messagePayload);
            $graph = new Graph();
            $graph->setAccessToken($accessToken);
            $client = new Client();
            try {
                if (!empty($draftMessageId)) {
                    OrganizationEmail::where('message_no', $draftMessageId)->delete();
                    $draftEmail = DraftEmail::where('draft_id', $draftMessageId)->first();
                    if ($draftEmail) {
                        $messageId = $draftEmail->email_id;
                        if ($draftEmail->type == 0) {
                            // Create the reply draft
                            $createReplyResponse = $graph->createRequest('POST', "/me/messages/{$messageId}/createReply")
                                ->addHeaders(['Content-Type' => 'application/json'])
                                ->attachBody(['message' => $messagePayload])
                                ->execute();

                            $draftReplyId = $createReplyResponse->getBody()['id'];
                            $sendResponse = $graph->createRequest('POST', "/me/messages/{$draftReplyId}/send")
                                ->execute();
                            if ($sendResponse->getStatus() === 202) {
                                $draftEmail->delete();
                                $graph->createRequest('DELETE', "/me/messages/{$draftMessageId}")
                                    ->execute();

                                sleep(5);

                                    // Retrieve the most recent sent message
                                $sentItemsResponse = $client->get('https://graph.microsoft.com/v1.0/me/mailFolders/sentItems/messages', [
                                    'headers' => [
                                        'Authorization' => 'Bearer ' . $accessToken,
                                        'Content-Type' => 'application/json'
                                    ],
                                    'query' => [
                                        '$top' => 1, // Get the most recent message
                                        '$orderby' => 'sentDateTime DESC'
                                    ]
                                ]);

                                // Decode the JSON response
                                $sentItemsResponseBody = json_decode($sentItemsResponse->getBody(), true)['value'];

                                return response()->json(['message' => 'Reply sent successfully', 'sent_message' => $sentItemsResponseBody], 200);
                            } else {
                                return response()->json(['error' => 'Failed to send Draft reply mail'], $sendResponse->getStatus());
                            }
                        } elseif ($draftEmail->type == 1) {
                            // Create a forward draft message
                            $draftResponse = $graph->createRequest('POST', "/me/messages/{$messageId}/createForward")
                                ->addHeaders(['Content-Type' => 'application/json'])
                                ->attachBody($messagePayload)
                                ->execute();
                            $draftId = $draftResponse->getBody()['id'];
                            foreach ($graphAttachments as $attachment) {
                                $graph->createRequest('POST', "/me/messages/{$draftId}/attachments")
                                    ->addHeaders(['Content-Type' => 'application/json'])
                                    ->attachBody($attachment)
                                    ->execute();
                            }
                            // Update the draft message with subject and attachments
                            // $updateDraft = [
                            //     'subject' => 'FW: ' . $subject,
                            //     'ccRecipients' => $ccRecipients,
                            //     'bccRecipients' => $bccRecipients,
                            // ];

                            // $graph->createRequest('PATCH', "/me/messages/{$draftId}")
                            //     ->addHeaders(['Content-Type' => 'application/json'])
                            //     ->attachBody($updateDraft)
                            //     ->execute();

                            // Send the forward draft message
                            $response = $graph->createRequest('POST', "/me/messages/{$draftId}/send")
                                ->execute();
                            if ($response->getStatus() === 202) {

                                sleep(5);

                                // Retrieve the most recent sent message
                                $sentItemsResponse = $client->get('https://graph.microsoft.com/v1.0/me/mailFolders/sentItems/messages', [
                                    'headers' => [
                                        'Authorization' => 'Bearer ' . $accessToken,
                                        'Content-Type' => 'application/json'
                                    ],
                                    'query' => [
                                        '$top' => 1, // Get the most recent message
                                        '$orderby' => 'sentDateTime DESC'
                                    ]
                                ]);

                                // Decode the JSON response
                                $sentItemsResponseBody = json_decode($sentItemsResponse->getBody(), true)['value'];

                                $draftEmail->delete();
                                $graph->createRequest('DELETE', "/me/messages/{$draftMessageId}")
                                    ->execute();
                                return response()->json(['message' => 'Mail successfully forwarded', 'sent_message' => $sentItemsResponseBody], 200);
                            } else {
                                return response()->json(['error' => 'Failed to send Draft Forward mail'], $response->getStatus());
                            }
                        }
                    } else {
                        $sendResponse = $client->post('https://graph.microsoft.com/v1.0/me/sendMail', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $accessToken,
                                'Content-Type' => 'application/json'
                            ],
                            'json' => ['message' => $messagePayload]
                        ]);

                        // Check if the request was successful
                        if ($sendResponse->getStatusCode() === 202) {

                            sleep(5);

                            // Retrieve the most recent sent message
                            $sentItemsResponse = $client->get('https://graph.microsoft.com/v1.0/me/mailFolders/sentItems/messages', [
                                'headers' => [
                                    'Authorization' => 'Bearer ' . $accessToken,
                                    'Content-Type' => 'application/json'
                                ],
                                'query' => [
                                    '$top' => 1, // Get the most recent message
                                    '$orderby' => 'sentDateTime DESC'
                                ]
                            ]);

                            // Decode the JSON response
                            $sentItemsResponseBody = json_decode($sentItemsResponse->getBody(), true)['value'];

                            $graph->createRequest('DELETE', "/me/messages/{$draftMessageId}")
                                    ->execute();
                            return response()->json(['message' => 'Mail sent successfully', 'sent_message' => $sentItemsResponseBody], 200);
                        } else {
                            return response()->json(['error' => 'Failed to send draft email'], $sendResponse->getStatusCode());
                        }
                    }
                } else {
                    // Send the new email
                    $sendResponse = $client->post('https://graph.microsoft.com/v1.0/me/sendMail', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken,
                            'Content-Type' => 'application/json'
                        ],
                        'json' => ['message' => $messagePayload]
                    ]);

                    // Check if the request was successful
                    if ($sendResponse->getStatusCode() === 202) {

                    sleep(5);

                        // Retrieve the most recent sent message
                    $sentItemsResponse = $client->get('https://graph.microsoft.com/v1.0/me/mailFolders/sentItems/messages', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken,
                            'Content-Type' => 'application/json'
                        ],
                        'query' => [
                            '$top' => 1, // Get the most recent message
                            '$orderby' => 'sentDateTime DESC'
                        ]
                    ]);

                    // Decode the JSON response
                    $sentItemsResponseBody = json_decode($sentItemsResponse->getBody(), true)['value'];

                        return response()->json(['message' => 'Mail sent successfully', 'sent_message' => $sentItemsResponseBody], 200);
                    } else {
                        return response()->json(['error' => 'Failed to send email'], $sendResponse->getStatusCode());
                    }
                }
            } catch (\Exception $e) {
                // Handle exceptions
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }


    private function sanitizeUtf8($data)
        {
            array_walk_recursive($data, function (&$value) {
                if (is_string($value)) {
                    $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            });

            return $data;
        }

    private function attachImagesAsAttachments($quillContent)
        {
            $attachments = [];

            // Convert Quill content to HTML format
            $htmlContent = $this->quillToHtml($quillContent);

            // Find all img tags with base64-encoded src attributes in the HTML content
            preg_match_all('/<img[^>]+src="data:image\/\w+;base64,([^"]+)"/i', $htmlContent, $matches);

            // Process each found img tag
            foreach ($matches[0] as $index => $imgTag) {
                $base64Data = $matches[1][$index];

                // Decode the base64-encoded image data
                $imageData = base64_decode($base64Data);

                // Generate a unique content ID (CID) for the attachment
                $contentId = 'image_' . uniqid();

                // Create an attachment object containing the image data and CID
                $attachments[] = [
                    "@odata.type" => "#microsoft.graph.fileAttachment",
                    "name" => "image.jpg", // Adjust the filename as needed
                    "contentBytes" => base64_encode($imageData) // Encode the image data back to base64
                ];

                // Replace the base64-encoded image source with the CID in the HTML content
                $htmlContent = str_replace("data:image/jpeg;base64," . base64_encode($imageData), "cid:{$contentId}",  $htmlContent);
            }

            // Return attachments array and updated HTML content
            return [
                'attachments' => $attachments,
                'updatedContent' => $htmlContent
            ];
        }

    private function quillToHtml($quillContent)
        {

            $htmlContent = str_replace('<p>', '<div>', $quillContent);
            $htmlContent = str_replace('</p>', '</div>', $htmlContent);
            // Add more replacements as needed

            return $htmlContent;
        }
    public function sendReply(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;

            if ($accessToken == null && $refreshToken == null) {
                return redirect('/login/azure');
            } else {
                $validresponse = $this->graphService->getUserProfile($accessToken);
            }

            if (!$validresponse) {
                $accessToken = $this->getAccessToken($refreshToken);
            }
            $draftId = $request->input('draftId');
            $messageId = $request->input('messageId');
            $messageContent = $request->input('message');
            $to = $request->input('to', []);
            $cc = $request->input('cc', []);
            $bcc = $request->input('bcc', []);
            $images = $request->input('attachments', []);
            $attachments = [];
            foreach ($images as $attachment) {
                $attachments[] = [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => $attachment['name'],
                    'contentBytes' => $attachment['content'],
                    'contentType' => $attachment['type'],
                    'isInline' => false,
                ];
            }
            // Find all img tags in the email body and add them as attachments
            preg_match_all('/<img[^>]+src="([^"]+)"/', $messageContent, $matches);

            foreach ($matches[1] as $imageUrl) {
                $imageData = file_get_contents($imageUrl);
                $cid = md5(uniqid());
                $attachments[] = [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => basename($imageUrl),
                    'contentBytes' => base64_encode($imageData),
                    'isInline' => true,
                    'contentId' => $cid,
                    'contentType' => mime_content_type($imageUrl),
                ];
                $messageContent = str_replace($imageUrl, 'cid:' . $cid, $messageContent);
            }

            // Initialize recipient arrays
            $toRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $to);

            $ccRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $cc);

            $bccRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $bcc);

            $graph = new Graph();
            $graph->setAccessToken($accessToken);

            // Get the original message details
            $messageDetailsResponse = $graph->createRequest('GET', "/me/messages/{$messageId}")
                                            ->execute();

            $originalMessage = $messageDetailsResponse->getBody();
            $mainSubject = $originalMessage['subject'];
            $originalBodyContent = $originalMessage['body']['content'];

            $messageSubject = $request->input('subject', $mainSubject);

            // Prepare the reply message
            $replyMessage = [
                'subject' => 'Re: ' . $messageSubject,
                'toRecipients' => $toRecipients,
                'ccRecipients' => $ccRecipients,
                'bccRecipients' => $bccRecipients,
                'body' => [
                    'contentType' => 'html',
                    'content' => $messageContent . '<br><br>' . $originalBodyContent,
                ],
                'attachments' => $attachments,
            ];

            try {
                // Create the reply draft
                $createReplyResponse = $graph->createRequest('POST', "/me/messages/{$messageId}/createReply")
                                             ->addHeaders(['Content-Type' => 'application/json'])
                                             ->attachBody(['message' => $replyMessage])
                                             ->execute();

                $draftReplyId = $createReplyResponse->getBody()['id'];
                $sendResponse = $graph->createRequest('POST', "/me/messages/{$draftReplyId}/send")
                                      ->execute();

                sleep(5);
                $client = new Client();
                // Retrieve the most recent sent message
                $sentItemsResponse = $client->get('https://graph.microsoft.com/v1.0/me/mailFolders/sentItems/messages', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json'
                    ],
                    'query' => [
                        '$top' => 1, // Get the most recent message
                        '$orderby' => 'sentDateTime DESC'
                    ]
                ]);

                // Decode the JSON response
                $sentItemsResponseBody = json_decode($sentItemsResponse->getBody(), true)['value'];

                if($draftId){
                    $graph->createRequest('DELETE', "/me/messages/{$draftId}")
                    ->execute();
                }
                // Return a success response
                return response()->json(['message' => 'Reply sent successfully', 'sent_message' => $sentItemsResponseBody], 200);
            } catch (\Exception $e) {
                // Handle any errors
                return response()->json(['error' => 'Failed to send reply: ' . $e->getMessage()], 500);
            }
        }
        public function DraftReply(Request $request)
            {
                $accessToken = session('azure_access_token') ?? null;
                $refreshToken = session('azure_refresh_token') ?? null;

                if ($accessToken == null && $refreshToken == null) {
                    return redirect('/login/azure');
                } else {
                    $validresponse = $this->graphService->getUserProfile($accessToken);
                }

                if (!$validresponse) {
                    $accessToken = $this->getAccessToken($refreshToken);
                }

                $messageId = $request->input('messageId');
                $draftId = $request->input('draftId');
                $messageContent = $request->input('message');
                $to = $request->input('to', []);
                $cc = $request->input('cc', []);
                $bcc = $request->input('bcc', []);
                $images = $request->input('attachments', []);
                $attachments = [];

                foreach ($images as $attachment) {
                    $attachments[] = [
                        '@odata.type' => '#microsoft.graph.fileAttachment',
                        'name' => $attachment['name'],
                        'contentBytes' => $attachment['content'],
                        'contentType' => $attachment['type'],
                        'isInline' => false,
                    ];
                }

                $toRecipients = array_map(function ($email) {
                    return ['emailAddress' => ['address' => $email]];
                }, $to);

                $ccRecipients = array_map(function ($email) {
                    return ['emailAddress' => ['address' => $email]];
                }, $cc);

                $bccRecipients = array_map(function ($email) {
                    return ['emailAddress' => ['address' => $email]];
                }, $bcc);

                $graph = new Graph();
                $graph->setAccessToken($accessToken);

                // Get the original message details
                $messageDetailsResponse = $graph->createRequest('GET', "/me/messages/{$messageId}")
                                                ->execute();

                $originalMessage = $messageDetailsResponse->getBody();
                $mainSubject = $originalMessage['subject'];
                $originalBodyContent = $originalMessage['body']['content'];

                $messageSubject = $request->input('subject', $mainSubject);

                // Prepare the reply message
                $replyMessage = [
                    'subject' => 'Re: ' . $messageSubject,
                    'toRecipients' => $toRecipients,
                    'ccRecipients' => $ccRecipients,
                    'bccRecipients' => $bccRecipients,
                    'body' => [
                        'contentType' => 'html',
                        'content' => $messageContent . '<br><br>' . $originalBodyContent,
                    ],
                    'attachments' => $attachments,
                ];

                try {
                    if ($draftId) {
                        // Update the existing draft reply
                        OrganizationEmail::where('message_no', $draftId)->delete();
                        $updateDraftResponse = $graph->createRequest('PATCH', "/me/messages/{$draftId}")
                                                    ->addHeaders(['Content-Type' => 'application/json'])
                                                    ->attachBody($replyMessage)
                                                    ->execute();

                        $responseBody = $updateDraftResponse->getBody();
                        if(isset($request->organization_linked)){
                            $emailDetails2 = $this->graphService->getEmailMessageDetails($responseBody['id'], $accessToken);
                            OrganizationEmail::where('organization_id', $request->organization_linked)->where('message_no',$responseBody['id'])->delete();

                            $newOrganizationMail = new OrganizationEmail();
                            $newOrganizationMail->user_id = Auth::user()->id;
                            $newOrganizationMail->organization_id = $request->organization_linked;
                            $newOrganizationMail->message_no = $responseBody['id'];
                            $newOrganizationMail->subject = $responseBody['subject'];
                            $newOrganizationMail->type = 'Draft';
                            $newOrganizationMail->sender_email = session('azure_logged_email') ?? null;
                            $newOrganizationMail->body = $messageContent;
                            $newOrganizationMail->date = $emailDetails2['date'];

                            // Handle recipients
                            if (!empty($responseBody['ccRecipients'])) {
                                $newOrganizationMail->ccRecipients = json_encode($responseBody['ccRecipients']);
                            }
                            if (!empty($responseBody['bccRecipients'])) {
                                $newOrganizationMail->bccRecipients = json_encode($responseBody['bccRecipients']);
                            }
                            if (!empty($responseBody['toRecipients'])) {
                                $newOrganizationMail->toRecipients = json_encode($responseBody['toRecipients']);
                            }

                            $newOrganizationMail->active = 1;
                            $newOrganizationMail->save();
                        }

                        return response()->json(['message' => 'Draft reply updated successfully', 'draftId' => $draftId], 200);
                    } else {
                        // Create the reply draft
                        $createReplyResponse = $graph->createRequest('POST', "/me/messages/{$messageId}/createReply")
                                                    ->addHeaders(['Content-Type' => 'application/json'])
                                                    ->attachBody(['message' => $replyMessage])
                                                    ->execute();
                        $draftId = $createReplyResponse->getBody()['id'];

                        $responseBody = $createReplyResponse->getBody();
                        $emailDetails2 = $this->graphService->getEmailMessageDetails($draftId, $accessToken);
                        if(isset($request->organization_linked)){

                        OrganizationEmail::where('message_no',$draftId)->delete();

                        $newOrganizationMail = new OrganizationEmail();
                        $newOrganizationMail->user_id = Auth::user()->id;
                        $newOrganizationMail->organization_id = $request->organization_linked;
                        $newOrganizationMail->message_no = $draftId;
                        $newOrganizationMail->subject = $responseBody['subject'];
                        $newOrganizationMail->type = 'Draft';
                        $newOrganizationMail->sender_email = session('azure_logged_email') ?? null;
                        $newOrganizationMail->body = $messageContent;
                        $newOrganizationMail->date = $emailDetails2['date'];

                        // Handle recipients
                        if (!empty($responseBody['ccRecipients'])) {
                            $newOrganizationMail->ccRecipients = json_encode($responseBody['ccRecipients']);
                        }
                        if (!empty($responseBody['bccRecipients'])) {
                            $newOrganizationMail->bccRecipients = json_encode($responseBody['bccRecipients']);
                        }
                        if (!empty($responseBody['toRecipients'])) {
                            $newOrganizationMail->toRecipients = json_encode($responseBody['toRecipients']);
                        }

                        $newOrganizationMail->active = 1;
                        $newOrganizationMail->save();
                    }
                        $draftEmail = DraftEmail::create([
                                    'draft_id' => $draftId,
                                    'email_id' => $messageId,
                                    'type' => 0,
                                ]);

                        return response()->json(['message' => 'Draft reply saved successfully', 'draftId' => $draftId], 200);
                    }
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to save draft reply: ' . $e->getMessage()], 500);
                }
            }


    public function SearchEmail(Request $request)
        {

            $accessToken = session('azure_access_token') ?? null;
                $refreshToken = session('azure_refresh_token') ?? null;
                if($accessToken == null && $refreshToken == null){
                    return redirect('/login/azure');
                }else{

                    $validresponse = $this->graphService->getUserProfile($accessToken);

                }
                if((!$validresponse)){

                    $accessToken = $this->getAccessToken($refreshToken);
                }
                $searchText = $request->searchText;
                $pageNumber = $request->pageNumber;
                try {
                    $messages = $this->graphService->searchAllMail($accessToken, $searchText, $pageNumber);

                    return response()->json($messages);

                } catch (\Exception $e) {

                    return response()->json(['error' => $e->getMessage()], 500);
                }

        }

    public function forwardReply(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;

            if ($accessToken == null && $refreshToken == null) {
                return redirect('/login/azure');
            } else {
                $validresponse = $this->graphService->getUserProfile($accessToken);
            }

            if (!$validresponse) {
                $accessToken = $this->getAccessToken($refreshToken);
            }
            $sdraftId = $request->input('draftId');
            $messageId = $request->input('messageId');
            $messageContent = $request->input('message');
            $to = $request->input('to', []);
            $cc = $request->input('cc', []);
            $bcc = $request->input('bcc', []);
            $images = $request->input('attachments', []);

            // Initialize recipient arrays
            $toRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $to);

            $ccRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $cc);

            $bccRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $bcc);

            // Initialize attachment array
            $graphAttachments = [];
            foreach ($images as $attachment) {
                $graphAttachments[] = [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => $attachment['name'],
                    'contentBytes' => $attachment['content'],
                    'contentType' => $attachment['type'],
                    'isInline' => false,
                ];
            }

            // Find all img tags in the email body and attach inline images
            preg_match_all('/<img[^>]+src="([^"]+)"/', $messageContent, $matches);
            foreach ($matches[1] as $imageUrl) {
                if (strpos($imageUrl, 'https://') === 0) {
                    continue; // Skip this URL
                }
                $imageData = file_get_contents($imageUrl);
                $cid = md5(uniqid());
                $graphAttachments[] = [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => basename($imageUrl),
                    'contentBytes' => base64_encode($imageData),
                    'isInline' => true,
                    'contentId' => $cid,
                    'contentType' => mime_content_type($imageUrl),
                ];
                $messageContent = str_replace($imageUrl, 'cid:' . $cid, $messageContent);
            }

            $graph = new Graph();
            $graph->setAccessToken($accessToken);

            // Fetch original attachments
            $originalAttachmentsResponse = $graph->createRequest('GET', "/me/messages/{$messageId}/attachments")
                                                 ->execute();
            $originalAttachments = $originalAttachmentsResponse->getBody()['value'];

            // Append original attachments to $graphAttachments
            foreach ($originalAttachments as $attachment) {
                if (isset($attachment['@odata.type']) && $attachment['@odata.type'] === '#microsoft.graph.fileAttachment') {
                    $graphAttachments[] = [
                        '@odata.type' => '#microsoft.graph.fileAttachment',
                        'name' => $attachment['name'],
                        'contentBytes' => $attachment['contentBytes'],
                        'isInline' => $attachment['isInline'] ?? false,
                        'contentId' => $attachment['contentId'] ?? null,
                        'contentType' => $attachment['contentType'],
                    ];
                }
            }

            // Get the original message details
            $messageDetailsResponse = $graph->createRequest('GET', "/me/messages/{$messageId}")
                                            ->execute();
            $mainSubject = $messageDetailsResponse->getBody()['subject'];
            $messageSubject = $request->input('subject', $mainSubject);

            // Prepare the forward message
            $forwardMessage = [
                'comment' => $messageContent,
                'toRecipients' => $toRecipients,

            ];

            try {
                // Create a forward draft message
                $draftResponse = $graph->createRequest('POST', "/me/messages/{$messageId}/createForward")
                                       ->addHeaders(['Content-Type' => 'application/json'])
                                       ->attachBody($forwardMessage)
                                       ->execute();
                $draftId = $draftResponse->getBody()['id'];
                foreach ($graphAttachments as $attachment) {
                    $graph->createRequest('POST', "/me/messages/{$draftId}/attachments")
                          ->addHeaders(['Content-Type' => 'application/json'])
                          ->attachBody($attachment)
                          ->execute();
                }
                // Update the draft message with subject and attachments
                $updateDraft = [
                    'subject' => 'FW: ' . $messageSubject,
                    'ccRecipients' => $ccRecipients,
                    'bccRecipients' => $bccRecipients,

                ];

                $graph->createRequest('PATCH', "/me/messages/{$draftId}")
                      ->addHeaders(['Content-Type' => 'application/json'])
                      ->attachBody($updateDraft)
                      ->execute();

                // Send the forward draft message
                $Response = $graph->createRequest('POST', "/me/messages/{$draftId}/send")
                                ->execute();
                if($sdraftId){
                    $graph->createRequest('DELETE', "/me/messages/{$sdraftId}")
                    ->execute();
                }
                // Return a success response
                return response()->json(['message' => 'Forward sent successfully'], 200);
            } catch (\Exception $e) {
                // Handle any errors
                return response()->json(['error' => 'Failed to send forward: ' . $e->getMessage()], 500);
            }
        }
    public function draftforwardReply(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;

            if ($accessToken == null && $refreshToken == null) {
                return redirect('/login/azure');
            } else {
                $validresponse = $this->graphService->getUserProfile($accessToken);
            }

            if (!$validresponse) {
                $accessToken = $this->getAccessToken($refreshToken);
            }

            $messageId = $request->input('messageId');
            $draftId = $request->input('draftId');
            $messageContent = $request->input('message');
            $to = $request->input('to', []);
            $cc = $request->input('cc', []);
            $bcc = $request->input('bcc', []);
            $images = $request->input('attachments', []);

            // Initialize recipient arrays
            $toRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $to);

            $ccRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $cc);

            $bccRecipients = array_map(function ($email) {
                return ['emailAddress' => ['address' => $email]];
            }, $bcc);

            // Initialize attachment array
            $graphAttachments = [];
            foreach ($images as $attachment) {
                $graphAttachments[] = [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => $attachment['name'],
                    'contentBytes' => $attachment['content'],
                    'contentType' => $attachment['type'],
                    'isInline' => false,
                ];
            }

            // Fetch original attachments
            $graph = new Graph();
            $graph->setAccessToken($accessToken);

            $originalAttachmentsResponse = $graph->createRequest('GET', "/me/messages/{$messageId}/attachments")
                                                 ->execute();
            $originalAttachments = $originalAttachmentsResponse->getBody()['value'];

            // Append original attachments to $graphAttachments
            foreach ($originalAttachments as $attachment) {
                if (isset($attachment['@odata.type']) && $attachment['@odata.type'] === '#microsoft.graph.fileAttachment') {
                    $graphAttachments[] = [
                        '@odata.type' => '#microsoft.graph.fileAttachment',
                        'name' => $attachment['name'],
                        'contentBytes' => $attachment['contentBytes'],
                        'isInline' => $attachment['isInline'] ?? false,
                        'contentId' => $attachment['contentId'] ?? null,
                        'contentType' => $attachment['contentType'],
                    ];
                }
            }

            // Get the original message details
            $messageDetailsResponse = $graph->createRequest('GET', "/me/messages/{$messageId}")
                                            ->execute();
            $mainSubject = $messageDetailsResponse->getBody()['subject'];
            $messageSubject = $request->input('subject', $mainSubject);

            // Prepare the forward message
            $forwardMessage = [
                'comment' => $messageContent,
                'toRecipients' => $toRecipients,
                'ccRecipients' => $ccRecipients,
                'bccRecipients' => $bccRecipients,
            ];

            try {
                if ($draftId) {
                    // Update the existing draft forward message
                    $updateDraftResponse = $graph->createRequest('PATCH', "/me/messages/{$draftId}")
                                                 ->addHeaders(['Content-Type' => 'application/json'])
                                                 ->attachBody([
                                                     'subject' => 'FW: ' . $messageSubject,
                                                     'body' => [
                                                         'contentType' => 'html',
                                                         'content' => $messageContent,
                                                     ],
                                                     'toRecipients' => $toRecipients,
                                                     'ccRecipients' => $ccRecipients,
                                                     'bccRecipients' => $bccRecipients,
                                                 ])
                                                 ->execute();

                    // Add new attachments if any
                    foreach ($graphAttachments as $attachment) {
                        $graph->createRequest('POST', "/me/messages/{$draftId}/attachments")
                              ->addHeaders(['Content-Type' => 'application/json'])
                              ->attachBody($attachment)
                              ->execute();
                    }

                    $responseBody = $updateDraftResponse->getBody();
                    $draftId = $responseBody['id']; // Extract the draft ID from the response
                    $emailDetails2 = $this->graphService->getEmailMessageDetails($draftId, $accessToken);
                    if(isset($request->organization_linked)){

                        OrganizationEmail::where('message_no',$draftId)->delete();

                        $newOrganizationMail = new OrganizationEmail();
                        $newOrganizationMail->user_id = Auth::user()->id;
                        $newOrganizationMail->organization_id = $request->organization_linked;
                        $newOrganizationMail->message_no = $draftId;
                        $newOrganizationMail->subject = $responseBody['subject'];
                        $newOrganizationMail->type = 'Draft';
                        $newOrganizationMail->sender_email = session('azure_logged_email') ?? null;
                        $newOrganizationMail->body = $messageContent;
                        $newOrganizationMail->date = $emailDetails2['date'];

                        // Handle recipients
                        if (!empty($responseBody['ccRecipients'])) {
                            $newOrganizationMail->ccRecipients = json_encode($responseBody['ccRecipients']);
                        }
                        if (!empty($responseBody['bccRecipients'])) {
                            $newOrganizationMail->bccRecipients = json_encode($responseBody['bccRecipients']);
                        }
                        if (!empty($responseBody['toRecipients'])) {
                            $newOrganizationMail->toRecipients = json_encode($responseBody['toRecipients']);
                        }

                        $newOrganizationMail->active = 1;
                        $newOrganizationMail->save();
                    }

                    return response()->json(['message' => 'Draft forward message updated successfully', 'draftId' => $draftId], 200);
                } else {
                    // Create a forward draft message
                    $draftResponse = $graph->createRequest('POST', "/me/messages/{$messageId}/createForward")
                                           ->addHeaders(['Content-Type' => 'application/json'])
                                           ->attachBody($forwardMessage)
                                           ->execute();
                    $draftId = $draftResponse->getBody()['id'];

                    // Add attachments to the draft
                    foreach ($graphAttachments as $attachment) {
                        $graph->createRequest('POST', "/me/messages/{$draftId}/attachments")
                              ->addHeaders(['Content-Type' => 'application/json'])
                              ->attachBody($attachment)
                              ->execute();
                    }

                    // Create a record of the draft
                    $draftEmail = DraftEmail::create([
                        'draft_id' => $draftId,
                        'email_id' => $messageId,
                        'type' => 1,
                    ]);

                    $responseBody = $draftResponse->getBody();
                    $emailDetails2 = $this->graphService->getEmailMessageDetails( $draftId, $accessToken);
                    if(isset($request->organization_linked)){

                        OrganizationEmail::where('message_no',$draftId)->delete();

                        $newOrganizationMail = new OrganizationEmail();
                        $newOrganizationMail->user_id = Auth::user()->id;
                        $newOrganizationMail->organization_id = $request->organization_linked;
                        $newOrganizationMail->message_no = $draftId;
                        $newOrganizationMail->subject = 'FW: ' . $messageSubject;
                        $newOrganizationMail->type = 'Draft';
                        $newOrganizationMail->sender_email = session('azure_logged_email') ?? null;
                        $newOrganizationMail->body = $messageContent;
                        $newOrganizationMail->date = $emailDetails2['date'];

                        // Handle recipients
                        if (!empty($forwardMessage['ccRecipients'])) {
                            $newOrganizationMail->ccRecipients = json_encode($forwardMessage['ccRecipients']);
                        }
                        if (!empty($forwardMessage['bccRecipients'])) {
                            $newOrganizationMail->bccRecipients = json_encode($forwardMessage['bccRecipients']);
                        }
                        if (!empty($forwardMessage['toRecipients'])) {
                            $newOrganizationMail->toRecipients = json_encode($forwardMessage['toRecipients']);
                        }

                        $newOrganizationMail->active = 1;
                        $newOrganizationMail->save();
                    }

                    return response()->json(['message' => 'Draft forward message saved successfully', 'draftId' => $draftId], 200);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to save draft forward message: ' . $e->getMessage()], 500);
            }
        }



    public function linkNewOrganizationEmail(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }
            $messageId = $request->organization_messageNo;
            $emailDetails = $this->graphService->getEmailMessageDetails($messageId, $accessToken);

        try {
            $found_org = Organization::where('organization_name' , $request->organization_name)->first();

            if(!$found_org){
                $organization = new Organization();
                $organization->organization_name = $request->organization_name;
                $organization->website = $request->website;
                $organization->email = $request->email;
                $organization->pl_status = $request->add_plcustomer;
                $organization->sport = $request->sport;
                $organization->user_id = $request->user_id;
                $organization->lead_source = $request->lead_source;
                $organization->sales_tax = $request->sales_tax;
                $organization->sales_tax_active = $request->sales_tax_active;
                $organization->size_of_club = $request->size_of_club;
                $organization->shipping_street = $request->shipping_street;
                $organization->shipping_city = $request->shipping_city;
                $organization->shipping_state = $request->shipping_state;
                $organization->shipping_postal_code = $request->shipping_postal_code;
                $organization->shipping_country = $request->shipping_country;
                $organization->active =  1;
                $organization->save();
            }else{
                $organization = $found_org;
            }

            $emailDetailsParent = $this->graphService->getEmailMessageDetails($messageId, $accessToken);
            $parentFolderId = $emailDetailsParent['parentFolderId'] ?? null;

            if ($parentFolderId === null) {
                return response()->json(["status" => "error", "message" => "Parent folder ID not found."], 500);
            }

            $messageThread = $this->graphService->getEmailThread($accessToken, $messageId, $parentFolderId);
            $messageThread = $messageThread['resultMessages'];

                foreach ($messageThread as $threadItem) {
                    // Handle when $messageThread contains only one message directly
                    if (isset($threadItem['message']) && $threadItem['message'] instanceof \Microsoft\Graph\Model\Message) {
                        $message = $threadItem['message'];
                    } else {
                        $message = $threadItem;
                    }

                    // Ensure we have a valid message object
                    if ($message instanceof \Microsoft\Graph\Model\Message) {
                        $messageId = $message->getId();
                        $internetmessage_id =  $message->getInternetMessageId();
                        $conversationId = $message->getConversationId();
                        // Fetch the email details using the ID
                        $emailDetails = $this->graphService->getEmailMessageDetails($messageId, $accessToken);

                        // Delete any existing OrganizationEmail with the same message_no
                        OrganizationEmail::where('message_no', $messageId)->delete();

                        // Create new OrganizationEmail instance and populate it
                        $newOrganizationMail = new OrganizationEmail();
                        $newOrganizationMail->user_id = Auth::user()->id;
                        $newOrganizationMail->organization_id = $organization->id;
                        $newOrganizationMail->conversation_id = $conversationId;
                        $newOrganizationMail->internetmessage_id = $internetmessage_id;
                        $newOrganizationMail->message_no = $messageId;
                        $newOrganizationMail->subject = $emailDetails['subject'];
                        $newOrganizationMail->sender_email = $emailDetails['sender'];
                        $newOrganizationMail->sender = $emailDetails['senderName'];
                        $newOrganizationMail->body = $emailDetails['body'];
                        $newOrganizationMail->date = $emailDetails['date'];

                        // Handle recipients
                        if (!empty($emailDetails['ccRecipientsfull'])) {
                            $newOrganizationMail->ccRecipients = json_encode($emailDetails['ccRecipientsfull']);
                        }
                        if (!empty($emailDetails['bccRecipientsfull'])) {
                            $newOrganizationMail->bccRecipients = json_encode($emailDetails['bccRecipientsfull']);
                        }
                        if (!empty($emailDetails['toRecipientsfull'])) {
                            $newOrganizationMail->toRecipients = json_encode($emailDetails['toRecipientsfull']);
                        }

                        $newOrganizationMail->active = 1;
                        $newOrganizationMail->save();
                    }
                }

                return response()->json(["status" => "success", "data" => $newOrganizationMail]);
            } catch (\Exception $e) {
                return response()->json(["status" => "error", "message" => $e->getMessage()], 500);
            }

        }
        public function linkExistOrganizationEmail(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;

            if ($accessToken == null && $refreshToken == null) {
                return redirect('/login/azure');
            } else {
                $validresponse = $this->graphService->getUserProfile($accessToken);
            }

            if (!$validresponse) {
                $accessToken = $this->getAccessToken($refreshToken);
            }

            $messageId = $request->organization_messageNo;
            $emailDetailsParent = $this->graphService->getEmailMessageDetails($messageId, $accessToken);
            $parentFolderId = $emailDetailsParent['parentFolderId'] ?? null;

            if ($parentFolderId === null) {
                return response()->json(["status" => "error", "message" => "Parent folder ID not found."], 500);
            }

            $messageThread = $this->graphService->getEmailThread($accessToken, $messageId, $parentFolderId);
            $messageThread = $messageThread['resultMessages'];
            try {
                foreach ($messageThread as $threadItem) {

                    // Handle when $messageThread contains only one message directly
                    if (isset($threadItem['message']) && $threadItem['message'] instanceof \Microsoft\Graph\Model\Message) {
                        $message = $threadItem['message'];
                    } else {
                        $message = $threadItem;
                    }

                    // Ensure we have a valid message object
                    if ($message instanceof \Microsoft\Graph\Model\Message) {
                        $messageId = $message->getId();
                        $internetmessage_id =  $message->getInternetMessageId();
                        $conversationId = $message->getConversationId();
                        // dd($messageId);

                        // Fetch the email details using the ID
                        $emailDetails = $this->graphService->getEmailMessageDetails($messageId, $accessToken);

                        // Delete any existing OrganizationEmail with the same message_no
                        OrganizationEmail::where('message_no', $messageId)->delete();

                        // Create new OrganizationEmail instance and populate it
                        $newOrganizationMail = new OrganizationEmail();
                        $newOrganizationMail->user_id = Auth::user()->id;
                        $newOrganizationMail->organization_id = $request->link_organization_id;
                        $newOrganizationMail->message_no = $messageId;
                        $newOrganizationMail->conversation_id = $conversationId;
                        $newOrganizationMail->internetmessage_id = $internetmessage_id;
                        $newOrganizationMail->subject = $emailDetails['subject'] ?? "";
                        $newOrganizationMail->sender_email = $emailDetails['sender'];
                        $newOrganizationMail->sender = $emailDetails['senderName'];
                        $newOrganizationMail->body = $emailDetails['body'];

                        $mysqlDate = Carbon::parse($emailDetails['date'])->format('Y-m-d H:i:s');
                        $newOrganizationMail->date = $mysqlDate;

                        // Handle recipients
                        if (!empty($emailDetails['ccRecipientsfull'])) {
                            $newOrganizationMail->ccRecipients = json_encode($emailDetails['ccRecipientsfull']);
                        }
                        if (!empty($emailDetails['bccRecipientsfull'])) {
                            $newOrganizationMail->bccRecipients = json_encode($emailDetails['bccRecipientsfull']);
                        }
                        if (!empty($emailDetails['toRecipientsfull'])) {
                            $newOrganizationMail->toRecipients = json_encode($emailDetails['toRecipientsfull']);
                        }

                        $newOrganizationMail->active = 1;
                        $newOrganizationMail->save();

                    }
                }

                return response()->json(["status" => "success", "data" => $newOrganizationMail]);
            } catch (\Exception $e) {
                return response()->json(["status" => "error", "message" => $e->getMessage()], 500);
            }
        }

        public function linkExistOrganizationInfo(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{

                $validresponse = $this->graphService->getUserProfile($accessToken);

            }
            if((!$validresponse)){

                $accessToken = $this->getAccessToken($refreshToken);
            }
            $emailDetails = json_decode($request->emailDetails, true)[0];
            $emailDetails2 = $this->graphService->getEmailMessageDetails($emailDetails['id'], $accessToken);
            try {
                OrganizationEmail::where('message_no',$request->organization_messageNo)->delete();

                $newOrganizationMail = new OrganizationEmail();
                $newOrganizationMail->user_id = Auth::user()->id;
                $newOrganizationMail->organization_id = $request->link_organization_id;
                $newOrganizationMail->message_no = $emailDetails['id'];
                $newOrganizationMail->conversation_id = $emailDetails['conversationId'];
                $newOrganizationMail->internetmessage_id = $emailDetails['internetMessageId'];
                $newOrganizationMail->subject = $emailDetails['subject'];
                $newOrganizationMail->sender = $emailDetails['from']['emailAddress']['name'];
                $newOrganizationMail->sender_email = $emailDetails['from']['emailAddress']['address'];
                $newOrganizationMail->body = $emailDetails['body']['content'];

                $mysqlDate = Carbon::parse($emailDetails2['date'])->format('Y-m-d H:i:s');
                $newOrganizationMail->date = $mysqlDate;
                // Check if the CC recipients array is empty
                if (!empty($emailDetails['ccRecipients'])) {
                    // If not empty, assign it to the model
                    $newOrganizationMail->ccRecipients = json_encode($emailDetails['ccRecipients']);
                }

                // Check if the BCC recipients array is empty
                if (!empty($emailDetails['bccRecipients'])) {
                    // If not empty, assign it to the model
                    $newOrganizationMail->bccRecipients = json_encode($emailDetails['bccRecipients']);
                }
                if (!empty($emailDetails['toRecipients'])) {
                    // If not empty, assign it to the model
                    $newOrganizationMail->toRecipients = json_encode($emailDetails['toRecipients']);
                }
                $newOrganizationMail->active = 1;
                $newOrganizationMail->save();


                return response()->json(["status" => "success", "data" => $newOrganizationMail]);
            } catch (\Exception $e) {
                return response()->json(["status" => "error", "message" => $e->getMessage()], 500);
            }
        }
    public function unlinkExistOrganizationInfo(Request $request)
    {
        try {
                OrganizationEmail::where('message_no',$request->organization_messageNo)->where('organization_id', $request->link_organization_id)->delete();

                return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
                return response()->json(["status" => "error", "message" => $e->getMessage()], 500);
        }
    }

    public function addOrganization(Request $request)
        {
            $emailDetails2 = $this->graphService->getEmailMessageDetails($request->messageNo, $accessToken);
            if($request->type == 0){
                $organization = new Organization();
                $organization->organization_name = $request->organization_name;
                $organization->website = $request->website;
                $organization->email = $request->organization_email;
                $organization->sport = $request->sport;
                $organization->user_id = $request->user_id_org;
                $organization->sales_tax = $request->sales_tax;
                $organization->sales_tax_active = $request->sales_tax_active;
                $organization->size_of_club = $request->size_of_club;
                $organization->colors = $request->colors;
                $organization->shipping_street = $request->shipping_street;
                $organization->shipping_city = $request->shipping_city;
                $organization->shipping_state = $request->shipping_state;
                $organization->shipping_postal_code = $request->shipping_postal_code;
                $organization->shipping_country = $request->shipping_country;
                $organization->active =  1;
                $organization->save();

                $newOrganizationMail = new OrganizationEmail();
                $newOrganizationMail->user_id = Auth::user()->id;
                $newOrganizationMail->organization_id = $organization->id;
                $newOrganizationMail->message_no = $request->messageNo;
                $newOrganizationMail->subject = $request->subject;
                $newOrganizationMail->sender = $request->sender;
                $newOrganizationMail->active = 1;
                $newOrganizationMail->date = $emailDetails2['date'];
                $newOrganizationMail->save();
            }else{
                $newOrganizationMail = new OrganizationEmail();
                $newOrganizationMail->user_id = Auth::user()->id;
                $newOrganizationMail->organization_id = $request->orgID;
                $newOrganizationMail->message_no = $request->messageNo;
                $newOrganizationMail->subject = $request->subject;
                $newOrganizationMail->sender = $request->sender;
                $newOrganizationMail->active = 1;
                $newOrganizationMail->date = $emailDetails2['date'];
                $newOrganizationMail->save();
            }

            return json_encode(array("success", $organization->id, $organization->organization_name));

        }

    public function get_next_activity(Request $request)
    {
        $request->validate([
            'orgID' => 'required|integer',
        ]);

        $activity = Activity::where('organization_id', $request->orgID)
            ->where('is_done', 0)
            ->where('active', 1)
            ->orderBy('start_date', 'asc')
            ->first();

        if ($activity) {
            return response()->json([
                'status' => 'success',
                'activity' => $activity
            ]);
        } else {
            return response()->json([
                'status' => 'not found',
                'message' => 'No upcoming activity found.'
            ]);
        }
    }
    public function saveDraft(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;

            if ($accessToken == null && $refreshToken == null) {
                return redirect('/login/azure');
            } else {
                $validresponse = $this->graphService->getUserProfile($accessToken);
            }

            if (!$validresponse) {
                $accessToken = $this->getAccessToken($refreshToken);
            }

            // Retrieve necessary data from the form
            $subject = $request->input('subject', ''); // Default to an empty string if not provided
            $emailBody = $request->input('email_body', ''); // Default to an empty string if not provided
            $to = $request->input('to', []); // Default to an empty array if not provided
            $cc = $request->input('cc', []); // Default to an empty array if not provided
            $bcc = $request->input('bcc', []); // Default to an empty array if not provided
            $images = $request->file('attachments', []); // Default to an empty array if not provided

            // Retrieve attachments from the request
            $graphAttachments = [];

            // Process each attachment
            if ($images) {
                foreach ($images as $attachment) {
                    if ($attachment->isValid()) {
                        $fileContent = file_get_contents($attachment->getPathname());
                        $base64Content = base64_encode($fileContent);

                        $graphAttachments[] = [
                            '@odata.type' => '#microsoft.graph.fileAttachment',
                            'name' => $attachment->getClientOriginalName(),
                            'contentBytes' => $base64Content,
                            'isInline' => false,
                        ];
                    }
                }
            }

            // Process inline images
            // preg_match_all('/<img[^>]+src="([^"]+)"/', $emailBody, $matches);
            // foreach ($matches[1] as $imageUrl) {
            //     if (strpos($imageUrl, 'https://') === 0) {
            //         continue; // Skip this URL
            //     }
            //     $imageData = file_get_contents($imageUrl);
            //     $cid = md5(uniqid());
            //     $graphAttachments[] = [
            //         '@odata.type' => '#microsoft.graph.fileAttachment',
            //         'name' => basename($imageUrl),
            //         'contentBytes' => base64_encode($imageData),
            //         'isInline' => true,
            //         'contentId' => $cid,
            //         'contentType' => mime_content_type($imageUrl),
            //     ];
            //     $emailBody = str_replace($imageUrl, 'cid:' . $cid, $emailBody);
            // }

            // Prepare recipients
            $toRecipients = [];
            foreach ($to as $recipient) {
                $toRecipients[] = ['emailAddress' => ['address' => $recipient]];
            }

            // Prepare the payload for the draft
            $payload = [
                'subject' => $subject,
                'body' => [
                    'contentType' => 'HTML',
                    'content' => $emailBody // Use the updated body content with CID references
                ],
                'toRecipients' => $toRecipients,
                'attachments' => $graphAttachments,
                'isDraft' => true
            ];

            // Add CC recipients if provided
            if (!empty($cc)) {
                foreach ($cc as $recipient) {
                    $payload['ccRecipients'][] = ['emailAddress' => ['address' => $recipient]];
                }
            }

            // Add BCC recipients if provided
            if (!empty($bcc)) {
                foreach ($bcc as $recipient) {
                    $payload['bccRecipients'][] = ['emailAddress' => ['address' => $recipient]];
                }
            }

            // Sanitize the payload content to ensure it contains only valid UTF-8 characters
            $payload = $this->sanitizeUtf8($payload);

            // Make a request to the Graph API to save the draft
            $client = new Client();
            try {
                $response = $client->post('https://graph.microsoft.com/v1.0/me/messages', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json'
                    ],
                    'json' => $payload
                ]);

                // Check if the request was successful
                if ($response->getStatusCode() === 201) {
                    $responseBody = json_decode($response->getBody(), true);
                    $draftId = $responseBody['id']; // Extract the draft ID from the response
                    $emailDetails2 = $this->graphService->getEmailMessageDetails($draftId, $accessToken);
                    if(isset($request->organization_linked)){

                        OrganizationEmail::where('message_no',$draftId)->delete();

                        $newOrganizationMail = new OrganizationEmail();
                        $newOrganizationMail->user_id = Auth::user()->id;
                        $newOrganizationMail->organization_id = $request->organization_linked;
                        $newOrganizationMail->message_no = $draftId;
                        $newOrganizationMail->subject = $responseBody['subject'];
                        $newOrganizationMail->type = 'Draft';
                        $newOrganizationMail->sender_email = session('azure_logged_email') ?? null;
                        $newOrganizationMail->body = $emailBody;
                        $newOrganizationMail->date = $emailDetails2['date'];

                        // Handle recipients
                        if (!empty($responseBody['ccRecipients'])) {
                            $newOrganizationMail->ccRecipients = json_encode($responseBody['ccRecipients']);
                        }
                        if (!empty($responseBody['bccRecipients'])) {
                            $newOrganizationMail->bccRecipients = json_encode($responseBody['bccRecipients']);
                        }
                        if (!empty($responseBody['toRecipients'])) {
                            $newOrganizationMail->toRecipients = json_encode($responseBody['toRecipients']);
                        }

                        $newOrganizationMail->active = 1;
                        $newOrganizationMail->save();
                    }

                    // Draft saved successfully
                    return response()->json(['message' => 'Draft saved successfully', 'draftId' => $draftId], 200);
                } else {
                    // Failed to save draft
                    return response()->json(['error' => 'Failed to save draft'], $response->getStatusCode());
                }
            } catch (\Exception $e) {
                // Handle exceptions
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    public function updateDraft(Request $request )
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;

            if ($accessToken == null && $refreshToken == null) {
                return redirect('/login/azure');
            } else {
                $validresponse = $this->graphService->getUserProfile($accessToken);
            }

            if (!$validresponse) {
                $accessToken = $this->getAccessToken($refreshToken);
            }

            // Retrieve necessary data from the form
            $subject = $request->input('subject', '');
            $emailBody = $request->input('email_body', '');
            $to = $request->input('to', []);
            $cc = $request->input('cc', []);
            $bcc = $request->input('bcc', []);
            $images = $request->file('attachments', []);
            $draftId = $request->input('SavedDraftId');
            // Retrieve attachments from the request
            $graphAttachments = [];

            // Process each attachment
            if ($images) {
                foreach ($images as $attachment) {
                    if ($attachment->isValid()) {
                        $fileContent = file_get_contents($attachment->getPathname());
                        $base64Content = base64_encode($fileContent);

                        $graphAttachments[] = [
                            '@odata.type' => '#microsoft.graph.fileAttachment',
                            'name' => $attachment->getClientOriginalName(),
                            'contentBytes' => $base64Content,
                            'isInline' => false,
                        ];
                    }
                }
            }

            // Process inline images
            // preg_match_all('/<img[^>]+src="([^"]+)"/', $emailBody, $matches);
            // foreach ($matches[1] as $imageUrl) {
            //     if (strpos($imageUrl, 'https://') === 0) {
            //         continue;
            //     }
            //     $imageData = file_get_contents($imageUrl);
            //     $cid = md5(uniqid());
            //     $graphAttachments[] = [
            //         '@odata.type' => '#microsoft.graph.fileAttachment',
            //         'name' => basename($imageUrl),
            //         'contentBytes' => base64_encode($imageData),
            //         'isInline' => true,
            //         'contentId' => $cid,
            //         'contentType' => mime_content_type($imageUrl),
            //     ];
            //     $emailBody = str_replace($imageUrl, 'cid:' . $cid, $emailBody);
            // }

            // Prepare recipients
            $toRecipients = [];
            foreach ($to as $recipient) {
                $toRecipients[] = ['emailAddress' => ['address' => $recipient]];
            }

            // Prepare the payload for the draft
            $payload = [
                'subject' => $subject,
                'body' => [
                    'contentType' => 'HTML',
                    'content' => $emailBody
                ],
                'toRecipients' => $toRecipients,
                'attachments' => $graphAttachments,
                'isDraft' => true
            ];

            // Add CC recipients if provided
            if (!empty($cc)) {
                foreach ($cc as $recipient) {
                    $payload['ccRecipients'][] = ['emailAddress' => ['address' => $recipient]];
                }
            }

            // Add BCC recipients if provided
            if (!empty($bcc)) {
                foreach ($bcc as $recipient) {
                    $payload['bccRecipients'][] = ['emailAddress' => ['address' => $recipient]];
                }
            }

            // Sanitize the payload content to ensure it contains only valid UTF-8 characters
            $payload = $this->sanitizeUtf8($payload);

            // Make a request to the Graph API to update the draft
            $client = new Client();
            try {
                $response = $client->patch("https://graph.microsoft.com/v1.0/me/messages/{$draftId}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json'
                    ],
                    'json' => $payload
                ]);

                // Check if the request was successful
                if ($response->getStatusCode() === 200) {
                    $responseBody = json_decode($response->getBody(), true);
                    $emailDetails2 = $this->graphService->getEmailMessageDetails($responseBody['id'], $accessToken);
                    if(isset($request->organization_linked)){

                        OrganizationEmail::where('organization_id', $request->organization_linked)->where('message_no',$responseBody['id'])->delete();

                        $newOrganizationMail = new OrganizationEmail();
                        $newOrganizationMail->user_id = Auth::user()->id;
                        $newOrganizationMail->organization_id = $request->organization_linked;
                        $newOrganizationMail->message_no = $responseBody['id'];
                        $newOrganizationMail->subject = $responseBody['subject'];
                        $newOrganizationMail->type = 'Draft';
                        $newOrganizationMail->sender_email = session('azure_logged_email') ?? null;
                        $newOrganizationMail->body = $emailBody;
                        $newOrganizationMail->date = $emailDetails2['date'];

                        // Handle recipients
                        if (!empty($responseBody['ccRecipients'])) {
                            $newOrganizationMail->ccRecipients = json_encode($responseBody['ccRecipients']);
                        }
                        if (!empty($responseBody['bccRecipients'])) {
                            $newOrganizationMail->bccRecipients = json_encode($responseBody['bccRecipients']);
                        }
                        if (!empty($responseBody['toRecipients'])) {
                            $newOrganizationMail->toRecipients = json_encode($responseBody['toRecipients']);
                        }

                        $newOrganizationMail->active = 1;
                        $newOrganizationMail->save();
                    }
                    // Draft updated successfully
                    return response()->json(['message' => 'Draft updated successfully', 'draftId' => $draftId], 200);
                } else {
                    // Failed to update draft
                    return response()->json(['error' => 'Failed to update draft'], $response->getStatusCode());
                }
            } catch (\Exception $e) {
                // Handle exceptions
                return response()->json(['error' => $e->getMessage()], 500);
            }
}
    public function DeleteDraftDirect(Request $request)
        {
            $accessToken = session('azure_access_token') ?? null;
            $refreshToken = session('azure_refresh_token') ?? null;
            if($accessToken == null && $refreshToken == null){
                return redirect('/login/azure');
            }else{
                $accessToken = $this->getAccessToken($refreshToken);

                try {
                    $messageId = $request->chat_id_set;

                    OrganizationEmail::where('message_no',$messageId)->delete();

                    $this->graphService->deleteMessage($accessToken, $messageId);

                    return response()->json(['message' => 'Draft deleted successfully'], 200);
                } catch (\Exception $e) {

                    return response()->json(['error' => $e->getMessage()], 500);

                }
            }

        }

    public function saveFilter($filter)
        {
            // dd($filter);
            // Example: Get the authenticated user or any user
            $userId = Auth::user()->id; // Assuming you have authentication set up

            // Call the createOrUpdate method in EmailFilter model
            $emailFilter = EmailFilter::createOrUpdate($userId, $filter);

            return response()->json(['email_filter' => $emailFilter]);
        }


    public function syncingMailToOrg($messageId,$count,$orgId)
    {
        $accessToken = session('azure_access_token') ?? null;
        $refreshToken = session('azure_refresh_token') ?? null;
        if($accessToken == null && $refreshToken == null){
            return redirect('/login/azure');
        }else{

            $validresponse = $this->graphService->getUserProfile($accessToken);

        }
        if((!$validresponse)){

            $accessToken = $this->getAccessToken($refreshToken);
        }
        $MailLink = $this->graphService->linkAllChatToOrg($messageId,$count,$orgId,$orglinkedstatus=true,$accessToken);
        return response()->json("success");
    }

    public function emailUpdatesCount()
    {
        return response()->stream(function () {

            while (!connection_aborted()) {

                try {
                    $unreadCount = $this->getUnreadEmailCount();

                    echo "data: " . json_encode([
                        'unreadCount' => $unreadCount
                    ]) . "\n\n";

                    if (ob_get_level() > 0) {
                        ob_flush();
                    }

                    flush();

                } catch (\Exception $e) {

                    Log::error('Email SSE Error', [
                        'message' => $e->getMessage()
                    ]);

                    echo "data: " . json_encode([
                        'unreadCount' => 0,
                        'error' => true
                    ]) . "\n\n";

                    flush();
                }

                sleep(60); // Graph API call every 30 seconds instead of 5
            }

        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'Connection'        => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Nginx
        ]);
    }

    private function getUnreadEmailCount(): int
    {
        try {

            $accessToken  = session('azure_access_token');
            $refreshToken = session('azure_refresh_token');

            if (!$accessToken && !$refreshToken) {
                return 0;
            }

            // Refresh token only if access token is invalid
            if ($accessToken) {

                $isValid = $this->graphService->getUserProfile($accessToken);

                if (!$isValid && $refreshToken) {
                    $accessToken = $this->getAccessToken($refreshToken);
                }

            } elseif ($refreshToken) {

                $accessToken = $this->getAccessToken($refreshToken);
            }

            if (!$accessToken) {
                return 0;
            }

            $response = (new Client())->get(
                'https://graph.microsoft.com/v1.0/me/mailFolders/inbox',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                    'query' => [
                        '$select' => 'unreadItemCount',
                    ],
                ]
            );

            $body = json_decode(
                $response->getBody()->getContents(),
                true
            );

            return (int) ($body['unreadItemCount'] ?? 0);

        } catch (\Exception $e) {

            Log::error('Unread Mail Count Error', [
                'message' => $e->getMessage()
            ]);

            return 0;
        }
    }
   public function checkEmailOrganization(Request $request)
    {
        $email = $request->input('email');
        $currentOrgId = $request->input('org_id');

        $emailUser = Contact::where('email', $email)
            ->orWhere('email_two', $email)
            ->with(['contactOrganizations.organizations']) // eager load nested orgs
            ->first();

        if ($emailUser && $emailUser->contactOrganizations) {
            $otherOrgs = [];
            $hasthisorg = false;
            foreach ($emailUser->contactOrganizations as $orgLink) {
                $org = $orgLink->organizations;
                $org = $org[0];


                if ($org && $org['id'] != $currentOrgId) {
                    $otherOrgs[] = [
                        'id' => $org['id'],
                        'name' => $org->organization_name
                    ];
                }else{
                     $hasthisorg = true;
                }
            }

            if (count($otherOrgs) > 0 && ! $hasthisorg) {
                return response()->json([
                    'linked_to_another_org' => true,
                    'org_list' => $otherOrgs
                ]);
            }
        }

        return response()->json(['linked_to_another_org' => false]);
    }


    public function testfunction($id = null)
{
    $query = OrganizationEmail::select('sender_email', 'message_no','subject');

    if ($id) {
        $query->where('message_no', $id);
    }

    $organizationMail = $query->get();

    dd($organizationMail);
}
}
