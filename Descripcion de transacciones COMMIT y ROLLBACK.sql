USE SURNO;
/*
DELIMITER //
CREATE PROCEDURE ejecutar_accion()
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET @error =0;
	SET @ID_paquete=19;

	-- Paso 1: Descargar el paquete
	UPDATE TRAE SET fecha_descarga=current_timestamp() where ID_paquete=@id_paquete;
	SET @error = IF(row_count()=0, 1, @error);
	select @error;

	-- Paso 2: Crear un lote
	INSERT INTO lotes (ID_troncal,ID_almacen,fecha_creacion, tipo) values (5,4, current_timestamp(),0);
	SET @row= row_count();
	SET @id_lote= LAST_INSERT_ID();
	SET @error = IF(@row=0, 1, @error);

	-- Paso 3: Asignar el paquete al lote
	INSERT INTO paquetes_lotes (ID_lote,ID_paquete) VALUES (@id_lote, @id_paquete);
	SET @row= row_count();
	SET @error = IF(@row=0, 1, @error);

    IF @error=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;
DROP PROCEDURE ejecutar_accion;
-- Llama al procedimiento para ejecutar la lógica condicional
CALL ejecutar_accion();
*/

DELIMITER //
CREATE PROCEDURE camion (IN matricula char(7), vol_max int unsigned, peso_max int unsigned, OUT fallo bit)
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET @error =0;
    
	-- Paso 1: Crear el vehiculo
	insert into vehiculos (matricula, vol_max, peso_max) values (matricula, vol_max, peso_max);
	SET @error = IF(row_count()=0, 1, @error);

	-- Paso 2: Crear un camion
	INSERT INTO camiones (matricula) values (matricula);
	SET @row= row_count();
	SET @error = IF(@row=0, 1, @error);

    IF @error=1 THEN
       rollback;
       set fallo = 1;
    ELSE
		commit;
        set fallo = 0;
    END IF;
END //
DELIMITER ;


-- CALL camion("ead3342",10,10, @fallo);

DELIMITER //
CREATE PROCEDURE camioneta (IN matricula char(7), vol_max int unsigned, peso_max int unsigned, OUT fallo bit)
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET @error =0;
    
	-- Paso 1: Crear el vehiculo
	insert into vehiculos (matricula, vol_max, peso_max) values (matricula, vol_max, peso_max);
	SET @error = IF(row_count()=0, 1, @error);

	-- Paso 2: Crear un camion
	INSERT INTO camionetas (matricula) values (matricula);
	SET @row= row_count();
	SET @error = IF(@row=0, 1, @error);

    IF @error=1 THEN
       rollback;
       set fallo = 1;
    ELSE
		commit;
        set fallo = 0;
    END IF;
END //
DELIMITER ;

-- CALL camioneta("ead3342",10,10, @fallo);

-- DROP PROCEDURE almacen_cliente;
DELIMITER //
CREATE PROCEDURE almacen_cliente (IN nombre varchar(32), IN direccion varchar(128), IN RUT char(12), OUT error bit, OUT ID int)
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET error =0;
    
	-- Paso 1: Crear el almacen
	insert into almacenes (nombre, direccion) values (nombre, direccion);
	SET error = IF(row_count()=0, 1, @error);
    SET ID = LAST_INSERT_ID();
    
	-- Paso 2: Insertar almacen en almacenes_clientes
	INSERT INTO almacenes_clientes (rut,ID) values (RUT, ID);
	SET @row= row_count();
	SET error = IF(@row=0, 1, @error);

    IF error=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

/*CALL almacen_cliente("almacen7",'calle',234323232323,@error,@ID);
select @error, @ID;*/
/*
DELIMITER //
CREATE PROCEDURE camioneta (IN matricula char(7), vol_max int unsigned, peso_max int unsigned, OUT fallo bit)
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET @error =0;
    
	-- Paso 1: Crear el vehiculo
	insert into vehiculos (matricula, vol_max, peso_max) values (matricula, vol_max, peso_max);
	SET @error = IF(row_count()=0, 1, @error);

	-- Paso 2: Crear un camion
	INSERT INTO camionetas (matricula) values (matricula);
	SET @row= row_count();
	SET @error = IF(@row=0, 1, @error);

    IF @error=1 THEN
       rollback;
       set fallo = 1;
    ELSE
		commit;
        set fallo = 0;
    END IF;
END //
DELIMITER ;

-- CALL camioneta("ead3342",10,10, @fallo);
*/
-- DROP PROCEDURE almacen_propio;
DELIMITER //
CREATE PROCEDURE almacen_propio (IN nombre varchar(32), IN direccion varchar(128), OUT error bit, OUT ID int)
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET error =0;
    
	-- Paso 1: Crear el almacen
	insert into almacenes (nombre, direccion) values (nombre, direccion);
	SET error = IF(row_count()=0, 1, @error);
    SET ID = LAST_INSERT_ID();
    
	-- Paso 2: Insertar almacen en almacenes_propios
	INSERT INTO almacenes_propios (ID) values (ID);
	SET @row= row_count();
	SET error = IF(@row=0, 1, @error);

    IF error=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

-- DROP PROCEDURE descargar_trae;
DELIMITER //
CREATE PROCEDURE descargar_trae(IN paquete INT, IN almacen INT (128), OUT error bit)
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET error = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET error =0;
    
	-- Paso 2: Descargar el paquete
	UPDATE TRAE SET fecha_descarga=CURRENT_TIMESTAMP() WHERE ID_paquete=paquete AND fecha_descarga IS NULL;
	SET error = IF(row_count()!=1, 1, error);
    
	-- Paso 2: Insertar paquete en PAQUETES_ALMACENES
    INSERT INTO PAQUETES_ALMACENES values (paquete, almacen);
	SET error = IF(row_count()!=1, 1, error);

    IF error=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

-- CALL descargar_trae(19,1,@error);

/*
describe PAQUETES_ALMACENES;
select @error;
select * from PAQUETES_ALMACENES;
INSERT INTO PAQUETES (ID_almacen, ID_pickup, direccion, mail) VALUES
(16, 2 ,'Calle 123, florida', 'correo1@example.com');
select LAST_INSERT_ID();
insert into TRAE (ID_paquete, matricula) values (20, 'abc1234');
*/


-- drop trigger trigger_descargar_paquete;
CREATE TRIGGER trigger_descargar_paquete
before INSERT
ON paquetes_lotes FOR EACH ROW
DELETE FROM PAQUETES_ALMACENES where ID_paquete=NEW.ID_paquete;

-- drop TRIGGER trigger_cerrar_lote;
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
	END IF;
END //
DELIMITER ;

/*
insert into paquetes_lotes (ID_lote, ID_paquete) values (1,20);
set @almacen = (Select ID_almacen from destino_lote where id_lote=2);
			SELECT ID_paquete, @almacen
			FROM paquetes_lotes
			WHERE ID_lote = 2;
select @almacen;
describe lotes;
update lotes set fecha_cerrado=current_timestamp() where ID=2;*/


-- drop TRIGGER trigger_cargar_paquete;
DELIMITER //
CREATE TRIGGER trigger_cargar_paquete
BEFORE INSERT
ON reparte FOR EACH ROW
BEGIN
	DELETE FROM PAQUETES_ALMACENES where id_paquete=NEW.ID_paquete;
END //
DELIMITER ;

-- insert into reparte (id_paquete,matricula) values (2,'abd2399');








