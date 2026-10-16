<?php

namespace App\Console\Commands;

use App\Models\PmSectionDiscussion;
use App\Models\User;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDiscussionReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discussion:reminder-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email when sub discussion due date is before passed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Cron started: discussion:reminder-email');

        $tomorrow = Carbon::tomorrow()->toDateString();

        $discussions = PmSectionDiscussion::whereDate('due_date', $tomorrow)
            ->where('is_completed', 0)
            ->get();

        foreach ($discussions as $discussion) {

            $assignee = User::find($discussion->assignee_id);
            $creator  = User::find($discussion->assigned_by ?? $discussion->user_id);

            if (!$assignee || !$assignee->email) {
                continue;
            }

            $section = $discussion->section;
            if ($section && is_null($section->order_id)) {

                $project = $discussion->projectDetail;

                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                    'key_email_discussion_reminder_assignee',
                    [
                        'assigneeName'          => $assignee->name,
                        'AssignedBy'            => $creator->name,
                        'assignedByProfilePic'  => optional($creator)->profile_pic ?? null,
                        'discussionName'        => $discussion->discussion_name,
                        'description'           => $discussion->discussion_description,
                        'dueDate'               => $discussion->due_date,
                        'priority'              => $discussion->priority,
                        'projectName'           => $project->project_name,
                        'projectId'             => $discussion->project_id,
                        'discussionId'          => $discussion->id,
                    ]
                );

                Log::info('Reminder sent to assignee: ' . $assignee->email);
            }
        }
        Log::info('Cron finished: discussion:reminder-email');

        return Command::SUCCESS;
    }
}
