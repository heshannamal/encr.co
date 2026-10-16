<?php

namespace App\Console\Commands;

use App\Models\PmSectionDiscussion;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailNotificationBuilderService;

class SendDiscussionAssignEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discussion:assign-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send assigned discussion emails';

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
        Log::info('Cron started: discussion:assign-email');

        $discussions = PmSectionDiscussion::where('email_sent', 0)
        ->where('is_completed', 0)
        ->whereNotNull('assignee_id')
        ->get();

        foreach ($discussions as $discussion) {

            $assignee = User::find($discussion->assignee_id);
            $creator = User::find($discussion->assigned_by ?? $discussion->user_id);

            if (!$assignee || !$assignee->email) {
                continue;
            }

            $section = $discussion->section;
            if ($section && is_null($section->order_id)) {

                $project = $discussion->projectDetail;

                $comments = $discussion->comments()
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
                    'key_email_discussion_assign',
                    [
                        'assigneeName'    => $assignee->name,
                        'AssignedBy'      => $creator->name,
                        'discussionName'  => $discussion->discussion_name,
                        'description'     => $discussion->discussion_description,
                        'dueDate'         => $discussion->due_date,
                        'priority'        => $discussion->priority,
                        'projectName'     => $project->project_name,
                        'projectId'       => $discussion->project_id,
                        'discussionId'    => $discussion->id,
                        'comments'        => $comments,
                    ]
                );

                Log::info('Discussion email sent', [
                    'discussion_id' => $discussion->id,
                    'email' => $assignee->email
                ]);
            }

            $discussion->email_sent = 1;
            $discussion->email_sent_at = now();
            $discussion->save();
        }

        Log::info('Cron finished: discussion:assign-email');

        return 0;
    }


    private function cleanCommentHtmlForEmail(string $html): string
    {
        // Strip any <script> or <style> blocks entirely
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);

        // Force images to be email-safe: cap width, remove editor's own inline sizing
        $html = preg_replace_callback('/<img([^>]*)>/i', function ($matches) {
            // Extract src
            preg_match('/src=["\']([^"\']+)["\']/i', $matches[1], $srcMatch);
            $src = $srcMatch[1] ?? '';
            if (!$src) {
                return '';
            }
            return '<img src="' . e($src) . '" style="max-width:100%;height:auto;border-radius:6px;margin-top:6px;display:block;">';
        }, $html);

        // Strip attachment wrapper divs but keep their inner content (image/link)
        $html = preg_replace('/<div class="comment-attachment[^"]*"[^>]*>/i', '<div style="margin-top:6px;">', $html);

        // Strip inline font-family/font-size overrides from the editor so email styling stays consistent
        $html = preg_replace('/style="[^"]*font-family:[^;"]*;?/i', 'style="', $html);
        $html = preg_replace('/style="[^"]*font-size:[^;"]*;?/i', 'style="', $html);

        // Make links safe/consistent
        $html = preg_replace('/<a\s+/i', '<a style="color:#0d9488;text-decoration:underline;" ', $html);

        return $html;
    }
}
