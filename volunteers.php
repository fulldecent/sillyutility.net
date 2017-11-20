<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'sources/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Silly Utility</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="main.css">

  <!-- Custom Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
</head>

<body>
    <div class="secondary-color-band">
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a href="volunteers" class="navbar-brand page-scroll">Silly Utility &mdash;
                      Volunteers &mdash;
                      <i class="fa fa-user" aria-hidden="true"></i> <?= htmlspecialchars($_SERVER['PHP_AUTH_USER']) ?></a>
                </div>
            </div>
        </nav>

        <section class="selling-point text-xs-center">
            <h1 class="display-3">
                <i class="fa fa-file" aria-hidden="true"></i>
                All Submitted Bills
            </h1>
        </section>
    </div>

    <section class="selling-point text-xs-center">
        <table class="table lead">
            <tr>
                <th>
                <th>Status
                <th>Date added
                <th>ZIP
                <th>Company
                <th>Billing date
                <th>Subscriber #
                <th><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Invoice
<?php
$statement = $database->query('SELECT * FROM bills WHERE status!="DELETED" AND status!="PUBLISHED"');
foreach ($statement as $row) {
  $bill = Bill::initWithStdClass((object) $row);
  echo "<tr>";
  echo '<td><a href="volunteers-review-bill?uuid='.htmlspecialchars($bill->uuid).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Review</a>';
  echo '<br><a href="admin-review-bill?uuid='.htmlspecialchars($bill->uuid).'"><i class="fa fa-send" aria-hidden="true"></i> Publish</a>';
  echo '<td>' . htmlspecialchars($bill->status);
  echo '<td>' . date('Y-m-d', strtotime($bill->updated));
  echo '<td>' . intval($bill->zipCode);
  echo '<td>' . htmlspecialchars($bill->company);
  echo '<td>' . date('Y-m-d', strtotime($bill->billingDate));
  echo '<td>' . (empty($bill->subscriber) ? '' : $bill->subscriber);

  $pages = $bill->getUnpublishedImages();
  echo '<td>';

  foreach ($pages as $i => $page) {
    echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Page ' . intval($i) . '<br>';
  }

}


?>
            <tr>
                <td>&nbsp;<td><td><td><td>
            <tr>
                <td>&nbsp;<td><td><td><td>
        </table>
    </section>

    <footer class="text-xs-center">
        <p>Made by <a href="http://phor.net/">William Entriken</a> because I think utilities are a racket.</p>
        <p>Please mail volunteers<span>@</span>sillyutility.net to assist with this project.</p>
        <p>Privacy policy: we publish what you give us, that's the point.</p>
    </footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52764-24', 'auto');
  ga('send', 'pageview');

</script>
</body>

</html>
