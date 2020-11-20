<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        //计算评论总和
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
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
}
