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

DROP PROCEDURE IF EXISTS camion;

DELIMITER //
CREATE PROCEDURE camion (IN matricula char(7), IN vol_max int unsigned, IN peso_max int unsigned, OUT fallo bit)
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET @error :=0;
    
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

DROP PROCEDURE IF EXISTS camioneta;
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

DROP PROCEDURE IF EXISTS almacen_cliente;
DELIMITER //
CREATE PROCEDURE almacen_cliente (IN nombre varchar(32), IN direccion varchar(128), IN RUT char(12), OUT ID int, OUT error bit)
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

DROP PROCEDURE IF EXISTS almacen_propio;
DELIMITER //
CREATE PROCEDURE almacen_propio (IN nombre varchar(32), IN direccion varchar(128), OUT ID int, OUT error bit)
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

DROP PROCEDURE IF EXISTS descargar_trae;
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