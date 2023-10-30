USE SURNO;
/*
DELIMITER //
CREATE PROCEDURE ejecutar_accion()
BEGIN
	-- Inicio de la transacción
	START TRANSACTION;
	SET @fallo =0;
	SET @ID_paquete=19;

	-- Paso 1: Descargar el paquete
	UPDATE TRAE SET fecha_descarga=current_timestamp() where ID_paquete=@id_paquete;
	SET @fallo = IF(row_count()=0, 1, @fallo);
	select @fallo;

	-- Paso 2: Crear un lote
	INSERT INTO lotes (ID_troncal,ID_almacen,fecha_creacion, tipo) values (5,4, current_timestamp(),0);
	SET @row= row_count();
	SET @id_lote= LAST_INSERT_ID();
	SET @fallo = IF(@row=0, 1, @fallo);

	-- Paso 3: Asignar el paquete al lote
	INSERT INTO paquetes_lotes (ID_lote,ID_paquete) VALUES (@id_lote, @id_paquete);
	SET @row= row_count();
	SET @fallo = IF(@row=0, 1, @fallo);

    IF @fallo=1 THEN
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

DROP PROCEDURE IF exists camion;
DELIMITER //
CREATE PROCEDURE camion (IN matricula char(7), IN vol_max int unsigned, IN peso_max int unsigned, OUT fallo bit)
BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET @fallo =0;
    
	-- Paso 1: Crear el vehiculo
	insert into vehiculos (matricula, vol_max, peso_max) values (matricula, vol_max, peso_max);
	SET @fallo = IF(row_count()=0, 1, @fallo);

	-- Paso 2: Crear un camion
	INSERT INTO camiones (matricula) values (matricula);
	SET @row= row_count();
	SET @fallo = IF(@row=0, 1, @fallo);

    IF @fallo=1 THEN
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
DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET @fallo =0;
    
	-- Paso 1: Crear el vehiculo
	insert into vehiculos (matricula, vol_max, peso_max) values (matricula, vol_max, peso_max);
	SET @fallo = IF(row_count()=0, 1, @fallo);

	-- Paso 2: Crear un camion
	INSERT INTO camionetas (matricula) values (matricula);
	SET @row= row_count();
	SET @fallo = IF(@row=0, 1, @fallo);

    IF @fallo=1 THEN
       rollback;
       set fallo = 1;
    ELSE
		commit;
        set fallo = 0;
    END IF;
END //
DELIMITER ;
/*
CALL almacen_propio ("casa","julio sosa 4515",-34.88526,-56.11027,@ID,@fallo);
CALL almacen_propio ("casa","julio sosa 4515",-34.8526,-56.1027,@ID,@fallo);
select @fallo, @ID;
*/
DROP PROCEDURE IF EXISTS almacen_cliente;
DELIMITER //
CREATE PROCEDURE almacen_cliente (IN nombre varchar(32), IN direccion varchar(128), IN longitud decimal(7,5), IN latitud decimal(7,5), IN RUT char(12), OUT ID int, OUT fallo bit)
BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;
    
	-- Paso 1: Crear el almacen
	insert into almacenes (nombre, direccion, longitud, latitud) values (nombre, direccion, longitud, latitud);
	SET fallo = IF(row_count()=0, 1, @fallo);
    SET ID = LAST_INSERT_ID();
    
	-- Paso 2: Insertar almacen en almacenes_clientes
	INSERT INTO almacenes_clientes (rut,ID) values (RUT, ID);
	SET @row= row_count();
	SET fallo = IF(@row=0, 1, @fallo);

    IF fallo=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS almacen_propio;
DELIMITER //
CREATE PROCEDURE almacen_propio (IN nombre varchar(32), IN direccion varchar(128), IN longitud decimal(7,5), IN latitud decimal(7,5), OUT ID int, OUT fallo INT)
BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
  
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;
    
	-- Paso 1: Crear el almacen
	insert into almacenes (nombre, direccion,longitud, latitud) values (nombre, direccion, longitud, latitud);
	SET fallo = IF(row_count()=0, 1, fallo);
    SET ID = LAST_INSERT_ID();

	-- Paso 2: Insertar almacen en almacenes_propios
	INSERT INTO almacenes_propios (ID) values (ID);
	SET @row= row_count();
	SET fallo = IF(@row=0, 1, fallo);

    IF fallo=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS descargar_trae;
DELIMITER //
CREATE PROCEDURE descargar_trae(IN paquete INT, IN almacen INT, OUT fallo bit)
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;
    
	-- Paso 2: Eliminar la direccion de paquete
    UPDATE PAQUETES SET direccion=null where ID=paquete;
    SET fallo = IF(row_count()!=1, 1, fallo);
    
	-- Paso 3: Descargar el paquete
	UPDATE TRAE SET fecha_descarga=CURRENT_TIMESTAMP() WHERE ID_paquete=paquete AND fecha_descarga IS NULL;
	SET fallo = IF(row_count()!=1, 1, fallo);
    
	-- Paso 4: Insertar paquete en PAQUETES_ALMACENES
    INSERT INTO PAQUETES_ALMACENES(ID_paquete,ID_almacen) values (paquete, almacen);
	SET fallo = IF(row_count()!=1, 1, fallo);

    IF fallo=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

