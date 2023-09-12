-- REVISAR  ESTADOS DE LOTES Y TIPOS DE LOTES
drop database IF EXISTS piston_logistics;

CREATE DATABASE piston_logistics;

DROP USER IF EXISTS 'almacen'@'localhost' ;
DROP USER IF EXISTS 'autentificacion'@'localhost';
DROP USER IF EXISTS 'camionero'@'localhost';
DROP USER IF EXISTS 'backoffice'@'localhost';

CREATE USER 'almacen'@'localhost' IDENTIFIED BY 'almacen';
CREATE USER 'camionero'@'localhost' IDENTIFIED BY 'camionero';
CREATE USER 'autentificacion'@'localhost' IDENTIFIED BY 'autentificacion';
CREATE USER 'backoffice'@'localhost' IDENTIFIED BY 'backoffice';


USE piston_logistics;

CREATE TABLE USUARIOS (
    usuario VARCHAR(20) PRIMARY KEY NOT NULL,
    pass VARCHAR(255) NOT NULL,
    rol TINYINT NOT NULL
);

ALTER TABLE USUARIOS
    ADD CONSTRAINT rol CHECK ( 0<=rol AND rol<=2);

CREATE TABLE CAMIONEROS (
    CI CHAR(8) PRIMARY KEY NOT NULL,
    nombre VARCHAR(32) NOT NULL,
    apellido VARCHAR(32) NOT NULL,
    baja BIT DEFAULT 0 NOT NULL
);

ALTER TABLE CAMIONEROS
    ADD CONSTRAINT CI CHECK (CI REGEXP '^[0-9]+$');

CREATE TABLE VEHICULOS (
    matricula CHAR(7) PRIMARY KEY NOT NULL,
    vol_max INT UNSIGNED NOT NULL,
    peso_max INT UNSIGNED NOT NULL,
    es_operativo BIT DEFAULT 1 NOT NULL,
    baja BIT DEFAULT 0 NOT NULL
);

ALTER TABLE VEHICULOS
    ADD CONSTRAINT MATRICULA CHECK (matricula REGEXP '^[A-Z]{3}[0-9]{4}$');

