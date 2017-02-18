<?php
namespace SillyUtility;

class ErrorPage
{
  ##############################################################################
  ## MODEL
  ##############################################################################

  // Title for the page
  public $title = 'Error';
  
  // Message to explain what happened (will be HTML encoded)
  public $message = 'A problem happened with this web page';
  
  // Message to explain what happened (will be HTML encoded)
  public $statusCode = 'A problem happened with this web page';
  
  // Is this a result of a proble initiated with the user 
  public $isUsersFault = false;
 
  ##############################################################################
  ## FACTORY
  ##############################################################################

  private function init() {
  }

  public static function userErrorWithTitleAndMessage($title, $message) {
    $retval = new self();
    $retval->title = $title;
    $retval->message = $message;
    $retval->isUsersFault = true;
    return $retval;
  }

  public static function serverErrorWithTitleAndMessage($title, $message) {
    $retval = new self();
    $retval->title = $title;
    $retval->message = $message;
    $retval->isUsersFault = false;
    return $retval;
  }

  ##############################################################################
  ## BUSINESS
  ##############################################################################

  public function renderAndDie() {
    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');  
    if ($this->isUsersFault) {
      header($protocol . ' 400 Bad Request', true, 400);
    } else {
    	header($protocol . ' 500 Internal Server Error', true, 500);      
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
    <div class="primary-color-band">
        <section class="selling-point text-xs-center">      
            <h1 class="display-1">Error</h1>
            <h2><?= htmlspecialchars($this->title) ?></h2>
            <p><?= htmlspecialchars($this->message) ?></p>
        </section>
    </div>
</body>
</html>
<?php
die();    
  }
}