<html>
<head>
<title>Auto SideTrip Sample</title>
<link rel='stylesheet' type='text/css' href='style.css' />
</head>
<body>

<form action="" method="post"> 
<table><tr> 
<td><input placeholder="Arrival" type="date" name="arrival"></td> 
<td><input placeholder="Departure" type="date" name="departure"></td> 
<td><input placeholder="City" type="text" name="city"></td> 
<td><input placeholder="Country" type="text" name="country"></td> 

<td><input name="submit" type="submit" value="Add Trip"/></td></tr> 
</table>

<?php 

include "./utils.php";

$db = new SQLite3('nomadlist.db');
if ($db == null) {
    echo 'Error, could not connect to database!';
}

$tripList = new TripList($db);
if ($_POST) {
  //echo "got a POST";
  $tripList->add();
}

$tripList->display();

//-------------------------------------------------

class TripList {

  protected $db;
  protected $trips;

  function __construct($db) {
    $this->db = $db;
  }

  function getTrips() {
    $this->trips = $this->db->query('select * from trips order by arrival,departure');
  }

  function display() {
    if ($this->trips == null) {
      $this->getTrips();
    }
    while ($row = $this->trips->fetchArray()) {
      $this->printRow($row);
    }
  }

  function add() {
    if ($this->trips == null) {
      $this->getTrips();
    }
    $arrival = Utils::formatDateWithFormat($_POST["arrival"], "Y-m-d");
    $departure = Utils::formatDateWithFormat($_POST["departure"], "Y-m-d");
    $city = $_POST["city"];
    $country = $_POST["country"];
    // eval and handle a sideTrip 
    while ($row = $this->trips->fetchArray()) {
      $id1 = $row["id"];
      $arrival1 = $row["arrival"];
      $departure1 = $row["departure"];
      $city1 = $row["city"];
      $country1 = $row["country"];
      if ($arrival >= $arrival1 && $departure <= $departure1) {
        echo "processing side trip and adjusting existing trips";
        //delete the old record (editing it requires a littel more code logic)
        $this->delete($id1);
        //recreate the old record with new dates sandwiching the side trip
        $this->insert($arrival1, $arrival, $city1, $country1);
        $this->insert($departure, $departure1, $city1, $country1);
      }
    }
    
    $this->insert($arrival, $departure, $city, $country);
  }

  function insert($arrival, $departure, $city, $country) {
    $this->db->exec("insert into trips (arrival, departure, city, country) values ('$arrival', '$departure', '$city', '$country')" );
  }

  function edit($tripID, $arrival, $departure, $city, $country) {
  }

  function delete($tripID) {
    $this->db->exec("delete from trips where id = $tripID" );
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
