<?php

include_once('settings.php');

$apiKey = getenv('API_KEY') ?? $settings['api_key'];
$recipientAddress = getenv('RECIPIENT_ADDRESS') ?? $settings['recipient_address'];
$regionId = $settings['region_id'];
$expectedRank = $settings['expected_rank'];
$humanUrl = $settings['human_readable_url'];
$countryName = $settings['country_name'];

//The API pages at https://equaldex.stoplight.io/docs/equaldex/ show a completely broken API demo in the test widget.
//So for now, I scrape the page manually, hoping better days will eventaully arrive.

$result = file_get_contents($humanUrl);
$matches = [];
$rankString = preg_match('/"rowItem b".*([0-9]+).*'.$countryName.'/', $result, $matches);

if (count($matches) !== 2) {
    throw new \Exception('The format has changed. Maybe we should try the API again and see if it is not broken now.');
}

$rank = $matches[1];

if ($rank !== $expectedRank) {
    $subject  = 'The Equaldex LGBT+-friendliness ranking for your country has changed.';
    $message  = 'This is a message from a scraper hacked together for alerting change on an Equaldex country rank. ';
    $message .= PHP_EOL; 
    $message .= 'I expected rank ' . $expectedRank . ' for ' . $countryName . ' but got ' . $rank . '. ';
    $message .= PHP_EOL; 
    $message .= 'See ' . $humanUrl . ' for country details, then cross check against archive.org for comparison.';
    print 'The message that will be sent: ' . PHP_EOL . $message . PHP_EOL;
    if(mail($recipientAddress, $subject, $message)){
        print 'Mail sent.' . PHP_EOL;
    }  else {
        print 'Mail not sent.' . PHP_EOL;
        exit(1); 
    }
}
