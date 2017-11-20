<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'sources/config.php';

if (empty($_POST['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Missing uuid, please go back and try again');
  $error->renderAndDie();
}
if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i',$_POST['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Bad uuid');
  $error->renderAndDie();
}
$uuid = $_POST['uuid'];
if (empty($_POST['zip'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'ZIP code is missing, please go back and try again');
  $error->renderAndDie();
}
if (!preg_match('/^[0-9]+$/i',$_POST['zip'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'ZIP code is not a valid number, please go back and try again');
  $error->renderAndDie();
}
if (empty($_POST['zip']) || intval($_POST['zip']) > 99999) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Only use five-digit zip code for privacy reasons, please go back and try again');
  $error->renderAndDie();
}

$bill = new Bill();
$bill->uuid = $_POST['uuid'];
$bill->zipCode = $_POST['zip'];
if (!empty($_POST['company'])) {
  $bill->company = $_POST['company'];
}
if (!empty($_POST['date'])) {
  $bill->billingDate = $_POST['date'];
}

if (!empty($_POST['email'])) {
  $subscriber = new Subscriber();
  $subscriber->email = $_POST['email'];
  $subscriber->zipCode = $bill->zipCode;
  $subscriber->store();
  $storedSubscriber = Subscriber::fetchWithUUID($subscriber->uuid);
  $bill->subscriber = $storedSubscriber->id;
}

$bill->store();

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

  <!-- Custom Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
  <link rel="stylesheet" href="main.css">
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
            <div class="section-heading">
                <h1 class="display-3">
                  <i class="fa fa-heart" aria-hidden="true"></i>
                  Thanks so much!
                </h1>
                <p class="lead">
                  We will review your bill and publish it on the page you are about to see.
                </p>
                <a href="upload" class="text-xs-center btn btn-lg btn btn-primary m-x-auto">Upload another utility bill</a>
                <hr class="section">
<?php if (!empty($subscriber)): ?>
                <h1 class="display-4">
                  <i class="fa fa-check" aria-hidden="true"></i>
                  We will mail you if neighbors share bills near <?= $bill->zipCode ?>.
                </h1>
<?php else: ?>
                <h1 class="display-4">
                  <i class="fa fa-times" aria-hidden="true"></i>
                  We will not mail you.
                </h1>
<?php endif; ?>
                <hr class="section">
                <h1 class="display-4">
                  See your neighbors' bills.
                </h1>
                <p>
                  <a href="<?= $bill->zipCode ?>" class="btn btn-lg btn-primary">Bills shared in <?= $bill->zipCode ?></a>
                </p>
            </div>
        </section>

    <footer class="text-xs-center">
            <p>Made by <a href="http://phor.net/">William Entriken</a> because I think utilities are a racket.</p>
            <p>Please mail volunteers<span>@</span>sillyutility.net to assist with this project.</p>
            <p>Privacy policy: we publish what you give us, that's the point.</p>
    </footer>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-52764-24"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-52764-24');
    </script>
</body>

</html>
