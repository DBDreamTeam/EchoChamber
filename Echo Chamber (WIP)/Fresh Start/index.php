<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>EchoChamber</title>

    <!-- Bootstrap -->
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css?v=<? time(); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <header id="welcome-banner">
      <h1><span>Echo</span>Chamber</h1>
      <h4>a social network for people just like you.</h4>
  </header>
  
  <body>
    <div class="wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-5 col-sm-offset-1 col-xs-12" id="intro">
            <p>
              <b>EchoChamber</b> is the social network for the modern day.
              Here, you can avoid seeing any views with which you disagree,
              and bask in just how fabulously <em>right</em> you are about
              everything. Join groups of like-minded people and while
              away your days patting each other on the back, reaffirming
              the views you came here with, and generally just reminding
              yourself how superior you are to all those other idiots out
              there. <b>Have fun!</b>
            <p>
          </div>

          
          <div class="col-sm-6 text-right" id="signin">
            <div class="row">
              <div class="col-xs-12 col-sm-8 col-sm-offset-4">
                <form>
                  <label>
                    <input type="email" name="email" value="email">
                  </label>
                  <label>
                    <input type="password" name="password" value="password">
                  </label>
                  <label>
                    <input type="submit" class="btn btn-default" name="submit" value="Log in">
                  </label>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-8 col-sm-offset-4">
                <h4>New here?</h4>
                <form action="register.php" method="post">
                  <label>
                    <input type="submit" class="btn btn-default" name="submit" value="Register!">
                  </label>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    
  </body>
  
  <footer>
    <div class="row">
      <div class="col-sm-12 hidden-xs text-right">
        <p>Copyright DB Dream Team 2017&copy;</p>
      </div>
    </div>
  </footer>
  
</html>
