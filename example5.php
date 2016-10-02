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

  <h3>Example 5</h3>

  <p><strong>Topic:</strong> filtering rows in table</p>

  <p><strong>Data:</strong>'select GetGroup() as XML' and 'select GetZoo3() as XML'</p>

  <h3>The output</h3>

  <?php

   $sort = isset($_POST['sort']) ? strtoupper($_POST['sort']) : 'N';
   $gid = isset($_POST['gid']) ? (int)$_POST['gid'] : 0;

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

   function getXSLTGroup($gid) {
     return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
            "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">".
   	    "<xsl:template match=\"group\">".
	      "<xsl:choose>".
		  "<xsl:when test=\"@id = '". $gid. "'\">".
                     "<option name=\"tid\" value=\"{@id}\" selected=\"selected\"><xsl:value-of select=\".\"/></option>".
		  "</xsl:when>".
                  "<xsl:otherwise>".
                     "<option name=\"tid\" value=\"{@id}\"><xsl:value-of select=\".\"/></option>".
                  "</xsl:otherwise>".
              "</xsl:choose>".
            "</xsl:template>".
            "</xsl:stylesheet>";
   }

   function getXML($conn, $sort, $gid) {
     try {
       $stmt = $conn->prepare("select GetZoo3(?, ?) as XML;");
       $stmt->bindParam(1, $sort, PDO::PARAM_STR);
       $stmt->bindParam(2, $gid, PDO::PARAM_STR);
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['XML'];
     } catch(PDOException $e)   {
       echo "getXML PDOException: " . $e->getMessage();
     }
     return "";
   }

   function getGroupXML($conn) {
     try {
       $stmt = $conn->prepare("select GetGroup() as XML;");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['XML'];
     } catch(PDOException $e)   {
       echo "getGroupXML PDOException: " . $e->getMessage();
     }
     return "";
   }

   function getConnection() {
     $servername='localhost';
     $dbname='zoodb';
     $username='zoo';
     $password='zoo!';
     try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       return $conn;
     } catch(PDOException $e)   {
       echo "getConnection PDOException: " . $e->getMessage();
     }     
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

   function xsltTransform($xsltProcessor, $xsltData, $xmlData) {
      $xsltProcessor->importStylesheet(new SimpleXMLElement($xsltData));
      return $xsltProcessor->transformToXml(new SimpleXMLElement($xmlData));
   }

   $conn = getConnection();
   $xslt = new XSLTProcessor();
   echo "<fieldset style=\"height:450px;\">";
   echo "<legend>Example 5</legend>";
   echo "<form id=\"table\" action=\"example5.php\" method=\"post\">";
   echo "<input type=\"hidden\" name=\"sort\" value=\"". $sort. "\" />";
   echo "<p class=\"edit\">Select: ";
   echo "<select id=\"groupSelect\" list=\"groups\" name=\"gid\" onchange=\"onGroupChange()\">".
        "<option value=\"0\">All Groups</option>";
   echo xsltTransform($xslt, getXSLTGroup($gid), getGroupXML($conn));
   echo "</select></p>";
   echo "<table>";
   echo "<tr>".
          getTH("N", $sort, "Name").
          getTH("G", $sort, "Group").
          getTH("C", $sort, "Count").
        "</tr>";
   echo xsltTransform($xslt, getXSLT(), getXML($conn, $sort, $gid));
   echo "</table>";
   echo "</form>";
   echo "</fieldset>";
   
   $conn = null;
?>

  <h3>The code</h3>

  <p>The first step is to build select element.</p>
  <p>The <strong>GetGroup()</strong> code.</p>
  <textarea rows="10" cols="120">
  <?php
    include "db/GetGroup.sql";
  ?>
  </textarea>

  <p>And the XSLT</p>
  <textarea rows="10" cols="120">
  <!-- please remove the XML comment
   function getXSLTGroup($gid) {
     return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
            "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">".
   	    "<xsl:template match=\"group\">".
	      "<xsl:choose>".
		  "<xsl:when test=\"@id = '". $gid. "'\">".
                     "<option name=\"tid\" value=\"{@id}\" selected=\"selected\"><xsl:value-of select=\".\"/></option>".
		  "</xsl:when>".
                  "<xsl:otherwise>".
                     "<option name=\"tid\" value=\"{@id}\"><xsl:value-of select=\".\"/></option>".
                  "</xsl:otherwise>".
              "</xsl:choose>".
            "</xsl:template>".
            "</xsl:stylesheet>";
  -->
  </textarea>

  <p>Then is possible to build a table</p>
  <p>The <strong>GetZoo3()</strong> - it takes an argument that determinates the sort order</p>
  <textarea rows="10" cols="120">
  <?php
    include "db/GetZoo3.sql";
  ?>
  </textarea>

  <p>The XSLT to format table header</p>
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

  <p>And the XSLT to format table body</p>
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

  <?php
    include "include/footer.php";
  ?>


 </body>
</html>
