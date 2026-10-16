<?php

namespace App\Console\Commands;

use App\Models\PmSection;
use App\Models\PmSectionDiscussion;
use App\Models\PmSectionDiscussionComment;
use App\Models\PmSectionSubDiscussion;
use App\Models\Project;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMentionCommentEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:send-mention-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mention comment emails';

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
        $comments = PmSectionDiscussionComment::where('email_sent', 0)
            ->whereNotNull('mentioned_users')
            ->get();

        foreach ($comments as $comment) {

            try {

                if ($comment->is_sub_discussion == 0) {

                    $taskInfo = PmSectionDiscussion::find(
                        $comment->section_discussion_id
                    );
                    $taskType = "discussion";
                } else {

                    $taskInfo = PmSectionSubDiscussion::find(
                        $comment->sub_section_discussion_id
                    );
                    $taskType = "sub_discussion";
                }

                $commentedUser = User::find($comment->user_id);

                if (!$commentedUser) {
                    continue;
                }

                $section = null;

                if ($taskInfo) {

                    $section = PmSection::find(
                        $taskInfo->section_id
                    );
                }

                if (!$taskInfo) {
                    continue;
                }

                $mentionedUsers = explode(',', $comment->mentioned_users);

                $mentionedUserNames = User::whereIn('id', $mentionedUsers)
                    ->pluck('name')
                    ->toArray();

                $projectInfo = Project::find($comment->project_id);
                if (!$projectInfo) {
                    continue;
                }

                foreach ($mentionedUsers as $userId) {

                    $user = User::find($userId);

                    if (!$user || empty($user->email)) {
                        continue;
                    }
                    $recentComments = $taskInfo->comments()
                        ->with('userInfo:id,name,profile_pic')
                        ->latest()
                        ->limit(5)
                        ->get()
                        ->reverse()
                        ->values();

                    $commentsForEmail = $recentComments->map(function ($c) use ($comment) {
                        return [
                            'user_name'   => optional($c->userInfo)->name ?? 'Unknown',
                            'profile_pic' => optional($c->userInfo)->profile_pic ?? null,
                            'comment'     => $this->cleanCommentHtmlForEmail($c->comment),
                            'created_at'  => $c->created_at->format('M j, Y \a\t g:i a'),
                            'is_mention'  => $c->id === $comment->id,
                        ];
                    })->toArray();

                    $data = [
                        'mentionedByName' => $commentedUser->name,
                        'discussionName'  => $taskInfo->discussion_name,
                        'priority'        => $taskInfo->priority,
                        'projectName'     => $projectInfo->project_name,
                        'projectId'       => $comment->project_id,
                        'discussionId'    => $taskInfo->id,
                        'taskType'        => $taskType,
                        'dueDate'         => $taskInfo->due_date,
                        'comments'        => $commentsForEmail,
                    ];

                    Mail::send('emails.comment_mention', $data, function ($message) use ($user, $taskInfo) {
                        $message->to($user->email)
                            ->subject($user->name . ', you were mentioned in a comment | ' . $taskInfo->discussion_name);
                    });

                    Log::info('Mention email sent', [
                        'comment_id' => $comment->id,
                        'to' => $user->email,
                    ]);
                }

                $comment->update(['email_sent' => 1]);

            } catch (\Exception $e) {
                Log::error('Failed to send mention email for comment ' . $comment->id . ': ' . $e->getMessage());
            }
        }

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
