SELECT LOTES.ID AS id, LOTES.ID_ALMACEN AS origen, DESTINO_LOTE.ID_almacen destino, DESTINO_LOTE.ID_troncal troncal, peso, cantidad
FROM LOTES
INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LOTES.ID
INNER JOIN PESO_LOTES ON PESO_LOTES.LOTE = DESTINO_LOTE.ID_lote
WHERE LOTES.ID NOT IN (	SELECT ID_lote
						FROM LLEVA)
AND LOTES.fecha_cerrado IS NULL
AND LOTES.fecha_pronto IS NOT NULL;

SELECT sum(peso) as peso, PAQUETES_LOTES.ID_lote AS lote 
from PAQUETES_LOTES
INNER JOIN PAQUETES ON PAQUETES_LOTES.ID_paquete= PAQUETES.ID
INNER JOIN LOTES ON PAQUETES_LOTES.ID_lote= LOTES.ID
where fecha_pronto is not null
group by PAQUETES_LOTES.ID_lote;

select * from PAQUETES_LOTES
INNER JOIN PAQUETES ON PAQUETES_LOTES.ID_paquete= PAQUETES.ID
WHERE PAQUETES_LOTES.ID_lote=1;

SELECT LOTES.ID AS id,LOTES.ID_ALMACEN AS origen,DESTINO_LOTE.ID_almacen destino,DESTINO_LOTE.ID_troncal troncal,peso,cantidad 
FROM LOTES INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LOTES.ID 
INNER JOIN PESO_LOTES ON PESO_LOTES.LOTE = DESTINO_LOTE.ID_lote WHERE LOTES.ID NOT IN (SELECT ID_lote FROM LLEVA WHERE fecha_carga is not null) AND LOTES.fecha_cerrado IS NULL AND LOTES.fecha_pronto IS NOT NULL;

 SELECT VEHICULOS.matricula, ifnull(sum(peso),0) carga_asignada, VEHICULOS.peso_max, max(LOTES.ID_troncal) troncal
FROM CAMIONES
INNER JOIN VEHICULOS ON VEHICULOS.matricula=CAMIONES.matricula
LEFT JOIN (select * from LLEVA where fecha_carga is null) LLEVA ON VEHICULOS.matricula=LLEVA.matricula
LEFT JOIN PESO_LOTES ON PESO_LOTES.lote = LLEVA.ID_lote
LEFT JOIN LOTES ON LOTES.ID= LLEVA.ID_lote
where VEHICULOS.baja =0
and VEHICULOS.es_operativo=1
group by VEHICULOS.matricula
having carga_asignada+ 120<peso_max
and troncal = 1 or troncal is null;

call lote_0(2,6,1,@id,@error);
select @id,@error;
select * from ORDENES;
INSERT INTO LLEVA (ID_lote,matricula) values (18,'SAE2841');
use surno;
select * from PESO_LOTES;

SELECT *
FROM CAMIONES
INNER JOIN VEHICULOS ON VEHICULOS.matricula=CAMIONES.matricula
LEFT JOIN (select * from LLEVA where fecha_carga is null) LLEVA ON VEHICULOS.matricula=LLEVA.matricula
LEFT JOIN PESO_LOTES ON PESO_LOTES.lote = LLEVA.ID_lote
LEFT JOIN LOTES ON LOTES.ID= LLEVA.ID_lote;

insert into PAQUETES (id_almacen,id_pickup,direccion,cedula,peso) values (18,1,'casa','12343223',300);
UPDATE LOTES SET FECHA_PRONTO=current_timestamp() WHERE ID=18;
INSERT INTO PAQUETES_LOTES (ID_lote, ID_paquete) VALUES (18,22),(18,24),(18,23);

select * from LLEVA;
use surno;
select * from ORDENES;

call lote_0(7,3,4,@id,@error);
select @id,@error;


SELECT VEHICULOS.matricula, ifnull(sum(peso),0) carga_asignada, VEHICULOS.peso_max, max(LOTES.ID_troncal) troncal
FROM CAMIONES
INNER JOIN VEHICULOS ON VEHICULOS.matricula=CAMIONES.matricula
LEFT JOIN (select * from LLEVA where fecha_carga is null) LLEVA ON VEHICULOS.matricula=LLEVA.matricula
LEFT JOIN PESO_LOTES ON PESO_LOTES.lote = LLEVA.ID_lote
LEFT JOIN LOTES ON LOTES.ID= LLEVA.ID_lote
where VEHICULOS.baja =0
and VEHICULOS.es_operativo=1
and VEHICULOS.matricula not in(	SELECT TRAE.matricula
								FROM TRAE
								where fecha_carga is null)
