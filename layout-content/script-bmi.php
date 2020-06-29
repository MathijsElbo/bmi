<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$bdate = sanitize($_POST["bdate"]);
$mass = sanitize($_POST["mass"]);
$length = sanitize($_POST["length"]);


//Controle of er een massa en lengte is
if (isset($mass) && isset($length)) {
    //Als de user een massa en lengte heeft word de bmi uitgerekend

        $a = floatval($length) / 100;
        $b = floatval($mass);
        $c = floatval($a)*floatval($a);
        

        $bmi = floatval($b) / floatval($c);

    //Test of de User's BMI een waarde heeft gekregen
        if ($bmi) {
        


        $id = $_SESSION["id"];

        $sql = "UPDATE `bmi_users`
         SET `bmi` = $bmi,
        `mass` = $mass,
        `length` = $length
         WHERE `userid` = $id";


        $result = mysqli_query($conn, $sql);

        if ($result)  {
            $_SESSION["calc"] = "success";
            echo $bmi;
            header("Location: index.php?content=myaccount");

          } else {
            $_SESSION["calc"] = "error3";
           header("Location: index.php?content=myaccount");
          }
        
        //Geef Session "bmi" de waarde van de BMI


    }
    else {
        $_SESSION["calc"] = "error2";
        header("Location: index.php?content=myaccount");
    }

} else {
    $_SESSION["calc"] = "error1";
    header("Location: index.php?content=myaccount");
}


// error 1 betekent dat de lengte en massa niet in de instance staan.
// error 2 betekent dat de bmi niet in de instance staat.

?>