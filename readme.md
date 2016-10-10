# WoW Stats Tracker

## Planned Features

- Assign characters to registered users.
- Ability to create raids and track player statistics such as DPS, HPS, ilvl, etc.

## Installation

This is a laravel application so if you are unsure how to deploy laravel please refer to the [Laravel Documentation](https://laravel.com/docs/5.3).

Assuming knowledge of Laravel follow the below steps.

- Upload the application to your server.
- Generate a new app key <code>php artisan key:generate</code>.
- Run the migrations <code>php artisan migrate</code>

### Set your guild name
- Edit <code>config/wow.php</code>
- Change the following code, replacing 'My Guild' with your guild name (make sure the quotes remain).


    'guild' => [
        'name' => 'My Guild',
    ],

### Set the app name
By default the app name is Stats Tracker, you can change this if you desire by changing <code>config/wow.php</code> and changing the app name, steps are similar to above guild name steps.

### Add your battle.net API key (optional)
This is only required if you wish to automatically pull character item levels from the wow API.  You can still enter these manually if you don't wish to set up an API key.
