/*
ALTER DATABASE surno CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
drop database surno;
CREATE DATABASE surno CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;*/
USE surno;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS personal_access_tokens;
DROP TABLE IF EXISTS PAQUETES_ALMACENES;
DROP TABLE IF EXISTS LLEVA;
DROP TABLE IF EXISTS REPARTE;
DROP TABLE IF EXISTS TRAE;
DROP TABLE IF EXISTS DESTINO_LOTE;
DROP TABLE IF EXISTS PAQUETES_LOTES;
DROP TABLE IF EXISTS LOTES;
DROP TABLE IF EXISTS PAQUETES;
DROP TABLE IF EXISTS ALMACENES_CLIENTES;
DROP TABLE IF EXISTS CLIENTES;
DROP TABLE IF EXISTS ORDENES;
DROP TABLE IF EXISTS ALMACENES_PROPIOS;
DROP TABLE IF EXISTS ALMACENES;
DROP TABLE IF EXISTS TRONCALES;
DROP TABLE IF EXISTS CAMIONES;
DROP TABLE IF EXISTS CAMIONETAS;
DROP TABLE IF EXISTS CONDUCEN;
DROP TABLE IF EXISTS VEHICULOS;
DROP TABLE IF EXISTS CAMIONEROS;


CREATE TABLE users (
	ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) DEFAULT NULL,
    rol TINYINT NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    remember_token VARCHAR(100) NULL DEFAULT NULL
);
ALTER TABLE users
    ADD CONSTRAINT rol CHECK ( 0<=rol AND rol<=3);

CREATE TABLE password_resets (
  email varchar(255) PRIMARY KEY NOT NULL ,
  token varchar(255) NOT NULL,
  created_at timestamp NULL DEFAULT NULL
);

