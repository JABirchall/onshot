<?php

return [
    'api_url' => "https://api.twitch.tv",
    'client_id' => '65xhc9zdu5ht6883cepsknz3uxxzzse',
    'client_secret' => 'bxo2s1one4aw94qjt0dpe4zzz8v0gab',
    'redirect_url' => 'http://onshot.app/twitchAuth',
    'scopes' => [
        'user_read',
        'user_blocks_edit',
        'user_blocks_read',
        'user_follows_edit',
        'channel_read',
        'channel_editor',
        'channel_commercial',
        'channel_stream',
        'channel_subscriptions',
        'user_subscriptions',
        'channel_check_subscription',
        'chat_login'
    ]
];