SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS hangman;
CREATE DATABASE hangman DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE hangman;


DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(60) COLLATE utf8_spanish_ci UNIQUE KEY NOT NULL,
  clave varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  email varchar(60) COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

DROP TABLE IF EXISTS partidas;
CREATE TABLE partidas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    numerrores INT NOT NULL,
    palabrasecreta VARCHAR(255) NOT NULL,
    palabradescubierta VARCHAR(255) NOT NULL,
    letras VARCHAR(255) NOT NULL,
    maxnumerrores INT NOT NULL,
    inicio TIMESTAMP NULL DEFAULT NULL,
    fin TIMESTAMP NULL DEFAULT NULL,
    idusuario int(11) NULL DEFAULT NULL
);

ALTER TABLE partidas
ADD CONSTRAINT fk_usuario_id FOREIGN KEY (idusuario)
REFERENCES usuarios(id)
ON DELETE CASCADE
ON UPDATE CASCADE;

INSERT INTO usuarios (id, nombre, clave, email) VALUES
(1, 'pepe', '123456', 'pepe@pepe.es');
INSERT INTO usuarios (id, nombre, clave, email) VALUES
(2, 'luis', '654321', 'luis@luis.es');

COMMIT;

