CREATE TABLE
hg_user
(
session_id INT NOT NULL AUTO_INCREMENT,
id_guest VARCHAR(100),
id_customer VARCHAR(100),
segment VARCHAR(100),
test_id VARCHAR(100),
test_variant VARCHAR(100),
PRIMARY KEY (session_id)
)