CREATE TABLE personal_access_tokens (
id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
tokenable_type varchar(255) NOT NULL,
tokenable_id bigint(20) unsigned NOT NULL,
name varchar(255) NOT NULL,
token varchar(64) NOT NULL,
abilities text DEFAULT NULL,
last_used_at timestamp NULL DEFAULT NULL,
created_at timestamp NULL DEFAULT NULL,
updated_at timestamp NULL DEFAULT NULL,
expires_at timestamp NULL DEFAULT NULL,
PRIMARY KEY (id),
UNIQUE KEY personal_access_tokens_token_unique (token),
KEY personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type,tokenable_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE CAMIONEROS (
    CI CHAR(8) PRIMARY KEY NOT NULL,
    nombre VARCHAR(64) NOT NULL,
    baja BIT DEFAULT 0 NOT NULL
);

ALTER TABLE CAMIONEROS
    ADD CONSTRAINT CI CHECK (CI REGEXP '^[0-9]+$');

CREATE TABLE VEHICULOS (
    matricula CHAR(7) PRIMARY KEY NOT NULL,
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
    PRIMARY KEY (CI , matricula, desde),
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
    nombre VARCHAR(32) NOT NULL UNIQUE,
    baja BIT DEFAULT 0 NOT NULL
);

CREATE TABLE ALMACENES (
    ID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(32) NOT NULL,
    direccion VARCHAR(256) NOT NULL,
    longitud decimal(8,5) NOT NULL,
    latitud decimal(8,5) NOT NULL,
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
    baja BIT DEFAULT 0 NOT NULL,
    PRIMARY KEY (ID_almacen , ID_troncal),
    FOREIGN KEY (ID_almacen)
        REFERENCES ALMACENES_PROPIOS (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_troncal)
        REFERENCES TRONCALES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE CLIENTES (
    RUT CHAR(12) PRIMARY KEY,
    nombre VARCHAR(32) NOT NULL UNIQUE,
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
    codigo CHAR(8) UNIQUE NOT NULL,
    ID_almacen INT NOT NULL,
    fecha_registrado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ID_pickup INT NOT NULL,
    direccion VARCHAR(256) NULL DEFAULT NULL,
    peso FLOAT UNSIGNED NULL DEFAULT NULL,
    cedula VARCHAR(8) NOT NULL,
    fecha_entregado TIMESTAMP NULL DEFAULT NULL,
    mail VARCHAR(64) NULL,
    estado int NOT NULL default 1,
    FOREIGN KEY (ID_almacen)
        REFERENCES ALMACENES_CLIENTES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_pickup)
        REFERENCES ALMACENES_PROPIOS (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
)CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;


ALTER TABLE PAQUETES
    ADD CONSTRAINT ESTADO_ENTREGADO CHECK ((fecha_entregado is not null AND estado = 0) or (fecha_entregado is null AND estado != 0));

ALTER TABLE PAQUETES
	ADD CONSTRAINT FECHAS_PAQUETE CHECK (fecha_registrado<fecha_entregado);

CREATE TABLE LOTES (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    codigo CHAR(8) UNIQUE NOT NULL,
    ID_troncal INT NOT NULL,
    ID_almacen INT NOT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_pronto TIMESTAMP NULL DEFAULT NULL,
    fecha_cerrado TIMESTAMP NULL DEFAULT NULL,
    tipo BIT NOT NULL DEFAULT 0,
    FOREIGN KEY (ID_almacen, ID_troncal)
        REFERENCES ORDENES (ID_almacen, ID_troncal)
        ON DELETE RESTRICT ON UPDATE RESTRICT /*,
    FOREIGN KEY (ID_troncal)
        REFERENCES ORDENES (ID_troncal)
        ON DELETE RESTRICT ON UPDATE RESTRICT*/
);

CREATE TABLE PAQUETES_LOTES (
    ID_paquete INT NOT NULL,
    ID_lote INT NOT NULL,
    desde TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    hasta TIMESTAMP NULL DEFAULT NULL,
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
    fecha_asignado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_estimada TIMESTAMP NULL DEFAULT NULL,
    fecha_carga TIMESTAMP NULL DEFAULT NULL,
    fecha_descarga TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (ID_lote)
        REFERENCES LOTES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (matricula)
        REFERENCES CAMIONES (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE LLEVA 
	ADD CONSTRAINT LLEVA_FECHAS_CARGA CHECK ((fecha_carga<fecha_descarga and fecha_carga is not null and fecha_descarga is not null )OR fecha_descarga is null );
ALTER TABLE LLEVA
	ADD CONSTRAINT LLEVA_FECHAS_ESTIMADA CHECK ((fecha_carga<fecha_estimada and fecha_carga is not null and fecha_estimada is not null )OR fecha_estimada is null );
ALTER TABLE LLEVA
	ADD CONSTRAINT LLEVA_FECHAS_ASIGNADO CHECK (fecha_asignado<fecha_carga);

CREATE TABLE REPARTE (
    ID_paquete INT PRIMARY KEY,
    matricula CHAR(7),
    fecha_asignado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_carga TIMESTAMP NULL DEFAULT NULL,
    fecha_descarga TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (ID_paquete)
        REFERENCES PAQUETES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (matricula)
        REFERENCES CAMIONETAS (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE REPARTE 
	ADD CONSTRAINT REPARTE_FECHAS_CARGA CHECK ((fecha_carga<fecha_descarga and fecha_carga is not null and fecha_descarga is not null )OR fecha_descarga is null );
ALTER TABLE REPARTE
	ADD CONSTRAINT REPARTE_FECHAS_ASIGNADO CHECK (fecha_asignado<fecha_carga);
    
CREATE TABLE TRAE (
    ID_paquete INT PRIMARY KEY,
    matricula CHAR(7),
    fecha_asignado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_carga TIMESTAMP NULL DEFAULT NULL,
    fecha_descarga TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (ID_paquete)
        REFERENCES PAQUETES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (matricula)
        REFERENCES VEHICULOS (matricula)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

ALTER TABLE TRAE 
	ADD CONSTRAINT TRAE_FECHAS_CARGA CHECK ((fecha_carga<fecha_descarga and fecha_carga is not null and fecha_descarga is not null )OR fecha_descarga is null );
ALTER TABLE TRAE
	ADD CONSTRAINT TRAE_FECHAS_ASIGNADO CHECK (fecha_asignado<fecha_carga);
    
CREATE TABLE PAQUETES_ALMACENES (
    ID_paquete INT NOT NULL,
    ID_almacen INT NOT NULL,
    desde TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    hasta TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (ID_paquete , ID_almacen , desde),
    FOREIGN KEY (ID_paquete)
        REFERENCES PAQUETES (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (ID_almacen)
        REFERENCES ALMACENES_PROPIOS (ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);
/*    
RNE 1: En conduce en cada nuevo registro fecha desde>max(fecha_hasta) de la seleccionde conduce con el camionero a ingresar
RNE 2: Un paquete no puede estar en mas de un lote a la vez(en mas de uno que tenga hasta=null)
RNE 3: Para asignarle un camion en reparte a un paquete, este tine que estar en un almacen TRIGGER OK
IMPLEMENTADO PROCEDURES RNE 4: El orden de la relacion Destino_Lote debe estar relacionado con la misma troncal con la que esta relacionado el origen del lote pero no con el mismo almacen
IMPLEMENTADO PROCEDURES RNE 5: Almacen no puede ser  Almacen de cliente y Almacen propio a la vez
IMPLEMENTADO PROCEDURES RNE 6: Vehiculo no puede ser camion y camioneta a la vez
IMPLEMENTADO CHECK RNE 7: En paquete fecha de registro<fecha entregado
IMPLEMENTADO CHECK RNE 8: En trae fecha carga<fecha descarga
IMPLEMENTADO CHECK RNE 9: En reparte fecha carga<fecha descarga
IMPLEMENTADO CHECK RNE 10: En conduce fecha desde<fecha hasta
IMPLEMENTADO CHECK RNE 11 : Fecha de registro de paquete < Fecha carga de trae
IMPLEMENTADO PROCEDURES RNE 12: Para que un lote teste en DESTINP_LOTE tiene que tener tipo=0
*/
