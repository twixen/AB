CREATE TABLE student 
(
	id_student INT PRIMARY KEY, 
	imie VARCHAR(20), 
	nazwisko VARCHAR(30),
	pesel VARCHAR(11),
	nr_indeksu VARCHAR(6),
	data_ur DATE,
	ulica  VARCHAR(50),
	numer VARCHAR(10),
	kod VARCHAR(6),
	miejscowosc VARCHAR(30),
	tel VARCHAR(9),
	email VARCHAR(50),
	notka TEXT
);
CREATE TABLE projekt 
(
	id_projekt INT PRIMARY KEY,
	nazwa VARCHAR(50),
	opis TEXT,
	data_rozp DATE,
	data_zak DATE
);
CREATE TABLE zapis 
(
	id_projekt INT,
	id_student INT,
	PRIMARY KEY (id_projekt, id_student)
);
INSERT INTO projekt VALUES (1, 'xxx', 'oxxx', '1988-01-31', '1989-01-01');
INSERT INTO projekt VALUES (2, 'yyy', 'oyyy', '1958-04-18', '1958-08-20');
INSERT INTO projekt VALUES (3, 'zzz', 'ozzz', '1956-06-04', '1956-10-11');
INSERT INTO student VALUES (1, 'Damian', 'Lewandowski', 94345930576, 195555, '1988-01-31','Hallera',1,'80-300','Sopot',947295465,'damian@gmail.com','haha');
INSERT INTO student VALUES (2, 'Karolina', 'Majewska', 39472950375, 113435, '1958-08-20','Grunwaldzka',2,'80-400','Gdynia',123687546,'karolina@gmail.com','hehe');
INSERT INTO student VALUES (3, 'Agnieszka', 'Nowak', 59275027467, 174896, '1956-06-04','Szeroka',3,'80-500','Gdansk',743843719,'agnieszka@gmail.com','hyhy');
INSERT INTO zapis VALUES (1, 2);
INSERT INTO zapis VALUES (2, 3);
INSERT INTO zapis VALUES (3, 1);