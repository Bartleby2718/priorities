
/* Below are teh sql commands you will need to update table and make it work. 
Changes made include:
proper password hashing
different saved format for password in user table*/
ALTER TABLE users MODIFY COLUMN password VARCHAR(256);

UPDATE users SET password=SHA2('jmpassword', 256) WHERE email='jam3gw@virginia.edu'; 

UPDATE users SET password=SHA2('jppassword', 256) WHERE email='jp9vd@virginia.edu';

UPDATE users SET password=SHA2('mspassword', 256) WHERE email='mes2hu@virginia.edu';

UPDATE users SET password=SHA2('rrpassword', 256) WHERE email='rcr4eh@virginia.edu';

UPDATE users SET password=SHA2('sapassword', 256) WHERE email='sa2dt@virginia.edu';

UPDATE users SET password=SHA2('uppassword', 256) WHERE email='up3f@virginia.edu';

