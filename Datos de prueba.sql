use piston_logistics;

INSERT INTO CAMIONEROS (CI, nombre, apellido, baja) VALUES
('12345678', 'Juan', 'Perez', 0),
('23456789', 'Maria', 'Gomez', 0),
('34567890', 'Pedro', 'Lopez', 0),
('45678901', 'Ana', 'Martinez', 0),
('56789012', 'Carlos', 'Rodriguez', 0),
('67890123', 'Laura', 'Hernandez', 0),
('12341234', 'Alejandro', 'Gonzalez', 0),
('23452345', 'Isabel', 'Lopez', 0),
('34563456', 'Pablo', 'Fernandez', 0),
('45674567', 'Carolina', 'Gomez', 0),
('54321098', 'Andres', 'Ramirez', 0),
('65432109', 'Eva', 'Vargas', 0),
('54321087', 'Fernando', 'Torres', 0),
('43210987', 'Carmen', 'Sanchez', 0),
('32109876', 'Luis', 'Mendoza', 0),
('65432108', 'Maria', 'Jimenez', 0),
('54321086', 'Diego', 'Paredes', 0),
('43210986', 'Sofia', 'Guerrero', 0),
('32109875', 'Javier', 'Luna', 0),
('65432107', 'Valentina', 'Cabrera', 0);


INSERT INTO VEHICULOS (matricula, vol_max, peso_max, es_operativo, baja) VALUES
('ABC1234', 500, 2000, 0, 0),
('DEF5678', 700, 2500, 1, 0),
('GHI9012', 600, 1800, 1, 0),
('JKL3456', 550, 2100, 1, 0),
('MNO7890', 650, 2200, 1, 0),
('PQR1234', 450, 1900, 1, 0),
('STU5678', 750, 2600, 1, 0),
('VWX9012', 800, 2400, 1, 0),
('YZA3456', 700, 2300, 1, 0),
('BCD7890', 600, 2100, 1, 0),
('EFG1234', 550, 2000, 1, 0),
('HIJ5678', 500, 1900, 1, 0),
('KLM9012', 450, 1800, 1, 0),
('NOP3456', 750, 500, 1, 0),
('QRS7890', 800, 2700, 1, 0),
('TUV1234', 700, 2300, 0, 0),
('WXY3367', 600, 2100, 1, 0),
('ABD2399', 550, 2000, 1, 0),
('CDE3450', 500, 1900, 1, 0),
('FGH6789', 450, 1800, 1, 1);


INSERT INTO CAMIONES (matricula)
VALUES
('ABC1234'),
('DEF5678'),
('GHI9012'),
('JKL3456'),
('MNO7890'),
('PQR1234');

INSERT INTO CAMIONETAS (matricula)
VALUES
('STU5678'),
('VWX9012'),
('YZA3456'),
('BCD7890'),
('EFG1234'),
('HIJ5678'),
('KLM9012'),
('NOP3456'),
('QRS7890'),
('TUV1234'),
('WXY3367'),
('ABD2399'),
('CDE3450'),
('FGH6789');


INSERT INTO CONDUCEN (matricula, CI, desde, hasta) values
('ABC1234' ,'12345678' ,'2023-09-05 14:01:26' ,'2023-09-13 14:01:26' ),
('DEF5678' ,'23456789' ,'2023-07-24 13:17:29' ,'2023-08-29 13:17:29' ),
('GHI9012' ,'34567890' ,'2023-07-29 18:12:12' ,'2023-09-01 18:12:12' ),
('JKL3456' ,'45678901' ,'2023-08-27 06:03:14' ,'2023-09-15 06:03:14' ),
('MNO7890' ,'56789012' ,'2023-08-26 16:18:09' ,'2023-09-01 16:18:09' ),
('PQR1234' ,'67890123' ,'2023-08-12 20:07:10' ,'2023-08-27 20:07:10' ),
('STU5678' ,'12341234' ,'2023-08-08 03:48:25' ,'2023-08-25 03:48:25' ),
('VWX9012' ,'23452345' ,'2023-08-30 20:53:28' ,'2023-08-30 20:53:28' ),
('YZA3456' ,'34563456' ,'2023-07-26 12:11:12' ,'2023-08-26 12:11:12' ),
('BCD7890' ,'45674567' ,'2023-08-18 05:18:24' ,null ),
('EFG1234' ,'54321098' ,'2023-08-09 05:05:36' ,null ),
('HIJ5678' ,'65432109' ,'2023-08-13 23:16:22' ,null ),
('KLM9012' ,'54321087' ,'2023-07-24 00:18:07' ,null ),
('NOP3456' ,'43210987' ,'2023-08-11 02:40:35' ,null ),
('QRS7890' ,'32109876' ,'2023-08-05 18:07:43' ,null ),
('TUV1234' ,'65432108' ,'2023-09-10 07:31:15' ,null ), 
('WXY3367' ,'54321086' ,'2023-09-11 06:43:39' ,null ),
('ABD2399' ,'43210986' ,'2023-09-11 12:41:15' ,null ),
('CDE3450' ,'32109875' ,'2023-08-03 22:05:06' ,null ),
('FGH6789' ,'65432107' ,'2023-08-02 17:42:11' ,null ),
('ABC1234' ,'23456789' ,'2023-09-14 14:01:26' ,'2023-09-15 14:01:26' ),
('DEF5678' ,'12345678' ,'2023-09-14 13:17:29' ,'2023-09-15 13:17:29' ),
('GHI9012' ,'34563456' ,'2023-09-01 18:12:12' ,'2023-09-12 18:12:12' ),
('YZA3456' ,'34567890' ,'2023-09-03 12:11:12' ,null ),
('MNO7890' ,'67890123' ,'2023-09-01 17:18:09' ,null ),
('PQR1234' ,'56789012' ,'2023-09-12 20:07:10' ,null );

