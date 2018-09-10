<?php
    require 'baza.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
     
    if ( !empty($_POST)) {
        $imeError = null;
        $prezimeError = null;
         
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
         
        $valid = true;
        if (empty($ime)) {
            $imeError = 'Molimo unesite ime';
            $valid = false;
        }
        $valid = true;
        if (empty($prezime)) {
            $prezimeError = 'Molimo unesite prezime';
            $valid = false;
        }
         
        if ($valid) {
            $pdo = Baza::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE podaci  set ime = ?, prezime = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($ime,$prezime,$id));
            Baza::disconnect();
            header("Location: index.php");
        }
    } else {
        $pdo = Baza::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM podaci where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $ime = $data['ime'];
        $prezime = $data['prezime'];
        Baza::disconnect();
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
                        <h3>Ažuriranje podataka</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
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
                          <button type="submit" class="btn btn-success">Ažuriraj</button>
                          <a class="btn" href="index.php">Povratak</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>