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
    CONSTRAINT pk_idGenreXMovies PRIMARY KEY genresXMovie (idGenreXMovie),
	CONSTRAINT fk_idMovie FOREIGN KEY genresXMovie(idMovie) REFERENCES movies(idMovie),
	CONSTRAINT fk_idGenre FOREIGN KEY genresXMovie(idGenre) REFERENCES genres(idGenre)
);

CREATE TABLE users (
    idUser INT AUTO_INCREMENT,
    userName VARCHAR(255),
    pass VARCHAR(255),
    idRole INT,
    dni INT UNIQUE,
    email VARCHAR(255) UNIQUE,
    birthday DATE,
    CONSTRAINT pk_idUser PRIMARY KEY users(idUser),
    CONSTRAINT fk_idRole FOREIGN KEY users(idRole) REFERENCES roles(idRole)
);

CREATE TABLE roles(
    idRole INT AUTO_INCREMENT,
    roleDescription VARCHAR(255),
    CONSTRAINT pk_idRole PRIMARY KEY roles(idRole)
);

CREATE TABLE rooms(
	idRoom int auto_increment,
    roomName varchar(255) unique,
	capacity int,
    idCinema int,
    constraint pk_idRoom primary key room(idRoom),
    constraint fk_idcinema foreign key rooms(idCinema) references cinemas(idCinema)
);

CREATE TABLE cinemas(
    idCinema INT AUTO_INCREMENT NOT NULL,
    cinemaName VARCHAR(255) NOT NULL,
    adress VARCHAR(255),
    openingTime TIME,
    closingTime TIME,
    ticket_value FLOAT,
    capacity INT,
    cinemaDelete INT, 
    address VARCHAR(255),
    CONSTRAINT pk_idCinema PRIMARY KEY cinemas(idCinema)
);

CREATE TABLE tickets(
	idTicket int auto_increment,
    qr varchar(255),
    idMovieFunction int,
    constraint pk_idTicket primary key(idTicket),
    constraint fk_idMovieFunctionTicket foreign key(idMovieFunction) references movieFunctions(idMovieFunction)
);

CREATE TABLE movieFunctions(
	idMovieFunction INT AUTO_INCREMENT,
	startFunction DATETIME,
    idRoom INT,
	idMovie INT,
	CONSTRAINT pk_idMovieFunction PRIMARY KEY movieFunctions(idMovieFunction),
	CONSTRAINT fk_idRoomFunction FOREIGN KEY movieFunctions(idRoom) REFERENCES rooms(idRoom),
	CONSTRAINT fk_idMovieFunction FOREIGN KEY movieFunctions(idMovie) REFERENCES movies(idMovie));
    