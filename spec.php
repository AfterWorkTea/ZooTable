<html lang="en">
<link rel="stylesheet" type="text/css" href="css/zoo.css">
 <head>
  <title>Zoo Demo App</title>
  <meta charset="UTF-8" />
 </head>
 <body>

  <?php
    include "include/header.php";
  ?>

  <h2>System Specification</h2>

  <p>The following provides technical background of the Zoo Demo applicaiton.</p>

  <h3>Architecture</h3>

  <p>The Zoo application consist of two layers:</p>
  <ul>
  <li>MySQL DB for consistent storage, processing requests and generating XML response.</li>
  <li>Apache2 server with PHP for control/presentation.</li>
  </ul>

  <p>It assumes that data sorting and filtering takes place in stored routines (on DB side).</p>


  <p><img src="pic/PHP-XLST.png" /></p>

  <h3>Zoo DB model</h3>
  <p>There are are two tables in 1-N relation:</p>
  <p><img src="pic/zoo-db.png" /></p>

  <h3>Requirements</h3>
  <p>The following configuration is recommended to host Zoo Demo:</p>
  <ul>
  <li>Linux OS</li>
  <li>MySQL Sever Community Server</li>
  <li>Apache 2.0 HTML server with PHP modules to support PDO-MySQL</li>
  <li>PHP 5.6.x for HTML pages (using PDO/MySQL, php5-xsl).</li>
  </ul>

  <h3>Running</h3>
  <p>Please execute the included db/run.sh to build the database (it will ask for DB root password) before checking examples.</p>
  
  <?php
    include "include/footer.php";
  ?>

  </div>

 </body>
</html>
