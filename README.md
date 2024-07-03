# equaldex watcher

The most basic watcher possible for equaldex.com ranking changes.

Designed for journalists who want an alert when their country's
LGBT+-friendliness ranking changes.

The flag string that needs to change to trigger an email is hard-coded,
meaning you don't need a database.

With the logic located in just two files -- a 50-line logic file and and even
shorter settings file -- the files are simple enough for even a near-novice
to do a security scan on, so you know they're safe for your server.

(I was tempted to build this with a big framework for practice, but then it
would be difficult for others to vet the security of the code at a glance,
so ... no.)

Runs on pretty much any webserver that runs PHP.

Have fun!

## Setup instructions

After cloning the repository onto your server, `cd` into it and then do a
`touch lastrun.txt` to create a new file. (This file will always be empty.)

You can then make that new .txt file writeable by your php user using the
`chmod` command so that the scraper can give itself an idea of whether
it is being run too aggressively -- for example, via a misconfigured cron
job or via a settings array that tries to grab rankings from more than a
dozen localities. It will not run if it does not have this information,
and it will not scrape if it senses that it is being used too aggressively.
The scraper should be run only once a day at most.

Open settings.php and edit in the current API key, country name(s) and
ranking(s) you want to look for changes to. I suggest initially putting in
ranking values that are **not** the current accureate rankings for at least
one day before changing the values to be accurate, in order to make sure that
the mailer works on your system. (My server's mailer has more success sending
to ProtonMail addresses than Gmail addresses, for example -- something that I
found out through this sort of testing.)

Then set up a cron job that runs the collect.php script on a daily basis.

Assuming you put in the wrong rankings on purpose, you should get email
within the next couple of days. Ignore what it says, and change the settings
file to have the correct rankings. Now you can ignore the whole system until
whenever it flags a new ranking, at which point you'll need to update the
settings file again so you don't get email every day.

## Todo items

Someday, maybe I'll make a more complex version that can be hosted on my
server for signup by others, uses a database, hits the (hopefully by then
fixed) API, uses a web UI and allows users to sign up for emails based on a
number of different possible change detections. Meanwhile, if someone wants
to beat me to that task, please do so.
