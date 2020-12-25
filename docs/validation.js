function validate() {
  var arrival = document.getElementById('arrival');
  var departure = document.getElementById('departure');
  var city = document.getElementById('city');
  var country = document.getElementById('country');
  var adate = arrival.value;
  var ddate = departure.value;
  if (adate == "") { alert("Arrival is required");  return false; };
  if (ddate == "") { alert("Departure is required");  return false; };
  if (city.value == "") { alert("City is required");  return false; };

  if (ddate >= adate) {
     return true;
  } else {
    alert("Departure must be greater or equal to arrival date")
    return false;
  }
}


