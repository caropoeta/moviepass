create database if not exists moviepass;

use moviepass;

CREATE TABLE movies(
    idMovie INT ,
    title VARCHAR(255) NOT NULL,
    releaseDate DATE,
    points SMALLINT,
    movieDescription VARCHAR(1023),
    poster VARCHAR(255),
    CONSTRAINT pk_idMovie PRIMARY KEY movies(idMovie)
);

CREATE TABLE genres(
    idGenre INT AUTO_INCREMENT NOT NULL,
    genreDescription VARCHAR(255),
	CONSTRAINT pk_idGenre PRIMARY KEY genres(idGenre)
);

CREATE TABLE genresXMovies(
    idGenreXMovie INT AUTO_INCREMENT NOT NULL,
    idMovie INT,
    idGenre INT,
    CONSTRAINT pk_idGenreXMovies PRIMARY KEY genresXMovies (idGenreXMovie),
	CONSTRAINT fk_idMovie FOREIGN KEY genresXMovie(idMovie) REFERENCES movies(idMovie),
	CONSTRAINT fk_idGenre FOREIGN KEY genresXMovie(idGenre) REFERENCES genres(idGenre)
);

CREATE TABLE IF NOT EXISTS roles (
	role_id int AUTO_INCREMENT,
    role_name varchar(50) NOT NULL,
    
    CONSTRAINT pk_roles PRIMARY KEY (role_id),
    CONSTRAINT unq_roles_name UNIQUE (role_name)
);

INSERT INTO roles(`role_name`) VALUES ('Client');
INSERT INTO roles(`role_name`) VALUES ('Admin');

CREATE TABLE IF NOT EXISTS users (
	user_id int AUTO_INCREMENT,
    user_name varchar(50) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_dni int NOT NULL,
    user_email varchar(50) NOT NULL,
    user_birthday date NOT NULL,
    user_role int NOT NULL,
    
    CONSTRAINT pk_users PRIMARY KEY (user_id),
    CONSTRAINT fk_users_role FOREIGN KEY (user_role) REFERENCES roles(role_id),
    
    CONSTRAINT unq_users_dni UNIQUE (user_dni),
    CONSTRAINT unq_users_email UNIQUE (user_email),
    CONSTRAINT unq_users_name UNIQUE (user_name)
);

INSERT INTO `users`(`user_name`, `user_password`, `user_dni`, `user_email`, `user_birthday`, `user_role`) 
VALUES ('admin','$2y$10$Y8uv.LImHjTsBXCoorLwnOUUlBBgViNUUJnoone7lWsNhZ1ZUIu8m', 0000,'admin@localhost','2020-10-15',2);

CREATE TABLE cinemas(
    idCinema INT AUTO_INCREMENT NOT NULL,
    cinemaName VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    openingTime TIME,
    closingTime TIME,
    ticket_value FLOAT,
    capacity INT,
    cinemaDelete INT, 
    CONSTRAINT pk_idCinema PRIMARY KEY cinemas(idCinema)
);

INSERT INTO `cinemas`(`idCinema`, `cinemaName`, `address`, `openingTime`, `closingTime`, `ticket_value`, `capacity`, `cinemaDelete`)
 VALUES (1,'Roxy','Santa Fe 2400', 1200,2300,500,200,0);

CREATE TABLE rooms(
	idRoom int auto_increment,
    roomName varchar(255) unique,
	capacity int,
    price float,
    idCinema int,
    constraint pk_idRoom primary key room(idRoom),
    constraint fk_idcinema foreign key rooms(idCinema) references cinemas(idCinema)
);
   

CREATE TABLE movieFunctions(
	idMovieFunction INT AUTO_INCREMENT,
	startFunction DATETIME,
    idRoom INT,
	idMovie INT,
	CONSTRAINT pk_idMovieFunction PRIMARY KEY movieFunctions(idMovieFunction),
	CONSTRAINT fk_idRoomFunction FOREIGN KEY movieFunctions(idRoom) REFERENCES rooms(idRoom),
	CONSTRAINT fk_idMovieFunction FOREIGN KEY movieFunctions(idMovie) REFERENCES movies(idMovie));

CREATE TABLE tickets(
	idTicket int auto_increment,
    qr varchar(255),
    idMovieFunction int,
    constraint pk_idTicket primary key(idTicket),
    constraint fk_idMovieFunctionTicket foreign key(idMovieFunction) references movieFunctions(idMovieFunction)
);


    