INSERT INTO TRONCALES (nombre, baja) VALUES
('Troncal 1', 0),
('Troncal 2', 0),
('Troncal 3', 0),
('Troncal 4', 1),
('Troncal 5', 0),
('Troncal 6', 1);

INSERT INTO ALMACENES (nombre, calle, numero, latitud, longitud, baja) VALUES
('Almacén 1', 'Calle A', '123', 40.123456, -74.654321, 0),
('Almacén 2', 'Calle B', '456', 40.987654, -73.123456, 0),
('Almacén 3', 'Calle C', '789', 41.111111, -75.222222, 1),
('Almacén 4', 'Calle D', '101', 39.555555, -72.444444, 0),
('Almacén 5', 'Calle E', '202', 40.777777, -73.888888, 0),
('Almacén 6', 'Calle F', '303', 39.888888, -74.555555, 1),
('Almacén 7', 'Calle G', '404', 41.222222, -75.777777, 0),
('Almacén 8', 'Calle H', '505', 40.333333, -73.333333, 0),
('Almacén 9', 'Calle I', '606', 39.444444, -72.777777, 1),
('Almacén 10', 'Calle J', '707', 41.444444, -75.444444, 0),
('Almacén 11', 'Calle K', '808', 40.555555, -74.111111, 0),
('Almacén 12', 'Calle L', '909', 41.777777, -75.555555, 0),
('Almacén 13', 'Calle M', '1010', 40.666666, -73.777777, 1),
('Almacén 14', 'Calle N', '1111', 39.222222, -72.111111, 0),
('Almacén 15', 'Calle O', '1212', 41.888888, -75.888888, 0),
('Almacén 16', 'Calle P', '1313', 40.444444, -73.444444, 1),
('Almacén 17', 'Calle Q', '1414', 39.777777, -72.888888, 0),
('Almacén 18', 'Calle R', '1515', 41.666666, -75.333333, 0),
('Almacén 19', 'Calle S', '1616', 40.888888, -73.111111, 1),
('Almacén 20', 'Calle T', '1717', 39.111111, -72.666666, 0);

INSERT INTO ALMACENES_PROPIOS (ID) VALUES (1), (2), (3), (4), (5), (6), (7), (8), (9), (10), (11), (12), (13), (14), (15);

INSERT INTO ORDENES (ID_troncal,ID_almacen,orden) VALUES
(1	,9	,1),
(1	,6	,2),
(1	,12	,3),
(1	,11	,4),
(1	,14	,5),
(1	,2	,6),
(2	,9	,1),
(2	,13	,2),
(2	,3	,3),
(2	,1	,4),
(2	,7	,5),
(2	,11	,6),
(2	,5	,7),
(2	,8	,8),
(2	,6	,9),
(2	,12	,10),
(3	,3	,1),
(3	,14	,2),
(3	,7	,3),
(3	,12	,4),
(3	,1	,5),
(3	,13	,6),
(3	,6	,7),
(4	,3	,1),
(4	,7	,2),
(4	,2	,3),
(4	,8	,4),
(4	,15	,5),
(5	,9	,1),
(5	,1	,2),
(5	,2	,3),
(5	,3	,4),
(5	,4	,5),
(5	,5	,6),
(5	,6	,7),
(6	,9	,1),
(6	,1	,2),
(6	,2	,3),
(6	,3	,4);


INSERT INTO CLIENTES (RUT, nombre, baja) VALUES
('213456789012', 'Crecom', 0),
('987654321012', 'EcoShop', 0),
('456789123012', 'SuperTienda', 1);

INSERT INTO ALMACENES_CLIENTES (RUT, ID) VALUES
('213456789012', 16),
('213456789012', 17),
('213456789012', 18),
('987654321012', 19),
('456789123012', 20);

