<?php
require __DIR__ . '/config.php';
require __DIR__ . '/functions.php';

if (isset($_GET[ANTISPAM_CODE])) {
    $message_url = DISCORD_WEBHOOK . '/messages/' . DISCORD_MESSAGE_ID;

    if (isset($_GET['message'])) {
        send_discord_message($_GET['message'], DISCORD_WEBHOOK);
    } else {
        $json = file_get_contents('php://input');
        file_put_contents(__DIR__ . '/bobot.json', $json);
        $log_path = __DIR__ . '/logs/' . date('Y-m-d');
        if (!is_dir($log_path))
            mkdir($log_path);
        file_put_contents($log_path . '/' . date('H-i') . '.json', $json);
        $bobot_data = json_decode($json, true);
        usort($bobot_data, function ($team1, $team2) {
            return $team2['points'] <=> $team1['points'];
        });
        $message = "";
        foreach ($bobot_data as $key => $team) {
            $place = $key + 1;
            $message .= '`' . ($place >= 10 ? $place : ' ' . $place) . '.` ' . $team['group'] .
                ' - ' . $team['points'] . ' pkt' . PHP_EOL;
        }
        $message .= '---' . PHP_EOL .
            '[Więcej informacji](http://' . $_SERVER['HTTP_HOST'] . BOBOT_HOME_DIR . 'results)' . PHP_EOL .
            'Zaktualizowano ' . date('d.m.Y') . ' o ' . date('H:i');
        update_discord_message($message, $message_url);
        // Log every JSON string to Pracownia
        send_discord_embed(
            'Bobot is running!',
            'http://' . $_SERVER['HTTP_HOST'] . BOBOT_HOME_DIR . 'results',
            'Bobot is about to check Your work!',
            DISCORD_WEBHOOK_LOG
        );
    }
    echo 'Notification sent.';
} else {
    $bobot_data = json_decode(file_get_contents(__DIR__ . '/bobot.json'), true);
    usort($bobot_data, function ($team1, $team2) {
        return $team2['points'] <=> $team1['points'];
    });
    if ($_SERVER['REQUEST_URI'] == BOBOT_HOME_DIR . 'results') {
        echo heading('Ranking', 'Sprawdź swój wynik, porównaj go z innymi', true);
        echo table(['#', 'Nazwa grupy', 'Punkty', '']);
        foreach ($bobot_data as $key => $team) {
            $place = $key + 1;
            echo '<tr' . ($team['points'] == 10 ? ' class="winner"' : '') . '>
            <td>' . $place . '</td>
            <td>' . $team['group'] . '</td>
            <td>' . $team['points'] . '</td>
            <td><a href="' . BOBOT_HOME_DIR . 'results/' . $team['group'] . '">Szczegóły&nbsp;»</td>
          </tr>';
        }
        echo footer();
    } elseif ($_SERVER['REQUEST_URI'] == '' . BOBOT_HOME_DIR . 'results/raw') {
        die(file_get_contents(__DIR__ . '/bobot.json'));
    } elseif (substr($_SERVER['REQUEST_URI'], 0, strlen(BOBOT_HOME_DIR . 'results')) == BOBOT_HOME_DIR . 'results') {
        $team_name = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);
        echo heading('Błędy', 'Wykryte problemy u zespołu ' . $team_name);
        echo table(['Lista błędów']);
        foreach ($bobot_data as $team) {
            if ($team['group'] == $team_name) {
                foreach ($team['issues'] as $issue)
                    echo '<tr><td><code>' . $issue . '</code></td></tr>';
                if (count($team['issues']) == 0)
                    echo '<tr><td><code>Nie znaleziono problemów</code></td></tr>';
                echo '</tbody></table>';
                echo table(['Problemy z repozytorium']);
                foreach ($team['errors'] as $error)
                    echo '<tr><td><code>' . $error . '</code></td></tr>';
                if (count($team['errors']) == 0)
                    echo '<tr><td><code>Nie znaleziono problemów</code></td></tr>';
            }
        }
        echo footer();
    } else {
        header('Location: ' . BOBOT_HOME_DIR . 'results');
    }
}
<?php
require __DIR__ . '/config.php';
require __DIR__ . '/functions.php';