group by VEHICULOS.matricula
having carga_asignada + 10<peso_max
and troncal = 5 or troncal is null
;
select * from PAQUETES_LOTES;






/*
SELECT * 
FROM CAMIONETAS
INNER JOIN VEHICULOS ON VEHICULOS.matricula = CAMIONETAS.matricula
LEFT JOIN REPARTE ON 
where VEHICULOS.baja =0
and VEHICULOS.es_operativo=1;*/
SELECT * 
FROM PAQUETES;

SELECT VEHICULOS.matricula, ifnull(round(sum(peso),2),0) carga_asignada, VEHICULOS.peso_max, max(PAQUETES_ALMACENES.ID_almacen) almacen
FROM VEHICULOS
INNER JOIN CAMIONETAS ON VEHICULOS.matricula = CAMIONETAS.matricula
LEFT JOIN REPARTE ON REPARTE.matricula = VEHICULOS.matricula
LEFT JOIN PAQUETES ON REPARTE.ID_paquete = PAQUETES.ID
LEFT JOIN PAQUETES_ALMACENES ON REPARTE.ID_paquete = PAQUETES_ALMACENES.ID_paquete
where VEHICULOS.baja =0
and VEHICULOS.es_operativo=1
and VEHICULOS.matricula not in(	SELECT TRAE.matricula
								FROM TRAE
								where fecha_carga is null)
and REPARTE.fecha_carga is null
group by VEHICULOS.matricula
having carga_asignada + 1 < peso_max
and almacen is null or almacen = 1
;

select * from REPARTE;


select PAQUETES.ID as ID_paquete,PAQUETES.codigo,PAQUETES.direccion as direccion,PAQUETES.fecha_registrado,PAQUETES_ALMACENES.desde,ALMACENES.ID as ID_almacen,ALMACENES.nombre as nombre,PAQUETES.peso
from PAQUETES 
inner join PAQUETES_ALMACENES on PAQUETES_ALMACENES.ID_paquete = PAQUETES.ID 
inner join ALMACENES on PAQUETES_ALMACENES.ID_almacen = ALMACENES.ID 
where estado = 7
and PAQUETES_ALMACENES.hasta is null 
and PAQUETES.peso is not null 
and PAQUETES.ID = ?
and PAQUETES.ID not in (SELECT ID_paquete 
						FROM REPARTE)
order by PAQUETES_ALMACENES.desde asc;

select * from LLEVA;

SELECT Id_lote,
CASE
    WHEN fecha_descarga is not null THEN fecha_descarga
    ELSE fecha_carga 
END as fecha,
CASE
    WHEN fecha_descarga is not null THEN "descarga"
    ELSE "carga"
END as coso
 FROM LLEVA
 INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
 where matricula=?
 where troncal=?
 order by fecha DESC
 limit 1;
 
use surno;
 
 SELECT ID_troncal
 from LLEVA
 INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
 WHERE fecha_carga is null
 and matricula = ?
 LIMIT 1;
 
 select ID_ALMACEN from LOTES WHERE ID_almacen=?;
 
 
 SELECT Id_lote,ID_troncal,
CASE
	WHEN fecha_descarga is not null THEN fecha_descarga
	ELSE fecha_carga 
END as fecha,
CASE
	WHEN fecha_descarga is not null THEN "descarga"
	ELSE "carga"
END as accion
FROM LLEVA
INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
where matricula=?
order by fecha DESC
limit 1;
 
 
 use surno;
 
 SELECT LLEVA.Id_lote,
                CASE
                    WHEN fecha_descarga is not null THEN fecha_descarga
                    ELSE fecha_carga 
                    END as fecha,
                CASE
                    WHEN fecha_descarga is not null THEN DESTINO_LOTE.ID_almacen
                    ELSE LOTES.ID_almacen
                END as almacen,
                CASE
					WHEN exists( select ID_almacen from ORDENES where id_troncal = 4 and id_almacen=almacen and baja =0) THEN 'esta'
					ELSE 'no esta'
				END as esta
                 FROM LLEVA
                 INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
                 INNER JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
				 where !(fecha_descarga is not null and DESTINO_LOTE.ID_almacen=2) and !(fecha_descarga is null and LOTES.ID_almacen=2)
                 order by fecha desc;
                 ;

                 select * from CONDUCEN;
                 
                 
                 
                 
