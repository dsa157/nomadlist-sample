<html>
<head>
<title>Auto SideTrip Sample</title>
<link rel='stylesheet' type='text/css' href='style.css' />
</head>
<body>

<?php 

include "./Utils.php";

$db = new SQLite3('nomadlist.db');
if ($db == null) {
    echo 'Error, could not connect to database!';
}

$tripList = new TripList($db);
$tripList->display();

//-------------------------------------------------

class TripList {

  protected $db;

  function __construct($db) {
    $this->db = $db;
  }

  function display() {
    $results = $this->db->query('select * from trips');
    while ($row = $results->fetchArray()) {
      $this->printRow($row);
      //var_dump($row);
    }
  }

  function add($arrival, $departure, $city, $country) {
  }

  function edit($tripID, $arrival, $departure, $city, $country) {
  }

  function delete($tripID) {
  }

  function printRow($row) {
    $arrival = Utils::formatDate($row["arrival"]);
    $departure = Utils::formatDate($row["departure"]);
    $city = $row["city"];
    $country = $row["country"];

    echo <<<EOT

    <div class=trip>
    <span class=tripProperty>$arrival</span>
    <span class=tripProperty>$departure</span>
    <span class=tripProperty>$city</span>
    <span class=tripProperty>$country</span>
    </div>
EOT;
  }
}

?> 

</body>
<html>
