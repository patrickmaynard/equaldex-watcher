# equaldex watcher

The most basic watcher possible for equaldex.com ranking changes. Designed for journalists who want an alert when their country's LGBT+-friendliness ranking changes.

The flag string that needs to change to trigger an email is hard-coded, meaning you don't need a database. 

Scripts are simple enough for even a near-novice to do a security scan on, so you know they're safe for your server. 

(I was tempted to build this with a big framework for practice, but then it would be difficult for others to vet the security of the code at a glance, so ... no.)

Runs on pretty much any webserver that runs PHP. 

Have fun!

## Setup instructions

Open settings.php and edit in the current API key, country name and ranking you want to look for changes to. 

Then set up a cron job that runs the collect.php script on a daily basis.

## Todo items

Make a more complex version that can be hosted, uses a database and allows users to sign up for emails based on a number of different possible change detections. 
