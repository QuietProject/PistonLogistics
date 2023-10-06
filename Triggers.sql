use surno;



/*
Este trigger se ejecuta cuando se ingresa un paquete a un lote y elimina al paquete de la tabla paquetes_almacenes 
y le asigna estado al paquete de acuerdo si es lote tipo 1 o 2
*/
drop trigger trigger_descargar_paquete;
DELIMITER //
CREATE TRIGGER trigger_paquete_lote
before INSERT
ON paquetes_lotes FOR EACH ROW
BEGIN
DELETE FROM PAQUETES_ALMACENES where ID_paquete=NEW.ID_paquete;

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
Este trigger se ejecuta al cerrar un lote y añade los paquetes de ese lote a la tabla paquetes_almacen 
y *TODO* le asigna el nuevo estado al lote de acuerdo a si este es el final o no
*/
drop TRIGGER trigger_cerrar_lote;
DELIMITER //
CREATE TRIGGER trigger_cerrar_lote
AFTER UPDATE
ON lotes FOR EACH ROW
BEGIN
	IF NEW.fecha_cerrado IS NOT NULL AND OLD.fecha_cerrado IS NULL AND OLD.tipo=0
	THEN
		set @almacen = (Select ID_almacen from destino_lote where id_lote=OLD.ID);
		INSERT INTO PAQUETES_ALMACENES (ID_paquete,ID_almacen)
			SELECT ID_paquete, @almacen
			FROM paquetes_lotes
			WHERE ID_lote = OLD.ID;
		UPDATE PAQUETES 
			SET estado =3 
			WHERE ID = (SELECT ID
			FROM PAQUETES
            INNER JOIN PAQUETES_LOTES ON PAQUETES.ID = PAQUETES_LOTES.ID_paquete
            WHERE PAQUETES_LOTES.ID_lote = OLD.ID AND ID_pickup != @almacen);
		UPDATE PAQUETES 
			SET estado =7 
			WHERE ID = (SELECT ID
			FROM PAQUETES
            INNER JOIN PAQUETES_LOTES ON PAQUETES.ID = PAQUETES_LOTES.ID_paquete
            WHERE PAQUETES_LOTES.ID_lote = OLD.ID AND ID_pickup = @almacen);
	END IF;
END //
DELIMITER ;
-- drop TRIGGER trigger_repartir_paquete;
/*
Este trigger se ejecuta cuando se carga un paquete a repartirse y elimina el paquete de la tabla almacenes paquete y le da estado repartiendo
*/
DELIMITER //
CREATE TRIGGER trigger_repartir_paquete
BEFORE INSERT
ON reparte FOR EACH ROW
BEGIN
	DELETE FROM PAQUETES_ALMACENES where id_paquete=NEW.ID_paquete;
    UPDATE PAQUETES SET estado=8 where ID=NEW.ID_paquete;
END //
DELIMITER ;

/*
Este trigger se ejecuta cuando se carga un paquete en trae y le da estado de trayendo
*/

DELIMITER //
CREATE TRIGGER trigger_traer_paquete
AFTER INSERT
ON trae FOR EACH ROW
BEGIN
	UPDATE PAQUETES SET estado=2 where ID=NEW.ID_paquete;
END //
DELIMITER ;



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

/*Trigger cuando se carga un lote al camion actualiza el estado del paquete*/
DELIMITER //
CREATE TRIGGER trigger_lleva_lote_carga
AFTER INSERT
ON LLEVA
FOR EACH ROW
BEGIN
UPDATE PAQUETES 
	SET estado =5 
	WHERE ID IN (SELECT ID
	FROM PAQUETES_LOTES
    WHERE PAQUETES_LOTES.ID_lote = NEW.ID_lote);
END //
DELIMITER ;

/*Trigger cuando se descarga un lote al almacen actualiza el estado del paquete*/
DELIMITER //
CREATE TRIGGER trigger_lleva_lote_descarga
AFTER UPDATE
ON LLEVA
FOR EACH ROW
BEGIN
	IF NEW.fecha_descarga IS NOT NULL AND OLD.fecha_descarga IS NULL
    THEN
		UPDATE PAQUETES 
			SET estado =7
			WHERE ID = (SELECT ID
			FROM PAQUETES_LOTES
			WHERE PAQUETES_LOTES.ID_lote = NEW.ID_lote);
    END IF;
END //
DELIMITER ;


DROP TRIGGER trigger_estado_paquete_entregado;
DELIMITER //
CREATE TRIGGER trigger_estado_paquete_entregado
BEFORE UPDATE
ON PAQUETES
FOR EACH ROW
BEGIN
	IF NEW.fecha_entregado IS NOT NULL AND OLD.fecha_entregado IS NULL
	THEN
		SET NEW.estado=9;
	END IF;
END //
DELIMITER ;

/*
ESTADOS DE LOS PAQUETES
0 = entregado
1 = En almacenes del cliente  ok
2 = Trayendo de almacenes de cliente ok
3 = En almacen ok?
4 = En lote (en almacen) ok
5 = Transportando lote de almacen a almacen ok
6 = En lote (en almacen destino) ok
7 = Almacen destino ok
8 = Repartiendo a destino ok
9 = Esperando en pick UP ok



describe PAQUETES_ALMACENES;
select @error;
select * from PAQUETES_ALMACENES;
INSERT INTO PAQUETES (ID_almacen, ID_pickup, direccion, mail) VALUES
(16, 2 ,'Calle 123, florida', 'correo1@example.com');
select LAST_INSERT_ID();
insert into TRAE (ID_paquete, matricula) values (20, 'abc1234');


/*
insert into paquetes_lotes (ID_lote, ID_paquete) values (1,20);
set @almacen = (Select ID_almacen from destino_lote where id_lote=2);
			SELECT ID_paquete, @almacen
			FROM paquetes_lotes
			WHERE ID_lote = 2;
select @almacen;
describe lotes;
update lotes set fecha_cerrado=current_timestamp() where ID=2;*/



