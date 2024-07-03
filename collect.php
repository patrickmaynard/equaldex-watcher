<?php

include_once('settings.php');
$apiKey = $settings['api_key'];
$recipientAddress = $settings['recipient_address'];
$regions = $settings['regions'];
if (false && filemtime('lastrun.txt') < time() + 86000 || count($regions) > 12) {
    print 'Please run this scraper less aggressively to avoid taxing the equaldex server. Exiting without a scrape.';
    print PHP_EOL;
    exit(1);
}
foreach ($regions as $region) {
    sleep(5);
    $regionId = $region['region_id'];
    $expectedRank = $region['expected_rank'];
    $humanUrl = $region['human_readable_url'];
    $countryName = $region['country_name'];

    //The API pages at equaldex.stoplight.io/docs/equaldex/ show a completely broken API demo in the test widget.
    //So for now, I scrape the page manually, hoping better days will eventaully arrive.
    $result = file_get_contents($humanUrl);
    $matches = [];
    $rankString = preg_match('/"rowItem b".*#([0-9]+).*'.$countryName.'/', $result, $matches);
    if (count($matches) !== 2) {
        throw new \Exception(
            'The format has changed. Maybe we should try the API again and see if it has stopped being broken now.'
        );
    }
    $rank = $matches[1];
    if ($rank != $expectedRank) {
        $subject  = 'The Equaldex LGBT+-friendliness ranking for your locality has changed.';
        $message  = 'This is a message from a scraper hacked together for alerting change on an Equaldex rank. ';
        $message .= PHP_EOL; 
        $message .= 'I expected rank ' . $expectedRank . ' for ' . $countryName . ' but got ' . $rank . '. ';
        $message .= PHP_EOL; 
        $message .= 'See ' . $humanUrl . ' for locality details, then cross check against archive.org for comparison.';
        $headers = 'From: no-reply@patrickmaynard.com' . "\r\n" .
        'Reply-To: patrickmaynard@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        print PHP_EOL . '=============' . PHP_EOL . 'A message will be sent: ' . PHP_EOL . $message . PHP_EOL;
        if(mail($recipientAddress, $subject, $message)){
            print 'Mail SENT to address "' . $recipientAddress . '". ' . PHP_EOL;
        }  else {
            print 'Mail NOT sent to address "' . $recipientAddress . '". ' . PHP_EOL;
        }
    } else {
        print PHP_EOL . '=============' . PHP_EOL . 'Nothing changed about locality "' . $countryName . '".' . PHP_EOL;
    }
}
touch('lastrun.txt');
