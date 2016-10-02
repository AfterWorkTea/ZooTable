<html lang="en">
<link rel="stylesheet" type="text/css" href="css/zoo.css">
 <head>
  <title>Zoo Demo Parser</title>
 </head>
 <body>

<?php

   include "include/zooXML.php";
   include "include/headerXSLT.php";

  function echoParam($name, $value) {  
     echo "<p>". $name. "=". $value. "</p>";
   }

  function echoXML($xml) {
    echo "<p><small>". htmlspecialchars($xml, ENT_XML1). "</small></p>";
  }

   $sourceXML = new SimpleXMLElement($sourceXMLString);

   echo "<h3>Params</h3>";

   echoParam("server", $sourceXML->database[0]->server[0]);
   echoParam("schema", $sourceXML->database[0]->schema[0]);
   echoParam("user", $sourceXML->database[0]->user[0]);
   echoParam("password", $sourceXML->database[0]->password[0]);
   echoParam("List@name", $sourceXML->functions[0]->list[0]->attributes()['name']);
   echoParam("Table@name", $sourceXML->functions[0]->table[0]->attributes()['name']);
   echoParam("Table@sort", $sourceXML->functions[0]->table[0]->attributes()['sort']);
   echoParam("Table@pagesize", $sourceXML->functions[0]->table[0]->attributes()['pagesize']);

   echo "<h3>Header XML</h3>";
   $xsltProc = new XSLTProcessor();
   $entryXSLT = str_replace("_sort_", $sourceXML->functions[0]->table[0]->attributes()['sort'], $headerXSLT);
   $xsltProc->importStylesheet(new SimpleXMLElement($entryXSLT));
   $tableHTML=$xsltProc->transformToXml($sourceXML);
   echoXML($tableHTML);

   echo "<h3>Table Header</h3>";
   echo "<table style=\"border:1px;\"><tr>". $tableHTML. "</tr></table>";

?>

 </body>
</html>
