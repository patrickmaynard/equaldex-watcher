# equaldex watcher

The most basic watcher possible for equaldex.com ranking changes. Designed for journalists who want an alert when their country's LGBT+-friendliness ranking changes.

The flag string that needs to change to trigger an email is hard-coded, meaning you don't need a database. 

Scripts are simple enough for even a near-novice to do a security scan on, so you know they're safe for your server. 

(I was tempted to build this with a big framework for practice, but then it would be difficult for others to vet the security of the code at a glance, so ... no.)

Runs on pretty much any webserver that runs PHP. 

Have fun!

## Setup instructions

Open settings.php and edit in the current API key, country name and ranking you want to look for changes to. I suggest initially putting in a ranking that is **not** the current ranking for at least one day before changing it to be accurate, in order to make sure that the mailer works on your system. 

Then set up a cron job that runs the collect.php script on a daily basis. 

Assuming you put in the wrong raking on purpose, you should get an email within the next couple of days. Ignore what it says, and change the settings file to have the correct ranking. Now you can ignore the whole thing until whenever it flags a new ranking, at which point you'll need to update the settings file again so you don't get an email every day. 

## Todo items

Someday, maybe I'll make a more complex version that can be hosted, uses a database and a web UI and allows users to sign up for emails based on a number of different possible change detections. Meanwhile, if someone wants to be me to it, please do so.

