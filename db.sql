CREATE TABLE types_of_sports (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

CREATE TABLE stadions (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

CREATE TABLE sportsmen (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL DEFAULT '',
  phone varchar(12) NOT NULL DEFAULT '',
  sport varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

CREATE TABLE performances (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  date varchar(10) NOT NULL DEFAULT '',
  place varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

CREATE TABLE performances_members (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_performance int(10) NOT NULL DEFAULT 0,
  id_member int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);

insert into stadions (name) values ('КубГУ');
insert into stadions (name) values ('Фишт');
insert into stadions (name) values ('Краснодар');
insert into stadions (name) values ('Кубань');
insert into stadions (name) values ('КубГТУ');

insert into types_of_sports (name) values ('Футбол');
insert into types_of_sports (name) values ('Баскетбол');
insert into types_of_sports (name) values ('Волейбол');
insert into types_of_sports (name) values ('Теннис');
insert into types_of_sports (name) values ('Бокс');
insert into types_of_sports (name) values ('Борьба');