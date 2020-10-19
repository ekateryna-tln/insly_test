/*
* Create DB command could be used if necessary:
* */

/*CREATE DATABASE IF NOT EXISTS employee_db;

USE employee_db*/

CREATE TABLE IF NOT EXISTS employee (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(200) NOT NULL,
	birthday DATE,
	code VARCHAR(20),
	is_current BOOLEAN,
	email VARCHAR(128),
	phone VARCHAR(128),
	address VARCHAR(300),
	created_by INT NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_by INT NOT NULL,
	updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

/*
 * Depending on the project's requirements the storage of contact data could be changed.
 * In case if an employee will have more than one contact address or phone number
 * it will need to separate contact data to an additional table with One-to-many relationships.
 * Separation will make sense also for the address field if need to separate customer address as country, city, etc...
 * 
 * Also should be determined which fields are required and which ones could be empty.
 * 
 * Depends on requests should be added indexes.
 * E.g. if an administrator uses employee names to search very often,
 * it makes sense to create an index for the name field.
 * */

INSERT INTO employee VALUES
(null, 'Test Name', '1995-10-20', '59510201111',
true, 'testemail@test.com', '+372 53654383', 'Narva mnt, 34, Tallinn, Estonia, 1111111',
1, CURRENT_TIMESTAMP, 1, CURRENT_TIMESTAMP);

CREATE TABLE IF NOT EXISTS lang (
	id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	code CHAR(2) NOT NULL,
	name VARCHAR(128) NOT NULL,
	status BOOLEAN DEFAULT FALSE
);

INSERT INTO lang VALUES(null, 'en', 'English', true),(null, 'es', 'Spanish', true),(null, 'fr', 'French', true);

/*
 * Additional employees' information storage.
 * For the current case could be also created more flexible solution,
 * with using one more table and rows instead of following fields: introduction, work_experience, education.
 * It will make sense in case if such fields are added very often.
 * In other ways the structure will be over flexible.
 * 
 * Depends of the requirements could be created tables for "Previous work experience"
 * and "Education information" in case if it is important to keep and change separately
 * enough often such data as company name, start and end working date, branch, position, etc.
 * In case if information is added one time and is sufficiently stable,
 * it is not needed to complicate the system with follow separation.
 * */

CREATE TABLE IF NOT EXISTS employee_data (
	id INT PRIMARY KEY AUTO_INCREMENT,
	employee_id INT NOT NULL,
	lang_id TINYINT UNSIGNED NOT NULL,
	introduction TEXT,
	work_experience TEXT,
	education TEXT,
	created_by INT NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_by INT NOT NULL,
	updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX employee_id_index (employee_id),
	FOREIGN KEY (employee_id)
		REFERENCES employee(id),
	FOREIGN KEY (lang_id)
		REFERENCES lang(id)
);

INSERT INTO employee_data VALUES
(null, 1, 1,
	'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.',
	'2010-2011, Test company 1,
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.
	2011-2015, Test company 2,
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.',
	'Lorem ipsum dolor, sit amet.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.', 1, CURRENT_TIMESTAMP, 1, CURRENT_TIMESTAMP),
(null, 1, 2,
	'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.',
	'2010-2011, Test company 1,
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.
	2011-2015, Test company 2,
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.',
	'Lorem ipsum dolor, sit amet.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.', 1, CURRENT_TIMESTAMP, 2, CURRENT_TIMESTAMP),
(null, 1, 3,
	'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.',
	'2010-2011, Test company 1,
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.
	2011-2015, Test company 2,
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.',
	'Lorem ipsum dolor, sit amet.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum et doloribus id
	minima nisi iste modi vero distinctio dicta inventore culpa recusandae laborum exercitationem,
	explicabo! Animi, non dicta quaerat necessitatibus.', 2, CURRENT_TIMESTAMP, 2, CURRENT_TIMESTAMP);
