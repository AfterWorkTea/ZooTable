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

  <h3>Example 1</h3>

  <p><strong>Topic:</strong> PHP DB query using PDO</p>
 
  <p><strong>Data:</strong> responce from 'select * from list':</p>

  <h3>The output</h3>
  
  <p style="padding-left:5em;">
  <?php
   $servername='localhost';
   $dbname='zoodb';
   $username='zoo';
   $password='zoo!';
   
   try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $stmt = $conn->prepare("select * from list;");
       $stmt->execute();
       while($raw = $stmt->fetch(PDO::FETCH_ASSOC)) {          
          print_r($raw);
          echo "<br/>";
       }
   } catch(PDOException $e)   {
       echo "PDOException: " . $e->getMessage();
   }
  ?>
 
  <p>


  <h3>The code</h3>

  <p>The <strong>PHP</strong> call to DB</p>
  <textarea rows="20" cols="100">
   $servername='localhost';
   $dbname='zoodb';
   $username='zoo';
   $password='zoo!';
   
   try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $stmt = $conn->prepare("select * from list;");
       $stmt->execute();
       while($raw = $stmt->fetch(PDO::FETCH_ASSOC)) {          
          print_r($raw);
          echo "<br/>";
       }
   } catch(PDOException $e)   {
       echo "PDOException: " . $e->getMessage();
   }
  </textarea>

  <?php
    include "include/footer.php";
  ?>


 </body>
</html>
