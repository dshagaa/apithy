DROP USER IF EXISTS apithy_user_test;
CREATE USER apithy_user_test IDENTIFIED BY '12345678';
GRANT USAGE ON *.* TO apithy_user_test@localhost IDENTIFIED BY '12345678';
GRANT ALL PRIVILEGES ON apithy_test.* TO apithy_user_test@localhost;
FLUSH PRIVILEGES;