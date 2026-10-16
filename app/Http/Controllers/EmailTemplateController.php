<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\UserEmailTemplate;
use Auth;
use App\Models\EmailSignature;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationBuilderService;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $emailTemplates = null;
        $AddedEmailTemplates = null;
        $PublicEmailTemplates = null;
        $all_users = User::get();

        return view('pages.mail.email_templates.index', compact('emailTemplates','PublicEmailTemplates','AddedEmailTemplates','all_users'));

    }

    public function getAllTableData(){
        $userId = Auth::user()->id;
        $emailTemplates = EmailTemplate::where('user_id', $userId)->where('active' , 1)->get();
        $AddedEmailTemplates = UserEmailTemplate::where('user_id', $userId)->with('emailTemplate')->get();

        $PublicEmailTemplates = EmailTemplate::where('publish_type', 1)->where('user_id', '!=', $userId)->where('active' , 1)->get();

        $addedTemplateIds = $AddedEmailTemplates->pluck('template_id')->toArray();

        $PublicEmailTemplates = $PublicEmailTemplates->reject(function ($template) use ($addedTemplateIds) {
            return in_array($template->id, $addedTemplateIds);
        });

        return  json_encode(['emailTemplates' => $emailTemplates,'PublicEmailTemplates' => $PublicEmailTemplates,'AddedEmailTemplates' => $AddedEmailTemplates]);
    }
    public function getSearchTableData(Request $request){
        $userId = Auth::user()->id;
        $emailTemplates = EmailTemplate::where('user_id', $userId)->
                                        where(function($query) use ($request) {
                                            $query->where('title', 'LIKE', '%' . $request->search_key . '%')
                                                ->orWhere('subject', 'LIKE', '%' . $request->search_key . '%');
                                        })->where('active' , 1)->get();
        $AddedEmailTemplates = UserEmailTemplate::where('user_id', $userId)
                                        ->whereHas('emailTemplate', function($query) use ($request) {
                                            $query->where('title', 'LIKE', '%' . $request->search_key . '%')
                                                  ->orWhere('subject', 'LIKE', '%' . $request->search_key . '%');
                                        })->with('emailTemplate')->get();

        $PublicEmailTemplates = EmailTemplate::where('publish_type', 1)->where('user_id', '!=', $userId)
                                                ->where(function($query) use ($request) {
                                                    $query->where('title', 'LIKE', '%' . $request->search_key . '%')
                                                          ->orWhere('subject', 'LIKE', '%' . $request->search_key . '%');
                                                })->where('active' , 1)->get();

        $addedTemplateIds = $AddedEmailTemplates->pluck('template_id')->toArray();

        $PublicEmailTemplates = $PublicEmailTemplates->reject(function ($template) use ($addedTemplateIds) {
            return in_array($template->id, $addedTemplateIds);
        });

        return  json_encode(['emailTemplates' => $emailTemplates,'PublicEmailTemplates' => $PublicEmailTemplates,'AddedEmailTemplates' => $AddedEmailTemplates]);
    }
    public function do_with_selected(Request $request) {
        $array_data = json_decode($request->array_data, true);

        if (!is_array($array_data)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data format'], 400);
        }

        switch ($request->type) {
            case 'delete_item':
                foreach ($array_data as $id) {
                    $emailTemplate = EmailTemplate::find($id);
                    if ($emailTemplate) {
                        $emailTemplate->active = 0;
                        $emailTemplate->save();
                    }
                }
                break;

            case 'remove_from_list':
                foreach ($array_data as $id) {
                    $userEmailTemplate = UserEmailTemplate::where('user_id' , Auth::user()->id)->where('template_id' , $id)->first();
                    if ($userEmailTemplate) {
                        $userEmailTemplate->delete();
                    }
                }
                break;

            case 'add_to_my_list':
                foreach ($array_data as $id) {
                    $existingRecord = UserEmailTemplate::where('user_id', Auth::user()->id)->where('template_id' , $id)->first();

                    if(!$existingRecord){

                        $userEmailTemplate = new UserEmailTemplate();
                        $userEmailTemplate->user_id = Auth::user()->id;
                        $userEmailTemplate->template_id = $id;
                        $userEmailTemplate->save();

                    }
                }
                break;

            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid action type'], 400);
        }

        return response()->json(['status' => 'success', 'data' => $array_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // Validate the incoming request data
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'subject' => 'required|string|max:255',
        //     'body' => 'required|string',
        //     'publish_type' => 'required|integer',
        //     // Add more validation rules as needed
        // ]);

        // Create a new instance of EmailTemplate model
        $emailTemplate = new EmailTemplate();
        $emailTemplate->title = $request->title;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->body = $request->templatecontent;
        $emailTemplate->publish_type = $request->publish_type;
        $emailTemplate->user_id = Auth::user()->id;
        $emailTemplate->active = 1; // Set default value if needed


        // Save the email template
        $emailTemplate->save();
        $emailTemplate_id = $emailTemplate->id;
        $templateBodyHtml = $this->toHtml($request->templatecontent);

        
        if ($request->publish_type == 1) {
            $builder = new NotificationBuilderService();

            $builder->sendNotification(
                'key_email_template_creation',
                [
                    '{user_name}'        => Auth::user()->name,
                    '{template_title}'   => $request->title,
                    '{template_link}'    => url('email/templates'),
                    '{template_subject}' => $request->subject,
                    '{template_body}'    => $templateBodyHtml,
                    '{template_id}'      => $emailTemplate_id,
                ],
                [
                    'email_template_id'          => $emailTemplate_id,
                    'target_notification_field'  => 'key_email_template_creation',
                    'new_notification'           => 1,
                ]
            );
        }

        // Redirect to a success page or return a response
        return redirect()->route('email.templates')->with('success', 'Email template created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the email template with the specified ID
        $emailTemplate = EmailTemplate::findOrFail($id);

        // Return the email template data in JSON format
        return response()->json($emailTemplate);
    }
    public function pick($id)
{
    // Retrieve the email template with the specified ID
    $emailTemplate = EmailTemplate::findOrFail($id);
    $userId = Auth::user()->id;

    // Retrieve email signature belonging to the authenticated user
    $emailSignature = EmailSignature::where('user_id', $userId)->first();

    // Convert JSON strings to arrays
    $ops1 = json_decode($emailTemplate->body, true)['ops'] ?? [];
    $ops2 = json_decode($emailSignature->signature, true)['ops'] ?? [];

    // Merge "ops" arrays
    $mergedOps = array_merge($ops1, $ops2);

    // Create a new delta object with merged "ops" array
    $mergedDelta = json_encode(['ops' => $mergedOps]);

    // Update the body of the email template with the merged delta object
    $emailTemplate->body = $mergedDelta;

    // Return the modified email template data
    return response()->json($emailTemplate);
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        // Retrieve the email template from the database
        $emailTemplate = EmailTemplate::findOrFail($request->template_id);

        // Update the email template data
        $emailTemplate->update([
            'body' => $request->templatecontent,
            'title' => $request->title,
            'subject' => $request->subject,
            'publish_type' => $request->publish_type,
            // Update other fields as needed
        ]);

        // Return a response indicating success
        return redirect()->back()->with('success', 'Email template Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EmailTemplate = EmailTemplate::find($id);

        if ($EmailTemplate) {
            $EmailTemplate->active = 0;
            $EmailTemplate->save();
        }

        return response()->json(['message' => 'User email template deleted successfully'], 200);
    }
    public function add($id)
    {

        $existingRecord = UserEmailTemplate::where('user_id', Auth::user()->id)->where('template_id' , $id)->first();

        if(!$existingRecord){

            $userEmailTemplate = new UserEmailTemplate();
            $userEmailTemplate->user_id = Auth::user()->id; // Replace with the actual user ID
            $userEmailTemplate->template_id = $id; // Replace with the actual template ID
            $userEmailTemplate->save();

            return json_encode($userEmailTemplate);
        }else{
            return json_encode($existingRecord);
        }

    }
    public function addEmailTemplate(Request $request)
    {
        $existingRecord = UserEmailTemplate::where('user_id', Auth::user()->id)->where('template_id' , $request->template_id)->first();
        Notification::where('id', $request->notification_id)
        ->update([
            'order_reject_or_confirm' => 2,
        ]);

        if(!$existingRecord){
            $userEmailTemplate = new UserEmailTemplate();
            $userEmailTemplate->user_id = Auth::user()->id; 
            $userEmailTemplate->template_id = $request->template_id; 
            $userEmailTemplate->save();

            return response()->json(['status' => true, 'message' => 'Added to your list successfully']);
        }

        return response()->json(['status' => true, 'message' => 'Already in your list']);
    }

    public function remove($id)
    {
        $userEmailTemplate = UserEmailTemplate::find($id);

        if ($userEmailTemplate) {
            $userEmailTemplate->delete();
        }


        return response()->json(['message' => 'User email template deleted successfully'], 200);
    }

    private function toHtml($deltaJson)
    {
        if (empty($deltaJson)) {
            return '';
        }

        $delta = json_decode($deltaJson, true);
        if (!isset($delta['ops']) || !is_array($delta['ops'])) {
            return nl2br(e($deltaJson));
        }

        $blocks = [];
        $buffer = '';

        foreach ($delta['ops'] as $op) {
            if (!isset($op['insert']) || !is_string($op['insert'])) {
                continue;
            }

            $attrs = $op['attributes'] ?? [];
            $parts = explode("\n", $op['insert']);
            $partCount = count($parts);

            foreach ($parts as $i => $part) {
                if ($part !== '') {
                    $escaped = e($part);
                    if (!empty($attrs['bold'])) {
                        $escaped = "<strong>{$escaped}</strong>";
                    }
                    $buffer .= $escaped;
                }

                // Every "\n" boundary closes the current block
                if ($i < $partCount - 1) {
                    $type = (!empty($attrs['list']) && $attrs['list'] === 'bullet') ? 'li' : 'p';
                    $blocks[] = ['type' => $type, 'html' => $buffer];
                    $buffer = '';
                }
            }
        }

        if ($buffer !== '') {
            $blocks[] = ['type' => 'p', 'html' => $buffer];
        }

        $html = '';
        $inList = false;
        foreach ($blocks as $block) {
            if ($block['html'] === '') {
                continue;
            }
            if ($block['type'] === 'li') {
                if (!$inList) { $html .= '<ul>'; $inList = true; }
                $html .= "<li>{$block['html']}</li>";
            } else {
                if ($inList) { $html .= '</ul>'; $inList = false; }
                $html .= "<p>{$block['html']}</p>";
            }
        }
        if ($inList) { $html .= '</ul>'; }

        return $html;
    }
}
