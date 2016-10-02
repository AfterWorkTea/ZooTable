<?php

class ZooTable {

  private $sourceXML = null;
  private $server = '';
  private $schema = '';
  private $user = '';
  private $password = '';
  private $listFunction = '';
  private $tableFunction = '';
  private $conn = null;
  private $xsltProc = null;
  private $gid = 0;
  private $defSort = '';
  private $sort = '';
  private $from = 0;
  private $pagesize = 1;
  private $listXML = null;
  private $headerXML = null;
  private $tableXML = null;
  private $formatXSLT = '';
  private $dataXML = '';

  public function ZooTable($definitionXML, $formatXSLT) {
    $this->initFromXML($definitionXML);
    $this->initConnection();
    $this->xsltProc = new XSLTProcessor();
    $this->formatXSLT = $formatXSLT;
    $this->gid = isset($_POST['gid']) ? (int)$_POST['gid'] : 0;
    $this->sort = isset($_POST['sort']) ? strtoupper($_POST['sort']) : $this->defSort;
    if (isset($_POST['button_back'])) {
       $this->from = (isset($_POST['BCK']) ? (int)$_POST['BCK'] : 0);
    }
    if (isset($_POST['button_next'])) {    
       $this->from = (isset($_POST['FRD']) ? (int)$_POST['FRD'] : 0);
    }
    $this->callDB();
  }

  private function callDB() {
     $this->getListXML();
     $this->getTableXML();
  }

  private function initFromXML($XMLStr) {
    $this->sourceXML = new SimpleXMLElement($XMLStr);
    $this->server = $this->sourceXML->database[0]->server[0];
    $this->schema = $this->sourceXML->database[0]->schema[0];
    $this->user = $this->sourceXML->database[0]->user[0];
    $this->password = $this->sourceXML->database[0]->password[0];
    $this->listFunction = $this->sourceXML->functions[0]->list[0]->attributes()['name'];
    $this->tableFunction = $this->sourceXML->functions[0]->table[0]->attributes()['name'];
    $this->defSort = $this->sourceXML->functions[0]->table[0]->attributes()['sort'];
    $this->pagesize = $this->sourceXML->functions[0]->table[0]->attributes()['pagesize'];
    $this->headerXML = $this->sourceXML->functions[0]->table[0]->columns[0]->asXML();
  }

  private function initConnection() {
    try {
       $this->conn = new PDO("mysql:host=". $this->server. ";dbname=". $this->schema, $this->user, $this->password);
       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e1) {
       echo "initConnection Exception: " . $e1->getMessage();
    }
  }

  function getTableXML() {
     try {
       $stmt = $this->conn->prepare("select ". $this->tableFunction. "(?, ?, ?, ?) as XML;");
       $stmt->bindParam(1, $this->sort, PDO::PARAM_STR);
       $stmt->bindParam(2, $this->gid, PDO::PARAM_STR);
       $stmt->bindParam(3, $this->from, PDO::PARAM_INT);
       $stmt->bindParam(4, $this->pagesize, PDO::PARAM_INT);
       $stmt->execute();
       $this->tableXML = $stmt->fetch(PDO::FETCH_ASSOC)['XML'];
       return $this->tableXML;
     } catch(PDOException $e) {
       echo "getXML PDOException: ". $e->getMessage();
     }
     return "";
  }

  private function getListXML() {
     try {
       $stmt = $this->conn->prepare("select ". $this->listFunction. "() as XML;");
       $stmt->execute();
       $this->listXML = $stmt->fetch(PDO::FETCH_ASSOC)['XML'];
       return $this->listXML;
     } catch(PDOException $e) {
       echo "getListXML PDOException: " . $e->getMessage();
     }
     return "";
   }

  public function getHTML($page) {
    $xmlElement = new SimpleXMLElement($this->tableXML);
    $count = $xmlElement->attributes()['count'];
    $prev = $this->from - $this->pagesize;
    $next = $this->from + $this->pagesize;
    $to = ($next > $count) ? $count : ($next);
    $more = $count - $to;
    $this->dataXML = "<data>". $this->listXML. 
                  "<table>". $this->headerXML. $this->tableXML. "</table>".
                  "<buttons count=\"". $count. "\" from=\"". $this->from. "\" more=\"". $more. "\" to=\"". $to. 
                       "\" prev=\"". $prev.  "\" next=\"". $next. "\"/>".
              "</data>";
    //$this->echoXML($this->dataXML);
    $formatXSLT = str_replace("_gid_", "".$this->gid, $this->formatXSLT);
    $formatXSLT = str_replace("_sort_", $this->sort, $formatXSLT);
    $formatXSLT = str_replace("_page_", $page, $formatXSLT);
    //$this->echoXML($formatXSLT);
    $this->xsltProc->importStylesheet(new SimpleXMLElement($formatXSLT));
    return $this->xsltProc->transformToXml(new SimpleXMLElement($this->dataXML));
  }


  public function getDataXML() {
    return $this->dataXML;
  }

  private function echoXML($xml) {
    echo "<p><small>". htmlspecialchars($xml, ENT_XML1). "</small></p>";
  }

  public function __destruct() {
    $this->conn = null;
  }


}

?>
