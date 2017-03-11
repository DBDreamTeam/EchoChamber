<?php include '../includes/connect.php'?>
<?php session_start();
print_r($_SESSION);?>

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
    <!-- Custom CSS -->
    <!-- TIME PARAM ADDED TO FORCE CSS RELOAD - REMOVE WHEN FINAL -->
    <link href="css/custom.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
  </head>
  
  <body>
  
  <?php echo $_SESSION["LoggedUserID"];?>
    
    <?php
    include("../includes/entity-onboarding.php");
    $entity = get_entity();
    
    // TEST
    //$_SESSION['UserID'] = 3;
    
    ?>
    
    <header>
      <h1><span id="echo">Echo</span>Chamber</h1>
    </header>
    
    <div class="container">
      <div class="jumbotron">
        <div class="row">
          <div class="col-sm-9 col-sm-offset-1">
            <h2>Now, let's find your chamber!</h2>
            <p>Tell us how you feel about a few things:</p>
          </div>
        </div>
        
        <div class="row">
          <div class="col-xs-12 text-center">
            
            <h1><?php echo ucwords($entity); ?></h1>
            
            <form action="../process/process-entity-onboarding.php" method="post" class="signup-form form-inline">
              <input type="hidden" name="entity" value="<?php echo $entity; ?>">
              <button type="submit" class="btn btn-default" name="sentiment" value="negative"
                      id="btn-negative-sentiment">
                <span class="glyphicon glyphicon-thumbs-down"></span>
              </button>
              <button type="submit" class="btn btn-default" name="sentiment" value="neutral">
                <span class="glyphicon glyphicon-minus"></span>
              </button>
              <button type="submit" class="btn btn-default" name="sentiment" value="positive">
                <span class="glyphicon glyphicon-thumbs-up"></span>
              </button>
            </form>
            
          </div>
        </div>
      </div>
    </div>

  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
  </body>
</html>