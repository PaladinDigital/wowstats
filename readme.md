# WoW Stats Tracker

[![Build Status](https://travis-ci.org/PaladinDigital/wowstats.svg?branch=master)](https://travis-ci.org/PaladinDigital/wowstats)

## Features
- Users are able to claim unclaimed characters
- Users can unclaim characters
- Admins can create raids and fights.
- Admins can add player stats against given fights (dps, hps, etc).
- Users can view comparisons of DPS or HPS of given characters by going to the url /compare/{char1}/{char2}

### Planned Features (TODO)

- Allow administrators to release character claims.
- Allow administrators to assign characters to users.

## Installation

This is a laravel application so if you are unsure how to deploy laravel please refer to the [Laravel Documentation](https://laravel.com/docs/5.3).

Assuming knowledge of Laravel follow the below steps.

- Clone the application to your server.  (You can install from zip if you desire but then you would have to overwrite when the package changes).
- Copy .env.example to .env and configure your database connection.
- Generate a new app key <code>php artisan key:generate</code>.
- Run the migrations <code>php artisan migrate</code>
- Seed the database <code>php artisan db:seed</code>
- Register as a user in the application http://example.com/register
- Run the following command to promote yourself to an administrator <code>php artisan promote:user</code>

### Set your guild name
- Edit <code>config/wow.php</code>
- Change the following code, replacing 'My Guild' with your guild name (make sure the quotes remain).


    'guild' => [
        'name' => 'My Guild',
    ],

### Set the app name
By default the app name is Stats Tracker, you can change this if you desire by changing <code>config/wow.php</code> and changing the app name, steps are similar to above guild name steps.
