DROP USER IF EXISTS 'almacen'@'%' ;
DROP USER IF EXISTS 'autentificacion'@'%';
DROP USER IF EXISTS 'camionero'@'';
DROP USER IF EXISTS 'backoffice'@'%';

CREATE USER 'almacen'@'%' IDENTIFIED BY 'almacen';
CREATE USER 'camionero'@'%' IDENTIFIED BY 'camionero';
CREATE USER 'autentificacion'@'%' IDENTIFIED BY 'autentificacion';
CREATE USER 'backoffice'@'%' IDENTIFIED BY 'backoffice';

-- AUTENTIFICACION

GRANT SELECT ON surno.USERS TO 'autentificacion'@'%';

-- ALMACEN

GRANT SELECT ON surno.VEHICULOS TO 'almacen'@'%';
GRANT SELECT ON surno.CAMIONES TO 'almacen'@'%';
GRANT SELECT ON surno.CAMIONETAS TO 'almacen'@'%';
GRANT SELECT ON surno.TRONCALES TO 'almacen'@'%';
GRANT SELECT ON surno.ALMACENES TO 'almacen'@'%';
GRANT SELECT ON surno.ALMACENES_PROPIOS TO 'almacen'@'%';
GRANT SELECT ON surno.ALMACENES_CLIENTES TO 'almacen'@'%';
GRANT SELECT ON surno.ORDENES TO 'almacen'@'%';
GRANT SELECT ON surno.PAQUETES TO 'almacen'@'%';
GRANT SELECT ON surno.LOTES TO 'almacen'@'%';
GRANT SELECT ON surno.PAQUETES_LOTES TO 'almacen'@'%';
GRANT SELECT ON surno.DESTINO_LOTE TO 'almacen'@'%';
GRANT SELECT ON surno.LLEVA TO 'almacen'@'%';
GRANT SELECT ON surno.REPARTE TO 'almacen'@'%';
GRANT SELECT ON surno.TRAE TO 'almacen'@'%';

GRANT INSERT(ID_almacen, ID_pickup, calle, numero, ciudad, mail) ON surno.PAQUETES TO 'almacen'@'%';
GRANT UPDATE(peso, volumen, fecha_entregado, cedula) ON surno.PAQUETES TO 'almacen'@'%';

GRANT INSERT (ID_almacen, ID_troncal, tipo) ON surno.LOTES TO 'almacen'@'%';
GRANT UPDATE (fecha_pronto,fecha_cerrado) ON surno.LOTES TO 'almacen'@'%';

GRANT INSERT (ID_paquete, ID_lote) ON surno.PAQUETES_LOTES TO 'almacen'@'%';


GRANT INSERT (ID_almacen, ID_lote) ON surno.DESTINO_LOTE TO 'almacen'@'%';

GRANT INSERT (ID_lote, matricula) ON surno.LLEVA TO 'almacen'@'%';
GRANT UPDATE (fecha_descarga) ON surno.LLEVA TO 'almacen'@'%';

GRANT INSERT (ID_paquete, matricula) ON surno.REPARTE TO 'almacen'@'%';
GRANT UPDATE (fecha_descarga) ON surno.REPARTE TO 'almacen'@'%';

GRANT INSERT (ID_paquete, matricula) ON surno.TRAE TO 'almacen'@'%';
GRANT UPDATE (fecha_descarga) ON surno.TRAE TO 'almacen'@'%';

-- CAMIONERO

