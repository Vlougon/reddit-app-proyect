<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    public static function getByChannel(Channel $channel)
    {
        return $channel->communityLinks()->where('approved', true)->latest('updated_at')->paginate(25);
    }

    public static function getAll()
    {
        return CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
    }

    public static function getMostPopular()
    {
        return CommunityLink::where('approved', true)->withCount('users')->orderByDesc('users_count')->paginate(25);
    }

    public static function getMostPopularByChannel(Channel $channel)
    {
        return $channel->communityLinks()->where('approved', true)->withCount('users')->orderByDesc('users_count')->paginate(25);
    }

    public static function getByTitle($search)
    {
        return CommunityLink::where('approved', true)->where('title', 'like', '%' . $search . '%')->latest('updated_at')->paginate(25);
    }

    public static function getByTwoTitles($search1, $search2)
    {
        return CommunityLink::where([
            ['approved', true],
            ['title', 'like', '%' . $search1 . '%'],
            ['title', 'like', '%' . $search2 . '%']
        ])->latest('updated_at')->paginate(25);
    }

    public static function getByTitleAndPopular($search)
    {
        return CommunityLink::where([
            ['approved', true],
            ['title', 'like', '%' . $search . '%']
        ])->withCount('users')->orderByDesc('users_count')->paginate(25);
    }
}
