/*create database acmwDB;
*/
use acmwDB;
/*
create table year
        (
          yearid int not null primary key auto_increment,
          year varchar(10) not null
        );

LOAD DATA LOCAL INFILE '/home/afco229//acmw-database/textFiles/year.txt'
INTO TABLE year
FIELDS TERMINATED BY '\t';

create table gender
        (
        genderid int not null primary key auto_increment,
        gender varchar(10) not null
        );

LOAD DATA LOCAL INFILE '/home/afco229//acmw-database/textFiles/gender.txt'
INTO TABLE gender
FIELDS TERMINATED BY '\t';

create table officer
        (
        officerid int not null primary key auto_increment,
        title varchar(50) not null
        );

LOAD DATA LOCAL INFILE '/home/afco229//acmw-database/textFiles/officer.txt'
INTO TABLE officer
FIELDS TERMINATED BY '\t';

create table major
        (
        majorid int not null primary key auto_increment,
        major varchar(50) not null,
        abbreviation varchar(3) not null
        );

LOAD DATA LOCAL INFILE '/home/afco229//acmw-database/textFiles/major.txt'
INTO TABLE major
FIELDS TERMINATED BY '\t';

create table race
        (
        raceid int not null primary key auto_increment,
        race varchar(50) not null,
        hispanic boolean not null
        );

LOAD DATA LOCAL INFILE '/home/afco229//acmw-database/textFiles/race.txt'
INTO TABLE race
FIELDS TERMINATED BY '\t';

create table location
        (
        locationid int not null primary key auto_increment,
        buildingRoom varchar(100),
        address varchar(50)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/textFiles/location.txt'
INTO TABLE location
FIELDS TERMINATED BY '\t';

create table student
        (
        sid int not null primary key,
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
        foreign key (genderid) 
		references gender (genderid),
        foreign key (yearid) 
		references year (yearid),
        foreign key (raceid) 
		references race (raceid),
        foreign key (officerid) 
		references officer (officerid),
        foreign key (majorid) 
		references major (majorid)
        );

load data local infile '/home/assc223/Desktop/acmw-database/textFiles/student.txt'
into table student
fields terminated by '\t';

create table faculty
        (
        facultyid int not null primary key auto_increment,
        fname varchar(20) not null,
        lname varchar(20) not null,
        department varchar(20) not null,
        email varchar(50) not null,
        genderid int not null,
        foreign key (genderid)
        	references gender(genderid)
        );

LOAD DATA LOCAL INFILE '/home/afco229//acmw-database/textFiles/faculty.txt'
INTO TABLE faculty
FIELDS TERMINATED BY '\t';

create table project
        (
        projectid int not null primary key auto_increment,
        facultyid int not null,
        project varchar(100) not null,
        foreign key (facultyid) 
		references faculty(facultyid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/textFiles/project.txt'
INTO TABLE project
FIELDS TERMINATED BY '\t';

create table event
        (
        eventid int not null primary key auto_increment,
        event varchar(50) not null,
	eventTime datetime not null,
	description text not null,
        sid int,
        projectid int,
        locationid int not null,
        foreign key (sid) 
		references student(sid),
        foreign key (projectid) 
		references project(projectid),
        foreign key (locationid) 
		references location(locationid)
		on delete cascade
	);
*/
LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/textFiles/event.txt'
INTO TABLE event
FIELDS TERMINATED BY '\t';
/*
create table attends
        (
        sid int not null,
        eventid int not null,
        rsvp boolean not null,
        attend boolean not null,
        primary key (sid, eventid),
        foreign key(sid) 
		references student(sid)
		on delete cascade,
        foreign key (eventid) 
		references event(eventid)
		on delete cascade
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/textFiles/attends.txt'
INTO TABLE attends
FIELDS TERMINATED BY '\t';
/*
create table memberof
        (
        sid int not null,
        projectid int not null,
        primary key (sid, projectid),
        foreign key (sid) 
		references student(sid),
        foreign key (projectid) 
		references project(projectid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/textFiles/memberof.txt'
INTO TABLE memberof
FIELDS TERMINATED BY '\t';

create table research
        (
        sid int not null,
        topic varchar(1000) not null,
        professor varchar(50) not null,
        primary key (sid, topic),
        foreign key (sid) 
		references student(sid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/textFiles/research.txt'
INTO TABLE research
FIELDS TERMINATED BY '\t';

create table company
        (
        sid int not null,
        company varchar(100) not null,
        position varchar(50) not null,
        primary key (sid, company),
        foreign key (sid) 
		references student(sid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/textFiles/company.txt'
INTO TABLE company
FIELDS TERMINATED BY '\t';
*/
