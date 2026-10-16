<?php
use App\Services\EmailNotificationBuilderService;

function email_Notify(): EmailNotificationBuilderService
{
    return app(EmailNotificationBuilderService::class);
}
