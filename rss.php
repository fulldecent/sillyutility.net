<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'vendor/autoload.php';
require 'sources/config.php';

header("Content-Type: application/rss+xml");
#header("Content-Type: text/plain");

echo <<<HEADER
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>
  <title>Silly Utility bills to review</title>
  <link>https://sillyutility.net</link>
  <description>All uploaded bills in NEEDS REVIEW state</description>
  <atom:link href="https://sillyutility.net/rss.php" rel="self" type="application/rss+xml" />

HEADER;

$results = $database->select('bills', 'status!="DELETED" AND status!="PUBLISHED"');
foreach ($results as $row) {
  $bill = Bill::initWithStdClass((object) $row);
  $uuidHTML = htmlspecialchars($bill->uuid);
  $dateHTML = date("D, d M Y H:i:s O", strtotime($bill->updated));
  
  echo <<<ITEM
    <item>
      <title>Bill $uuidHTML</title>
      <link>https://sillyutility.net/volunteers</link>
      <guid>https://sillyutility.net/volunteers-review-bill?uuid=$uuidHTML</guid>
      <description>
        A new bill is ready to review with ID set to $uuidHTML
        &lt;br&gt; See: https://sillyutility.net/volunteers-review-bill?uuid=$uuidHTML
      </description>
      <pubDate>$dateHTML</pubDate>
    </item>
  
ITEM;

}

echo <<<FOOTER
</channel>
</rss>
FOOTER;
