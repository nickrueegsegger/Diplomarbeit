--Datenbank erstellen
Create Database DB_MMKZ_Langnau

use DB_MMKZ_Langnau;

--Tabellen erstellen
create table Marke(
	MarkenID INT not null identity(1,1) primary key,
	MarkenName varchar (30)
);
create table BuchbareMitarbeiter(
	MitarbeiterID INT not null identity(1,1) primary key,
	Mnachname varchar (30),
	Mvorname varchar (30),
	
);

alter table BuchbareMitarbeiter
add BildpfadMitarbeiter varchar (200),
	Beschreibung varchar (200)
	;


create table Mietgeraete(
	MietgeraetID INT not null identity(1,1) primary key,
	Mietgeraetetyp varchar (50),
	MietpreisproTag INT,
	MarkenID INT,
	Bildpfad varchar(200)
);
create table Lagergeraete(
	LagergeraetID INT not null identity(1,1) primary key,
	SortimentID INT,
	Seriennummer varchar (30),
	Verkauft BIT NOT NULL DEFAULT 0
);
create table Vermietung(
	VermietungsID INT not null identity(1,1) primary key,
	Vermietungsbeginn Date,
	Vermietungsende Date,
	MietgeraetID INT,
	PID INT
);
create table Personen(
	PID INT not null identity(1,1) primary key,
	Nachname varchar (30),
	Vorname varchar (20),
	Mail varchar (50),
	Passwort varchar (30)
);

alter table Personen
add Telefonnummer varchar(10)
;

create table Geraetetyp(
	GeraetetypID INT not null identity(1,1) primary key,
	Geraetebezeichnung nvarchar(50)
);

create table Sortiment(
	SortimentID INT not null identity(1,1) primary key,
	MarkenID INT,
	GeraetetypID INT,
	Modell varchar (30),
	Verkaufspreis INT,
	Bildpfad varchar(200)
);

create table Login(
	LID INT not null identity(1,1) primary key,
	Benutzername varchar (50),
	LoginPasswort varchar(50)
	);


create table Mitarbeiterbuchungen(
    MitarbeiterbuchungsID INT identity(1,1) primary key,
    Terminbeginn DATETIME NOT NULL,
    Terminende DATETIME NOT NULL,
    MitarbeiterID INT,
    FOREIGN KEY (MitarbeiterID) REFERENCES BuchbareMitarbeiter(MitarbeiterID),
	PID INT
);



alter table Sortiment
add Einkaufspreis_exkl_mwst INT;

alter table Sortiment
add Beschreibung varchar(500);


create table Bildschirmdiagonale(
	BildschirmdiagonaleID INT not null identity(1,1) primary key,
	Bildschirmdiagonaleinzoll INT,
	GeraetetypID INT
);


--Beziehungen setzen
ALTER TABLE Vermietung ADD CONSTRAINT FK_VermietungMietgeraetID
FOREIGN KEY(MietgeraetID)
REFERENCES Mietgeraete(MietgeraetID)

ALTER TABLE Vermietung ADD CONSTRAINT FK_VermietungPID
FOREIGN KEY(PID)
REFERENCES Personen(PID)

ALTER TABLE Mietgeraete ADD CONSTRAINT FK_MietgeraeteMarkenID
FOREIGN KEY(MarkenID)
REFERENCES Marke(MarkenID)

ALTER TABLE Lagergeraete ADD CONSTRAINT FK_LagergeraeteSortimentID
FOREIGN KEY(SortimentID)
REFERENCES Sortiment(SortimentID)

ALTER TABLE Bildschirmdiagonale ADD CONSTRAINT FK_BildschirmdiagonaleGeraetetypID
FOREIGN KEY(GeraetetypID)
REFERENCES Geraetetyp(GeraetetypID)

ALTER TABLE Sortiment ADD CONSTRAINT FK_SortimentMarkenID
FOREIGN KEY(MarkenID)
REFERENCES Marke(MarkenID)

ALTER TABLE Sortiment ADD CONSTRAINT FK_SortimentGeraetetypID
FOREIGN KEY(GeraetetypID)
REFERENCES Geraetetyp(GeraetetypID)

