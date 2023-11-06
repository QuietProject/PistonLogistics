use surno;

/*
1 Este trigger se ejecuta cuando se ingresa un paquete a un lote, elimina al paquete de la tabla paquetes_almacenes 
y le asigna estado al paquete de acuerdo si es lote tipo 1 o 2
*/
drop trigger if exists trigger_paquete_lote;
DELIMITER //
CREATE TRIGGER trigger_paquete_lote
before INSERT
ON PAQUETES_LOTES FOR EACH ROW
BEGIN
UPDATE PAQUETES_ALMACENES SET hasta=current_timestamp() where ID_paquete=NEW.ID_paquete AND hasta is null;

IF EXISTS(SELECT 1 
            FROM LOTES 
            WHERE ID=NEW.ID_lote AND tipo=0)
		THEN
			UPDATE PAQUETES SET estado=4 where ID=NEW.ID_paquete;
		ELSE
			UPDATE PAQUETES SET estado=9 where ID=NEW.ID_paquete;
    END IF;
END //
DELIMITER ;

/*
2 Este trigger se ejecuta al cerrar un lote, añade los paquetes de ese lote a la tabla paquetes_almacen 
y le asigna el nuevo estado al lote de acuerdo a si este es el final o no
*/
drop TRIGGER if exists trigger_cerrar_lote;
DELIMITER //
CREATE TRIGGER trigger_cerrar_lote
AFTER UPDATE
ON LOTES FOR EACH ROW
BEGIN
	IF NEW.fecha_cerrado IS NOT NULL AND OLD.fecha_cerrado IS NULL AND OLD.tipo=0
	THEN
		set @almacen = (Select ID_almacen from DESTINO_LOTE where id_lote=OLD.ID);
		INSERT INTO PAQUETES_ALMACENES (ID_paquete,ID_almacen)
			SELECT ID_paquete, @almacen
			FROM PAQUETES_LOTES
			WHERE ID_lote = OLD.ID;
		UPDATE PAQUETES 
			SET estado =3 
			WHERE ID IN (SELECT ID
			FROM PAQUETES_LOTES
            INNER JOIN (SELECT * FROM PAQUETES)PAQUETES ON PAQUETES.ID = PAQUETES_LOTES.ID_paquete
            WHERE PAQUETES_LOTES.ID_lote = OLD.ID AND ID_pickup != @almacen);
		UPDATE PAQUETES 
			SET estado =7 
			WHERE ID IN (SELECT ID
			FROM PAQUETES_LOTES
            INNER JOIN (SELECT * FROM PAQUETES)PAQUETES ON PAQUETES.ID = PAQUETES_LOTES.ID_paquete
            WHERE PAQUETES_LOTES.ID_lote = OLD.ID AND ID_pickup = @almacen);
		UPDATE PAQUETES_LOTES 
			SET hasta=current_timestamp()
            WHERE ID_lote = OLD.ID AND hasta is null;
	END IF;
END //
DELIMITER ;

/*
3 Este trigger se ejecuta cuando se carga un paquete a repartirse y elimina el paquete de la tabla almacenes paquete y le da estado repartiendo
*/
drop TRIGGER if exists trigger_repartir_paquete;

DELIMITER //
CREATE TRIGGER trigger_repartir_paquete
BEFORE INSERT
ON REPARTE FOR EACH ROW
BEGIN
	UPDATE PAQUETES_ALMACENES SET hasta=current_timestamp() where ID_paquete=NEW.ID_paquete AND hasta is null;
    UPDATE PAQUETES SET estado=8 where ID=NEW.ID_paquete;
END //
DELIMITER ;

/*
4 Este trigger se ejecuta cuando se carga un paquete en trae y le da estado de trayendo
*/

DROP TRIGGER IF EXISTS trigger_traer_paquete;
DELIMITER //
CREATE TRIGGER trigger_traer_paquete
AFTER INSERT
ON TRAE FOR EACH ROW
BEGIN
	UPDATE PAQUETES SET estado=2 where ID=NEW.ID_paquete;
END //
DELIMITER ;

/*
5 Este triger se ejecuta cuando se ingresa un paquete a la tabla paquetes_almacenes y le da el estado correspondiente a los paquetes
*/

DROP TRIGGER IF EXISTS trigger_estado_PAQUETE_ALMACENES;
DELIMITER //
CREATE TRIGGER trigger_estado_PAQUETE_ALMACENES
AFTER INSERT
ON PAQUETES_ALMACENES FOR EACH ROW
BEGIN
	IF EXISTS(SELECT 1 
		FROM PAQUETES 
        WHERE ID=NEW.ID_paquete AND ID_pickup=NEW.ID_almacen)
	THEN
		UPDATE PAQUETES SET estado=7 where ID=NEW.ID_paquete;
	ELSE
		UPDATE PAQUETES SET estado=3 where ID=NEW.ID_paquete;
    END IF;
END //
DELIMITER ;

/* 6 Trigger cuando se carga un lote al camion actualiza el estado del paquete*/
DROP TRIGGER IF EXISTS trigger_lleva_lote_carga;
DELIMITER //
CREATE TRIGGER trigger_lleva_lote_carga
AFTER INSERT
ON LLEVA
FOR EACH ROW
BEGIN
UPDATE PAQUETES 
	SET estado =5 
	WHERE ID IN (SELECT ID_paquete
				FROM PAQUETES_LOTES
				WHERE PAQUETES_LOTES.ID_lote = NEW.ID_lote);
END //
DELIMITER ;

DROP TRIGGER IF EXISTS trigger_lleva_lote_descarga;

/* 7 Trigger cuando se descarga un lote al almacen actualiza el estado del paquete*/
DELIMITER //
CREATE TRIGGER trigger_lleva_lote_descarga
AFTER UPDATE
ON LLEVA
FOR EACH ROW
BEGIN
	IF NEW.fecha_descarga IS NOT NULL AND OLD.fecha_descarga IS NULL
    THEN
		UPDATE PAQUETES 
			SET estado = 6
			WHERE ID IN (SELECT ID_paquete
			FROM PAQUETES_LOTES
			WHERE PAQUETES_LOTES.ID_lote = NEW.ID_lote);
    END IF;
END //
DELIMITER ;
/*
/* 8 Al marcar un paquete como entregado su estado cambia a entregado
DROP TRIGGER IF EXISTS trigger_estado_paquete_entregado;
DELIMITER //
CREATE TRIGGER trigger_estado_paquete_entregado
BEFORE UPDATE
ON PAQUETES
FOR EACH ROW
BEGIN
	IF NEW.fecha_entregado IS NOT NULL AND OLD.fecha_entregado IS NULL
	THEN
		SET NEW.estado=0;
	END IF;
END //
DELIMITER ;
*/

/*
ESTADOS DE LOS PAQUETES
0 = entregado
1 = En almacenes del cliente
2 = Trayendo de almacenes de cliente
3 = En almacen
4 = En lote (en almacen)
5 = Transportando lote de almacen a almacen
6 = En lote (en almacen destino)
7 = Almacen destino
8 = Repartiendo a destino
9 = Esperando en pick UP
*/

