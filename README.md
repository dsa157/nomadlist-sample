# Example of side trip management on the Nomad List Trips

**The Problem**

On the trips page, the trip entries are correctly sorted by arrival date. The map uses that data to 
generate the hops from location to location. 

People often take side trips, where they are located in City1 for a duration and within that duration, they go to City2 for a short period and then return to City1.

if I add a side trip, by default the map, treats that as a new destination and will plot me from City1 to City 2 to City3.

What really happened was City1 to City2 to City1 to City3.

**A Solution**

To handle this properly now is a manual process or you live with the fact that the map is (admittedly only slightly) wrong.

My sample code detects that you added a side trip and adjusts your entries accordingly.
It compares the date range of a new trip to see if it is contained within an existing trip. If so, it splits the existing trip into Trip1 and Trip3 and the new trip is added as Trip2

Note: the relevant logic for this is just lines 68-82 in index.php

**Try It!**
http://www.dsa157.com/nomadList-sample/docs/


**Known Limitations of Sample Code**

* this was quick an dirty
 * no exception handling
 * no security in the app or the file system with the way I structured the folders and files
 * rudimetary javascript form validation
 * rudimentary styling
 * rudimentary classes and methods
 * no client side javascript - just very basic PHP and a SQLite database 
* the logic only detects cases of a side trip within an existing trip. If the bounds cross a previous or subsequent trip, I don't yet handle that, but it isn't that difficult to do so.
* you could add the same logic when rendering the map, but then the list of trips doesn't read as easily. Accounting for side trips adds more travel legs to a member's trip list, but reflects the reality of their travel   
* 

