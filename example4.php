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

  <h3>Example 4</h3>

  <p><strong>Topic:</strong> sorting columns in table generated from XML</p>

  <p><strong>Data:</strong> 'select GetZoo2() as XML'</p>

  <h3>The output</h3>

  <?php

   $sort = isset($_POST['sort']) ? strtoupper($_POST['sort']) : 'N';

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

   function getXML($sort) {
     $servername='localhost';
     $dbname='zoodb';
     $username='zoo';
     $password='zoo!';
     try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $stmt = $conn->prepare("select GetZoo2(?) as XML;");
       $stmt->bindParam(1, $sort, PDO::PARAM_STR);
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['XML'];
     } catch(PDOException $e)   {
       echo "PDOException: " . $e->getMessage();
     }
     return "";
   }

  function getTH($sortChar, $sort, $header) {
    $disabled = "";
    $arrow = "►";
    if(strcasecmp($sortChar, $sort) == 0 ) {
        $disabled = "disabled=\"disabled\"";
        $arrow = "▼";
    }
    return "<th><button type=\"submit\" name=\"sort\" value=\"". $sortChar. "\" ". $disabled. ">". $header. "&#160;". $arrow. "</button></th>";
  }

   $xslt = new XSLTProcessor();
   $xslt->importStylesheet(new SimpleXMLElement(getXSLT()));
   echo "<fieldset>";
   echo "<legend>Example 4</legend>";
   echo "<form id=\"table\" action=\"example4.php\" method=\"post\">";
   echo "<table>";
   echo "<tr>".
          getTH("N", $sort, "Name").
          getTH("G", $sort, "Group").
          getTH("C", $sort, "Count").
        "</tr>";
   echo $xslt->transformToXml(new SimpleXMLElement(getXML($sort)));
   echo "</table>";
   echo "</form>";
   echo "</fieldset>";

?>

  <h3>The code</h3>

  <p>Please note the use of a new GetZoo2().</p>

  <br/>

  <p>The <strong>GetZoo2()</strong> - it takes one argument that determinates the sorting order.</p>
  <textarea rows="10" cols="120">
  <?php
    include "db/GetZoo2.sql";
  ?>
  </textarea>

  <p>The PHP function formating headers</p>
  <p>(it takes 3 arguments: the control sort charachter, the current sort value and the element name)</p>
  <textarea rows="10" cols="120">
  <!-- please remove the XML comment
  function getTH($sortChar, $sort, $header) {
    $disabled = "";
    $arrow = "►";
    if(strcasecmp($sortChar, $sort) == 0 ) {
        $disabled = "disabled=\"disabled\"";
        $arrow = "▼";
    }
    return "<th><button type=\"submit\" name=\"sort\" value=\"". $sortChar. "\" ". $disabled. ">". $header. "&#160;". $arrow. "</button></th>";
  }
  -->
  </textarea>

  <p>The PHP that generates table</p>
  <textarea rows="10" cols="120">
  <!-- please remove the XML comment
   $xslt = new XSLTProcessor();
   $xslt->importStylesheet(new SimpleXMLElement(getXSLT()));
   echo "<fieldset>";
   echo "<legend>Example 4</legend>";
   echo "<form id=\"table\" action=\"example4.php\" method=\"post\">";
   echo "<table>";
   echo "<tr>".
          getTH("N", $sort, "Name").
          getTH("G", $sort, "Group").
          getTH("C", $sort, "Count").
        "</tr>";
   echo $xslt->transformToXml(new SimpleXMLElement(getXML($sort)));
   echo "</table>";
   echo "</form>";
   echo "</fieldset>";
  -->
  </textarea>


  <?php
    include "include/footer.php";
  ?>


 </body>
</html>
