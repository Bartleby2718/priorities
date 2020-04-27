-------------------------------------------------------------------------------
-- Part 1: Run in http://localhost/phpmyadmin/server_databases.php
-------------------------------------------------------------------------------
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
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);

CREATE TABLE workspace (
	email VARCHAR(255),
	workspace_name VARCHAR(255),
	description TEXT,
	PRIMARY KEY(email, workspace_name),
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
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
	FOREIGN KEY (email,workspace_name) REFERENCES workspace(email,workspace_name) ON DELETE CASCADE
);

CREATE TABLE workspace_list_connection (
	email VARCHAR(255),
	workspace_name VARCHAR(255),
	list_ID INT,
	PRIMARY KEY (email, workspace_name, list_ID),
	FOREIGN KEY(email,workspace_name) REFERENCES workspace(email,workspace_name) ON DELETE CASCADE,
	FOREIGN KEY(list_ID) REFERENCES lists(list_ID) ON DELETE CASCADE
	);

CREATE TABLE group_list_connection (
list_ID INT,
group_ID INT,
PRIMARY KEY(list_ID, group_ID),
FOREIGN KEY(list_ID) REFERENCES lists(list_ID) ON DELETE CASCADE,
FOREIGN KEY(group_ID) REFERENCES groups(group_ID) ON DELETE CASCADE
	);
	
CREATE TABLE item(
	item_ID INT PRIMARY KEY AUTO_INCREMENT,
	list_ID INT,
	description TEXT NOT NULL,
	date_time_created DATETIME NOT NULL,
	date_time_due DATETIME,
	FOREIGN KEY (list_ID) REFERENCES lists(list_ID) ON DELETE CASCADE
	);

CREATE TABLE item_assignment_connection(
	email VARCHAR(255),
	item_ID INT,
	PRIMARY KEY(email, item_ID),
	FOREIGN KEY(email) REFERENCES users(email) ON DELETE CASCADE,
	FOREIGN KEY(item_ID) REFERENCES item(item_ID) ON DELETE CASCADE
);

CREATE TABLE reminder (
reminder_ID INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(255),
	item_ID INT,
	date_time DATETIME NOT NULL,
	message TEXT NOT NULL,
	FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE,
	FOREIGN KEY (item_ID) REFERENCES item(item_ID) ON DELETE CASCADE
	);

CREATE TRIGGER new_user_created 
AFTER INSERT ON users
FOR EACH ROW 
    INSERT INTO workspace(email, workspace_name, description)
    VALUES (NEW.email, 'primary', 'Any personal matters that need to be done');

DELIMITER //
CREATE PROCEDURE new_user (IN my_email VARCHAR(255), IN my_password VARCHAR(255), IN my_fname VARCHAR(255), IN my_lname VARCHAR(255)) 
BEGIN 
INSERT INTO users(email, password, first_name, last_name) VALUES(my_email, SHA2(my_password, 256), my_fname, my_lname); 
END;
//

-- -----------------------------------------------------------------------------
-- Part 2: Run in http://localhost/phpmyadmin/db_sql.php?db=priorities
-- Below is the data used to populate the database
-- -----------------------------------------------------------------------------

CALL new_user('jp9vd@virginia.edu', 'jppassword', 'Jihoon', 'Park');
CALL new_user('jam3gw@virginia.edu', 'jmpassword', 'Jake', 'Moses');
CALL new_user('mes2hu@virginia.edu', 'mspassword', 'Mia', 'Shaker');
CALL new_user('sa2dt@virginia.edu', 'sapassword', 'Sonia', 'Aggarwal');
CALL new_user('up3f@virginia.edu', 'uppassword', 'Upsorn', 'Praphamontripong');
CALL new_user('rcr4eh@virginia.edu', 'rrpassword', 'Ryan', 'Ritzo');

-- -----------------------------------------------------------------------------
-- User_phone Table
-- -----------------------------------------------------------------------------
INSERT INTO
  user_phone (email, phoneNumber)
values
  -- Some users don't have phone numbers
  ('jam3gw@virginia.edu', '2222222222'),
  ('sa2dt@virginia.edu', '3333333333'),
  ('mes2hu@virginia.edu', '4444444444'),
  -- Some users have multiple phone numbers
  ('up3f@virginia.edu', '5555555555'),
  ('up3f@virginia.edu', '6666666666');
-- -----------------------------------------------------------------------------
-- workspace Table
-- -----------------------------------------------------------------------------
INSERT INTO
  workspace (email, workspace_name, description)
