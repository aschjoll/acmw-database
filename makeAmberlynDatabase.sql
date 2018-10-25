use acmwDB;
/*
create table year
        (
          yearid int not null primary key auto_increment,
          year varchar(10) not null
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/year.txt'
INTO TABLE year
FIELDS TERMINATED BY '\t';

create table gender
        (
        genderid int not null primary key auto_increment,
        gender varchar(10) not null
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/gender.txt'
INTO TABLE gender
FIELDS TERMINATED BY '\t';

create table officer
        (
        officerid int not null primary key auto_increment,
        title varchar(50) not null
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/officer.txt'
INTO TABLE officer
FIELDS TERMINATED BY '\t';

create table major
        (
        majorid int not null primary key auto_increment,
        major varchar(50) not null,
        abbreviation varchar(3) not null
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/major.txt'
INTO TABLE major
FIELDS TERMINATED BY '\t';

create table race
        (
        raceid int not null primary key auto_increment,
        race varchar(50) not null,
        hispanic boolean not null
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/race.txt'
INTO TABLE race
FIELDS TERMINATED BY '\t';
/*
create table location
        (
        locationid int not null primary key auto_increment,
        building varchar(50),
        room varchar(5),
        address varchar(50)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/location.txt'
INTO TABLE location
FIELDS TERMINATED BY '\t';
*/
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
        officerid int,
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

load data local infile '/home/assc223/Desktop/acmw-database/student.txt'
into table student
fields terminated by '\t';
/*
create table event
        (
        eventid int not null primary key auto_increment,
        event string not null,
        when datetime not null,
        description text(100) not null
        sid int not null,
        projectid int not null,
        locationid int not null,
        foreign key (sid) 
		references student(sid),
        foreign key (projectid) 
		references project(projectid),
        foreign key (locationid) 
		references location(locationid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/event.txt'
INTO TABLE event
FIELDS TERMINATED BY '\t';

create table attends
        (
        sid int not null,
        eventid int not null,
        rsvp boolean not null,
        attend boolean not null,
        primary key (sid, eventid),
        foreign key(sid) 
		references student(sid),
        foreign key (eventid) 
		reference event(eventid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/attends.txt'
INTO TABLE attends
FIELDS TERMINATED BY '\t';

create table faculty
        (
        facultyid int not null,
        fname varchar(20) not null,
        lname varchar(20) not null,
        department varchar(20) not null,
        email varchar(50) not null,
        genderid int not null
        primary key (facultyid)
        foreign key (genderid) 
		reference gender(genderid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/faculty.txt'
INTO TABLE faculty
FIELDS TERMINATED BY '\t';

create table project
        (
        projectid int not null primary key auto_increment,
        facultyid int not null,
        project varchar(100) not null,
        primary key (facultyid),
        foreign key (facultyid) 
		references faculty(facultyid)
        );


LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/project.txt'
INTO TABLE project
FIELDS TERMINATED BY '\t';

create table memberof
        (
        sid int not null,
        projectid int not null,
        primary key (sid, projectid),
        foreign key (sid) 
		references student(sid),
        foreign key (project) 
		references project(projectid)
        );

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/memberof.txt'
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

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/research.txt'
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

LOAD DATA LOCAL INFILE '/home/assc223/Desktop/acmw-database/company.txt'
INTO TABLE company
FIELDS TERMINATED BY '\t'; */
