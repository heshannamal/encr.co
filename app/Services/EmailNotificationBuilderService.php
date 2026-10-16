<?php
namespace App\Services;

use App\Models\EmailNotification;
use App\Models\EmailNotificationTemplateUser;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Organization;
use App\Models\UserLeave;
use App\Models\Project;
use App\Models\PmSection;
use App\Models\PmSectionDiscussion;
use App\Models\PmSectionSubDiscussion;
use App\Models\Store;
use App\Models\Contact;
use App\Models\EmailNotificationTemplateCustomer;
use Illuminate\Support\Facades\Blade;


class EmailNotificationBuilderService{

    var $smptEncryption = 'SSL';
    var $smptPort = '465';
    var $smptHost = 'mail.encr.co';
    var $username = 'info@encr.co';
    var $password = 'Encr.co@ec123';
    public function sendEmailFromTemplate(string $templateId, array $replacements): bool
    {
        config(['mail.mailers.smtp.transport' => 'smtp']);
        config(['mail.mailers.smtp.host' => $this->smptHost]);
        config(['mail.mailers.smtp.port' => $this->smptPort]);
        config(['mail.mailers.smtp.encryption' => $this->smptEncryption]);

        config(['mail.mailers.smtp.username' => $this->username]);
        config(['mail.mailers.smtp.password' => $this->password]);

        config(['mail.from.address' => $this->username]);
        config(['mail.from.name' => 'Encore Custom']);
        $template = EmailNotification::where('template_key', $templateId)->first();
        if (!$template) {
            \Log::warning("Email template ID {$templateId} not found.");
            return false;
        }
        if ($template->active != 1) {
            return true; // Notification disabled
        }

        // Replace placeholders
       $subject = Blade::render($template->subject, $replacements);

        $to = EmailNotificationTemplateUser::getEmailsByType($template->id, 0);
        $cc = EmailNotificationTemplateUser::getEmailsByType($template->id, 1);
        $bcc = EmailNotificationTemplateUser::getEmailsByType($template->id, 2);
        if ((int) $template->send_organization == 1) {
            $to = array_values(array_unique(array_merge(
                $to,
                EmailNotificationTemplateCustomer::getEmailsByType(
                    $template->id,
                    0
                )
            )));

            $cc = array_values(array_unique(array_merge(
                $cc,
                EmailNotificationTemplateCustomer::getEmailsByType(
                    $template->id,
                    1
                )
            )));

            $bcc = array_values(array_unique(array_merge(
                $bcc,
                EmailNotificationTemplateCustomer::getEmailsByType(
                    $template->id,
                    2
                )
            )));
        }
        if($template->proccessing_rep == 1  && isset($replacements['orderId'])){
            $order_Details = Order::where('id',$replacements['orderId'])->first();
            $user_email = User::where('id', $order_Details->order_procesing_user_id)->value('email');
            if ($user_email) {
                $to = array_unique(array_merge($to, [$user_email]));
            }
        }
        if($template->sales_rep == 1  && isset($replacements['orderId'])){
            $order_Details = Order::where('id',$replacements['orderId'])->first();
            $user_email = User::where('id', $order_Details->user_id)->value('email');
            if ($user_email) {
                $to = array_unique(array_merge($to, [$user_email]));
            }
        }

        if($template->order_customer == 1  && isset($replacements['orderId'])){
            $order_Details = Order::with('contactDetails')->where('id',$replacements['orderId'])->first();
            $user_email = $order_Details->contactDetails->email ?? null;
            if ($user_email) {
                $to = array_unique(array_merge($to, [$user_email]));
            }
        }

        if(isset($replacements['organization_id'])){

            $organizationSettings = json_decode($template->organization_user, true);
            $organization = Organization::with('userDetails','contactOrganizations')->where('id', $replacements['organization_id'])->first();

            if(isset($organizationSettings['to'])){
                $toSettings = $organizationSettings['to'];
                if(isset($toSettings['organization']) && $toSettings['organization'] == 1){
                    $organizationEmail = $organization->email ?? null;
                    if ($organizationEmail) {
                        $to = array_unique(array_merge($to, [$organizationEmail]));
                    }
                }
                if(isset($toSettings['sales_rep']) && $toSettings['sales_rep'] == 1){
                    $salesRepEmail = $organization->userDetails->email ?? null;
                    if ($salesRepEmail) {
                        $to = array_unique(array_merge($to, [$salesRepEmail]));
                    }
                }
                if(isset($toSettings['customers']) && $toSettings['customers'] == 1){
                    $customerContacts = $organization->contactOrganizations->pluck('contact_id')->toArray();
                    $customerEmails = Contact::whereIn('id',$customerContacts)->pluck('email')->toArray();
                    if (!empty($customerEmails)) {
                        $to = array_unique(array_merge($to, $customerEmails));
                    }
                }
            }
            if(isset($organizationSettings['cc'])){
                $ccSettings = $organizationSettings['cc'];
                if(isset($ccSettings['organization']) && $ccSettings['organization'] == 1){
                    $organizationEmail = $organization->email ?? null;
                    if ($organizationEmail) {
                        $cc = array_unique(array_merge($cc, [$organizationEmail]));
                    }
                }
                if(isset($ccSettings['sales_rep']) && $ccSettings['sales_rep'] == 1){
                    $salesRepEmail = $organization->userDetails->email ?? null;
                    if ($salesRepEmail) {
                        $cc = array_unique(array_merge($cc, [$salesRepEmail]));
                    }
                }
                if(isset($ccSettings['customers']) && $ccSettings['customers'] == 1){
                    $customerContacts = $organization->contactOrganizations->pluck('contact_id')->toArray();
                    $customerEmails = Contact::whereIn('id',$customerContacts)->pluck('email')->toArray();
                    if (!empty($customerEmails)) {
                        $cc = array_unique(array_merge($cc, $customerEmails));
                    }
                }
            }
            if(isset($organizationSettings['bcc'])){
                $bccSettings = $organizationSettings['bcc'];
                if(isset($bccSettings['organization']) && $bccSettings['organization'] == 1){
                    $organizationEmail = $organization->email ?? null;
                    if ($organizationEmail) {
                        $bcc = array_unique(array_merge($bcc, [$organizationEmail]));
                    }
                }
                if(isset($bccSettings['sales_rep']) && $bccSettings['sales_rep'] == 1){
                    $salesRepEmail = $organization->userDetails->email ?? null;
                    if ($salesRepEmail) {
                        $bcc = array_unique(array_merge($bcc, [$salesRepEmail]));
                    }
                }
                if(isset($bccSettings['customers']) && $bccSettings['customers'] == 1){
                    $customerContacts = $organization->contactOrganizations->pluck('contact_id')->toArray();
                    $customerEmails = Contact::whereIn('id',$customerContacts)->pluck('email')->toArray();
                    if (!empty($customerEmails)) {
                        $bcc = array_unique(array_merge($bcc, $customerEmails));
                    }
                }
            }
        }

        if(isset($replacements['user_leave_id'])){
            $HRsettings = json_decode($template->hr_users, true);
            $userLeave = UserLeave::with('userDetails')->where('id', $replacements['user_leave_id'])->first();
            if($userLeave){
                if(isset($HRsettings['to'])){
                    $toSettings = $HRsettings['to'];
                    if(isset($toSettings['employee']) && $toSettings['employee'] == 1){
                        $leaveUserEmail = $userLeave->userDetails->email ?? null;
                        if ($leaveUserEmail) {
                            $to = array_unique(array_merge($to, [$leaveUserEmail]));
                        }
                    }
                }
                if(isset($HRsettings['cc'])){
                    $ccSettings = $HRsettings['cc'];
                    if(isset($ccSettings['employee']) && $ccSettings['employee'] == 1){
                        $leaveUserEmail = $userLeave->userDetails->email ?? null;
                        if ($leaveUserEmail) {
                            $cc = array_unique(array_merge($cc, [$leaveUserEmail]));
                        }
                    }
                }
                if(isset($HRsettings['bcc'])){
                    $bccSettings = $HRsettings['bcc'];
                    if(isset($bccSettings['employee']) && $bccSettings['employee'] == 1){
                        $leaveUserEmail = $userLeave->userDetails->email ?? null;
                        if ($leaveUserEmail) {
                            $bcc = array_unique(array_merge($bcc, [$leaveUserEmail]));
                        }
                    }
                }
            }
        }

        if(isset($replacements['store_id'])){
            $storeSettings = json_decode($template->store_users, true);
            $store = Store::with('userDetails','StoreOrders.storeCustomer')->where('id', $replacements['store_id'])->first();
            if($store){
                $storeSalesRepEmail = $store->userDetails->email ?? null;
                $storecustomerEmails = $store->StoreOrders->pluck('storeCustomer.email')->filter()->unique()->values()->toArray();

                if(isset($storeSettings['to'])){
                    $toStoreSetting = $storeSettings['to'];
                    if(isset($toStoreSetting['sales_rep']) && $toStoreSetting['sales_rep'] == 1){
                        if($storeSalesRepEmail){
                            $to = array_unique(array_merge($to, [$storeSalesRepEmail]));
                        }
                    }
                    if(isset($toStoreSetting['store_customers']) && $toStoreSetting['store_customers'] == 1){
                        if(!empty($storecustomerEmails)){
                            $to = array_unique(array_merge($to, $storecustomerEmails));
                        }
                    }
                    if(isset($toStoreSetting['custom_email']) && $toStoreSetting['custom_email'] == 1){
                        if(isset($replacements['custom_email'])){
                            $to = array_unique(array_merge($to, [$replacements['custom_email']]));
                        }
                    }
                }
                if(isset($storeSettings['cc'])){
                    $ccStoreSetting = $storeSettings['cc'];
                    if(isset($ccStoreSetting['sales_rep']) && $ccStoreSetting['sales_rep'] == 1){
                        if($storeSalesRepEmail){
                            $cc = array_unique(array_merge($cc, [$storeSalesRepEmail]));
                        }
                    }
                    if(isset($ccStoreSetting['store_customers']) && $ccStoreSetting['store_customers'] == 1){
                        if(!empty($storecustomerEmails)){
                            $cc = array_unique(array_merge($cc, $storecustomerEmails));
                        }
                    }
                    if(isset($ccStoreSetting['custom_email']) && $ccStoreSetting['custom_email'] == 1){
                        if(isset($replacements['custom_email'])){
                            $cc = array_unique(array_merge($cc, [$replacements['custom_email']]));
                        }
                    }
                }
                if(isset($storeSettings['bcc'])){
                    $bccStoreSetting = $storeSettings['bcc'];
                    if(isset($bccStoreSetting['sales_rep']) && $bccStoreSetting['sales_rep'] == 1){
                        if($storeSalesRepEmail){
                            $bcc = array_unique(array_merge($bcc, [$storeSalesRepEmail]));
                        }
                    }
                    if(isset($bccStoreSetting['store_customers']) && $bccStoreSetting['store_customers'] == 1){
                        if(!empty($storecustomerEmails)){
                            $bcc = array_unique(array_merge($bcc, $storecustomerEmails));
                        }
                    }
                    if(isset($bccStoreSetting['custom_email']) && $bccStoreSetting['custom_email'] == 1){
                        if(isset($replacements['custom_email'])){
                            $bcc = array_unique(array_merge($bcc, [$replacements['custom_email']]));
                        }
                    }
                }
            }
        }

        if(isset($replacements['projectId'])){
            $PMsettings = json_decode($template->pm_users, true);
            $project = Project::find($replacements['projectId']);
            if($project){
                if(isset($PMsettings['to'])){
                    $projectOwner = User::find($project->owner_id);
                    if($projectOwner){
                        if(isset($PMsettings['to']['project_owner']) && $PMsettings['to']['project_owner'] == 1){
                            $to = array_unique(array_merge($to, [$projectOwner->email]));
                        }
                        if(isset($PMsettings['cc']['project_owner']) && $PMsettings['cc']['project_owner'] == 1){
                            $cc = array_unique(array_merge($cc, [$projectOwner->email]));
                        }
                        if(isset($PMsettings['bcc']['project_owner']) && $PMsettings['bcc']['project_owner'] == 1){
                            $bcc = array_unique(array_merge($bcc, [$projectOwner->email]));
                        }
                    }
                }
            }
        }

        if(isset($replacements['discussionId'])){
            $PMsettings = json_decode($template->pm_users, true);
            $discussion = PmSectionDiscussion::with('assigneeUser')->find($replacements['discussionId']);
            if($discussion){
                $assigneeUser = $discussion->assigneeUser;
                $PMsection = PmSection::find($discussion->section_id);
                if($assigneeUser && empty($PMsection->order_id)){
                    if(isset($PMsettings['to']['task_assignees']) && $PMsettings['to']['task_assignees'] == 1){
                        $to = array_unique(array_merge($to, [$assigneeUser->email]));
                    }
                    if(isset($PMsettings['cc']['task_assignees']) && $PMsettings['cc']['task_assignees'] == 1){
                        $cc = array_unique(array_merge($cc, [$assigneeUser->email]));
                    }
                    if(isset($PMsettings['bcc']['task_assignees']) && $PMsettings['bcc']['task_assignees'] == 1){
                        $bcc = array_unique(array_merge($bcc, [$assigneeUser->email]));
                    }
                }
            }
        }

        if(isset($replacements['subDiscussionId'])){
            $PMsettings = json_decode($template->pm_users, true);
            $subDiscussion = PmSectionSubDiscussion::with('assigneeUser')->find($replacements['subDiscussionId']);
            if($subDiscussion){
                $assigneeUser = $subDiscussion->assigneeUser;
                $PMsection = PmSection::find($subDiscussion->section_id);
                if($assigneeUser && empty($PMsection->order_id)){
                    if(isset($PMsettings['to']['sub_task_assignees']) && $PMsettings['to']['sub_task_assignees'] == 1){
                        $to = array_unique(array_merge($to, [$assigneeUser->email]));
                    }
                    if(isset($PMsettings['cc']['sub_task_assignees']) && $PMsettings['cc']['sub_task_assignees'] == 1){
                        $cc = array_unique(array_merge($cc, [$assigneeUser->email]));
                    }
                    if(isset($PMsettings['bcc']['sub_task_assignees']) && $PMsettings['bcc']['sub_task_assignees'] == 1){
                        $bcc = array_unique(array_merge($bcc, [$assigneeUser->email]));
                    }
                }
            }
        }

        if(isset($replacements['custom_email']) && !empty($replacements['custom_email'])){
            $Customsettings = json_decode($template->custom_email, true);

            $customEmailInput = $replacements['custom_email'];
            $isCustomEmailString = is_string($customEmailInput);

            if(isset($Customsettings['to']['custom_email']) && $Customsettings['to']['custom_email'] == 1){
                $customToArray = $isCustomEmailString ? [$customEmailInput] : ($customEmailInput['to'] ?? []);
                if (!empty($customToArray)) {
                    $to = array_unique(array_merge($to, $customToArray));
                }
            }
            if(isset($Customsettings['cc']['custom_email']) && $Customsettings['cc']['custom_email'] == 1){
                $customCcArray = $isCustomEmailString ? [$customEmailInput] : ($customEmailInput['cc'] ?? []);
                if (!empty($customCcArray)) {
                    $cc = array_unique(array_merge($cc, $customCcArray));
                }
            }
            if(isset($Customsettings['bcc']['custom_email']) && $Customsettings['bcc']['custom_email'] == 1){
                $customBccArray = $isCustomEmailString ? [$customEmailInput] : ($customEmailInput['bcc'] ?? []);
                if (!empty($customBccArray)) {
                    $bcc = array_unique(array_merge($bcc, $customBccArray));
                }
            }
        }

        if(isset($replacements['orderId']) && isset($replacements['send_relevent_factory']) && $template->related_fac == 1){
            $orderDetails = Order::where('id',$replacements['orderId'])->with('orderItems')->first();
            if($replacements['send_relevent_factory'] && $template->related_fac == 1){
                $factoryArray = [];
                if(isset($replacements['factorys_array'])){
                    $factoryArray = $replacements['factorys_array'];
                }else{
                    if(isset($replacements['new_order_items'])){
                        foreach($replacements['new_order_items'] as $newOrderItem){
                            $item = OrderItem::find($newOrderItem->id);
                            if(isset($item->factory_id)){
                                $factoryArray[] = $item->factory_id;
                            }
                        }
                    }else{
                        foreach($orderDetails->orderItems as $newOrderItem){
                            $item = OrderItem::find($newOrderItem->id);
                            if(isset($item->factory_id)){
                                $factoryArray[] = $item->factory_id;
                            }
                        }
                    }
                }
            }
            if($factoryArray){
                foreach (array_unique($factoryArray) as $factory_id) {


                    if($factory_id == 2){     // PBS Factory
                        $userRoleId = 5;  // PBS
                    }
                    if($factory_id == 1){     // WDC Factory
                        $userRoleId = 6;  // WDC
                    }
                    if($factory_id == 3){     // BII Factory
                        $userRoleId = 7;  // BII
                    }
                    if($factory_id == 7){     // UET Factory
                        $userRoleId = 8;  // UET
                    }
                    if($factory_id == 10){     // ZYS Factory
                        $userRoleId = 11;  // ZYS
                    }
                    if($factory_id == 16){     // Test Factory
                        $userRoleId = 12;  // Test
                    }
                    if($factory_id == 18){     // BT Factory
                        $userRoleId = 27;
                    }
                    $users = User::select('email')
                                ->whereHas('roles', function($q) use ($userRoleId) {
                                    $q->where('id', $userRoleId);
                                })
                                ->where('active', 1)
                                ->get()
                                ->pluck('email') // get only email values
                                ->toArray();
                    $to_new = array_unique(array_merge($to, $users));
                    $orderItemArray = '';

                    if (isset($replacements['new_order_items']) && !empty($replacements['new_order_items'])) {
                        foreach ($replacements['new_order_items'] as $newOrderItem) {
                            $item = OrderItem::find($newOrderItem->id);
                            if ($item && $item->factory_id == $factory_id) {
                                $orderItemArray .= '<li>' . e($item->productDetails->product_name) . '</li>';
                            }
                        }
                    } else {
                        foreach ($orderDetails->orderItems as $newOrderItem) {
                            $item = OrderItem::find($newOrderItem->id);
                            if ($item && $item->factory_id == $factory_id) {
                                $orderItemArray .= '<li>' . e($item->productDetails->product_name) . '</li>';
                            }
                        }
                    }
                    $new_replacements = array_merge(['order_items_Array' =>  $orderItemArray], $replacements);
                    // $new_replacements = ['order_items_Array' => $orderItemArray];
                    $New_body = Blade::render($template->body, $new_replacements);
                    if (empty($to_new)) {
                        \Log::warning("No 'To' recipients found for template ID {$templateId}.");
                        return false;
                    }

                    $isTestEnvironment = (int) $template->environment == 0;

                    if ($isTestEnvironment) {

                        $testEmails = [
                            'prasad@encorebrand.com',
                            'kasunencoreit@gmail.com',
                        ];

                        $testBody = '
                            <div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                                <h2 style="margin-bottom: 10px;">TEST EMAIL - Email Notification Preview</h2>

                                <p><strong>Original Subject:</strong> ' . e($subject) . '</p>

                                <hr>

                                <h3>Original Recipient Details</h3>

                                <p><strong>TO:</strong><br>' . e(implode(', ', (array) $to_new)) . '</p>
                                <p><strong>CC:</strong><br>' . e(implode(', ', (array) $cc)) . '</p>
                                <p><strong>BCC:</strong><br>' . e(implode(', ', (array) $bcc)) . '</p>

                                <hr>

                                <h3>Email Body Preview</h3>

                                <div style="border: 1px solid #ddd; padding: 15px; background: #fafafa;">
                                    ' . $New_body . '
                                </div>
                            </div>
                        ';

                        \Mail::html($testBody, function ($message) use ($testEmails, $subject) {
                            $message->to($testEmails);
                            $message->subject('[TEST EMAIL] ' . $subject);
                        });

                        return true;

                    } else {

                        \Mail::html($New_body, function ($message) use ($to_new, $cc, $bcc, $subject) {
                            $message->to($to_new);

                            if (!empty($cc)) {
                                $message->cc($cc);
                            }

                            if (!empty($bcc)) {
                                $message->bcc($bcc);
                            }

                            $message->subject($subject);
                        });

                        return true;
                    }
                }
            }
        }else{
            $new_replacements = array_merge(['order_items_Array' => ''], $replacements);
            $body = Blade::render($template->body, $new_replacements);

            if (empty($to)) {
                \Log::warning("No 'To' recipients found for template ID {$templateId}.");
                return false;
            }

            $isTestEnvironment = (int) $template->environment == 0;

            if ($isTestEnvironment) {

                $testEmails = [
                    'prasad@encorebrand.com',
                    'kasunencoreit@gmail.com',
                ];

                $testBody = '
                    <div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
                        <h2 style="margin-bottom: 10px;">TEST EMAIL - Email Notification Preview</h2>

                        <p><strong>Original Subject:</strong> ' . e($subject) . '</p>

                        <hr>

                        <h3>Original Recipient Details</h3>

                        <p><strong>TO:</strong><br>' . e(implode(', ', (array) $to)) . '</p>
                        <p><strong>CC:</strong><br>' . e(implode(', ', (array) $cc)) . '</p>
                        <p><strong>BCC:</strong><br>' . e(implode(', ', (array) $bcc)) . '</p>

                        <hr>

                        <h3>Email Body Preview</h3>

                        <div style="border: 1px solid #ddd; padding: 15px; background: #fafafa;">
                            ' . $body . '
                        </div>
                    </div>
                ';


                try {
                    \Mail::html($testBody, function ($message) use ($testEmails, $subject) {
                        $message->to($testEmails);
                        $message->subject('[TEST EMAIL] ' . $subject);
                    });

                    return true;
                } catch (\Exception $e) {
                    \Log::error("Failed to send test email for template {$templateId}: " . $e->getMessage());
                    return false;
                }

            } else {
                try {
                    \Mail::html($body, function ($message) use ($to, $cc, $bcc, $subject) {
                        $message->to($to);

                        if (!empty($cc)) {
                            $message->cc($cc);
                        }
                        if (!empty($bcc)) {
                            $message->bcc($bcc);
                        }
                        $message->subject($subject);
                    });

                    return true;
                } catch (\Exception $e) {
                    \Log::error("Failed to send email for template {$templateId}: " . $e->getMessage());
                    return false;
                }
            }
        }
    }

    protected function applyReplacements(string $text, array $replacements): string
    {
        foreach ($replacements as $placeholder => $value) {
            $text = str_replace($placeholder, $value, $text);
        }
        return $text;
    }

}
