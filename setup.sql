CREATE DATABASE priorities;
USE priorities;

CREATE TABLE users (
email VARCHAR(255) PRIMARY KEY, 
password VARCHAR(255) NOT NULL, 
first_name VARCHAR(255) NOT NULL, 
last_name VARCHAR(255) NOT NULL
);

CREATE TABLE user_phone (
	email VARCHAR(255),
	phoneNumber VARCHAR(10),
	PRIMARY KEY(email, phoneNumber),
	FOREIGN KEY (email) REFERENCES users(email)
);

CREATE TABLE workspace (
	email VARCHAR(255),
	workspace_name VARCHAR(255),
	description TEXT,
	PRIMARY KEY(email, workspace_name),
	FOREIGN KEY (email) REFERENCES users(email)
);

CREATE TABLE lists(
	list_ID INT PRIMARY KEY AUTO_INCREMENT,
	description TEXT,
	title VARCHAR(255) NOT NULL
	);

CREATE TABLE groups (
	group_ID INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR (255),
	workspace_name VARCHAR(255),
	group_name VARCHAR(255) NOT NULL,
	description TEXT,
	FOREIGN KEY (email,workspace_name) REFERENCES workspace(email,workspace_name)
);

CREATE TABLE workspace_list_connection (
	email VARCHAR(255),
	workspace_name VARCHAR(255),
	list_ID INT,
	PRIMARY KEY (email, workspace_name, list_ID),
	FOREIGN KEY(email,workspace_name) REFERENCES workspace(email,workspace_name),
	FOREIGN KEY(list_ID) REFERENCES lists(list_ID)
	);

CREATE TABLE group_list_connection (
list_ID INT,
group_ID INT,
PRIMARY KEY(list_ID, group_ID),
FOREIGN KEY(list_ID) REFERENCES lists(list_ID),
FOREIGN KEY(group_ID) REFERENCES groups(group_ID)
	);
	
CREATE TABLE item(
	item_ID INT PRIMARY KEY AUTO_INCREMENT,
	list_ID INT,
	description TEXT NOT NULL,
	date_time_created DATETIME NOT NULL,
	date_time_due DATETIME,
	FOREIGN KEY (list_ID) REFERENCES lists(list_ID)
	);

CREATE TABLE item_assignment_connection(
	email VARCHAR(255),
	item_ID INT,
	PRIMARY KEY(email, item_ID),
	FOREIGN KEY(email) REFERENCES users(email),
	FOREIGN KEY(item_ID) REFERENCES item(item_ID)
);

CREATE TABLE reminder (
reminder_ID INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(255),
	item_ID INT,
	date_time DATETIME NOT NULL,
	message TEXT NOT NULL,
	FOREIGN KEY (email) REFERENCES users(email),
	FOREIGN KEY (item_ID) REFERENCES item(item_ID)
	);

CREATE TRIGGER new_user_created 
AFTER INSERT ON users
FOR EACH ROW 
    INSERT INTO workspace(email, workspace_name, description)
    VALUES (NEW.email, 'primary', 'default workspace for shared lists');

DELIMITER //
CREATE PROCEDURE new_user (IN my_email VARCHAR(255), IN my_password VARCHAR(255), IN my_fname VARCHAR(255), IN my_lname VARCHAR(255)) 
BEGIN 
INSERT INTO users(email, password, first_name, last_name) VALUES(my_email, SHA2(my_password, 256), my_fname, my_lname); 
END;
//


/* Below is the data used to populate the database*/

