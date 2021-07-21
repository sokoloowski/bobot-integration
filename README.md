# First things first...

This integration is for [Bobot](https://gitlab.com/bobot-is-a-bot) maintainers and AGH UST students

# Supported web servers

## Apache

Works right out-of-the-box

## Nginx

You need to add following lines to Your Nginx config:

```nginx
location /path/to/bobot {
    try_files $uri $uri/ /path/to/bobot/index.php$is_args$args;
}
```

# How to use?

1. Clone this repo or download it. Also configure Discord webhook.
2. Enter the necessary data in the configuration file (without message URL)
3. Upload integration files to Your public server. Remember to change permissions of `bobot.json` (`chmod a+w bobot.json`).
4. Create `logs/` directory with correct permissions (`chmod 777 logs/`).
5. Send message via webhook. To do that, use following URL: `http://your-server.com/path/to/bobot/?ANTISPAM_KEY&message=YOUR_MESSAGE`. Replace `ANTISPAM_KEY` with the one from Your configuration.
6. From Discord, copy Bobot's message ID (You'll probably need developer mode enabled) and update Your configuration. You may test it using [ReqBin](https://reqbin.com) and `sample.json`
7. Configure Bobot HTTP request (or ask maintainers for it) - send HTTP POST request with `application/json` data to `http://your-server.com/path/to/bobot/?ANTISPAM_KEY`
8. You can access Bobot website using `http://your-server.com/path/to/bobot/results`. See `config.php` for more URLs.

# FAQ

## Does this integration change how Bobot works?

No, it's only an interface to make Bobot speak on Your Discord server. So You can't send modified `GRADE.md` to Your GitLab repository or make Bobot change Your grade.

## Do I have to change default webhook name and avatar?

No, this integration automatically sets webhook name to `Bobot` and uses it's avatar.

## Will it spam on my Discord server?

No, this integration will edit it's message, so the best practice is to make a separate channel for it (e.g. `#bobot-is-a-bot`).

## Can I send messages as Bobot?

Yes, use HTTP GET `message` like above to send messages as Bobot. This one can be used by maintainers to communicate with students about Bobot's issues. To mention user, include `<@USER_ID>` in Your message, to mention role, use `<@&ROLE_ID>`. Remember to encode Your message (You may use `urlencode()` in PHP).

# Screenshots

## Discord

![image](https://user-images.githubusercontent.com/39133910/126449224-62ac3413-a430-4fb6-95ea-cf374821af37.png)

## Webpage

![image](https://user-images.githubusercontent.com/39133910/126450759-1d8aee98-6479-4f43-9a3f-05eff8c3388a.png)

