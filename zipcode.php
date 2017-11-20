<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'sources/config.php';

if (empty($_GET['zipcode']) || intval($_GET['zipcode']) > 99999) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Finding shared bills', 'Only use five-digit zip code for privacy reasons, please go back and try again.');
  $error->renderAndDie();
}
$zipcode = intval($_GET['zipcode']);
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
    <div class="primary-color-band">
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand page-scroll" href="/">Silly Utility</a>
                </div>
            </div>
        </nav>

        <section class="selling-point text-xs-center">
            <h1 class="display-3">
                <i class="fa fa-file" aria-hidden="true"></i>
                Utility bills in <?= $zipcode ?>
            </h1>
        </section>
    </div>

    <section class="selling-point text-xs-center">
        <table class="table lead">
            <tr>
                <th>Company
                <th>Billing date
                <th>Price
                <th><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Invoice
<?php
$bills = Bill::fetchAllInZipCode($zipcode);
foreach ($bills as $bill) {
  echo "<tr>";
  if ($bill->status == 'PUBLISHED') {
    echo '<td>' . htmlspecialchars($bill->company);
  } else {
    echo '<td class="text-muted">UNDER REVIEW';
  }
  if (strtotime($bill->billingDate)) {
    echo '<td>' . date('Y-m-d', strtotime($bill->billingDate));
  } else {
    echo '<td class="text-muted">UNDER REVIEW';
  }
  if ($bill->status == 'PUBLISHED') {
    echo '<td>$' . round($bill->totalPrice, 2);
  } else {
    echo '<td class="text-muted">UNDER REVIEW';
  }
  if ($bill->status == 'PUBLISHED') {
    echo '<td>';
    $numberOfPages = $bill->getNumberOfPublishedImages();
    for ($i = 0; $i < $numberOfPages; $i++) {
      $url = 'bill-images/' . $bill->uuid . '-page-' . ($i+1) . '.jpg';
      echo "<p><a target=\"_blank\" href=\"$url\"><i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> Page #" . ($i + 1) . "</a></p>";
    }
  } else {
    echo '<td class="text-muted">UNDER REVIEW';
  }
  echo '<td>';

}


?>
            <tr>
                <td>&nbsp;<td><td><td><td>
            <tr>
                <td>&nbsp;<td><td><td><td>
        </table>
    </section>

    <div class="secondary-color-band">
        <section class="selling-point text-xs-center">
            <a href="upload" class="text-xs-center btn btn-lg btn btn-primary m-x-auto">Upload another utility bill</a>
        </section>
    </div>

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