if (isset($_GET[ANTISPAM_CODE])) {
    $message_url = DISCORD_WEBHOOK . '/messages/' . DISCORD_MESSAGE_ID;

    if (isset($_GET['message'])) {
        send_discord_message($_GET['message'], DISCORD_WEBHOOK);
    } else {
        $json = file_get_contents('php://input');
        file_put_contents(__DIR__ . '/bobot.json', $json);
        $log_path = __DIR__ . '/logs/' . date('Y-m-d');
        if (!is_dir($log_path))
            mkdir($log_path);
        file_put_contents($log_path . '/' . date('H-i') . '.json', $json);
        $bobot_data = json_decode($json, true);
        usort($bobot_data, function ($team1, $team2) {
            return $team2['points'] <=> $team1['points'];
        });
        $message = "";
        foreach ($bobot_data as $key => $team) {
            $place = $key + 1;
            $message .= '`' . ($place >= 10 ? $place : ' ' . $place) . '.` ' . $team['group'] .
                ' - ' . $team['points'] . ' pkt' . PHP_EOL;
        }
        $message .= '---' . PHP_EOL .
            '[Więcej informacji](http://' . $_SERVER['HTTP_HOST'] . BOBOT_HOME_DIR . 'results)' . PHP_EOL .
            'Zaktualizowano ' . date('d.m.Y') . ' o ' . date('H:i');
        update_discord_message($message, $message_url);
        // Log every JSON string to Pracownia
        send_discord_embed(
            'Bobot is running!',
            'http://' . $_SERVER['HTTP_HOST'] . BOBOT_HOME_DIR . 'results',
            'Bobot is about to check Your work!',
            DISCORD_WEBHOOK_LOG
        );
    }
    echo 'Notification sent.';
} else {
    $bobot_data = json_decode(file_get_contents(__DIR__ . '/bobot.json'), true);
    usort($bobot_data, function ($team1, $team2) {
        return $team2['points'] <=> $team1['points'];
    });
    if ($_SERVER['REQUEST_URI'] == BOBOT_HOME_DIR . 'results') {
        echo heading('Ranking', 'Sprawdź swój wynik, porównaj go z innymi', true);
        echo table(['#', 'Nazwa grupy', 'Punkty', '']);
        foreach ($bobot_data as $key => $team) {
            $place = $key + 1;
            echo '<tr' . ($team['points'] == 10 ? ' class="winner"' : '') . '>
            <td>' . $place . '</td>
            <td>' . $team['group'] . '</td>
            <td>' . $team['points'] . '</td>
            <td><a href="' . BOBOT_HOME_DIR . 'results/' . $team['group'] . '">Szczegóły&nbsp;»</td>
          </tr>';
        }
        echo footer();
    } elseif ($_SERVER['REQUEST_URI'] == '' . BOBOT_HOME_DIR . 'results/raw') {
        die(file_get_contents(__DIR__ . '/bobot.json'));
    } elseif (substr($_SERVER['REQUEST_URI'], 0, strlen(BOBOT_HOME_DIR . 'results')) == BOBOT_HOME_DIR . 'results') {
        $team_name = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);
        echo heading('Błędy', 'Wykryte problemy u zespołu ' . $team_name);
        echo table(['Lista błędów']);
        foreach ($bobot_data as $team) {
            if ($team['group'] == $team_name) {
                foreach ($team['issues'] as $issue)
                    echo '<tr><td><code>' . $issue . '</code></td></tr>';
                if (count($team['issues']) == 0)
                    echo '<tr><td><code>Nie znaleziono problemów</code></td></tr>';
                echo '</tbody></table>';
                echo table(['Problemy z repozytorium']);
                foreach ($team['errors'] as $error)
                    echo '<tr><td><code>' . $error . '</code></td></tr>';
                if (count($team['errors']) == 0)
                    echo '<tr><td><code>Nie znaleziono problemów</code></td></tr>';
            }
        }
        echo footer();
    } else {
        header('Location: ' . BOBOT_HOME_DIR . 'results');
    }
}
