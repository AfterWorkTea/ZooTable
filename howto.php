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

  <h3>Checklist</h3>
  <p>Follow the steps to build your own table</p>
  <ul>
     <li>Prepare system (Apache + MySQL with PHP and modules)</li>
     <li>Copy the example files and run it to make sure all works</li>
     <li>Prepare MySQL stored functions (or modify the examples)</li>
     <ul>
       <li>One for select list data</li>
       <li>One for table body data</li>
     </ul>
     <li>Modify the zooXML.php (you can rename it if you like), adjust</li>
     <ul>
       <li>Database access credentials</li>
       <li>Stored functions names</li>
       <li>Table's list of entries (names and the unique sort characters)</li>
     </ul>
     <li>Modify the zooXSLT.php (you can rename it if you like):</li>
     <ul>
       <li>Define transformation for all/selected returned entries</li>
       <li>Optionally you can add images/links and other fancy elements</li>
       <li>Optionally you can ajust header, buttons, etc.</li>
     </ul>
  </ul>

  <p>Optionally you might ajust the ZooTable class and your css.</p> 


  <p>Now you are ready to go, congratulations!</p>

  <h3>Troubleshoot problems</h3> 
  <p>Follow the steps</p>
  <ol>
    <li>Verify stored procedures, the arguments and the returned XML (data and format)</li>
    <li>Verify format of all XML/XSLT data.</li>
    <li>Verify the list of entries in stored procedure, in table definition, in XSLT</li>
    <li>Verify the group ID used for select list in stored procedure, in XSLT</li>
    <li>Verify the sort characters are unique and match in stored procedure, in XML entry definition</li>
    <li>Verify any optional changes you made.</li>
  </ol>
  
  <?php
    include "include/footer.php";
  ?>

  </div>

 </body>
</html>
