<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

// haal id van user uit sessie
$id = $_SESSION["id"];

// haal informatie van user uit de DB
$sql = "SELECT * FROM `bmi_users` WHERE `userid` = $id;";

$result = mysqli_query($conn, $sql);
// pak het bestaande bmi als het er is
if ( mysqli_num_rows($result) == 1 ) {
  $record = mysqli_fetch_assoc($result);
  $bmi = $record["bmi"];
}

// Switch voor script-bmi
if (isset($_SESSION["calc"])) {
    switch ($_SESSION["calc"]) {
        case "success":
            $bmiSucces = "success";
            $msg = "u bm is ingesteld.";
            unset($_SESSION["calc"]);
            break;
        case "error1":
            $bmiClasses = "error";
            $msg = "Error1 neem contact op met achterlijke webdeveloper";
            unset($_SESSION["calc"]);
        break;
        case "error2":
            $bmiClasses = "error";
            $msg = "Error2 neem contact op met achterlijke webdeveloper";
            unset($_SESSION["calc"]);
        break;
        case "error3":
            $bmiClasses = "error";
            $msg = "Error3 neem contact op met achterlijke webdeveloper";
            unset($_SESSION["calc"]);
        break;
            
    }
}

if(isset($bmi)){
     switch(true){
         case ($bmi < 18.5):
             $bmiMsg = "u heeft ondergewicht!";
             break;
             case ($bmi > 18.5 && $bmi < 25.01): 
             $bmiMsg = "u heeft een gezond gewicht!";
             break;
             case ($bmi > 25 && $bmi < 30.01): 
             $bmiMsg = "u heeft overgewicht!";
             break;
             case ($bmi > 30 && $bmi < 35): 
             $bmiMsg = "u heeft obesitas!";
             break;
             case ($bmi > 35):
             $bmiMsg = "u heeft extreme obesitas!";
             break;
        }
    }
 
?>

<!-- Error message display -->
<div class="<?php if (isset($bmiClasses)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
    <?php
        if (isset($bmiClasses)) {
             echo "<p class='". $bmiClasses ."'>". $msg ."</p>";
        }
    ?>
</div>

<!-- Formulier -->
<form action="index.php?content=script-bmi" method="post">
    <div class="form-group">
        <label for="bdate">Geboorte Datum</label>
        <input class="form-control" id="bdate" name="bdate" placeholder="dd/mm/yyyy">
    </div>
    <div class="form-group">
        <label for="massa">Massa (kg)</label>
        <input type="number" class="form-control" id="mass" name="mass" placeholder="00"> 
    </div>
    <div class="form-group">
        <label for="lengte">Lengte (cm)</label>
        <input type="number" class="form-control" id="length" name="length" placeholder="000">
    </div>
    <button type="submit" class="btn btn-primary" value="calc">Bereken BMI</button>
</form>


<!-- Bericht als er al een bmi in de db staat -->
<div class="<?php if (isset($bmi)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
    <?php
        if (isset($bmi)) {
            echo "<p> uw bmi is: " . $bmi ."</p>";
            echo "<p>". $bmiMsg ."</p>";
        }
    ?>
</div>