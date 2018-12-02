create user 'WebServerRoot'@'localhost' identified by 'root01';
GRANT SELECT,UPDATE,INSERT,DELETE ON ENCRYPTED_CHAT.* To 'WebServerRoot'@'localhost';
Flush privileges;