SELECT VEHICULOS.matricula, count(PAQUETES.ID) paquetes_asignados, VEHICULOS.peso_max,
		CASE
			WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
			ELSE 2
		END as tipo
        FROM VEHICULOS
        LEFT JOIN TRAE ON TRAE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(	SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null)
        and TRAE.fecha_carga is null
        group by VEHICULOS.matricula;
        
        
SELECT VEHICULOS.matricula, count(PAQUETES.ID) paquetes_asignados, VEHICULOS.peso_max,
		CASE
			WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
			ELSE 2
		END as tipo
        FROM VEHICULOS
        LEFT JOIN TRAE ON TRAE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(	SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null)
        and TRAE.fecha_carga is null
        group by VEHICULOS.matricula;
        
 -- paquetes asignados en trae
SELECT PAQUETES.ID ID_paquete,codigo, fecha_registrado,ALMACENES.ID ID_almacen,ALMACENES.nombre nombre, CLIENTES.nombre cliente, CLIENTES.RUT RUT, TRAE.fecha_asignado fecha_asignado, TRAE.matricula matricula 
FROM TRAE
INNER JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
inner join ALMACENES on PAQUETES.ID_almacen = ALMACENES.ID
inner join ALMACENES_CLIENTES on ALMACENES_CLIENTES.ID = ALMACENES.ID
inner join CLIENTES on ALMACENES_CLIENTES.RUT = CLIENTES.RUT
WHERE TRAE.fecha_carga is null;	
        
SELECT * 
FROM TRAE 
WHERE fecha_carga is null
and ID_paquete = ?;

SELECT LOTES.ID AS id,LOTES.codigo AS codigo,LOTES.ID_ALMACEN AS origen, DESTINO_LOTE.ID_almacen destino, LOTES.fecha_pronto pronto,DESTINO_LOTE.ID_almacen destino,DESTINO_LOTE.ID_troncal troncal,round(peso,2) peso,cantidad, LLEVA.fecha_asignado as fecha_asignado, LLEVA.matricula
        FROM LOTES 
        INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LOTES.ID
        INNER JOIN PESO_LOTES ON PESO_LOTES.LOTE = DESTINO_LOTE.ID_lote
        INNER JOIN LLEVA ON LLEVA.ID_lote = LOTES.ID
        WHERE LLEVA.fecha_carga is null
        ORDER BY LOTES.fecha_pronto ASC;
        

        
SELECT VEHICULOS.matricula, count(PAQUETES.ID) paquetes_asignados, VEHICULOS.peso_max,
		CASE
			WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
			ELSE 2
		END as tipo
        FROM VEHICULOS
        LEFT JOIN TRAE ON TRAE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(	SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null)
        and TRAE.fecha_carga is null
        group by VEHICULOS.matricula;
        
        
SELECT VEHICULOS.matricula, count(PAQUETES.ID) paquetes_asignados, VEHICULOS.peso_max,
		CASE
			WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
			ELSE 2
		END as tipo
        FROM VEHICULOS
        LEFT JOIN TRAE ON TRAE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(	SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null)
        and TRAE.fecha_carga is null
        group by VEHICULOS.matricula, VEHICULOS.peso_max;
        

        
        
        
        
        
        insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula,peso) values ('Paaabbb1',18,1,'casa','12312312',0.56);
SELECT SLEEP(1);
insert into TRAE (matricula,ID_paquete) values('ABC1234',20);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=20;
SELECT SLEEP(1);
call descargar_trae(20,1,@error);
insert into REPARTE (matricula,ID_paquete) values ('ABD2399',20);

insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula,peso) values ('Paaabbb2',18,1,'casa','12343223',0.3);
insert into TRAE (matricula,ID_paquete) values('ABC1234',21);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=21;
SELECT SLEEP(1);
call descargar_trae(21,3,@error);
call lote_0('Laaabbb1',3,2,5,@ID,@error); -- QQQQQQQQQQQ
select @error, @ID;
SELECT SLEEP(1);
insert into PAQUETES_LOTES(ID_paquete,ID_lote) values(21,12);
SELECT SLEEP(1);
update LOTES set fecha_pronto=current_timestamp() where ID=12;

insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula,peso) values ('Lbcabd23',18,1,'casa','98712367',1.5);
        
use surno;
 select * from `users`;
 select * from CONDUCEN where CI="12345678";
 
INSERT INTO ALMACENES (ID, nombre, direccion, longitud, latitud, baja) VALUES('25', 'casa', 'casa casa, Montevideo Uruguay', '-56.19143', '-34.90314', 0);
INSERT INTO ALMACENES_PROPIOS(ID)VALUES(25);
INSERT INTO users ( ID, user, password, rol, email, email_verified_at, remember_token) VALUES ('50', '12312312.25', '$2y$10$39freduj580sVlnfMfSKaecR56yarB1p6tb87JwLDe9B.U5C8BV5.', '1', 'surnotech@gmail.com', '2023-11-13 15:44:13', 'ZbsxkcBwmeH5dpUgChpjzgCjzLVNmvzr4X6c5Xpq5SoTfvffhkQwELtDiuOZ');

SELECT LLEVA.Id_lote,
        CASE
            WHEN fecha_descarga is not null THEN fecha_descarga
            ELSE fecha_carga
            END as fecha,
        CASE
            WHEN fecha_descarga is not null THEN DESTINO_LOTE.ID_almacen
            ELSE LOTES.ID_almacen
        END as almacen,
        CASE
            WHEN exists( select ID_almacen from ORDENES where id_troncal = 5 and id_almacen=almacen and baja =0) THEN 1
            ELSE 0
        END as esta
         FROM LLEVA
         INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
         INNER JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
         where matricula='DEF5678'
         and fecha_carga is not null
         order by fecha DESC
         limit 2;
         
		 SELECT DESTINO_LOTE.*
         FROM LLEVA
         INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
         INNER JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
         where matricula='DEF5678'
         and fecha_carga is not null
         order by fecha_carga DESC
         limit 2;
         
         SELECT LLEVA.Id_lote,
                CASE
                    WHEN fecha_descarga is not null THEN fecha_descarga
                    ELSE fecha_carga
                    END as fecha,
                CASE
                    WHEN fecha_descarga is not null THEN DESTINO_LOTE.ID_almacen
                    ELSE LOTES.ID_almacen
                END as almacen,
                CASE
					WHEN exists( select ID_almacen from ORDENES where id_troncal = 5 and id_almacen=almacen and baja =0) THEN 1
					ELSE 0
				END as esta
                 FROM LLEVA
                 INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
                 INNER JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
                 where !(fecha_descarga is not null and DESTINO_LOTE.ID_almacen=4) and !(fecha_descarga is null and LOTES.ID_almacen=4)
                 and matricula='DEF5678'
                 order by fecha DESC
                 limit 1;

SELECT orden
        FROM ORDENES
        WHERE ID_almacen=4
        AND ID_troncal=5;
        
        SELECT * FROM DESTINO_LOTE;
SELECT LOTES.ID AS id,LOTES.codigo AS codigo,LOTES.ID_ALMACEN AS origen, LOTES.fecha_pronto pronto,DESTINO_LOTE.ID_almacen destino,DESTINO_LOTE.ID_troncal troncal,round(peso,2) peso,cantidad
        FROM LOTES INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LOTES.ID
        INNER JOIN PESO_LOTES ON PESO_LOTES.LOTE = DESTINO_LOTE.ID_lote
        WHERE LOTES.ID NOT IN (SELECT ID_lote FROM LLEVA)
        AND LOTES.fecha_cerrado IS NULL
        AND LOTES.fecha_pronto IS NOT NULL
        ORDER BY LOTES.fecha_pronto ASC;
        
SELECT * FROM LOTES;

insert into DESTINO_LOTE VALUES(26,6,5);

SELECT VEHICULOS.matricula, ifnull(round(sum(peso),2),0) carga_asignada, VEHICULOS.peso_max, max(LOTES.ID_troncal) troncal
        FROM CAMIONES
        INNER JOIN VEHICULOS ON VEHICULOS.matricula=CAMIONES.matricula
        LEFT JOIN (select * from LLEVA where fecha_carga is null) LLEVA ON VEHICULOS.matricula=LLEVA.matricula
        LEFT JOIN PESO_LOTES ON PESO_LOTES.lote = LLEVA.ID_lote
        LEFT JOIN LOTES ON LOTES.ID= LLEVA.ID_lote
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT TRAE.matricula
								FROM TRAE
								where fecha_carga is null)
        group by VEHICULOS.matricula, VEHICULOS.peso_max
        having carga_asignada > 2600
        and (troncal = 5 or troncal is null);
