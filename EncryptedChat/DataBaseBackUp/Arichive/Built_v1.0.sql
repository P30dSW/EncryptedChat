--Creating Webserver User
create user 'WebServerRoot'@'localhost' identified by 'rooq01';
GRANT SELECT,UPDATE,INSERT,DELETE ON ENCRYPTED_CHAT.* To 'WebServerRoot'@'localhost';
Flush privileges;
--Tables
create database ENCRYPTED_CHAT;

create table ENCRYPTED_CHAT.Users(
uId integer not null AUTO_INCREMENT,
firstName VARCHAR(50) not null,
lastName VARCHAR(50) not null,
eMail varchar(100) not null,
password varchar(255) not null,
primary key(uId)
);

create table ENCRYPTED_CHAT.Messages(
mId integer not null AUTO_INCREMENT,
message text not null,
fromUser integer not null,
toUser integer not null,
timeSend datetime not null,
CONSTRAINT fk_fromUser Foreign key (fromUser) References ENCRYPTED_CHAT.Users(uId),
CONSTRAINT fk_toUser Foreign key (toUser) References ENCRYPTED_CHAT.Users(uId),
PRIMARY key(mId)
);