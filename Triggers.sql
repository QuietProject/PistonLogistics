use surno;
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
DELIMITER //
CREATE TRIGGER trigger_paquete_lote
before INSERT
ON paquetes_lotes FOR EACH ROW
BEGIN
DELETE FROM PAQUETES_ALMACENES where ID_paquete=NEW.ID_paquete;
UPDATE PAQUETES SET estado=where ID=NEW.ID_paquete;
END
DELIMITER ;


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

DELIMITER //
CREATE TRIGGER trigger_estado2_trae
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
			UPDATE PAQUETES SET estado=5 where ID=NEW.ID_paquete;
		ELSE
			UPDATE PAQUETES SET estado=3 where ID=NEW.ID_paquete;
    END IF;
END //
DELIMITER ;




/*
ESTADOS DE LOS PAQUETES
ESTADOS DE LOS PAQUETES
0 = entregado
1 = En almacenes del cliente
2 = Trayendo de almacenes de cliente
3 = En almacen
4 = En lote (en almacen)
5 = Transportando lote de almacen a almacen
6 = Almacen destino
7 = Repartiendo a destino
8 = Esperando en pick UP
*/



