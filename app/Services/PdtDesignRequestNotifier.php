<?php
namespace App\Services;
use Illuminate\Support\Facades\Log;
class PdtDesignRequestNotifier extends NotificationBuilderService
{
    private function replacements($request): array
    {
        return ['request_id'=>$request->id,'request_title'=>$request->title,'request_brief'=>$request->brief ?? '',
            'sales_rep_name'=>$request->requester->name ?? 'Sales','request_url'=>route('pdt.design-requests.show',$request),
            'product_names'=>$request->items->map(function($item){return $item->product->product->product_name ?? 'Product #'.$item->pdt_product_id;})->implode(', ')];
    }
    private function dispatchConfigured($request,string $notificationKey,string $emailKey): array
    {
        $values=$this->replacements($request);$notified=false;$sent=false;
        $notificationValues=[];
        foreach($values as $key=>$value)$notificationValues['{{'.$key.'}}']=e((string)$value);
        try{$notified=app(NotificationBuilderService::class)->sendNotification($notificationKey,$notificationValues,['new_notification'=>1,'target_notification_field'=>$notificationKey]);}
        catch(\Throwable $error){Log::warning('PDT configured notification failed',['request_id'=>$request->id,'template_key'=>$notificationKey]);}
        try{$sent=app(EmailNotificationBuilderService::class)->sendEmailFromTemplate($emailKey,$values);}
        catch(\Throwable $error){Log::warning('PDT configured email failed',['request_id'=>$request->id,'template_key'=>$emailKey]);}
        return ['notified'=>$notified?1:0,'email_sent'=>$sent];
    }
    public function created($request): array{return $this->dispatchConfigured($request,'key_notification_pdt_design_request','key_email_pdt_design_request');}
    public function completed($request): void{$this->dispatchConfigured($request,'key_notification_pdt_design_completed','key_email_pdt_design_completed');}
}
