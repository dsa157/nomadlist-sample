#Example of side trip management on the NomadList Trips

**The Problem**

On the trips page, the trip entries are correctly sorted by arrival date. The map uses that data to 
generate the hops from location to location. 

People often take side trips, where they are located in City1 for a duration and within that duration, they go to City2 for a short period and then return to City1.

if I add a side trip, by default the map, treats that as a new destination and will plat me from City1 to City 2 to City3.

What really happened was City1 to City2 to City1 to City3.

To handle this proerly now is a manual process or you live with the fact that the map is (admittedly only slightly) wrong.

My sample code detects that you added a side trip and adjusts your entries accordingly.

**Known Limitations of Sample Code**

* this was quick an dirty
* no exception handling
* no security in the app or the file system with the way I structured the folders and files
* rudimentary styling
* rudimentary classes and methods 
* you could add the same logic when rendering the map, but then the list of trips doesn't read as easily. Accounting for side trips adds more travel legs to a member's trip list, but reflects the reality of their travel   