CREATE TABLE CONDUCEN (
    CI CHAR(8) NOT NULL,
    matricula CHAR(7) NOT NULL,
    desde TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    hasta TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (CI , matricula),
    FOREIGN KEY (CI)
        REFERENCES CAMIONEROS (CI)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (matricula)
        REFERENCES VEHICULOS (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE CAMIONES (
    matricula CHAR(7) PRIMARY KEY NOT NULL,
    FOREIGN KEY (matricula)
        REFERENCES VEHICULOS (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE CAMIONETAS (
    matricula CHAR(7) PRIMARY KEY NOT NULL,
    FOREIGN KEY (matricula)
        REFERENCES VEHICULOS (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE TRONCALES (
    ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(32) NOT NULL,
    baja BIT DEFAULT 0 NOT NULL
);

CREATE TABLE ALMACENES (
    ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(32) NOT NULL,
    calle VARCHAR(64) NOT NULL,
    numero VARCHAR(8) NOT NULL,
    latitud DECIMAL(10 , 6 ) NOT NULL,
    longitud DECIMAL(10 , 6 ) NOT NULL,
    baja BIT DEFAULT 0 NOT NULL
);

CREATE TABLE ALMACENES_PROPIOS (
    ID INT PRIMARY KEY NOT NULL,
    FOREIGN KEY (ID)
        REFERENCES ALMACENES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE ORDENES (
    ID_almacen INT NOT NULL,
    ID_troncal INT NOT NULL,
    orden INT UNSIGNED,
    PRIMARY KEY (ID_almacen , ID_troncal),
    FOREIGN KEY (ID_almacen)
        REFERENCES ALMACENES_PROPIOS (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_troncal)
        REFERENCES TRONCALES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

-- TRIGGER NO PODER INSERTAR ALMACENES O TRONCALES DADOS DE BAJA

CREATE TABLE CLIENTES (
    RUT CHAR(12) PRIMARY KEY,
    nombre VARCHAR(32) NOT NULL,
    baja BIT DEFAULT 0 NOT NULL
);

ALTER TABLE CLIENTES
    ADD CONSTRAINT RUT CHECK (RUT REGEXP '^[0-9]+$');

CREATE TABLE ALMACENES_CLIENTES (
    ID INT PRIMARY KEY NOT NULL,
    RUT CHAR(12) NOT NULL,
    FOREIGN KEY (ID)
        REFERENCES ALMACENES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (RUT)
        REFERENCES CLIENTES (RUT)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE PAQUETES (
    ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    ID_almacen INT NOT NULL,
    fecha_registrado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ID_pickup INT NOT NULL,
    calle VARCHAR(32) NULL DEFAULT NULL,
    numero VARCHAR(8) NULL DEFAULT NULL,
    ciudad VARCHAR(32) NULL DEFAULT NULL,
    peso INT UNSIGNED NULL DEFAULT NULL,
    volumen INT UNSIGNED NULL DEFAULT NULL,
    fecha_recibido TIMESTAMP NULL DEFAULT NULL,
    mail VARCHAR(64) NULL,
    cedula VARCHAR(8) NULL DEFAULT NULL,
    FOREIGN KEY (ID_almacen)
        REFERENCES ALMACENES_CLIENTES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_pickup)
        REFERENCES ALMACENES_PROPIOS (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE PAQUETES
	ADD CONSTRAINT FECHAS_TRAE CHECK (fecha_registrado<fecha_recibido);

ALTER TABLE PAQUETES
	ADD CONSTRAINT DIRECCION CHECK ( (ciudad IS NULL AND calle IS NULL AND ciudad IS NULL) OR  (ciudad IS NOT NULL AND calle IS NOT NULL AND ciudad IS NOT NULL));

CREATE TABLE LOTES (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_troncal INT NOT NULL,
    ID_almacen INT NOT NULL,
    tipo BIT NOT NULL DEFAULT 0,
    FOREIGN KEY (ID_almacen)
        REFERENCES ORDENES (ID_almacen)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_troncal)
        REFERENCES ORDENES (ID_troncal)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);
-- TRIGGER AL AFTER INSERT CREAR PRIMER ESTADO

CREATE TABLE ESTADOS (
    ID_lote INT NOT NULL,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    tipo INT,
    PRIMARY KEY (ID_lote , fecha),
    FOREIGN KEY (ID_lote)
        REFERENCES LOTES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE ESTADOS
    ADD CONSTRAINT ESTADO CHECK ( 0<=tipo AND tipo<=3);
-- REVISAR LOS TIPOS

CREATE TABLE PAQUETES_LOTES (
    ID_paquete INT NOT NULL,
    ID_lote INT NOT NULL,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID_paquete , ID_lote),
    FOREIGN KEY (ID_paquete)
        REFERENCES PAQUETES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_lote)
        REFERENCES LOTES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE DESTINO_LOTE (
    ID_lote INT PRIMARY KEY NOT NULL,
    ID_almacen INT NOT NULL,
    ID_troncal INT NOT NULL,
    FOREIGN KEY (ID_lote)
        REFERENCES LOTES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_almacen , ID_troncal)
        REFERENCES ORDENES (ID_almacen , ID_troncal)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE LLEVA (
    ID_lote INT PRIMARY KEY,
    matricula CHAR(7),
    fecha_carga TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_descarga TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (ID_lote)
        REFERENCES LOTES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (matricula)
        REFERENCES CAMIONES (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE LLEVA
	ADD CONSTRAINT FECHAS_TRAE CHECK (fecha_carga<fecha_descarga);

CREATE TABLE REPARTE (
    ID_paquete INT PRIMARY KEY,
    matricula CHAR(7),
    fecha_carga TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_descarga TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (ID_paquete)
        REFERENCES PAQUETES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (matricula)
        REFERENCES CAMIONETAS (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE REPARTE 
	ADD CONSTRAINT FECHAS_TRAE CHECK (fecha_carga<fecha_descarga);

CREATE TABLE TRAE (
    ID_paquete INT PRIMARY KEY,
    matricula CHAR(7),
    fecha_carga TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_descarga TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (ID_paquete)
        REFERENCES PAQUETES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (matricula)
        REFERENCES VEHICULOS (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE TRAE 
	ADD CONSTRAINT FECHAS_TRAE CHECK (fecha_carga<fecha_descarga);
/*    
RNE 1: En conduce en cada nuevo registro fecha desde>max(fecha_hasta) de la seleccionde conduce con el camionero a ingresar
RNE 2: Un paquete no puede estar en mas de un lote que no tenga estado.tipo = 0
RNE 3: Paquete no puede estar en Reparte si esta en un lote que tenga estado.tipo = 0
RNE 4: El orden de la relacion Destino_Lote debe estar relacionado con la misma troncal con la que esta relacionado el origen del lote pero no con el mismo almacen
RNE 5: Almacen no puede ser  Almacen de cliente y Almacen propio a la vez
RNE 6: Vehiculo no puede ser camion y camioneta a la vez
IMPLEMENTADO RNE 7: En paquete fecha de registro<fecha entregado
IMPLEMENTADO RNE 8: En trae fecha carga<fecha descarga
IMPLEMENTADO RNE 9: En reparte fecha carga<fecha descarga
IMPLEMENTADO RNE 10: En conduce fecha desde<fecha hasta
IMPLEMENTADO RNE 11 : Fecha de registro de paquete < Fecha carga de trae
*/

INSERT INTO USUARIOS (usuario, pass, rol) VALUES
('usuario1', 'contraseña1', 1),
('usuario2', 'contraseña2', 2),
('usuario3', 'contraseña3', 0);

INSERT INTO CAMIONEROS (CI, nombre, apellido) VALUES
('12345678', 'Juan', 'Pérez'),
('87654321', 'María', 'Gómez'),
('23456789', 'Pedro', 'Sánchez');

INSERT INTO VEHICULOS (matricula, vol_max, peso_max) VALUES
('ABC1234', 100, 500),
('XYZ5678', 80, 400),
('DEF9012', 120, 600);

INSERT INTO CONDUCEN (CI, matricula) VALUES
('12345678', 'ABC1234'),
('87654321', 'XYZ5678'),
('23456789', 'DEF9012');

INSERT INTO TRONCALES (nombre) VALUES
('Troncal 1'),
('Troncal 2'),
('Troncal 3');

INSERT INTO ALMACENES (nombre, calle, numero, latitud, longitud) VALUES
('Almacén A', 'Calle 1', '1232', 40.12456, -74.57920),
('Almacén B', 'Calle 2', '4561', 41.93654, -75.24536),
('Almacén C', 'Calle 3', '7849', 39.53321, -73.86534),
('Propio A', 'Calle 4', '1333', 40.12356, -74.57940),
('Propio B', 'Calle 5', '4156', 41.97454, -75.245336),
('Propio C', 'Calle 6', '7893', 39.54521, -73.86454);

INSERT INTO CLIENTES (RUT, nombre) VALUES
('123456789012', 'Cliente 1'),
('987654321098', 'Cliente 2'),
('543216789012', 'Cliente 3');

INSERT INTO ALMACENES_PROPIOS (ID) VALUES
(4),
(5),
(6);

INSERT INTO ALMACENES_CLIENTES (ID, RUT) VALUES 
(1,'123456789012'),
(2,'987654321098'),
(3,'543216789012');

/*INSERT INTO PAQUETES (ID_almacen, ID_pickup, peso, volumen, mail, cedula, calle, ciudad) VALUES
(1, 4, 5, 10, 'cliente1@mail.com', '12345678','calle',null);*/


INSERT INTO PAQUETES (ID_almacen, ID_pickup, peso, volumen, mail, cedula, calle, numero, ciudad) VALUES
(1, 4, 5, 10, 'cliente1@mail.com', '12345678','calle',1010,'rivera'),
(2, 5, 8, 15, 'cliente2@mail.com', '87654321','calle',1010,'canelones'),
(2, 5, 8, 15, 'cliente2@mail.com', '87654321','calle',1010,'melo'),
(3, 6, 6, 12, 'cliente3@mail.com', '23456789','calle',1010,'meontevideo'),
(3, 6, 6, 12, 'cliente3@mail.com', '23456789','calle',1010,'montevideo'),
(3, 6, 6, 12, 'cliente3@mail.com', '23456789','calle',1010,'melo');

INSERT INTO TRONCALES (nombre) values 
('troncal 1'),
('troncal 2');

INSERT INTO ORDENES (id_troncal,id_almacen,orden) VALUES
(1,4,1),
(1,5,1),
(1,6,1);


INSERT INTO LOTES (ID_troncal, ID_almacen, tipo) VALUES
(1, 4, 0),
(1, 5, 1),
(1, 6, 0);


INSERT INTO PAQUETES_LOTES (ID_paquete, ID_lote) VALUES
(1, 1),
(2, 2),
(3, 3);

INSERT INTO ESTADOS (ID_lote, tipo) VALUES
(1, 0),
(2, 1),
(3, 2);

INSERT INTO DESTINO_LOTE (ID_lote, ID_almacen, ID_troncal) VALUES
(1, 6, 1),
(2, 4, 1),
(3, 5, 1);

INSERT INTO CAMIONES (matricula) VALUES ('ABC1234');

INSERT INTO CAMIONETAS (matricula) VALUES 
('XYZ5678'),
('DEF9012');

INSERT INTO LLEVA (ID_lote, matricula) VALUES
(1, 'ABC1234'),
(2, 'ABC1234'),
(3, 'ABC1234');

INSERT INTO REPARTE (ID_paquete, matricula) VALUES
(1, 'DEF9012'),
(2, 'DEF9012'),
(3, 'DEF9012');

INSERT INTO TRAE (ID_paquete, matricula) VALUES
(1, 'XYZ5678'),
(2, 'XYZ5678'),
(3, 'XYZ5678');