GRANT SELECT ON surno.CAMIONEROS TO 'camionero'@'%';
GRANT SELECT ON surno.VEHICULOS TO 'camionero'@'%';
GRANT SELECT ON surno.CAMIONES TO 'camionero'@'%';
GRANT SELECT ON surno.CAMIONETAS TO 'camionero'@'%';
GRANT SELECT ON surno.CONDUCEN TO 'camionero'@'%';
GRANT SELECT ON surno.TRONCALES TO 'camionero'@'%';
GRANT SELECT ON surno.CLIENTES TO 'camionero'@'%';
GRANT SELECT ON surno.ALMACENES TO 'camionero'@'%';
GRANT SELECT ON surno.ALMACENES_PROPIOS TO 'camionero'@'%';
GRANT SELECT ON surno.ALMACENES_CLIENTES TO 'camionero'@'%';
GRANT SELECT ON surno.ORDENES TO 'camionero'@'%';
GRANT SELECT (ID, ID_almacen, fecha_registrado, peso, volumen, fecha_entregado, cedula, ciudad,calle, numero,ID_pickup) ON surno.PAQUETES TO 'camionero'@'%';
GRANT SELECT ON surno.LOTES TO 'camionero'@'%';
GRANT SELECT ON surno.PAQUETES_LOTES TO  'camionero'@'%';
GRANT SELECT ON surno.DESTINO_LOTE TO 'camionero'@'%';
GRANT SELECT ON surno.LLEVA TO 'camionero'@'%';
GRANT SELECT ON surno.TRAE TO 'camionero'@'%';
GRANT SELECT ON surno.REPARTE TO 'camionero'@'%';

GRANT INSERT (CI, matricula) ON surno.CONDUCEN TO 'camionero'@'%';
GRANT UPDATE (hasta) ON surno.CONDUCEN TO 'camionero'@'%';
GRANT UPDATE (fecha_entregado, cedula) ON surno.PAQUETES TO 'camionero'@'%';

-- BACKOFFICE

GRANT SELECT, INSERT, UPDATE, DELETE ON surno.USERS TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE ON surno.CAMIONEROS TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON surno.VEHICULOS TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON surno.CAMIONES TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON surno.CAMIONETAS TO 'backoffice'@'%';
GRANT SELECT, INSERT(CI, matricula), UPDATE(hasta) ON surno.CONDUCEN TO 'backoffice'@'%';
GRANT SELECT, INSERT(nombre), UPDATE(nombre,baja) ON surno.TRONCALES TO 'backoffice'@'%';
GRANT SELECT, INSERT(RUT, NOMBRE), UPDATE ON surno.CLIENTES TO 'backoffice'@'%';
GRANT SELECT, INSERT(nombre, calle, numero, latitud, longitud), UPDATE(nombre, calle, numero, latitud, longitud, baja) ON surno.ALMACENES TO 'backoffice'@'%';
GRANT SELECT, INSERT, DELETE ON surno.ALMACENES_PROPIOS TO 'backoffice'@'%';
GRANT SELECT, INSERT, DELETE ON surno.ALMACENES_CLIENTES TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON surno.ORDENES TO 'backoffice'@'%';
GRANT SELECT, UPDATE (ID_almacen, ID_pickup, calle, numero, ciudad, peso, volumen, mail), DELETE ON surno.PAQUETES TO 'backoffice'@'%';
GRANT SELECT ON surno.LOTES TO 'backoffice'@'%';
GRANT SELECT, DELETE ON surno.PAQUETES_LOTES TO  'backoffice'@'%';
GRANT SELECT ON surno.DESTINO_LOTE TO 'backoffice'@'%';
GRANT SELECT, INSERT(ID_lote, matricula), UPDATE(fecha_descarga) ON surno.LLEVA TO 'backoffice'@'%';
GRANT SELECT, INSERT(ID_paquete, matricula), UPDATE(fecha_descarga) ON surno.TRAE TO 'backoffice'@'%';
GRANT SELECT, INSERT(ID_paquete, matricula), UPDATE(fecha_descarga) ON surno.REPARTE TO 'backoffice'@'%';

SHOW GRANTS FOR 'backoffice'@'%';
-- SHOW GRANTS FOR 'almacen'@'%';
-- SHOW GRANTS FOR 'autentificacion'@'%';
-- SHOW GRANTS FOR 'camionero'@'%';
