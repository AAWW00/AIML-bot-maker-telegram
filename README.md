# AIML Maker Bot

## Description

This bot and MiniApp are designed to easily create telegram bots from the application

This repository contains all the necessary scripts for operation.
### Brief description of files

- `config.php`: file containing settings for connecting your bot to telegrams.
- `bot.php`: bot.
- `demo.aiml`: a file with your database needed to understand the questions and answers. More information about the specification can be found [here](https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwiv7a6hkumBAxVWIBAIHaJsBKcQFnoECAoQAQ&url=https%3A%2F%2Fru.wikipedia .org%2Fwiki%2FAIML&usg=AOvVaw3PN-9Zu9JGpIUmV_d84MmF&opi=89978449).
- `bot.log`: logging of interactions with the bot, it contains information about the user and question and answer.
- `save_aiml.php`: a file that processes data from the application to write it into the AIML file.
- `index.html`: application file.
- `style.css`: application and plugin styles.

## Installation

For the bot and application to work, you need to have a domain, hosting with the ability to run PHP scripts (Apache, Nginx or others), and an SSL certificate.

### Required steps:

1. Create a telegram bot in [@BotFather](https://t.me/BotFather).
2. Get a bot token.
3. Deploy files from this repository to the desired folder on your server.
4. Change connection parameters in `config.php`.

```php
'telegram_token' => 'YOUBOTTOKEN', //bot token
```
#### Create a webhook:
```
https://api.telegram.org/bot[YOUR_BOT_TOKEN]/setWebhook?url=https://[yourdomain.org]/bot.php
```
Replace ```[YOUR_BOT_TOKEN]``` with your bot token
Replace ```[yourdomain.org]``` with your site's domain. Please note that if you install the bot in one of the folders on your site, you must specify the rest of the directory where the bot.php file is located

#### Creating a MiniApp

To create a MiniApp, you need to create a new application in the telegram bot [@BotFather](https://t.me/BotFather), specify the location address ```index.html```

You can also add your application to the bot itself to quickly populate the response database and directly test it.
## Plugins

`log.php` : log console plugin.
`aiml_editor.php` : plugin for editing the AIML file.
`bot_editor.php` : plugin for editing `bot.php`

## How the bot works

The bot uses the popular AIML chatbot markup language, which allows you to define questions (pattern) and answers (template).


### Teams

You can use /commands directly from the AIML file.
Instructions for use

To set pattern, template, random, li, you can use the command constructor on the main page of the application.
AIML Formatting

```
<category>
   <pattern>⛄️</pattern>
   <template>☃️</template>
</category>

<category>
   <pattern>🐒</pattern>
   <template>
     <random>
       <li>🐵</li>
       <li>🙈</li>
       <li>🙉</li>
       <li>🙊</li>
     </random>
   </template>
</category>
```
## Advanced

MiniApp can create primitive AIML categories. This is necessary to test the filling of the AIML file and to simplify the installation of system tags.
## License

The bot and application code is licensed under the GNU GPL. The file ```demo.aiml``` is licensed as MIT. To develop the functionality of the bot, we ask you to comply with the license.
## Your bots and plugins

We can include your plugins in the main repository, and we can add your bots to this page.

## Author
## [Abadir](https://t.me/aba_dir)
