<?php
     
    require 'baza.php';
 
    if ( !empty($_POST)) {
        // provjera grešaka
        $imeError = null;
        $prezimeError = null;
         
        // dohvaćanje vrijednosti
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
         
        // provjera unosa
        $valid = true;
        if (empty($ime)) {
            $imeError = 'Molimo unesite ime';
            $valid = false;
        }
         
        if (empty($prezime)) {
            $prezimeError = 'Molimo unesite prezime';
            $valid = false;
        }
        
         
        // unos podataka
        if ($valid) {
            $pdo = Baza::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO podaci (ime,prezime) values(?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($ime,$prezime));
            Baza::disconnect();
            header("Location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Kreiranje podataka</h3>
                    </div>
             
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($imeError)?'error':'';?>">
                        <label class="control-label">Ime</label>
                        <div class="controls">
                            <input name="ime" type="text"  placeholder="ime" value="<?php echo !empty($ime)?$ime:'';?>">
                            <?php if (!empty($imeError)): ?>
                                <span class="help-inline"><?php echo $imeError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($prezimeError)?'error':'';?>">
                        <label class="control-label">Prezime</label>
                        <div class="controls">
                            <input name="prezime" type="text" placeholder="prezime" value="<?php echo !empty($prezime)?$prezime:'';?>">
                            <?php if (!empty($prezimeError)): ?>
                                <span class="help-inline"><?php echo $prezimeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Kreiraj</button>
                          <a class="btn" href="index.php">Povratak</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>