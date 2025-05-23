-- drop database if exists ygo;
-- create database ygo;
use ygo;

/*
drop table if exists price_history;
drop table if exists items;
drop table if exists offers;
drop table if exists orders;
drop table if exists credit_cards;
drop table if exists composed;
drop table if exists decks;
drop table if exists cards;
*/

ALTER TABLE users drop column if exists phone_number; 
ALTER TABLE users ADD phone_number varchar(20) default null;

drop table if exists cards;
create table cards(
	id int unsigned not null,
	primary key (id)
);

drop table if exists offers;
create table offers(
	id int unsigned auto_increment,
	card_quantity smallint unsigned not null,
	image_number smallint unsigned not null,
	quality enum('mint','near mint','excellent','good','light played','played','poor') not null,
	price smallint unsigned not null,
	description varchar(500),
	created_at datetime default now(),
	updated_at datetime default now(),
	user_id bigint unsigned not null,
	card_id int unsigned not null,
	primary key(id),
	foreign key(user_id) references users(id),
	foreign key(card_id) references cards(id)
);

drop table if exists price_history;
create table price_history(
	id int unsigned auto_increment,
	old_price smallint unsigned not null,
	offer_id int unsigned not null,
	created_at datetime default now(),
	updated_at datetime default now(),
	primary key (id),
	foreign key(offer_id) references offers(id)
);

drop table if exists credit_cards;
create table credit_cards(
	id int unsigned auto_increment,
	card_number char(4) default null, -- last 4 numbers
	card_expiration date default null,
	cvv char(3) default null,
	created_at datetime default now(),
	updated_at datetime default now(),
	primary key(id)
);

drop table if exists orders;
create table orders(
	id int unsigned auto_increment,
	state enum('cart','processing','paid') not null,
	order_date datetime default null,
	country varchar(50) default null,
	city varchar(50) default null,
	street varchar(50) default null,
	house_number varchar(10) default null,
	zip_code varchar(10) default null,
	created_at datetime default now(),
	updated_at datetime default now(),
	user_id bigint unsigned not null,
	credit_card_id int unsigned,
    primary key(id),
	foreign key(user_id) references users(id),
	foreign key(credit_card_id) references credit_cards(id)
);

drop table if exists items;
create table items(	
	order_id int unsigned,
	offer_id int unsigned,
	quantity smallint unsigned not null,
	created_at datetime default now(),
	updated_at datetime default now(),
	primary key (order_id,offer_id),
	foreign key (order_id) references orders(id),
	foreign key (offer_id) references offers(id)
);

drop table if exists decks;
create table decks(
	id int unsigned auto_increment,
	name varchar(255) not null,
	notes varchar(500),
	created_at datetime default now(),
	updated_at datetime default now(),
	user_id bigint unsigned not null,
	primary key(id),
	foreign key(user_id) references users(id)
);

drop table if exists composed;
create table composed(
	deck_id int unsigned,
	card_id int unsigned,
	quantity smallint unsigned not null,
	created_at datetime default now(),
	updated_at datetime default now(),
	primary key (deck_id,card_id),
	foreign key (deck_id) references decks(id),
	foreign key (card_id) references cards(id)
);
