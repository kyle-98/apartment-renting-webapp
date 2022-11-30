CREATE TABLE users(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	USERNAME VARCHAR(50) NOT NULL UNIQUE,
	PASSWORD VARCHAR(255) NOT NULL,
	CREATED DATETIME DEFAULT CURRENT_TIMESTAMP
);
