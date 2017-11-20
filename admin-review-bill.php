<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'sources/config.php';

if (empty($_GET['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Review bill', 'UUID missing');
  $error->renderAndDie();
}
$bill = Bill::fetchWithUUID($_GET['uuid']);

if (!empty($_POST['action'])) {
  if ($_POST['action'] == 'publish') {
    $bill->publish();
    header('Location: volunteers');
    die();
  }
}

if ($bill->status == 'DELETED') {
  $error = ErrorPage::userErrorWithTitleAndMessage('Review bill', 'The bill is deleted and gone!');
  $error->renderAndDie();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Silly Utility</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
</head>

<body>
    <div class="secondary-color-band" style="background:black">
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a href="volunteers" class="navbar-brand page-scroll">Silly Utility &mdash;
                      Admin &mdash;
                      <i class="fa fa-user" aria-hidden="true"></i> <?= htmlspecialchars($_SERVER['PHP_AUTH_USER']) ?></a>
                </div>
            </div>
        </nav>

        <section class="selling-point text-xs-center">
            <h1 class="display-3">
                <i class="fa fa-file" aria-hidden="true"></i>
                Review Bill
            </h1>
            <p class="lead"><?= htmlspecialchars($bill->uuid) ?></p>
        </section>
    </div>

    <section class="selling-point text-xs-center">
      <h1>Images</h1>
<?php
$pages = $bill->getUnpublishedImages();
$allEdited = true;

foreach ($pages as $i => $isEdited) {
  echo '<p>';
  echo '<a href="volunteers-review-image?uuid='.$bill->uuid.'&amp;pageNumber='.intval($i).'">';
  echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Page ' . intval($i);
  if ($isEdited) {
    echo ' EDITED';
  } else {
    echo ' NOT YET EDITED';
    $allEdited = false;
  }
  echo '</a>';
  echo '</p>';
}

if (count($pages) == 0) {
  echo '<p>No images, you should probably delete this one.</p>';
}

if ($pages > 0 && $allEdited) {
?>

        <hr>
        <h2>When you click PUBLISH, you are responsible for emailing all subscribed people for nearby ZIP codes! This is not automated yet!</h2>
        <h2>Add witty and fun notes on each email!</h2>
        <form method="post">
        <div class="row">
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Service ZIP code
                </h3>
                <p><?= htmlspecialchars($bill->zipCode) ?></p>
            </div>
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Company
                </h3>
                <p><?= htmlspecialchars($bill->company) ?></p>
            </div>
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Billing date
                </h3>
                <p><?= date('Y-m-d',strtotime($bill->billingDate)) ?></p>
            </div>
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Total price
                </h3>
                <p>$<?= htmlspecialchars($bill->totalPrice) ?></p>
                </div>
            </div>
        </div>
        <p>
            <button name="action" value="publish" class="btn btn-lg btn-primary">Publish bill</button>
        </p>
        </form>
<?php
}
?>
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
