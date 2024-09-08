# BUSA Beacons

## What is it?

BUSA Beacons is a laravel framework that automatically pulls fuel from the EVE Online API to populate tables in a database for the corporation Blackwater USA Inc.

## How do I use it?

BUSA Beacons is designed to be run from the command line. The following commands are available:

* `php artisan get:beacons CronJob 0` - this will pull beacons from the EVE API and store the fuel levels and other things in the database.

* `php artisan get:fuel` - gets the beacons from the databases and sends any with less than 7 days of fuel remaining to a channel of your choosing.

### Environment Variables

You will need to set the `EVE_CLIENT_ID`, `EVE_CLIENT_SECRET`, and `EVE_CALLBACK_URL` environment variables. You can get these from the EVE Developer Portal.
