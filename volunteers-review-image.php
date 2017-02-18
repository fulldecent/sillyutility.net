<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'vendor/autoload.php';
require 'sources/config.php';

if (empty($_GET['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Review image', 'UUID missing');
  $error->renderAndDie();
}
if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $_GET['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Review image', 'Bad uuid');
  $error->renderAndDie();
}
if (empty($_GET['pageNumber']) || !intval($_GET['pageNumber'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Review image', 'Missing page number, please go back and try again');
  $error->renderAndDie();
}
$uuid = $_GET['uuid'];
$pageNumber = intval($_GET['pageNumber']);

$fileName = '';
if (file_exists("bill-images-EDITED/$uuid-page-$pageNumber.jpg")) {
  $fileName = "bill-images-EDITED/$uuid-page-$pageNumber.jpg";
} else if (file_exists("bill-images-NOT-REVIEWED/$uuid-page-$pageNumber.png")) {
  $fileName = "bill-images-NOT-REVIEWED/$uuid-page-$pageNumber.png";  
} else {
  $error = ErrorPage::userErrorWithTitleAndMessage('Review image', 'Cannot find image');
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
                Review Bill Image
            </h1>
            <p class="lead"><?= htmlspecialchars($uuid) ?></p>
            <p class="lead">Page #<?= htmlspecialchars($pageNumber) ?></p>
        </section>
    </div>

    <section class="selling-point text-xs-center">
      <div class="row">
        <div class="col-md-6">
          <h2>Original image</h2>
          <img class="img-fluid" src="<?= $fileName ?>">
        </div>
        <div class="col-md-6">
          <h2>Instructions</h2>
          <ol>
            <li>Download the image (right click, download)
            <li>Rotate if necessary
            <li>Crop if necessary            
            <li>Adjust color if necessary            
            <li>Redact sensitive information
            <ul>
              <li>Names
              <li>Account numbers
              <li>Barcodes
              <li>ONLY the last two digits of the street address
            </ul>
            <li>Resize the file so the longest edge is 1200 pixels
            <li>Save as PNG file
            <li>Upload that file below
          </ol>
          <hr>
          <h2>Final image</h2>
            <form action="volunteers-upload-image" method="post" enctype="multipart/form-data">
              <input type="hidden" name="uuid" value="<?= $uuid ?>">
              <input type="hidden" name="pageNumber" value="<?= $pageNumber ?>">             
              <input type="file" name="file" />
              <button class="btn btn-lg btn-primary">
                <i class="fa fa-upload" aria-hidden="true"></i>
                Upload
              </button>
            </form>
        </div>
      </div>
      
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
