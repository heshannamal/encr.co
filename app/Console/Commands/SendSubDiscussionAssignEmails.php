<?php

namespace App\Console\Commands;

use App\Models\PmSectionSubDiscussion;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailNotificationBuilderService;

class SendSubDiscussionAssignEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subdiscussion:assign-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send assigned sub discussion emails';

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
        Log::info('Cron started: subdiscussion:assign-email');

        $subDiscussions = PmSectionSubDiscussion::where('email_sent', 0)
            ->where('is_completed', 0)
            ->whereNotNull('assignee_id')
            ->get();

        foreach ($subDiscussions as $sub) {

            $assignee = User::find($sub->assignee_id);
            $creator = User::find($sub->assigned_by ?? $sub->user_id);

            if (!$assignee || !$assignee->email) {
                continue;
            }

            $section = $sub->section;
            if ($section && is_null($section->order_id)) {

                $project = $sub->projectDetail;

                $comments = $sub->comments()
                    ->with('userInfo:id,name,profile_pic')
                    ->orderByDesc('created_at')
                    ->take(3)
                    ->get()
                    ->map(function ($comment) {
                        return [
                            'user_name'   => optional($comment->userInfo)->name ?? 'Unknown',
                            'profile_pic' => optional($comment->userInfo)->profile_pic ?? null,
                            'comment'     => $this->cleanCommentHtmlForEmail($comment->comment),
                            'created_at'  => $comment->created_at->format('M j, Y \a\t g:i a'),
                        ];
                    })
                    ->toArray();

                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                    'key_email_sub_discussion_assign',
                    [
                        'assigneeName'    => $assignee->name,
                        'AssignedBy'      => $creator->name,
                        'discussionName'  => $sub->discussion_name,
                        'description'     => $sub->discussion_description,
                        'dueDate'         => $sub->due_date,
                        'priority'        => $sub->priority,
                        'projectName'     => $project->project_name,
                        'projectId'       => $sub->project_id,
                        'subDiscussionId' => $sub->id,
                        'comments'        => $comments,
                    ]
                );

                Log::info('Sub discussion email sent', [
                    'sub_discussion_id' => $sub->id,
                    'email' => $assignee->email
                ]);
            }

            $sub->update([
                'email_sent' => 1,
                'email_sent_at' => now()
            ]);
        }

        Log::info('Cron finished: subdiscussion:assign-email');

        return 0;
    }

    private function cleanCommentHtmlForEmail(string $html): string
    {
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);

        $html = preg_replace_callback('/<img([^>]*)>/i', function ($matches) {
            preg_match('/src=["\']([^"\']+)["\']/i', $matches[1], $srcMatch);
            $src = $srcMatch[1] ?? '';
            if (!$src) {
                return '';
            }
            return '<img src="' . e($src) . '" style="max-width:100%;height:auto;border-radius:6px;margin-top:6px;display:block;">';
        }, $html);

        $html = preg_replace('/<div class="comment-attachment[^"]*"[^>]*>/i', '<div style="margin-top:6px;">', $html);
        $html = preg_replace('/style="[^"]*font-family:[^;"]*;?/i', 'style="', $html);
        $html = preg_replace('/style="[^"]*font-size:[^;"]*;?/i', 'style="', $html);
        $html = preg_replace('/<a\s+/i', '<a style="color:#0d9488;text-decoration:underline;" ', $html);

        return $html;
    }
}