VALUES
  -- A user can have multiple workspaces
  ('jp9vd@virginia.edu', 'Personal', 'daily notes'),
  (
    'jp9vd@virginia.edu',
    'Academics',
    'UVA'
  ),
  (
    'jp9vd@virginia.edu',
    'Open Source Projects',
    NULL
  ),
  -- Some users don't have any workspaces
  -- description is optional and workspace_name is not unique
  ('up3f@virginia.edu', 'Personal', NULL),
  ('up3f@virginia.edu', 'DB', 'MoWe330'),
  ('up3f@virginia.edu', 'Web PL', 'TuTh200');
 
-- -----------------------------------------------------------------------------
-- List Table
-- -----------------------------------------------------------------------------
INSERT INTO
  lists(list_ID, description, title)
VALUES
  (NULL, 'CV', 'MATH 3340'),
  (NULL, 'ACT', 'MATH 4452'),
  (NULL, 'ISA', 'CS 4260'),
  (NULL, 'DB', 'CS 4750'),
  (NULL, 'ML', 'CS 4774'),
  -- description is optional
  (NULL, NULL, 'Project'),
  (NULL, NULL, 'Logistics'),
  (NULL, '2/26, 4/10, 5/5', 'Exams'),
  (NULL, NULL, 'In Class Activities'),
  (NULL, NULL, 'TODO'),
  -- No UNIQUE constraint on title
  (NULL, NULL, 'TODO'),
  (NULL, NULL, 'Public Announcements'),
  (NULL, NULL, 'Idioms'),
  (NULL, NULL, 'slangs'),
  (NULL, NULL, 'textspeak');
 
-- -----------------------------------------------------------------------------
-- group Table
-- -----------------------------------------------------------------------------
INSERT INTO
  groups (
    group_ID,
    email,
    workspace_name,
    group_name,
    description
  )
values
  -- description is optional
  (
    NULL,
    'jp9vd@virginia.edu',
    'Personal',
    'to-google',
    NULL
  ),
  (
    NULL,
    'jp9vd@virginia.edu',
    'Personal',
    'to-blog',
    'will write a post at some point'
  );
 
-- -----------------------------------------------------------------------------
-- workspace_list_connection Table
-- -----------------------------------------------------------------------------
INSERT INTO
  workspace_list_connection (email, workspace_name, list_ID)
VALUES
  ('jp9vd@virginia.edu', 'Academics', 1),
  ('jp9vd@virginia.edu', 'Academics', 2),
  ('jp9vd@virginia.edu', 'Academics', 3),
  ('jp9vd@virginia.edu', 'Academics', 4),
  ('jp9vd@virginia.edu', 'Academics', 5),
  ('up3f@virginia.edu', 'DB', 6),
  ('up3f@virginia.edu', 'DB', 7),
  ('up3f@virginia.edu', 'DB', 8),
  ('up3f@virginia.edu', 'DB', 9),
  ('up3f@virginia.edu', 'DB', 10),
  ('up3f@virginia.edu', 'Personal', 11);
 
-- -----------------------------------------------------------------------------
-- group_list_connection Table
-- -----------------------------------------------------------------------------
INSERT INTO
  group_list_connection (list_ID, group_ID)
VALUES
  -- a list may optionally belong to a group
  (13, 1),
  (14, 1),
  (15, 1);
 
-- -----------------------------------------------------------------------------
-- item Table
-- -----------------------------------------------------------------------------
INSERT INTO
  item(
    item_ID,
    list_ID,
    description,
    date_time_created,
    date_time_due
  )
values
  -- description and date_due can be null
  (
    NULL,
    13,
    'catch up',
    '2020-04-04 01:23:45',
    NULL
  ),
  (
    NULL,
    14,
    'high key',
    '2019-09-09 00:00:00',
    NULL
  ),
  -- multiple items can belong to a single list
  (
    NULL,
    14,
    'low key',
    '2019-09-09 00:00:10',
    NULL
  );
 
-- -----------------------------------------------------------------------------
-- assigned_to Table
-- -----------------------------------------------------------------------------
INSERT INTO
  item_assignment_connection (email, item_ID)
VALUES
  ('jp9vd@virginia.edu', 1),
  ('sa2dt@virginia.edu', 2),
  ('sa2dt@virginia.edu', 3);
 
-- -----------------------------------------------------------------------------
-- reminder Table
-- -----------------------------------------------------------------------------
INSERT INTO
  reminder (
    reminder_ID,
    email,
    item_ID,
    date_time,
    message
  )
VALUES
  (
    NULL,
    'jp9vd@virginia.edu',
    3,
    '2020-05-05 08:00:00',
    'use this word when saying goodbye'
  );
