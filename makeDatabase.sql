create database acmwDB;
use acmwDB;
create table student
	(
	sid int not null,
	username varchar(100) not null,
	password varchar(100) not null,
	fname varchar(20) not null,
	lname varchar(20) not null,
	email varchar(50) not null,
	gpa float not null,
	ismember boolean not null,
	genderid int not null,
	yearid int not null,
	raceid int not null,
	officerid int not null,
	majorid int not null,
	primary key (sid)
	foreign key (genderid) references gender(id),
	foreign key (yearid) references year(id),
	foreign key (raceid) references race(id),
	foreign key (officerid) references officer(id),
	foreign key (majorid) references major(id)
	);
load data local infile '/home/afco229/student.txt'
into table student
fields terminated by '\t';

create table event
	(
	eventid int not null primary key auto_increment,
	event string not null,
	when datetime not null,
	description varchar(1000) not null
	sid int not null,
	projectid int not null,
	locationid int not null,
	foreign key (sid) references student(sid),
	foreign key (projectid) references project(projectid),
	foreign key (locationid) references location(locationid)
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/event.txt'
---INTO TABLE event
---FIELDS TERMINATED BY '\t';

create table location
	(
	locationid int not null primary key auto_increment,
	building varchar(50),
	room varchar(5),
	address varchar(50),
	);


---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/location.txt'
---INTO TABLE location
---FIELDS TERMINATED BY '\t';

create table attends
	(
	sid int not null,
	eventid int not null,
	rsvp boolean not null,
	attend boolean not null,
	primary key (sid),
	primary key (eventid),
	foreign key(sid) references student(sid),
	foreign key (eventid) reference event(eventid)
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/attends.txt'
---INTO TABLE attends
---FIELDS TERMINATED BY '\t';	
	
create table faculty
	(
	facultyid int not null,
	fname varchar(20) not null,
	lname varchar(20) not null,
	department varchar(20) not null,
	email varchar(50) not null,
	genderid int not null
	primary key (facultyid)
	foreign key (genderid) gender(id)
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/faculty.txt'
---INTO TABLE faculty
---FIELDS TERMINATED BY '\t'; 

create table project
	(
	projectid int not null primary key auto_increment,
	facultyid int not null,
	project varchar(100) not null,
	primary key (facultyid),
	foreign key (facultyid) references faculty(id)
	);


---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/project.txt'
---INTO TABLE project
---FIELDS TERMINATED BY '\t'; 

create table memberof
	(
	sid int not null,
	projectid int not null,
	primary key (sid),
	primary key (projectid),
	foreign key (sid) references student(sid),
	foreign key (project) references project(projectid)
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/memberof.txt'
---INTO TABLE memberof
---FIELDS TERMINATED BY '\t'; 

create table research 
	(
	sid int not null,
	topic varchar(1000) not null,
	professor varchar(50) not null,
	primary key (sid),
	primary key (topic),
	foreign key (sid) references student(sid)
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/research.txt'
---INTO TABLE research
---FIELDS TERMINATED BY '\t'; 


create table company 
	(
	sid int not null,
	company varchar(100) not null,
	position varchar(50) not null,
	primary key (sid),
	primary key (company),
	foreign key (sid) references student(sid)
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/company.txt'
---INTO TABLE company
---FIELDS TERMINATED BY '\t'; 

create table gender
	(
	id int not null primary key auto_increment,
	gender varchar(10) not null,
	);


---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/gender.txt'
---INTO TABLE gender
---FIELDS TERMINATED BY '\t'; 

create table officer
	(
	id int not null primary key auto_increment,
	title varchar(50) not null,
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/officer.txt'
---INTO TABLE officer
---FIELDS TERMINATED BY '\t'; 

create table major
	(
	id int not null primary key auto_increment,
	major varchar(50) not null,
	abbreviation varchar(3) not null,
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/major.txt'
---INTO TABLE major
---FIELDS TERMINATED BY '\t'; 

create table race
	(
	id int not null primary key auto_increment,
	race varchar(50) not null,
	hispanic boolean no null,
	);

---LOAD DATA LOCAL INFILE '/home/afco229/Downloads/forLab3/race.txt'
---INTO TABLE race
---FIELDS TERMINATED BY '\t'; 
