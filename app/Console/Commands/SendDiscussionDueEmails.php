<?php

namespace App\Console\Commands;

use App\Models\PmSectionDiscussion;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailNotificationBuilderService;

class SendDiscussionDueEmails extends Command
{
    /**
     * The name and signature of the console command.
     *php artisan discussion:due-email
     * @var string
     */
    protected $signature = 'discussion:due-email';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email when discussion due date is passed';

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
        $today = Carbon::today();

        $discussions = PmSectionDiscussion::whereDate('due_date', '<', $today)
            ->whereNull('deleted_at')
            ->where('is_completed', 0)
            ->get();

        foreach ($discussions as $discussion) {

            $assignee = User::find($discussion->assignee_id);
            $creator  = User::find($discussion->assigned_by ?? $discussion->user_id);

            if (!$assignee || !$assignee->email) {
                continue;
            }

            $section = $discussion->section;
            logger($section);
            if ($section && is_null($section->order_id)) {
                logger("run");

                $project = $discussion->projectDetail;

                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                    'key_email_discussion_overdue_assignee',
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
                Log::info('Assignee overdue email sent to: ' . $assignee->email);
            }
        }

        return Command::SUCCESS;
    }
}