use surno;
SELECT * FROM PAQUETES;
UPDATE LLEVA SET fecha_descarga=current_timestamp where id_lote=26;
UPDATE LLEVA SET fecha_descarga=current_timestamp() where id_lote=5;
select * from CONDUCEN WHERE matricula='PQR1234';

select * from PAQUETES;
#paquete 27
insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula,peso) values ('Pfeavk29',18,1,'casa','12312312',0.56);
SELECT SLEEP(1);
insert into TRAE (matricula,ID_paquete) values('ABC1234',27);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=27;
SELECT SLEEP(1);
call descargar_trae(27,1,@error);
select * from PAQUETES;


#paquete 24
insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula,peso) values ('Paaabb24',18,2,'casa','12312312',0.56);
SELECT SLEEP(1);
insert into TRAE (matricula,ID_paquete) values('ABC1234',24);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=24;
SELECT SLEEP(1);
call descargar_trae(24,2,@error);

#paquete 25
insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula,peso) values ('Paaabb25',18,3,'casa','12312312',0.56);
SELECT SLEEP(1);
insert into TRAE (matricula,ID_paquete) values('ABC1234',25);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=25;
SELECT SLEEP(1);
call descargar_trae(25,3,@error);
SELECT * from PAQUETES;
#paquete 26
insert into PAQUETES (codigo,id_almacen,id_pickup,direccion,cedula,peso) values ('Paaabb26',18,2,'casa','12312312',0.56);
SELECT SLEEP(1);
insert into TRAE (matricula,ID_paquete) values('ABC1234',26);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=26;
SELECT SLEEP(1);
call descargar_trae(26,2,@error);
insert into REPARTE (matricula,ID_paquete) values ('CDE3450',25);
update REPARTE set fecha_carga=current_timestamp where ID_paquete=25;
/*insert into REPARTE (matricula,ID_paquete) values ('ABD2399',20);
SELECT SLEEP(1);
update REPARTE set fecha_carga=current_timestamp where ID_paquete=20;
SELECT SLEEP(1);
call entregar_paquete(20,@error);
select * from TRAE;*/
SELECT * FROM PAQUETES_ALMACENES;
select * from TRAE;

SELECT VEHICULOS.matricula, ifnull(c.paquetes_asignados,0)paquetes_asignados, VEHICULOS.peso_max,
		CASE
			WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
			ELSE 2
		END as tipo
        FROM VEHICULOS
        LEFT JOIN (SELECT count(ID_paquete) as paquetes_asignados, matricula 
					from TRAE 
					WHERE fecha_carga is not null 
                    and fecha_descarga is null 
                    group by matricula) c ON c.matricula = VEHICULOS.matricula
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(	SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null);
       

       
SELECT * FROM TRAE;
SELECT count(ID_paquete) as paquetes_asignados, matricula from TRAE WHERE fecha_carga is not null and fecha_descarga is null group by matricula;


SELECT ALMACENES.*, PAQUETES.ID
            FROM PAQUETES
            INNER JOIN ALMACENES ON ALMACENES.ID = PAQUETES.ID_almacen
            where ID_almacen=8
            and hasta is null;
            
            
SELECT VEHICULOS.matricula, ifnull(c.paquetes_asignados,0)paquetes_asignados, VEHICULOS.peso_max,
        CASE
            WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
            ELSE 2
        END as tipo
        FROM VEHICULOS
        LEFT JOIN (SELECT count(ID_paquete) as paquetes_asignados, matricula
                    from TRAE
                    WHERE fecha_carga is not null
                    and fecha_descarga is null
                    group by matricula) c ON c.matricula = VEHICULOS.matricula
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(    SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
        and VEHICULOS.matricula not in(    SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(    SELECT TRAE.matricula
                                        FROM TRAE
                                        INNER JOIN PAQUETES ON PAQUETES.ID=TRAE.ID_paquete
                                        where fecha_carga is null
                                        and ID_almacen != 2);