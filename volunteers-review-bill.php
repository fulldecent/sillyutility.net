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
  if ($_POST['action'] == 'delete') {
    $bill->status = 'DELETED';
    $bill->store();
    header('Location: volunteers');
    die();
  } else if ($_POST['action'] == 'readyPublish') {
    $bill->zipCode = $_POST['zipCode'];
    $bill->company = $_POST['company'];
    $bill->billingDate = $_POST['billingDate'];
    $bill->totalPrice = $_POST['totalPrice'];
    $bill->status = 'READY PUBLISH';
    $bill->store();
    header('Location: volunteers');
    die();    
  }
}

if ($bill->status == 'DELETED') {
  $error = ErrorPage::userErrorWithTitleAndMessage('Review bill', 'The bill is deleted and gone!');
  $error->renderAndDie();  
}
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="William Entriken">
    <title>Silly Utility</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" crossorigin="anonymous">
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

        <form method="post">
        <p>
            <button name="action" value="delete" class="btn btn-lg btn-danger">Delete bill</button>
        </p>       
        </form>
        <hr>
        <form method="post">
        <div class="row">
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Service ZIP code
                </h3>
                <input required class="form-control form-control-lg m-x-auto form-control-lg" type="text" pattern="\d*" name="zipCode" value="<?= htmlspecialchars($bill->zipCode) ?>">
            </div>          
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Company
                </h3>
                <input required class="form-control form-control-lg m-x-auto form-control-lg" type="text" name="company" value="<?= htmlspecialchars($bill->company) ?>">
            </div>          
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Billing date
                </h3>
                <input required class="form-control form-control-lg m-x-auto form-control-lg" type="date" name="billingDate" value="<?= date('Y-m-d',strtotime($bill->billingDate)) ?>">
            </div>
            <div class="col-md-3">
                <h3 class=" text-center text-xs-center">
                    Total price ("Total New Charges")
                </h3>
                <div class="input-group">
                  <div class="input-group-addon">$</div>
                  <input required type="text" class="form-control form-control-lg" name="totalPrice" value="<?= htmlspecialchars($bill->totalPrice) ?>">
                </div>
            </div>   
        </div>
        <p>
            <a class="btn btn-lg btn-warning" href="?uuid=<?= $bill->uuid ?>">Discard changes</a>
            <button name="action" value="readyPublish" class="btn btn-lg btn-primary">Publish bill</button>
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
