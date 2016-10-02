<html lang="en">
<link rel="stylesheet" type="text/css" href="css/zoo.css">
 <head>
  <title>Zoo Demo App</title>
  <meta charset="UTF-8" />
 </head>
 <body>

<script>

  function onGroupChange() {
    document.getElementById("table").submit();
  }

</script>

  <?php
    include "include/header.php";
  ?>

  <h3>Example 7</h3>

  <p><strong>Topic:</strong> adding images and links to table generated by ZooTable</p>

  <p><strong>Data:</strong>'select GetGroup() as XML' and 'select GetZoo5() as XML'</p>

  <p>List of Changes:</p>
  <ul>
   <li>Display max 5 rows per page (example6 had 4 rows)</li>
   <li>New column 'Length' (the length of name - set in stored function)</li>
   <li>Display group as image</li>
   <li>The image should link to Wiki</li>
  </ul>

  <h3>The output</h3>

<?php

   include "include/ZooTable.php";
   include "include/zoo2XML.php";  //$definitionXML - DB access
   include "include/zoo2XSLT.php"; //$formatXSLT - XLST transformation

   $table = new ZooTable($definitionXML, $formatXSLT);
   echo "<fieldset style=\"height:280px;\">";
   echo "<legend>Example 7</legend>";
   echo $table->getHTML("example7.php");
   echo "</fieldset>";

?>

  <h3>The code</h3>

  <p>The <strong>GetZoo5()</strong> it returns additional 'len' element and adds new coursor for sorting.</p>
  <textarea rows="10" cols="100">
  <?php
    include "db/GetZoo5.sql";
  ?>
  </textarea>

  <p>The main page using the ZooTable class</p>
  <textarea rows="10" cols="100">
  <!-- <script>
    function onGroupChange() {
       document.getElementById("table").submit();
    }
  -->

  <!-- PHP

   include "include/ZooTable.php";
   include "include/zoo2XML.php";  //$definitionXML - DB access
   include "include/zoo2XSLT.php"; //$formatXSLT - XLST transformation

   $table = new ZooTable($definitionXML, $formatXSLT);
   echo "<fieldset style=\"height:280px;\">";
   echo "<legend>Example 7</legend>";
   echo $table->getHTML("example7.php");
   echo "</fieldset>";

  -->
  </textarea>

  <p>The <strong>zoo2XML.php</strong> - changed to use 'GetZoo5' stored function and add new entry for 'Length'</p>
  <textarea rows="10" cols="100">
  <?php
   $text = file_get_contents("include/zoo2XML.php");
   $text = str_replace("<?php", "<--", $text);
   $text = str_replace("?>", "-->", $text);
   echo $text;
  ?>
  </textarea>

  <p>The <strong>zoo2XSLT.php</strong> - changed to add to handle '@len' and format images as links</p>
  <textarea rows="10" cols="100">
  <?php
   $text = file_get_contents("include/zoo2XSLT.php");
   $text = str_replace("<?php", "<--", $text);
   $text = str_replace("?>", "-->", $text);
   echo $text;
  ?>
  </textarea>

  <?php
    include "include/footer.php";
  ?>


 </body>
</html>