--Creating Webserver User
create user 'WebServerRoot'@'localhost' identified by 'rooq01';
GRANT SELECT,UPDATE,INSERT,DELETE ON ENCRYPTED_CHAT.* To 'WebServerRoot'@'localhost';
Flush privileges;