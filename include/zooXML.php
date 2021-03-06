<?php
$definitionXML = <<<XML
<source>
  <database>
     <server>localhost</server>
     <schema>zoodb</schema>
     <user>zoo</user>
     <password>zoo!</password>
  </database>
  <functions>
    <list name="GetGroup" />
    <table name="GetZoo4" sort="N" pagesize="4">
      <columns>
        <entry><name>Name</name><sort>N</sort></entry>
        <entry><name>Group</name><sort>G</sort></entry>
        <entry><name>Count</name><sort>C</sort></entry>
      </columns>
    </table>
  </functions>
</source>
XML;

?>
