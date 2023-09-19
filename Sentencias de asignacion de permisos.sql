DROP USER IF EXISTS 'almacen'@'%' ;
DROP USER IF EXISTS 'autentificacion'@'%';
DROP USER IF EXISTS 'camionero'@'';
DROP USER IF EXISTS 'backoffice'@'%';

CREATE USER 'almacen'@'%' IDENTIFIED BY 'almacen';
CREATE USER 'camionero'@'%' IDENTIFIED BY 'camionero';
CREATE USER 'autentificacion'@'%' IDENTIFIED BY 'autentificacion';
CREATE USER 'backoffice'@'%' IDENTIFIED BY 'backoffice';

-- AUTENTIFICACION

GRANT SELECT ON piston_logistics.USUARIOS TO 'autentificacion'@'%';

-- ALMACEN

GRANT SELECT ON piston_logistics.VEHICULOS TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.CAMIONES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.CAMIONETAS TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.TRONCALES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.ALMACENES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.ALMACENES_PROPIOS TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.ALMACENES_CLIENTES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.ORDENES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.PAQUETES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.LOTES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.PAQUETES_LOTES TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.DESTINO_LOTE TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.LLEVA TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.REPARTE TO 'almacen'@'%';
GRANT SELECT ON piston_logistics.TRAE TO 'almacen'@'%';

GRANT INSERT(ID_almacen, ID_pickup, calle, numero, ciudad, mail) ON piston_logistics.PAQUETES TO 'almacen'@'%';
GRANT UPDATE(peso, volumen, fecha_entregado, cedula) ON piston_logistics.PAQUETES TO 'almacen'@'%';

GRANT INSERT (ID_almacen, ID_troncal, tipo) ON piston_logistics.LOTES TO 'almacen'@'%';
GRANT UPDATE (fecha_pronto,fecha_cerrado) ON piston_logistics.LOTES TO 'almacen'@'%';

GRANT INSERT (ID_paquete, ID_lote) ON piston_logistics.PAQUETES_LOTES TO 'almacen'@'%';


GRANT INSERT (ID_almacen, ID_lote) ON piston_logistics.DESTINO_LOTE TO 'almacen'@'%';

GRANT INSERT (ID_lote, matricula) ON piston_logistics.LLEVA TO 'almacen'@'%';
GRANT UPDATE (fecha_descarga) ON piston_logistics.LLEVA TO 'almacen'@'%';

GRANT INSERT (ID_paquete, matricula) ON piston_logistics.REPARTE TO 'almacen'@'%';
GRANT UPDATE (fecha_descarga) ON piston_logistics.REPARTE TO 'almacen'@'%';

GRANT INSERT (ID_paquete, matricula) ON piston_logistics.TRAE TO 'almacen'@'%';
GRANT UPDATE (fecha_descarga) ON piston_logistics.TRAE TO 'almacen'@'%';

-- CAMIONERO

GRANT SELECT ON piston_logistics.CAMIONEROS TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.VEHICULOS TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.CAMIONES TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.CAMIONETAS TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.CONDUCEN TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.TRONCALES TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.CLIENTES TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.ALMACENES TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.ALMACENES_PROPIOS TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.ALMACENES_CLIENTES TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.ORDENES TO 'camionero'@'%';
GRANT SELECT (ID, ID_almacen, fecha_registrado, peso, volumen, fecha_entregado, cedula, ciudad,calle, numero,ID_pickup) ON piston_logistics.PAQUETES TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.LOTES TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.PAQUETES_LOTES TO  'camionero'@'%';
GRANT SELECT ON piston_logistics.DESTINO_LOTE TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.LLEVA TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.TRAE TO 'camionero'@'%';
GRANT SELECT ON piston_logistics.REPARTE TO 'camionero'@'%';

GRANT INSERT (CI, matricula) ON piston_logistics.CONDUCEN TO 'camionero'@'%';
GRANT UPDATE (hasta) ON piston_logistics.CONDUCEN TO 'camionero'@'%';
GRANT UPDATE (fecha_entregado, cedula) ON piston_logistics.PAQUETES TO 'camionero'@'%';

-- BACKOFFICE

GRANT SELECT (user, rol), INSERT, UPDATE ON piston_logistics.USUARIOS TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE ON piston_logistics.CAMIONEROS TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.VEHICULOS TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.CAMIONES TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.CAMIONETAS TO 'backoffice'@'%';
GRANT SELECT, INSERT(CI, matricula), UPDATE(hasta) ON piston_logistics.CONDUCEN TO 'backoffice'@'%';
GRANT SELECT, INSERT(nombre), UPDATE(nombre,baja) ON piston_logistics.TRONCALES TO 'backoffice'@'%';
GRANT SELECT, INSERT(RUT, NOMBRE), UPDATE ON piston_logistics.CLIENTES TO 'backoffice'@'%';
GRANT SELECT, INSERT(nombre, calle, numero, latitud, longitud), UPDATE(nombre, calle, numero, latitud, longitud, baja) ON piston_logistics.ALMACENES TO 'backoffice'@'%';
GRANT SELECT, INSERT, DELETE ON piston_logistics.ALMACENES_PROPIOS TO 'backoffice'@'%';
GRANT SELECT, INSERT, DELETE ON piston_logistics.ALMACENES_CLIENTES TO 'backoffice'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.ORDENES TO 'backoffice'@'%';
GRANT SELECT, UPDATE (ID_almacen, ID_pickup, calle, numero, ciudad, peso, volumen, mail), DELETE ON piston_logistics.PAQUETES TO 'backoffice'@'%';
GRANT SELECT ON piston_logistics.LOTES TO 'backoffice'@'%';
GRANT SELECT, DELETE ON piston_logistics.PAQUETES_LOTES TO  'backoffice'@'%';
GRANT SELECT ON piston_logistics.DESTINO_LOTE TO 'backoffice'@'%';
GRANT SELECT, INSERT(ID_lote, matricula), UPDATE(fecha_descarga) ON piston_logistics.LLEVA TO 'backoffice'@'%';
GRANT SELECT, INSERT(ID_paquete, matricula), UPDATE(fecha_descarga) ON piston_logistics.TRAE TO 'backoffice'@'%';
GRANT SELECT, INSERT(ID_paquete, matricula), UPDATE(fecha_descarga) ON piston_logistics.REPARTE TO 'backoffice'@'%';

-- SHOW GRANTS FOR 'backoffice'@'%';
-- SHOW GRANTS FOR 'almacen'@'%';
-- SHOW GRANTS FOR 'autentificacion'@'%';
-- SHOW GRANTS FOR 'camionero'@'%';
