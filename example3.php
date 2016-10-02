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

  <h3>Example 3</h3>

  <p><strong>Topic:</strong> Transforming an XML into a table</p>

  <p><strong>Data:</strong> 'select GetZoo1() as XML'</p>

  <h3>The output</h3>
  <p>Make sure to install <strong>php5-xsl</strong> if you don't see the output</p>

  <?php

   function getXSLT() {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
    	       "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">".
 	       "<xsl:template match=\"animal\">".
                    "<tr>".
                      "<xsl:choose>".
                         "<xsl:when test=\"((position() div 2) mod 2) = 0\">".
                             "<xsl:attribute name=\"class\">even</xsl:attribute>".
                         "</xsl:when>".
                         "<xsl:otherwise>".
                             "<xsl:attribute name=\"class\">odd</xsl:attribute>".
                         "</xsl:otherwise>".
                      "</xsl:choose>".
                      "<td><xsl:value-of select=\".\"/></td>".
                      "<td><xsl:value-of select=\"@group\"/></td>".
                      "<td class=\"right\"><xsl:value-of select=\"@count\"/></td>".
                    "</tr>".
               "</xsl:template>".
               "</xsl:stylesheet>";
   }

   function getXML() {
     $servername='localhost';
     $dbname='zoodb';
     $username='zoo';
     $password='zoo!';
     try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $stmt = $conn->prepare("select GetZoo1() as XML;");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['XML'];
     } catch(PDOException $e)   {
       echo "PDOException: " . $e->getMessage();
     }
     return "";
   }

   $xslt = new XSLTProcessor();
   $xslt->importStylesheet(new SimpleXMLElement(getXSLT()));
   echo "<fieldset>";
   echo "<legend>Example 3</legend>";
   echo "<table>";
   echo "<tr><th>Name</th><th>Group</th><th>Count</th></tr>";
   echo $xslt->transformToXml(new SimpleXMLElement(getXML()));
   echo "</table>";
   echo "</fieldset>";

?>

  <h3>The code</h3>

  <p>Please note new parts: XSLT, PDO call returning XML and XSLTProcessor. It uses the same GetZoo1().</p>
  <br/>
  <p>The PHP function returning XSLT</p>
  <textarea rows="10" cols="120">
  <!-- please remove the XML comment
   function getXSLT() {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
    	       "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">".
 	       "<xsl:template match=\"animal\">".
                    "<tr>".
                      "<xsl:choose>".
                         "<xsl:when test=\"((position() div 2) mod 2) = 0\">".
                             "<xsl:attribute name=\"class\">even</xsl:attribute>".
                         "</xsl:when>".
                         "<xsl:otherwise>".
                             "<xsl:attribute name=\"class\">odd</xsl:attribute>".
                         "</xsl:otherwise>".
                      "</xsl:choose>".
                      "<td><xsl:value-of select=\".\"/></td>".
                      "<td><xsl:value-of select=\"@group\"/></td>".
                      "<td class=\"right\"><xsl:value-of select=\"@count\"/></td>".
                    "</tr>".
               "</xsl:template>".
               "</xsl:stylesheet>";
  -->
  </textarea>

  <p>The PHP call DB</p>
  <textarea rows="10" cols="120">
  <!-- please remove the XML comment
   function getXML() {
     $servername='localhost';
     $dbname='zoodb';
     $username='zoo';
     $password='zoo!';
     try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $stmt = $conn->prepare("select GetZoo1() as XML;");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['XML'];
     } catch(PDOException $e)   {
       echo "PDOException: " . $e->getMessage();
     }
     return "";
   };
  -->
  </textarea>

  <p>The PHP that generates table using <strong>XSLTProcessor()</strong></p>
  <textarea rows="10" cols="120">
  <!-- please remove the XML comment
   $xslt = new XSLTProcessor();
   $xslt->importStylesheet(new SimpleXMLElement(getXSLT()));
   echo "<fieldset>";
   echo "<legend>Example 3</legend>";
   echo "<table>";
   echo "<tr><th>Name</th><th>Group</th><th>Count</th></tr>";
   echo $xslt->transformToXml(new SimpleXMLElement(getXML()));
   echo "</table>";
   echo "</fieldset>";
  -->
  </textarea>


  <?php
    include "include/footer.php";
  ?>


 </body>
</html>