select matricula from conducen where hasta is null and matricula in(select matricula from camiones);
delete from paquetes where 1;
INSERT INTO PAQUETES (ID_almacen, fecha_registrado, ID_pickup, calle, numero, ciudad, peso, volumen, fecha_entregado, mail, cedula) VALUES
(16, '2023-09-15 07:37:40', 2,'Calle', '123', 'florida', 1000, 2000, NULL, 'correo1@example.com', NULL),
(16, '2023-09-14 07:34:40', 11,'Calle', '456', 'punta del este', 1500, 2500, NULL, 'correo2@example.com', NULL), 
(16, '2023-09-14 23:32:40', 2,'Calle', '789', 'chuy', 1200, 2200, NULL,	'correo3@example.com', NULL),
(16, '2023-08-26 16:28:20', 4,'Calle', '101', 'melo', 800, 1800, NULL, 'correo4@example.com', NULL),
(16, '2023-05-04 05:25:35', 11,'Calle', '202', 'melo', 1400, 2400, '2023-05-17 05:25:35', 'correo5@example.com', '56789012'),
(16, '2023-08-27 18:22:58', 1,'Calle', '303', 'salto', 1100, 2100, '2023-09-01 18:22:58', 'correo6@example.com', '67890123'),
(16, '2023-05-10 17:06:01', 11,'Calle', '404', 'melo', 1300, 2300, '2023-05-17 17:06:01', 'correo7@example.com', '78901234'),
(16, '2023-07-23 05:37:47', 8,'Calle', '505', 'canelones', 900,	1900, NULL, 'correo8@example.com', NULL),
(16, '2023-09-11 01:38:22', 7,'Calle', '606', 'montevideo',	1600, 2600,	NULL, 'correo9@example.com', NULL),
(16, '2023-08-13 04:06:42', 12,'Calle', '707', 'montevideo', 700, 1700,	'2023-08-20 04:06:42', 'correo10@example.com', '01234567'),
(17, '2023-08-02 04:22:08', 14,'Calle', '808', 'colonia del sacramento', 1800,	2800, NULL, 'correo11@example.com',	NULL),
(18, '2023-09-05 10:42:49', 5,'Calle', '909', 'tacuarembo',	1500, 2000,	'2023-09-10 10:42:49', 'correo12@example.com', '22345669'),
(18, '2023-08-29 11:42:52', 5,'Calle', '1010', 'montevideo', 1100, 2500, NULL, 'correo13@example.com', NULL),
(18, '2023-07-30 05:22:07', 4,'Calle', '1111', 'montevideo', 1400, 2100, '2023-08-01 05:22:07',	'correo14@example.com',	'44567871'),
(19, '2023-09-13 23:29:45', 5,'Calle', '1212', 'montevideo', 900, 2400,	NULL, 'correo15@example.com', NULL),
(19, '2023-08-28 23:54:46', 7,'Calle', '1313', 'montevideo', 1700, 1900, NULL, 'correo16@example.com', '66789073'),
(20, '2023-07-29 19:17:39', 8,'Calle', '1414', 'minas',	1200, 2700,	NULL, 'correo17@example.com', NULL),
(20, '2023-07-29 19:18:39', 8,'Calle', '1515', 'fray bentos', 1200,	2200, NULL,	'correo18@example.com',	NULL);

select * from paquetes where id=4;
delete from trae where 1;
INSERT INTO TRAE (ID_paquete, matricula,fecha_carga, fecha_descarga) VALUES
(1,'NOP3456','2023-09-17 09:37:40','2023-09-17 12:23:40'),
(2,'NOP3456','2023-09-17 09:38:40','2023-09-17 12:24:40'),
(3,'NOP3456','2023-09-17 09:39:40','2023-09-17 12:25:40'),

(4,'DEF5678','2023-08-27 10:48:20','2023-08-27 13:45:20');

select matricula from conducen where  desde<'2023-08-26 16:28:20' and (hasta is null or hasta> '2023-08-28 16:28:20');
INSERT INTO lotes (ID_troncal,ID_almacen,fecha_creacion,fecha_pronto,fecha_cerrado) values 
(4,15,'2023-09-17 12:23:40','2023-09-17 13:23:40','2023-09-18 10:50:40'),
(1,2,'2023-09-18 10:45:40','2023-09-18 11:20:40',null);

INSERT INTO DESTINO_LOTE (ID_lote,ID_troncal,ID_almacen) VALUES
(1,4,2);

INSERT INTO PAQUETES_LOTES(ID_lote,ID_paquete,fecha) VALUES
(1,1,'2023-09-17 12:27:40'),
(1,2,'2023-09-17 12:27:40'),
(1,3,'2023-09-17 12:27:40'),
(2,2,'2023-09-18 10:50:41');


INSERT INTO LLEVA (ID_lote,matricula,fecha_carga,fecha_descarga) values
(1,'MNO7890','2023-09-18 07:27:40','2023-09-18 10:40:40'),
(2,'PQR1234','2023-09-18 12:45:40', NULL);

INSERT INTO REPARTE (ID_paquete, matricula,fecha_carga) VALUES
(3,'KLM9012','2023-09-18 12:05:40');

select * from ordenes where ID_almacen=2; -- 1, 4, 5, 6
select * from ordenes where ID_troncal=4;
select *from paquetes;


select ALMACENES.* 
from ALMACENES_PROPIOS 
INNER JOIN ALMACENES on ALMACENES_PROPIOS.ID = ALMACENES.ID 
where ALMACENES_PROPIOS.ID in (select ID_almacen from ORDENES where ID_troncal in (select troncales.ID from troncales where baja=0)) and ALMACENES.baja=0;
