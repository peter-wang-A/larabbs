<?php

namespace App\Observers;

use App\Notifications\TopicReplied;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        if (!app()->runningInConsole()) {
            //计算评论总和
            $reply->topic->updateReplyCount();

            //通知话题作者有新的评论
            $reply->topic->user->notify(new TopicReplied($reply));
        }
    }
    public function saving(Reply $reply)
    {
        // XSS 过滤
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }
    public function deleted(Reply $reply)
    {
        //计算评论总和
        $reply->topic->updateReplyCount();
    }
}
