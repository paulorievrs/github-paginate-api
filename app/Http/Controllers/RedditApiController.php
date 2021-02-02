<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RedditApiController extends Controller
{
    public function index($page)
    {
        $result = Http::get("https://gateway.reddit.com/desktopapi/v1/subreddits/wallpapers?rtj=only&redditWebClient=web2x&app=web2x-client-production&allow_over18=&include=prefsSubreddit&after=$page&dist=9&layout=card&sort=hot&geo_filter=BR");

        $result = (json_decode($result->body(), true));
        $data = null;
        foreach($result['posts'] as  $key => $post) {

            $data[$key]['id'] = $post['id'];
            $data[$key]['title'] = $post['title'];
            $data[$key]['author'] = $post['author'];
            $data[$key]['link'] = $post['permalink'];
            $data[$key]['media'] = isset($post['media']['content']) ? $post['media']['content'] : '';
        }
        $data['token'] = $result['token'];
        return response()->json($data);
    }
}
