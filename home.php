<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Erinn Szarek</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/background.css">


</head>
<body>
<section class="intro">
  <div id="hex">
    <!-- PARTICLES -->
    <canvas id="particles"></canvas>

    <!-- HEXAGON GRID -->
    <div id="hexagonGrid"></div>

  </div>

</section>
<nav>

  <?php
  echo ($currentFile == "index.php") ? "<span class='navpage'>Home</span>" : "<a href='index.php'>Home</a>";
  echo ($currentFile == "allClasses.php") ? "<span class='navpage'>My Classes</span>" : "<a href='allClasses.php'> My Classes</a>";
  ?>

</nav>

<main class="content">
  <div id="page-container">
    <div id="content-wrap">
    </div>
  </div>
</main>

