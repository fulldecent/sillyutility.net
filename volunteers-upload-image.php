<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'vendor/autoload.php';
require 'sources/config.php';

if (empty($_FILES['file']['tmp_name'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Missing file, please go back and try again');
  $error->renderAndDie();
}
if (empty($_POST['pageNumber']) || !intval($_POST['pageNumber'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Missing page number, please go back and try again');
  $error->renderAndDie();
}
if (empty($_POST['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Missing uuid, please go back and try again');
  $error->renderAndDie();
}
if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i',$_POST['uuid'])) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Bad uuid');
  $error->renderAndDie();
}
$sizes = getimagesize($_FILES['file']['tmp_name']);
if ($sizes === false) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Could not understand image');
  $error->renderAndDie();
}
if ($sizes[0] > 1200 || $sizes[1] > 1200) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Image is too big. Please have the longest size exactly 1200 pixels.');
  $error->renderAndDie();  
}

$file = file_get_contents($_FILES['file']['tmp_name']);
if (!$file) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Could not access file');
  $error->renderAndDie();
}

$image = imagecreatefromstring($file);
if (!$image) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Could not load file');
  $error->renderAndDie();
}

// This removes metadata, GPS coordinates etc.
$result = imagejpeg($image, 'bill-images-EDITED/' . $_POST['uuid'] . '-page-' . $_POST['pageNumber'] . '.jpg', 75);
if (!$image) {
  $error = ErrorPage::userErrorWithTitleAndMessage('Volunteer image upload', 'Could not save image');
  $error->renderAndDie();
}

header('Location: volunteers-review-bill?uuid=' . $_POST['uuid']);