/* PARA DESCARGAR UN PAQUETE EN EL ALMACEN DESPUES NO HABER SIDO RECIBIO AL REPARTIR */
DROP PROCEDURE IF exists descargar_reparte;
DELIMITER //
CREATE PROCEDURE descargar_reparte(IN paquete INT, IN almacen INT, OUT fallo bit)
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;
    
	-- Paso 2: Descargar el paquete
	UPDATE REPARTE SET fecha_descarga=CURRENT_TIMESTAMP() WHERE ID_paquete=paquete AND fecha_descarga IS NULL;
	SET fallo = IF(row_count()!=1, 1, fallo);
    
	-- Paso 2: Insertar paquete en PAQUETES_ALMACENES
    INSERT INTO PAQUETES_ALMACENES(ID_paquete,ID_almacen) values (paquete, almacen);
	SET fallo = IF(row_count()!=1, 1, fallo);
    
    IF fallo=1 THEN
    
	/* UPDATE PAQUETE SET DIRECCION = NULL ???*/
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;
-- CALL descargar_trae(19,1,@fallo);

-- CALL descargar_trae(19,1,@fallo);

DROP PROCEDURE IF exists entregar_paquete;
DELIMITER //
CREATE PROCEDURE entregar_paquete(IN paquete INT(128), OUT fallo bit)
BEGIN
/* No funciona si el paquete ya fue descargado o entregado anteriormente*/
  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;
    
	-- Paso 2: Descargar el paquete
	UPDATE REPARTE SET fecha_descarga=CURRENT_TIMESTAMP() WHERE ID_paquete=paquete AND fecha_descarga IS NULL;
	SET fallo = IF(row_count()!=1, 1, fallo);
    
	-- Paso 2: Actualizar paquete
    UPDATE PAQUETES SET fecha_entregado=current_timestamp(), estado=0 where ID=paquete AND fecha_entregado IS NULL;
	SET fallo = IF(row_count()!=1, 1, fallo);

    IF fallo=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

DROP PROCEDURE IF exists entregar_paquete_pickup;
DELIMITER //
CREATE PROCEDURE entregar_paquete_pickup(IN paquete INT(128), OUT fallo bit)
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;

    -- Paso 1: Sacar el paquete del lote
    UPDATE PAQUETES_LOTES SET hasta=current_timestamp() where ID_paquete=paquete and hasta is null;
    SET fallo = IF(row_count()!=1, 1, fallo);
    
	-- Paso 2: Entregar el paquete
	UPDATE PAQUETES SET fecha_entregado=CURRENT_TIMESTAMP(), estado=0 WHERE ID=paquete;
	SET fallo = IF(row_count()!=1, 1, fallo);
    
    IF fallo=1 THEN
       rollback;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;

/* PARA CREAR UN LOTE TIPO 1 */
DROP PROCEDURE IF exists lote_1;
DELIMITER //
CREATE PROCEDURE lote_1(IN almacen INT, OUT ID int ,OUT fallo bit)
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;
    SET ID = 0;
    
	-- Paso 2: Obtener troncal
	Set @troncal = (Select ID_troncal from ordenes where ID_almacen=almacen limit 1);
	SET fallo = IF(found_rows()!=1, 1, fallo);
    
    
    -- Paso 3: Crear el lote
	INSERT INTO LOTES(ID_almacen,ID_troncal,tipo) values(almacen,@troncal,1);
    SET fallo = IF(row_count()!=1, 1, fallo);    
    
    IF fallo=1 THEN
       rollback;
    ELSE
		SET ID = LAST_INSERT_ID();
		commit;
    END IF;
END //
DELIMITER ;
/*CALL lote_1(1,@ID,@fallo);
select @ID, @fallo;
select * from lotes;*/

/* PARA CREAR UN LOTE TIPO 0 */
DROP PROCEDURE IF exists lote_0;
DELIMITER //
CREATE PROCEDURE lote_0(IN origen INT, IN destino INT, IN troncal INT, OUT ID int ,OUT fallo bit)
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
    BEGIN
	  SET fallo = 1;
      SET ID = 0;
      ROLLBACK;
  END;
	-- Inicio de la transacción
	START TRANSACTION;
	SET fallo =0;
    SET ID = 0;    
    
    -- Paso 2: Crear el lote
	INSERT INTO LOTES(ID_almacen,ID_troncal) values(origen,troncal);
    SET fallo = IF(row_count()!=1, 1, fallo);    
	SET ID = LAST_INSERT_ID();
    
	-- Paso 3: Guardar el destino
	INSERT INTO DESTINO_LOTE(ID_lote,ID_almacen,ID_troncal) values(ID,destino,troncal);
    SET fallo = IF(row_count()!=1, 1, fallo);    

    IF fallo=1 THEN
       rollback;
       SET ID = 0;
    ELSE
		commit;
    END IF;
END //
DELIMITER ;
-- CALL lote_0(2,6,1,@ID,@fallo);