ALTER Table Mitarbeiterbuchungen ADD CONSTRAINT FK_MitarbeiterbuchnugenPID
FOREIGN KEY (PID) REFERENCES Personen(PID)



--Daten einfügen
insert into Marke
(Markenname)
VALUES
('Metz Blue'),
('Epson'),
('Mipro'),
('Optoma'),
('Pioneer DJ'),
('AVer'),
('Sennheiser'),
('IMG Stageline'),
('Behringer'),
('Samsung'),
('Sony'),
('Panasonic'),
('Philips'),
('Loewe'),
('Metz'),
('LG'),
('TCL'),
('Bose'),
('Sonos'),
('Vincent Audio'),
('Tannoy'),
('Block'),
('Technisat'),
('B&W')
;


insert into BuchbareMitarbeiter
(Mnachname,Mvorname)
VALUES
('Rüegsegger','Nick'),
('Loosli','Simon')
;


--Daten einfügen
insert into Geraetetyp
(Geraetebezeichnung)
VALUES
('TV'),
('Lautsprecher'),
('Verstärker'),
('Multiroom Speaker'),
('Beamer'),
('BluRay Player'),
('Soundbar'),
('HiFi Anlage'),
('Mischpult'),
('Mikrofon und Empfänger'),
('Dokumentenkamera'),
('DJ Pult'),
('PA System'),
('Licht'),
('Leinwand');


INSERT INTO Mitarbeiterbuchungen (Terminbeginn, Terminende, MitarbeiterID, PID) 
VALUES ('2023-10-10 11:00:00', '2023-10-15 15:00:00', 3, 2);

INSERT INTO Mitarbeiterbuchungen (Terminbeginn, Terminende, MitarbeiterID, PID) 
VALUES ('2023-10-17 11:00:00', '2023-10-22 15:00:00', 3, 2);

INSERT INTO Mitarbeiterbuchungen (Terminbeginn, Terminende, MitarbeiterID, PID) 
VALUES ('2023-10-25 13:00:00', '2023-10-25 16:00:00', 4, 2);


SELECT SortimentID, MarkenID, GeraetetypID, Modell, Verkaufspreis, Bildpfad
FROM Sortiment;



DELETE FROM Geraetetyp;

DELETE FROM Mietgeraete;

DELETE FROM Vermietung;

DELETE FROM Lagergeraete;

DELETE FROM Sortiment;

DELETE FROM BuchbareMitarbeiter;

DELETE FROM Mitarbeiterbuchungen;

SELECT MietgeraetID, Mietgeraetetyp, MietpreisproTag, MarkenID
FROM Mietgeraete;


insert into Personen
(Nachname, Vorname, Mail, Passwort)
VALUES
('Rüegsegger','Nick','runi38@gmail.com','lexusisf','0798502490')
;

SELECT * FROM Personen;


SELECT
GeraetetypID, Geraetebezeichnung
FROM Geraetetyp;


insert into Vermietung
(Vermietungsbeginn, Vermietungsende, MietgeraetID, PID) 
VALUES
('09-22-2023','09-25-2023',1,1)
;

insert into Vermietung
(Vermietungsbeginn, Vermietungsende, MietgeraetID, PID) 
VALUES
('09-28-2023','10-05-2023',1,1)
;

insert into Vermietung
(Vermietungsbeginn, Vermietungsende, MietgeraetID, PID) 
VALUES
('09-28-2023','10-05-2023',2,1)
;


SELECT
VermietungsID, Vermietungsbeginn, Vermietungsende, MietgeraetID, PID
FROM Vermietung;

SELECT
PID, Nachname, Vorname, Mail, Passwort
FROM Personen

SELECT
MietgeraetID, Mietgeraetetyp, MietpreisproTag, MarkenID, Bildpfad
FROM Mietgeraete

SELECT
LagergeraetID, SortimentID, Seriennummer, Verkauft
FROM Lagergeraete

SELECT * FROM BuchbareMitarbeiter


SELECT * FROM Sortiment

SELECT * FROM Login

SELECT * FROM BuchbareMitarbeiter

DELETE FROM BuchbareMitarbeiter

DELETE FROM Mitarbeiterbuchungen

SELECT * FROM Mitarbeiterbuchungen

SELECT * FROM Personen

DELETE FROM Personen