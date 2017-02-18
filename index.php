<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="William Entriken">
    <title>Silly Utility</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" crossorigin="anonymous">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="header-content">
                        <div class="header-content-inner">
                            <h1>Compare Utility Bills<br>With Neighbors.</h1>
                            
<form action="zipcode.php" method="get">

<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, 'http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 500);
$geo = json_decode(curl_exec($ch));
curl_close($ch);
//var_dump($geo);
$zip = '';
if ($geo->country_code == 'US' && !empty($geo->zip_code) && !strstr(strtolower($_SERVER['HTTP_USER_AGENT']), "googlebot"))
  $zip = $geo->zip_code;
?>

  <input class="form-control form-control-lg" type="text" pattern="\d*" name="zipcode" placeholder="ZIP Code" value="<?= $zip ?>" style="width:10em">
  <button class="btn btn-primary btn-outline btn-xl">Go</button>
</form>  

                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                    <img src="compare.png" class="img-responsive" alt="">
                                </div>
                                <div class="button">
                                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="one" class="feature bg-one text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading">You're a Comcast customer for 33 years.</h2>
                    <p>But someone else on your block gets better service for less money.</p>
                    <div class="badges">
                        <i class="fa fa-television fa-5x" aria-hidden="true"></i>
                        <i class="fa fa-globe fa-5x" aria-hidden="true"></i>
                        <i class="fa fa-phone fa-5x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="two" class="feature bg-two text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-heading">
                        <h2>Companies charge whatever they want.</h2>
                        <p>They make you buy phone service and you don't even have a phone.</p>
                    <div class="badges">
                        <i class="fa fa-money fa-5x" aria-hidden="true"></i><br>
                        <i class="fa fa-magnet fa-5x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h2>Renegotiate your bill.</h2>
                        <p class="text-muted">See what your neighbors pay, and call to ask for the same deal.</p>
                        <div class="badges">
                            <i class="text-info fa fa-magic fa-5x" aria-hidden="true"></i><br>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                    <img src="alert.png" class="img-responsive" alt="Review Comcast XFINITY bill"> </div>
                                <div class="button">
                                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-screen-smartphone text-primary"></i>
                                    <h3>Philly <i class="text-danger fa fa-heart" aria-hidden="true"></i></h3>
                                    <p class="text-muted">Works in Philadelphia, PA and surrounding neighborhoods.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-camera text-primary"></i>
                                    <h3>It's free</h3>
                                    <p class="text-muted">We do not charge money for this service.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-lock-open text-primary"></i>
                                    <h3>Contribute</h3>
                                    <p class="text-muted">Send us your utility bill to compare. Use a smartphone with Snapchat or any computer to redact in seconds.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-present text-primary"></i>
                                    <h3>You redact</h3>
                                    <p class="text-muted">You remove account numbers, names and part of your address BEFORE sending us your bill. We also review and delete anything you missed before publishing.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="cta">
        <div class="cta-content">
            <div class="container">
                <h2>Do it now.</h2>
                <a href="upload" class="btn btn-outline btn-xl page-scroll">Compare bills</a>
            </div>
        </div>
        <div class="overlay"></div>
    </section>

    <section id="contact" class="contact bg-primary">
        <div class="container">
            <h2>
              <i class="fa fa-plane" aria-hidden="true"></i>
              Use the money to go on vacation or something.                     
            </h2>
            <h2>
              <i class="fa fa-heart"></i>
              Tell everyone you know.
            </h2>
            <ul class="list-inline list-social">
                <li class="social-twitter">
                    <a target="_blank" href="https://twitter.com/intent/tweet?text=I'm%20renegotiating%20my%20utility%20plans,%20thanks%20#sillyutility"><i class="fa fa-twitter"></i></a>
                </li>
                <li class="social-facebook">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://sillyutility.net"><i class="fa fa-facebook"></i></a>
                </li>
            </ul>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>Made by <a href="http://phor.net/">William Entriken</a> because I think utilities are a racket.</p>
            <p>Please mail volunteers<span>@</span>sillyutility.net to assist with this project.</p>
            <p>Read <a href="blog">our blog</a>.</p>
            <p>Privacy policy: we publish what you give us, that's the point.</p>
        </div>
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
