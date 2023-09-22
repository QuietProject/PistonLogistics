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

-- Llama al procedimiento para ejecutar la lógica condicional
CALL ejecutar_accion();
