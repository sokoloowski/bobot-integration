<?php

function heading($header, $subheader, $leaderboard = false)
{
    return '<!DOCTYPE html><html lang="pl"><head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#203D53">
        <title>Bobot</title>
        <link rel="icon" href="' . DEFAULT_AVATAR_PATH . '" />
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css">
        <link href="https://getbootstrap.com/docs/4.1/examples/sticky-footer/sticky-footer.css" rel="stylesheet">
        '.(($leaderboard) ? 
        '<style>
            tbody tr:nth-of-type(1), tbody tr.winner { background: #ffd70088!important; }
            tbody tr:nth-of-type(2) { background: #c0c0c088!important; }
            tbody tr:nth-of-type(3) { background: #cd7f3288!important; }
        </style>' : '') .'
    </head><body>
        <main role="main" class="container">
          <h1 class="mt-5">' . $header . '</h1>
          <p class="lead">' . $subheader . '</p>
          
          <div class="table-responsive">';
}

function table($header)
{
    $res = '<table class="table table-striped table-sm">
                  <thead>
                    <tr>';
    foreach ($header as $th) $res .= "<th>$th</th>";
    $res .= '</tr>
                  </thead>
                  <tbody>';
    echo $res;
}

function footer()
{
    return '</tbody></table></div></main><footer class="footer"><div class="container">
        <span class="text-muted">Ostatnia aktualizacja: ' . date('d.m.Y', filemtime(__DIR__ . '/bobot.json')) .
        ' o ' . date('H:i', filemtime(__DIR__ . '/bobot.json')) . '</span></div></footer></body></html>';
}

function send_discord_embed($title, $url, $message, $webhook, $name = 'Bobot', $avatar_url = DEFAULT_AVATAR_PATH)
{
    $json_data = [
        'embeds' => [[
            "title" => $title,
            "url" => $url,
            "description" => $message,
            "color" => 2112851
        ]],
        'username' => $name,
        'avatar_url' => $avatar_url
    ];
    make_curl($json_data, $webhook);
}

function send_discord_message($message, $webhook, $name = 'Bobot', $avatar_url = DEFAULT_AVATAR_PATH)
{
    $json_data = [
        'content' => $message,
        'username' => $name,
        'avatar_url' => $avatar_url
    ];
    make_curl($json_data, $webhook);
}

function update_discord_message($message, $message_url)
{
    $data = [
        'content' => '',
        'embeds' => [[
            "title" => 'Ranking',
            "url" => 'http://' . $_SERVER['HTTP_HOST'] . BOBOT_HOME_DIR . 'results',
            "description" => $message,
            "color" => 2112851
        ]],
    ];
    $curl = curl_init($message_url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($curl);
    curl_close($curl);
}

function make_curl($data, $webhook)
{
    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    $response = curl_exec($ch);
    echo $response;
}
