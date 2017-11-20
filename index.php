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
  <style>
header {
  position:relative;
  width:100%;
  min-height:auto;
  overflow-y:hidden;
  background:url(../img/bg-pattern.png),#8e44ad;
  background:url(../img/bg-pattern.png),-webkit-linear-gradient(to left,#8e44ad,#e74c3c);
  background:url(bg-pattern.png),linear-gradient(to left,#8e44ad,#e74c3c);
  color:#fff;
  font-family:Catamaran,Helvetica,Arial,sans-serif;font-weight:200;letter-spacing:1px;
  padding: 3em 0;
}

footer {
  text-align: center;
}

section{padding:5em 0}
section.feature{padding:150px 0;position:relative}

.bg-one{color:white;background:#f1c40f;background:-webkit-linear-gradient(#f1c40f,#e7842d);background:linear-gradient(#f1c40f,#e7842d)}
.bg-two{color:white;background:#3498db;background:-webkit-linear-gradient(#3498db,#2980b9);background:linear-gradient(#3498db,#2980b9)}

section.features .section-heading{margin-bottom:100px}
section.features .section-heading h2{margin-top:0}
section.features .section-heading p{margin-bottom:0}
section.features .device-container,section.features .feature-item{max-width:300px;margin:0 auto}
section.features .device-container{margin-bottom:100px}

section.cta{position:relative;-webkit-background-size:cover;-moz-background-size:cover;background-size:cover;-o-background-size:cover;background-position:center;background-image:url(bg-cta.jpg);padding:250px 0}

ul.list-social li a{display:inline-block;height:80px;width:80px;line-height:80px;font-size:40px;border-radius:100%;color:#fff}
ul.list-social li.social-twitter a{background-color:#1da1f2}
ul.list-social li.social-twitter a:hover{background-color:#0d95e8}
ul.list-social li.social-facebook a{background-color:#3b5998}
ul.list-social li.social-facebook a:hover{background-color:#344e86}
ul.list-social li.social-google-plus a{background-color:#dd4b39}
ul.list-social li.social-google-plus a:hover{background-color:#d73925}

  </style>
</head>

<body>
  <header>
    <div class="container">
      <div class="row">
        <div class="col-lg-7 align-self-center justify-content-center">
          <h1 class="display-3">Compare Utility Bills With Neighbors.</h1>
          <form action="zipcode.php" method="get" class="form-inline">
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
            <button class="btn btn-primary btn-outline btn-lg">Go</button>
          </form>
        </div>
        <div class="col-lg-5">
          <img src="compare.png" class="img-fluid" alt="Comcast">
        </div>
      </div>
    </header>

    <section id="one" class="feature bg-one text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h2 class="display-4">You're a Comcast customer for 33 years.</h2>
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
                <div class="col-md-8 offset-md-2">
                    <h2 class="display-4">Companies charge whatever they want.</h2>
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
                    <h2 class="display-4 section-heading">Renegotiate your bill.</h2>
                    <div class="section-heading">
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
                    <img src="alert.png" class="img-fluid" alt="Review Comcast XFINITY bill">
                </div>
                <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                    <i class="icon-screen-smartphone text-primary"></i>
                                    <h3>Philly <i class="text-danger fa fa-heart" aria-hidden="true"></i></h3>
                                    <p class="text-muted">Works in Philadelphia, PA and surrounding neighborhoods.</p>
                            </div>
                            <div class="col-md-6 text-center">
                                    <i class="icon-camera text-primary"></i>
                                    <h3>It's free</h3>
                                    <p class="text-muted">We do not charge money for this service.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                    <i class="icon-lock-open text-primary"></i>
                                    <h3>Contribute</h3>
                                    <p class="text-muted">Send us your utility bill to compare. Use a smartphone with Snapchat or any computer to redact in seconds.</p>
                            </div>
                            <div class="col-md-6 text-center">
                                    <i class="icon-present text-primary"></i>
                                    <h3>You redact</h3>
                                    <p class="text-muted">You remove account numbers, names and part of your address BEFORE sending us your bill. We also review and delete anything you missed before publishing.</p>
                            </div>
                        </div>
                </div>
            </div>
    </section>

    <section class="cta" class="feature bg-two text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 style="color: white" class="display-3">Do it now.</h2>
                    <a style="color:white; border-color: white" class="btn btn-outline-primary btn-lg" href="upload" role="button">Compare bills</a>
                </div>
            </div>
        </div>
    </section>

    <section id="one" class="feature bg-one text-center" style="background:#fdcc52;background:-webkit-linear-gradient(#fdcc52,#fdc539);background:linear-gradient(#fdcc52,#fdc539)">
      <div class="container">
        <h2 class="display-4"><i style="color:red" class="fa fa-plane" aria-hidden="true"></i> Use the money to go on vacation or something.</h2>
        <h2 class="display-4"><i style="color:red" class="fa fa-heart" aria-hidden="true"></i> Tell everyone you know.</h2>

          <ul class="list-inline list-social">
            <li class="list-inline-item social-twitter">
              <a target="_blank" href="https://twitter.com/intent/tweet?text=I'm%20renegotiating%20my%20utility%20plans,%20thanks%20#sillyutility"><i class="fa fa-twitter"></i></a>
            </li>
            <li class="list-inline-item social-facebook">
              <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://sillyutility.net"><i class="fa fa-facebook"></i></a>
            </li>
          </ul>
      </div>
    </section>

    <footer>
        <div class="container">
            <p>Made by <a href="http://phor.net/">William Entriken</a> because I think utilities are a racket.</p>
            <p>Please mail volunteers<span>@</span>sillyutility.net to assist with this project. <a href="https://github.com/fulldecent/silly-utility">See our GitHub</a>.</p>
            <p>Read <a href="blog">our blog</a>.</p>
            <p>Privacy policy: we publish what you give us, that's the point.</p>
        </div>
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
