<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'sources/config.php';
$uuid = gen_uuid();
?>

<!-- Ideas from http://www.dropzonejs.com/bootstrap.html -->
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" integrity="sha256-p2l8VeL3iL1J0NxcXbEVtoyYSC+VbEbre5KHbzq1fq8=" crossorigin="anonymous"></script>

<style>
.display-3 {
  font-size: 3.5rem;
}
@media(min-width:34em){
  font-size: 4.5rem;
}
.card-group {
  margin: 1em 0;
}
.card {
  background: none;
}
</style>

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
                Upload a utility bill.
            </h1>
<!--
            <div style="padding: 1em; border: 10px dashed rgba(255, 255, 255, 0.50); border-radius: 2em; margin: 1em 0" class="hidden-xs-down">
                <h2>Drag and drop each image here or use the button below.</h2>
            </div>
-->
            <span class="btn btn-primary fileinput-button">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <i class="fa fa-camera" aria-hidden="true"></i>
                <span>Add images...</span>
            </span>

            <div class="card-group" class="files" id="previews">
              <div class="card" id="template">
                <img class="card-img-top" data-dz-thumbnail>
                <div class="card-block">
                  <h4 class="card-title" data-dz-name></h4>
                  <p class="error text-danger" data-dz-errormessage></p>
                  <p class="card-text"><small class="text-muted" data-dz-uploadprogress></small></p>

                  <div>
                      <p class="size" data-dz-size></p>
                      <progress class="progress" value="0" max="100" aria-describedby="example-caption-1" data-dz-uploadprogress></progress>
                  </div>
                </div>
              </div>
            </div>
            <form style="display:none" class="text-center text-xs-center" action="uploading" method="get" id="doneUploading">
                <h2>
                    Or, click below if that was the last page...
                </h2>
                <input type="hidden" name="uuid" value="<?= htmlspecialchars($uuid) ?>">
                <button class="btn btn-lg btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> That was the last page</button>
            </form>

        </section>
    </div>

    <section class="selling-point text-xs-center">
        <div class="container">
            <h2 class="display-4 text-xs-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Here are some notes.</h2>
            <hr class="section">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-item">
                        <h3>
                          <i class="fa fa-file" aria-hidden="true"></i>
                          Get your PDF bill.
                        </h3>
                        <p class="text-muted">
                          <strong class="text-info">Comcast:</strong>
                          <a href="https://customer.xfinity.com/Secure/MyAccount/" target="_blank">Login here</a> and click "View or print bill" to the right of the "Your bill summary" heading.
                        </p>
                        <hr>
                        <p class="text-muted">
                          <strong class="text-info">Verizon:</strong>
                          PLEASE HELP ADD NOTES HERE. EMAIL volunteers@sillyutility.net
                        </p>
                        <hr>
                        <p class="text-muted">
                          <strong class="text-info">Aqua:</strong>
                          PLEASE HELP ADD NOTES HERE. EMAIL volunteers@sillyutility.net
                        </p>
                        <hr>
                        <p class="text-muted">
                          <strong class="text-info">PECO:</strong>
                          PLEASE HELP ADD NOTES HERE. EMAIL volunteers@sillyutility.net
                        </p>
                        <hr>
                        <p class="text-muted">
                          <strong class="text-info">Other:</strong>
                          You can upload other monthly utility bills, we'll figure out how to categorize them.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-item">
                        <h3>
                          <i class="fa fa-mobile-phone" aria-hidden="true"></i>
                          Or snap with a phone.
                        </h3>
                        <p class="text-muted">
                          You can use Snapchat to photograph your bill.
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-item">
                        <h3>
                          <i class="fa fa-eye" aria-hidden="true"></i>
                          Redact it.
                        </h3>
                        <p class="text-muted">
                          Please remove your name, account number and the last two digits of your street address. Also get any barcodes on the page (especially the one under your address).
                        </p>
                        <hr>
                        <p class="text-muted">
                          <strong class="text-info">On Snapchat:</strong>
                          Use the doodle button (<i class="fa fa-pencil" aria-hidden="true"></i>) to hide information and then save (<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>).
                        </p>
                        <hr>
                        <p class="text-muted">
                          <strong class="text-info">On Mac:</strong>
                          Scan PDF, use the line tool (<i class="fa fa-pencil" aria-hidden="true"></i>) to hide information and save each page as PNG file.
                        </p>
                        <hr>
                        <p class="text-muted">
                          <strong class="text-info">On Windows:</strong>
                          WE HAVEN'T DONE THIS ON WINDOWS YET. PLEASE HELP ADD INSTRUCTIONS HERE. EMAIL volunteers@sillyutility.net
                        </p>
                    </div>
                </div>
            </div>
    </section>

    <footer class="text-xs-center">
            <p>Made by <a href="http://phor.net/">William Entriken</a> because I think utilities are a racket.</p>
            <p>Please mail volunteers<span>@</span>sillyutility.net to assist with this project.</p>
            <p>Privacy policy: we publish what you give us, that's the point.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script>
// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
  url: "upload-image", // Set the url
  thumbnailWidth: 80,
  thumbnailHeight: 80,
  parallelUploads: 20,
  previewTemplate: previewTemplate,
  autoQueue: true,
  previewsContainer: "#previews", // Define the container to display the previews
  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
});

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
  $('#doneUploading').show();
});

pageNumber = 1
myDropzone.on("sending", function(file, xhr, formData) {
  // Will send the filesize along with the file as POST data.
  formData.append("uuid", "<?= $uuid ?>");
  formData.append("pageNumber", pageNumber);
  pageNumber++;
});

    </script>
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
