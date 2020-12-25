
-- attach database dsa157.db as dsa157;

create table if not exists trips (
	id integer primary key,
   	arrival text not null,
	departure text not null,
	city text not null,
	country text not null
);


insert into trips (arrival, departure, city, country) values ("2018-04-01", "2018-05-01", "Cape Town", "South Africa");
insert into trips (arrival, departure, city, country) values ("2018-05-01", "2018-06-01", "Lisbon", "Portugal");
insert into trips (arrival, departure, city, country) values ("2018-06-01", "2018-07-01", "Valencia", "Spain");


