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

  <h3>Example 2</h3>

  <p><strong>Topic:</strong> Calling stored function returning XML</p>

  <p><strong>Data:</strong> 'select GetZoo1() as XML'</p>

  <h3>The output</h3>

  <?php
   $servername='localhost';
   $dbname='zoodb';
   $username='zoo';
   $password='zoo!';
   
   try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $stmt = $conn->prepare("select GetZoo1() as XML;");
       $stmt->execute();
       $xml = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
       $data =  htmlspecialchars($xml['XML'], ENT_XML1, 'UTF-8');
       echo "<textarea rows=\"15\" cols=\"70\">". $data. "</textarea>";
   } catch(PDOException $e)   {
       echo "PDOException: " . $e->getMessage();
   }
  ?>

  <h3>The code</h3>

  <p>The <strong>PHP</strong></p>
  <textarea rows="10" cols="120">
   $servername='localhost';
   $dbname='zoodb';
   $username='zoo';
   $password='zoo!';
   
   try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $stmt = $conn->prepare("select GetZoo1() as XML;");
       $stmt->execute();
       $xml = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
       $data =  htmlspecialchars($xml['XML'], ENT_XML1, 'UTF-8');
       echo $data;
   } catch(PDOException $e)   {
       echo "PDOException: " . $e->getMessage();
   }
  </textarea>

  <p>The MySQL <strong>GetZoo1()</strong> stored function</p>
  <textarea rows="10" cols="120">
  <?php
    include "db/GetZoo1.sql";
  ?>
  </textarea>

  <?php
    include "include/footer.php";
  ?>


 </body>
</html>
