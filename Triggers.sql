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

use surno;
-- RNE 2: Un paquete no puede estar en mas de un lote a la vez(en mas de uno que tenga hasta=null) y tampoco se puede meter en un lote que ya esta pronto
/*
1 Este trigger se ejecuta cuando se ingresa un paquete a un lote, elimina al paquete de la tabla paquetes_almacenes 
y le asigna estado al paquete de acuerdo si es lote tipo 1 o 2
*/
drop trigger if exists trigger_paquete_lote;
DELIMITER //
CREATE TRIGGER trigger_paquete_lote
after INSERT
ON PAQUETES_LOTES FOR EACH ROW
BEGIN
IF NOT EXISTS (SELECT 1 FROM PAQUETES_ALMACENES WHERE hasta is null and ID_paquete=NEW.ID_paquete AND ID_almacen=(SELECT ID_almacen
																													FROM LOTES
																													WHERE ID=NEW.ID_lote))
    THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'EL paquete no se encuentra en el mismo almacen que el lote';
	END IF;
    
	IF EXISTS(SELECT 1 FROM LOTES WHERE ID=NEW.ID_lote AND fecha_pronto is not null)
    THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'El lote ya esta pronto';
    END IF;

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
AFTER UPDATE
ON REPARTE FOR EACH ROW
BEGIN
	IF(OLD.fecha_carga is null and NEW.fecha_carga is not null)
	THEN
		UPDATE PAQUETES_ALMACENES SET hasta=current_timestamp() where ID_paquete=NEW.ID_paquete AND hasta is null;
		UPDATE PAQUETES SET estado=8 where ID=NEW.ID_paquete;
	END IF;
END //
DELIMITER ;

/*
4 Este trigger se ejecuta cuando se carga un paquete en trae y le da estado de trayendo
*/

DROP TRIGGER IF EXISTS trigger_traer_paquete;
DELIMITER //
CREATE TRIGGER trigger_traer_paquete
AFTER UPDATE
ON TRAE FOR EACH ROW
BEGIN
	IF(OLD.fecha_carga is null and NEW.fecha_carga is not null)
	THEN
		UPDATE PAQUETES SET estado=2 where ID=NEW.ID_paquete;
    END IF;
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

/* No se puede cargar lotes cuando el camion tiene cargado un lote de distinta troncal o con distinto sentido*/
/* 6 Trigger cuando se carga un lote al camion actualiza el estado del paquete*/
DROP TRIGGER IF EXISTS trigger_lleva_lote_carga;
DELIMITER //
CREATE TRIGGER trigger_lleva_lote_carga
AFTER UPDATE
ON LLEVA
FOR EACH ROW
BEGIN
IF(OLD.fecha_carga is null and NEW.fecha_carga is not null)
	THEN
		IF EXISTS(	SELECT *
					FROM LLEVA 
					INNER JOIN LOTES ON LLEVA.ID_lote = LOTES.ID
					WHERE fecha_carga is not null and fecha_descarga is null
					and matricula =NEW.matricula
					AND id_troncal != (SELECT ID_troncal
										FROM LOTES
										WHERE ID=NEW.ID_lote))
		THEN
        		SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'El el camion esta recorriendo una troncal distinta a la del lote';
        END IF;
        		IF EXISTS(	SELECT *
							FROM LLEVA 
							INNER JOIN SENTIDO_LOTES ON LLEVA.ID_lote = SENTIDO_LOTES.ID
							WHERE fecha_carga is not null and fecha_descarga is null
							and matricula =NEW.matricula
							AND sentido != (SELECT sentido
												FROM SENTIDO_LOTES
												WHERE ID=NEW.ID_lote))
		THEN
        		SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'El el camion esta recorriendo la troncal en sentido opuesto al del lote';
        END IF;
    
		UPDATE PAQUETES 
		SET estado =5 
		WHERE ID IN (SELECT ID_paquete
					FROM PAQUETES_LOTES
					WHERE PAQUETES_LOTES.ID_lote = NEW.ID_lote);
	END IF;
END //
DELIMITER ;

/*SELECT *
FROM LLEVA 
INNER JOIN SENTIDO_LOTES ON LLEVA.ID_lote = SENTIDO_LOTES.ID
WHERE fecha_carga is not null and fecha_descarga is null
and matricula ='PQR1234'
AND sentido != (SELECT sentido
					FROM SENTIDO_LOTES
                    WHERE ID=27);
select * FROM LOTES;*/


DROP TRIGGER IF EXISTS trigger_lleva_lote_descarga;

/* 7 Trigger cuando se descarga un lote al almacen actualiza el estado del paquete*/
DELIMITER //
CREATE TRIGGER trigger_lleva_lote_descarga
AFTER UPDATE
ON LLEVA
FOR EACH ROW
BEGIN
	IF (NEW.fecha_descarga IS NOT NULL AND OLD.fecha_descarga IS NULL)
    THEN
		UPDATE PAQUETES 
			SET estado = 6
			WHERE ID IN (SELECT ID_paquete
			FROM PAQUETES_LOTES
			WHERE PAQUETES_LOTES.ID_lote = NEW.ID_lote);
    END IF;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS asignar_reparte;
