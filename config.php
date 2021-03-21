<?php
/**
 * Bobot URLs:
 * /bobot/?ANTISPAM             used to send data and messages
 * /bobot/results               leaderboard
 * /bobot/results/raw           raw information from Bobot
 * /bobot/results/team-name     details
 */

// this one is used as simple antispam, generate on https://www.random.org/strings/
define('ANTISPAM_CODE', 'your-secret-random-string');

// this one is used for Bobot's ranking
define('DISCORD_WEBHOOK', 'your-webhook-here');

// this one is used for logging Bobot's activity
define('DISCORD_WEBHOOK_LOG', 'your-webhook-here');

// place Bobot's message ID (see README.md for details)
define('DISCORD_MESSAGE_ID', 'bobot-message-id-here');

// Bobot's home directory, if not working, specify by Yourself
define('BOBOT_HOME_DIR', substr($_SERVER['PHP_SELF'], 0, -9));

// default avatar path
define('DEFAULT_AVATAR_PATH', BOBOT_HOME_DIR . 'bobot.png');