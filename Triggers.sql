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
		UPDATE PAQUETES 
		SET estado =5 
		WHERE ID IN (SELECT ID_paquete
					FROM PAQUETES_LOTES
					WHERE PAQUETES_LOTES.ID_lote = NEW.ID_lote);
	END IF;
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

DROP TRIGGER IF EXISTS asignar_reparte;
-- RNE 3: Para asignarle un camion en reparte a un paquete, este tine que estar en un almacen
DELIMITER //
CREATE TRIGGER asignar_reparte
BEFORE INSERT
ON REPARTE
FOR EACH ROW
BEGIN
	IF NOT EXISTS(SELECT 1 FROM PAQUETES_ALMACENES WHERE ID_paquete=NEW.ID_paquete AND hasta is null)
    THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'El paquete debe estar en un almacen';
    END IF;
END //
DELIMITER ;
/*
DROP TRIGGER IF EXISTS paquetes_lotes_insert;
-- RNE 2: Un paquete no puede estar en mas de un lote a la vez(en mas de uno que tenga hasta=null)
DELIMITER //
CREATE TRIGGER paquetes_lotes_insert
BEFORE INSERT
ON PAQUETES_LOTES
FOR EACH ROW
BEGIN
	SELECT count(*) FROM PAQUETES_ALMACENES WHERE ID_paquete=NEW.ID_paquete AND hasta is null AND ID_almacen=(SELECT ID_almacen
																													FROM LOTES
																													WHERE ID=NEW.ID_lote);
	SET @EXISTE = found_rows();
	/*IF EXISTS(SELECT 1 FROM PAQUETES_ALMACENES WHERE ID_paquete=NEW.ID_paquete AND hasta is null AND ID_almacen=(SELECT ID_almacen
																													FROM LOTES
																													WHERE ID=NEW.ID_lote))
    SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = @EXISTE;
    /*THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'EXISTE';
	ELSE
    SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = 'NO EXISTE';
    END IF;
	IF EXISTS(SELECT 1 FROM LOTES WHERE ID=NEW.ID_lote AND fecha_pronto is null)
    THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'El lote ya esta pronto';
    END IF;
END //
DELIMITER ;
select * from PAQUETES_ALMACENES;
select * from PAQUETES;
insert into PAQUETES (id_almacen,id_pickup,direccion,cedula) values (18,1,'casa','12343223');
insert into TRAE (matricula,ID_paquete) values('ABC1234',24);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=24;
SELECT SLEEP(1);
call descargar_trae(24,3,@error);
call lote_0(3,2,5,@ID,@error);
select @error, @ID;
SELECT SLEEP(1);
insert into PAQUETES_LOTES(ID_paquete,ID_lote) values(9,15);
SELECT SLEEP(1);
update LOTES set fecha_pronto=current_timestamp() where ID=13;
*/

