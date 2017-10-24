drop database if exists webshop2;
create database webshop2 default character set utf8;
use webshop2;

#alter database default character set utf8;


create table operater(
sifra			int not null primary key auto_increment,
ime 			varchar(50) not null,
prezime 		varchar(50) not null,
email 			varchar(50) not null,
lozinka			char(32) not null,
uloga			varchar(50) not null
);

create table kupac(
sifra			int (6) not null primary key auto_increment,
ime				varchar (50) not null,
prezime			varchar (50) not null,
email			varchar (100) not null,
lozinka			char (32) not null,
adresa			varchar (255) not null,
mjesto			varchar (255) not null,
postanskiBroj	int (5) not null,
uloga			varchar(50) not null default 'kupac'
);

create table proizvod(
sifra			int (6) not null primary key auto_increment,
naziv			varchar (50) not null,
opis			varchar (1000),
cijena			decimal (18,2) not null,
brand			varchar (50),
garancija		int (2) default 0,
dobavljac		int (6) not null,
kategorija		int (6) not null,
slika 			varchar(50),
unique key sifra (sifra)
);

create table narudzba(
sifra			int (6) not null primary key auto_increment,
brojNarudzbe	varchar (20) not null,
datum			datetime not null,
status			varchar (15) not null,
napomena		varchar (200),
dostava			int (6) not null,
kupac			int (6) not null
);

create table dobavljac(
sifra			int (6) not null primary key auto_increment,
oib				char (11) not null,
naziv			varchar (100) not null,
ziroracun		varchar (50) not null,
email			varchar (100),
adresa			varchar (255),
mjesto			varchar (255),
postanskiBroj	int (5)
);

create table kosarica(
kolicina		int (4) not null,
cijena			decimal (18,2) not null,
proizvod		int (6) not null,
narudzba		int (6) not null,
primary key (proizvod, narudzba)
);

create table kategorija(
sifra			int (6) primary key auto_increment,
naziv			varchar (50) not null,
slika			varchar (255),
opis			varchar (50)
);

create table dostava(
sifra			int (6) primary key auto_increment,
vrsta			varchar (20) not null,
cijena			decimal (18,2) not null
);


alter table proizvod add foreign key (dobavljac) references dobavljac(sifra);
alter table proizvod add foreign key (kategorija) references kategorija(sifra);

alter table narudzba add foreign key (kupac) references kupac(sifra);
alter table narudzba add foreign key (dostava) references dostava(sifra);

alter table kosarica add foreign key (proizvod) references proizvod(sifra);
alter table kosarica add foreign key (narudzba) references narudzba(sifra);


insert into operater values 
('', 'Hrvoje', 'Šen', 'hrvojesen@gmail.com', md5('hrvoje'), 'admin'),
('', 'Ivan', 'Ivić', 'ivanivic@gmail.com', md5('ivan'), 'korisnik');

insert into dobavljac values
('', 12345678911, 'Tvrtka 1 d.o.o.', 'HR2125000091111111111', '', '', '', ''),
('', 12345678912, 'Tvrtka 2 d.o.o.', 'HR2523400091111111112', 'tvrtka2@gmail.com', 'Stjepana Radića 20', 'Zagreb', 10000),
('', 12345678913, 'Tvrtka 3 d.o.o.', 'HR4923600001111111113', '', 'Buzinski Prilaz 10', 'Zagreb', 10010);

insert into kategorija values
('', 'Procesor', '', ''),
('', 'Matična ploča', '', ''),
('', 'Memorija', '', '');

insert into proizvod values
('', 'Proizvod 1', 'proizvod 1', 1500.00, '', 24, 1, 1, '../../img/proizvodi/1.jpg'),
('', 'Proizvod 2', 'proizvod 2', 500.00, '', 12, 1, 2, '../../img/proizvodi/2.jpg'),
('', 'Proizvod 3', 'proizvod 3', 280.00, '', 6, 2, 2, '../../img/proizvodi/2.jpg'),
('', 'Proizvod 4', 'proizvod 4', 195.00, '', 36, 3, 3, '../../img/proizvodi/3.jpg'),
('', 'Proizvod 5', 'proizvod 5', 2900.00, '', '', 3, 1, '../../img/proizvodi/1.jpg');

insert into kupac values
('', 'Ivan', 'Marić', 'kupac1@gmail.com', md5('kupac1'), 'Vladimira Nazora 117', 'Đakovo', 31400, default),
('', 'Marko', 'Živković', 'kupac2@gmail.com', md5('kupac2'), 'Marka Marulića 18', 'Osijek', 31000, default),
('', 'Natko', 'Đikić', 'kupac3@gmail.com', md5('kupac3'), 'Vladimira Nazora 10', 'Zagreb', 10000, default),
('', 'Ratko', 'Robić', 'kupac4@gmail.com', md5('kupac4'), 'Vladimira Nazora 10', 'Zagreb', 10010, default),
('', 'Slavko', 'Žderić', 'kupac5@gmail.com', md5('kupac5'), 'Vladimira Nazora 10', 'Zagreb', 10020, default);

insert into dostava values
('', 'besplatna', 0.00),
('', 'nije besplatna', 40.00);

insert into narudzba values
('', '01/2017', '2017-07-12', 'u obradi', '', 1, 2),
('', '02/2017', '2017-06-18', 'isporučeno', '', 2, 3),
('', '03/2017', '2017-06-18', 'isporučeno', '', 2, 3),
('', '04/2017', '2017-06-18', 'isporučeno', '', 1, 1),
('', '05/2017', '2017-06-18', 'isporučeno', '', 1, 1),
('', '06/2017', '2017-06-18', 'isporučeno', '', 1, 1),
('', '07/2017', '2017-06-18', 'isporučeno', '', 2, 4),
('', '08/2017', '2017-06-18', 'isporučeno', '', 2, 4),
('', '09/2017', '2017-06-18', 'isporučeno', '', 2, 4),
('', '10/2017', '2017-06-18', 'isporučeno', '', 2, 5),
('', '11/2017', '2017-06-18', 'isporučeno', '', 2, 5);

insert into kosarica values
(1, 2900.00, 5, 1),
(1, 500.00, 2, 2),
(2, 195.00, 4, 2),
(1, 1500.00, 1, 3),
(2, 1500.00, 1, 4),
(1, 2900.00, 5, 5),
(2, 2900.00, 5, 6),
(1, 280.00, 3, 7),
(2, 280.00, 3, 8),
(2, 280.00, 3, 9),
(2, 280.00, 3, 10),
(2, 280.00, 3, 11);
