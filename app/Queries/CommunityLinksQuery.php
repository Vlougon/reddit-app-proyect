<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    public static function getByChannel(Channel $channel)
    {
        $links = $channel->communityLinks()->where('approved', true)->latest('updated_at')->paginate(25);
        return $links;
    }

    public static function getAll()
    {
        $links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
        return $links;
    }

    public static function getMostPopular()
    {
        $links = CommunityLink::where('approved', true)->withCount('users')->orderByDesc('users_count')->paginate(25);
        return $links;
    }
}
