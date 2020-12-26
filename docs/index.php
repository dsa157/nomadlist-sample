<html>
<head>
<title>Auto SideTrip Sample</title>
<link rel='stylesheet' type='text/css' href='style.css' />
<script src="validation.js"></script>
</head>
<body>
<h1>Nomad List Side Trip Management (<a target="new" href="https://github.com/dsa157/nomadlist-sample">Github Repo</a>)</h1>

<h3>The Problem</h3>

<p>
On the trips page, the trip entries are correctly sorted by arrival date. The map uses that data to generate the hops from location to location.
<br/>People often take side trips, where they are located in City1 for a duration and within that duration, they go to City2 for a short period and then return to City1.
</p>

<p>
If I add a side trip, by default, the map treats that as a new destination and will plot me from City1 to City 2 to City3.
<br/>What really happened was City1 to City2 to City1 to City3.
</p>

<h3>A Solution</h3>

<p>
To handle this properly now is a manual process or you live with the fact that the map is (admittedly only slightly) wrong.
</p>

<p>
My sample code detects that you added a side trip and adjusts your entries accordingly. It compares the date range of a new trip to see if it is contained within an existing trip. If so, it splits the existing trip into Trip1 and Trip3 and the new trip is added as Trip2
</p>


<form action="" method="post"> 
<table><tr> 
<td><input id=arrival placeholder="Arrival" type="date" name="arrival"></td> 
<td><input id=departure placeholder="Departure" type="date" name="departure"></td> 
<td><input id=city placeholder="City" type="text" name="city"></td> 
<td><input id=country placeholder="Country" type="text" name="country"></td> 

<td><input name="submit" type="submit" onclick="return validate()" value="Add Trip"/></td></tr> 
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
