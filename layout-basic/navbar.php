<?php $content = (isset($_GET['content']) ? $_GET['content'] : false); ?>
<nav class="navbar navbar-expand-lg navbar-light navbar-sticky">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-title">
    <h2>BMI</h2>
  </div>

  <div class="nav-icons">
    <a href="index.php?content=redirect"><i class="fas fa-user" title="Mijn account"></i></a>
    <?php if (isset($_SESSION["id"])) {
echo "<a href='index.php?content=uitloggen'><i class='fas fa-sign-out-alt'></i></a>";
} 
?>

  </div>

</nav>