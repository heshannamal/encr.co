<?php

namespace App\Console\Commands;

use App\Models\PmSectionSubDiscussion;
use App\Models\User;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSubDiscussionDueEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subdiscussion:due-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email when sub discussion due date is passed';

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
        Log::info('Cron started: subdiscussion:due-email');

        $today = Carbon::today();

        $subDiscussions = PmSectionSubDiscussion::whereDate('due_date', '<', $today)
            ->whereNull('deleted_at')
            ->where('is_completed', 0)
            ->get();

        foreach ($subDiscussions as $sub) {

            $assignee = User::find($sub->assignee_id);
            $creator  = User::find($sub->assigned_by ?? $sub->user_id);

            if (!$assignee || !$assignee->email) {
                continue;
            }

            $section = $sub->section;
            if ($section && is_null($section->order_id)) {

                $project = $sub->projectDetail;

                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                    'key_email_subdiscussion_overdue_assignee',
                    [
                        'assigneeName'          => $assignee->name,
                        'AssignedBy'            => $creator->name ?? 'A team member',
                        'assignedByProfilePic'  => optional($creator)->profile_pic ?? null,
                        'discussionName'        => $sub->discussion_name,
                        'description'           => $sub->discussion_description,
                        'dueDate'               => $sub->due_date,
                        'priority'              => $sub->priority,
                        'projectName'           => $project->project_name ?? 'Encore Cloud',
                        'projectId'             => $sub->project_id,
                        'subDiscussionId'       => $sub->id,
                    ]
                );
                Log::info('Sub discussion overdue email sent to: ' . $assignee->email);
            }
        }

        Log::info('Cron finished: subdiscussion:due-email');

        return Command::SUCCESS;
    }
}