-- RNE 3: Para asignarle un camion en reparte a un paquete, este tine que estar en un almacen y tiene que haber sido pesado
DELIMITER //
CREATE TRIGGER asignar_reparte
AFTER INSERT
ON REPARTE
FOR EACH ROW
BEGIN
	IF NOT EXISTS(SELECT 1 FROM PAQUETES_ALMACENES WHERE ID_paquete=NEW.ID_paquete AND hasta is null)
    THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'El paquete debe estar en un almacen';
    END IF;
    	IF EXISTS(SELECT 1 FROM PAQUETES WHERE ID=NEW.ID_paquete AND peso is null)
    THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'El paquete debe haber sido pesado';
    END IF;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS asignar_lote;
-- RNE : No se puede asignar un lote en lleva si no esta pronto o un camion tener asignados(no cargados) lotes de distintas troncales a la vez
DELIMITER //
CREATE TRIGGER asignar_lote
AFTER INSERT
ON LLEVA
FOR EACH ROW
BEGIN
	IF EXISTS (SELECT 1 FROM LOTES WHERE fecha_pronto is null and ID= NEW.ID_lote)
    THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'El lote no esta pronto';
    END IF;
    IF EXISTS (SELECT 1 FROM LLEVA 
				INNER JOIN LOTES ON LLEVA.ID_lote = LOTES.ID
				WHERE LLEVA.fecha_carga is null 
                and LLEVA.matricula = NEW.matricula
				and LOTES.ID_troncal !=(SELECT ID_troncal
										FROM LOTES
										WHERE ID=NEW.ID_lote))
	THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'El camion tiene otras troncales asignadas';
    END IF;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS lote_pronto;
-- RNE : No se puede aprontar un lote vacio o con paquetes sin pesar
DELIMITER //
CREATE TRIGGER lote_pronto
AFTER UPDATE
ON LOTES
FOR EACH ROW
BEGIN
	IF (OLD.fecha_pronto is null and NEW.fecha_pronto is not null)
    THEN
		IF NOT EXISTS (SELECT 1 FROM PAQUETES_LOTES WHERE ID_lote = NEW.ID)
		THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'El lote esta vacio';
		END IF;
		IF EXISTS (SELECT 1 
					FROM PAQUETES_LOTES 
					INNER JOIN PAQUETES ON PAQUETES.ID = PAQUETES_LOTES.ID_paquete
                    WHERE PAQUETES_LOTES.ID_lote=NEW.ID
                    AND PAQUETES.peso is null)
		THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'El lote tiene paquetes sin pesar';
		END IF;
    END IF;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS conducen_peridos;
-- RNE : Comprueba que un camion este conducido por una persona a la vez y que un Camionero conduzca un camion solo a la vez
DELIMITER //
CREATE TRIGGER conducen_peridos
BEFORE INSERT
ON CONDUCEN
FOR EACH ROW
BEGIN
	IF EXISTS(SELECT 1 FROM CONDUCEN WHERE hasta is null and CI=NEW.CI)
		THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'El camionero ya esta conduciendo otro vehiculo';
		END IF;
	IF EXISTS(SELECT 1 FROM CONDUCEN WHERE hasta is null and matricula=NEW.matricula)
		THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'El vehiculo ya esta siendo conducido por otro camionero';
		END IF;
END //
DELIMITER ;





/*describe CONDUCEN;
INSERT INTO CONDUCEN (matricula, CI) values
('ABC1234' ,'54321098');
('ABC1234' ,'12345678' ,'2023-04-05 14:01:26' ,'2023-06-13 14:01:26' ),




SELECT * FROM PESO_LOTES;
INSERT INTO LLEVA(ID_lote,matricula) values (27,'DEF5678');
select * from LLEVA WHERE ID_lote>26;
select * from PAQUETES_ALMACENES; -- WHERE ID_paquete =29;
select * from PAQUETES_LOTES; -- WHERE ID_lote>26;
select * from PAQUETES;
insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula) values ('P1231234',18,1,'casa','12343223');
insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula) values ('P1231235',18,1,'casa','12343223');
insert into TRAE (matricula,ID_paquete) values('ABC1234',30);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=30;
SELECT SLEEP(1);
call descargar_trae(30,4,@error);
INSERT INTO REPARTE (ID_paquete,matricula) values (30,'ABD2399');
call lote_0('L1234123',3,1,1,@ID,@error);
select @error, @ID;
SELECT SLEEP(1);
insert into PAQUETES_LOTES(ID_paquete,ID_lote) values(30,23);
SELECT SLEEP(1);
update LOTES set fecha_pronto=current_timestamp() where ID=23;
select * FROM LOTES WHERE ID>20;
select * FROM ORDENES ;
select * from LOTES where id=23;
select * from LLEVA;
SELECT 1 FROM PAQUETES_ALMACENES WHERE hasta is null and ID_paquete=29 AND ID_almacen=(SELECT ID_almacen
																													FROM LOTES
																													WHERE ID=27);*/



