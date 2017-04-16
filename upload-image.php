<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'sources/config.php';

if (empty($_FILES['file']['tmp_name'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Missing file, please go back and try again');
  $error->renderAndDie();
}
if (empty($_POST['pageNumber']) || !intval($_POST['pageNumber'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Missing page number, please go back and try again');
  $error->renderAndDie();
}
if (empty($_POST['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Missing uuid, please go back and try again');
  $error->renderAndDie();
}
if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i',$_POST['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Bad uuid');
  $error->renderAndDie();
}

$file = file_get_contents($_FILES['file']['tmp_name']);
if (!$file) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Could not access file');
  $error->renderAndDie();
}

$image = @imagecreatefromstring($file);
if (!$image) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Could not load file, maybe it is not an image?');
  $error->renderAndDie();
}

// This removes metadata, GPS coordinates etc.
$result = imagepng($image, 'bill-images-NOT-REVIEWED/' . $_POST['uuid'] . '-page-' . $_POST['pageNumber'] . '.png');
if (!$image) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Bill upload', 'Could not save as PNG');
  $error->renderAndDie();
}

echo "SUCCESS";
