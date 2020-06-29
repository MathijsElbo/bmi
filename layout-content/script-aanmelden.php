<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$email = sanitize($_POST["email"]);
$user = strstr($email, '@', true);

if (!empty($email)) {

  // Maak een select-query om te controleren of het e-mailadres al bestaat.
  $sql = "SELECT * FROM `bmi_users` WHERE `email` = '$email'";

  // Stuur de query af op de database
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result)) {
    // Email is al in gebruik
    // echo '<div class="alert alert-info" role="alert">Het door u ingevoerde e-mailadres is al in gebruik, kies een ander e-mailadres</div>';
    $_SESSION["register"] = "error";
    $_SESSION["email"] = $email;
    header("Location: index.php?content=inloggen");
  } else {
    $password = RandomString();
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `bmi_users` (`userid`,
                                  `email`, 
                                  `password`,
                                  `username`,
                                  `bmi`,
                                  `length`,
                                  `mass`,
                                  `userroleid`,
                                  `salt`)
                          VALUES (NULL,
                                  '$email',
                                  '$password',
                                  NULL,
                                  NULL,
                                  NULL,
                                  NULL,
                                  1,
                                  NULL)";

    $createpinfo = mysqli_query($conn, $sql);

    // Hiermee vraag je de door autonummering gemaakt id op
    $id = mysqli_insert_id($conn);

    if ($createpinfo) {
      // Verstuur de email met activatielink naar de persoon die zich registreert.
      $to = $email;
      $subject = "Activatielink BMI";
      $message = "<!DOCTYPE html>
      <html>
        <head>
        <title>bmi website</title>
        <style>
        </style>
        </head>
        <body style='margin: 0; padding: 0;'> 
        <p> Heeft u zich geprobeert te registreren op onze website dan kunt u op de onderstaande link klikken en anders kunt u deze mail negeren
        </p>
        <a href='http://www.bmi.org/index.php?content=script-kiespw&id=" . $id . "&pw=" . $password_hash . "'
        style='padding: 8px 12px; border: 1px solid #0089c1;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 18px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;'>
        Activeer mijn account!
      </a>              
      </body>
      </html>";

      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";
      $headers .= "From: register@bmi.nl" . "\r\n";
      $headers .= "Cc: 328184@student.mboutrecht.nl;" . "\r\n";

      mail($to, $subject, $message, $headers);

      $_SESSION["register"] = "success";
      $_SESSION["email"] = $email;
      header("Location: index.php?content=inloggen");
    } else {
      $_SESSION["register"] = "error";
      $_SESSION["email"] = $email;
      header("Location: index.php?content=inloggen");
    }
  }
} else {
  $_SESSION["register"] = "error";
  $_SESSION["email"] = $email;
  header("Location: index.php?content=inloggen");
}
