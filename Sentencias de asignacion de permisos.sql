
-- AUTENTIFICACION

GRANT SELECT ON piston_logistics.USUARIOS TO 'autentificacion'@'localhost';

-- ALMACEN

GRANT SELECT ON piston_logistics.VEHICULOS TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.CAMIONES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.CAMIONETAS TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.TRONCALES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.ALMACENES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.ALMACENES_PROPIOS TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.ALMACENES_CLIENTES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.ORDENES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.PAQUETES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.LOTES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.PAQUETES_LOTES TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.ESTADOS TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.DESTINO_LOTE TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.LLEVA TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.REPARTE TO 'almacen'@'localhost';
GRANT SELECT ON piston_logistics.TRAE TO 'almacen'@'localhost';

GRANT INSERT(ID_almacen, ID_pickup, calle, numero, ciudad, mail) ON piston_logistics.PAQUETES TO 'almacen'@'localhost';
GRANT UPDATE(peso, volumen, fecha_recibido, cedula) ON piston_logistics.PAQUETES TO 'almacen'@'localhost';

GRANT INSERT (ID_almacen, ID_troncal, tipo) ON piston_logistics.LOTES TO 'almacen'@'localhost';

GRANT INSERT (ID_paquete, ID_lote) ON piston_logistics.PAQUETES_LOTES TO 'almacen'@'localhost';

GRANT INSERT (ID_lote, fecha, tipo) ON piston_logistics.ESTADOS TO 'almacen'@'localhost';

GRANT INSERT (ID_almacen, ID_lote) ON piston_logistics.DESTINO_LOTE TO 'almacen'@'localhost';

GRANT INSERT (ID_lote, matricula) ON piston_logistics.LLEVA TO 'almacen'@'localhost';
GRANT UPDATE (fecha_descarga) ON piston_logistics.LLEVA TO 'almacen'@'localhost';

GRANT INSERT (ID_paquete, matricula) ON piston_logistics.REPARTE TO 'almacen'@'localhost';
GRANT UPDATE (fecha_descarga) ON piston_logistics.REPARTE TO 'almacen'@'localhost';

GRANT INSERT (ID_paquete, matricula) ON piston_logistics.TRAE TO 'almacen'@'localhost';
GRANT UPDATE (fecha_descarga) ON piston_logistics.TRAE TO 'almacen'@'localhost';

-- CAMIONERO

GRANT SELECT ON piston_logistics.CAMIONEROS TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.VEHICULOS TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.CAMIONES TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.CAMIONETAS TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.CONDUCEN TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.TRONCALES TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.CLIENTES TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.ALMACENES TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.ALMACENES_PROPIOS TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.ALMACENES_CLIENTES TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.ORDENES TO 'camionero'@'localhost';
GRANT SELECT (ID, ID_almacen, fecha_registrado, peso, volumen, fecha_recibido, cedula, ciudad,calle, numero,ID_pickup) ON piston_logistics.PAQUETES TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.LOTES TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.PAQUETES_LOTES TO  'camionero'@'localhost';
GRANT SELECT ON piston_logistics.ESTADOS TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.DESTINO_LOTE TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.LLEVA TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.TRAE TO 'camionero'@'localhost';
GRANT SELECT ON piston_logistics.REPARTE TO 'camionero'@'localhost';

GRANT INSERT (CI, matricula) ON piston_logistics.CONDUCEN TO 'camionero'@'localhost';
GRANT UPDATE (hasta) ON piston_logistics.CONDUCEN TO 'camionero'@'localhost';
GRANT UPDATE (fecha_recibido, cedula) ON piston_logistics.PAQUETES TO 'camionero'@'localhost';

-- BACKOFFICE

GRANT SELECT (usuario, rol), INSERT, UPDATE ON piston_logistics.USUARIOS TO 'backoffice'@'localhost';
GRANT SELECT, INSERT, UPDATE ON piston_logistics.CAMIONEROS TO 'backoffice'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.VEHICULOS TO 'backoffice'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.CAMIONES TO 'backoffice'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.CAMIONETAS TO 'backoffice'@'localhost';
GRANT SELECT, INSERT(CI, matricula), UPDATE(hasta) ON piston_logistics.CONDUCEN TO 'backoffice'@'localhost';
GRANT SELECT, INSERT(nombre), UPDATE(nombre,baja) ON piston_logistics.TRONCALES TO 'backoffice'@'localhost';
GRANT SELECT, INSERT(RUT, NOMBRE), UPDATE ON piston_logistics.CLIENTES TO 'backoffice'@'localhost';
GRANT SELECT, INSERT(nombre, calle, numero, latitud, longitud), UPDATE(nombre, calle, numero, latitud, longitud, baja) ON piston_logistics.ALMACENES TO 'backoffice'@'localhost';
GRANT SELECT, INSERT, DELETE ON piston_logistics.ALMACENES_PROPIOS TO 'backoffice'@'localhost';
GRANT SELECT, INSERT, DELETE ON piston_logistics.ALMACENES_CLIENTES TO 'backoffice'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON piston_logistics.ORDENES TO 'backoffice'@'localhost';
GRANT SELECT, UPDATE (ID_almacen, ID_pickup, calle, numero, ciudad, peso, volumen, mail), DELETE ON piston_logistics.PAQUETES TO 'backoffice'@'localhost';
GRANT SELECT ON piston_logistics.LOTES TO 'backoffice'@'localhost';
GRANT SELECT, DELETE ON piston_logistics.PAQUETES_LOTES TO  'backoffice'@'localhost';
GRANT SELECT ON piston_logistics.ESTADOS TO 'backoffice'@'localhost';
GRANT SELECT ON piston_logistics.DESTINO_LOTE TO 'backoffice'@'localhost';
GRANT SELECT, INSERT(ID_lote, matricula), UPDATE(fecha_descarga) ON piston_logistics.LLEVA TO 'backoffice'@'localhost';
GRANT SELECT, INSERT(ID_paquete, matricula), UPDATE(fecha_descarga) ON piston_logistics.TRAE TO 'backoffice'@'localhost';
GRANT SELECT, INSERT(ID_paquete, matricula), UPDATE(fecha_descarga) ON piston_logistics.REPARTE TO 'backoffice'@'localhost';

-- SHOW GRANTS FOR 'backoffice'@'localhost';
-- SHOW GRANTS FOR 'almacen'@'localhost';
-- SHOW GRANTS FOR 'autentificacion'@'localhost';
-- SHOW GRANTS FOR 'camionero'@'localhost';

