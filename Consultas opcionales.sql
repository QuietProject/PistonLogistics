-- CONSULTAS OPCIONALES

-- 1 MOSTRAR LA LISTA DE LOS PAQUETES Y SU ESTADO, QUE SE ENCUENTREN EN UN ALMACÉN ESPECÍFICO
SELECT PAQUETES.ID, PAQUETES.estado
FROM PAQUETES 
INNER JOIN PAQUETES_ALMACENES ON PAQUETES.ID = PAQUETES_ALMACENES.ID_paquete
WHERE PAQUETES_ALMACENES.hasta IS NULL AND PAQUETES_ALMACENES.ID_almacen=1;

-- 2 MOSTRAR LOS LOTES QUE LLEGARON A UN ALMACEN ESPECIFICO DURANE EL MES DE AGOSTO DE 2023
SELECT DESTINO_LOTE.ID_lote
FROM DESTINO_LOTE
INNER JOIN LLEVA ON LLEVA.ID_lote = DESTINO_LOTE.ID_lote
WHERE month(LLEVA.fecha_descarga)=8 and year(LLEVA.fecha_descarga)=2023 and DESTINO_LOTE.ID_almacen =1;

-- 3. MUESTRA LA INFORMACIÓN DE LOS CAMIONES QUE ACTUALMENTE SE ENCUENTREN EN RUTA, JUNTO CON SU CARGA, DESTINO Y HORARIO ESTIMADO DE LLEGADA.
-- LA CARGA ES EL PESO O CADA LOTE Y PAQUETE QUE TRAE?

SELECT CAMIONES.matricula CAMION, sum(PAQUETES.peso) CARGA
FROM CAMIONES
INNER JOIN LLEVA ON CAMIONES.matricula = LLEVA.matricula AND LLEVA.fecha_descarga IS NULL
INNER JOIN PAQUETES_LOTES ON LLEVA.ID_lote =  PAQUETES_LOTES.ID_lote
INNER JOIN PAQUETES ON PAQUETES.ID = PAQUETES_LOTES.ID_paquete
group by CAMIONES.matricula;

UPDATE `surno`.`lleva` SET `fecha_descarga` = null WHERE (`ID_lote` = '13');
UPDATE `surno`.`lleva` SET `fecha_descarga` = null WHERE (`ID_lote` = '12');
UPDATE `surno`.`PAQUETES` SET `peso` = '1234' WHERE (`ID` = '22');
insert into PAQUETES_LOTES (ID_lote,ID_paquete) VALUES (12,22);

-- 4 MUESTRE INFORMACIÓN DE UN PAQUETE ESPECÍFICO QUE YA HAYA SIDO ENTREGADO. ESTO IMPLICA, IDENTIFICADOR DE: LOTE, RECORRIDO, CAMIÓN QUE LO TRANSPORTÓ, ALMACÉN DONDE SE ALMACENÓ, CAMIONETA QUE HIZO EL ÚLTIMO TRAMO Y DIRECCIÓN FINAL.

/*SELECT PAQUETES.*, PAQUETES_LOTES.ID_lote
FROM (SELECT * FROM PAQUETES WHERE ID = 21) PAQUETES
LEFT JOIN PAQUETES_LOTES ON PAQUETES_LOTES.ID_paquete = PAQUETES.ID
INNER JOIN PAQUETES_ALMACENES ON PAQUETES_ALMACENES.ID_paquete = PAQUETES.ID
;*/

SELECT * FROM PAQUETES WHERE ID = 21;
SELECT ID_lote FROM PAQUETES_LOTES WHERE ID_paquete = 21;
SELECT MATRICULA FROM LLEVA WHERE ID_LOTE in (SELECT ID_lote FROM PAQUETES_LOTES WHERE ID_paquete = 21);
SELECT ID_almacen FROM PAQUETES_ALMACENES WHERE ID_paquete=21;
SELECT matricula FROM reparte WHERE ID_paquete=21;
SELECT matricula FROM trae WHERE ID_paquete=21;

-- 5 DADO UN CAMIÓN, MOSTRAR LOS RECORRIDOS REALIZADOS Y LOS ALMACENES VISITADOS EN EL ÚLTIMO MES.
SELECT DESTINO_LOTE.ID_TRONCAL 'RECORIDO REALIZADO', LOTES.ID_almacen 'ALMACEN ORIGEN VISITADO', DESTINO_LOTE.ID_almacen 'ALMACEN DESTINO VISITADO'
FROM LLEVA
INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LLEVA.ID_lote
INNER JOIN LOTES ON DESTINO_LOTE.ID_lote = LOTES.ID
WHERE month(LLEVA.fecha_descarga)+1=month(current_timestamp()) and LLEVA.matricula='MNO7890'; 

-- 6 MOSTRAR LOS PAQUETES ENTREGADOS EN EL MES DE JULIO DE 2023, ORDENADOS POR FECHA DE ENTREGA DE FORMA DESCENDENTE
SELECT *
FROM PAQUETES
WHERE month(fecha_entregado)=8 AND year(fecha_entregado)=2023
ORDER BY fecha_entregado DESC;

-- 7 MOSTRAR LOS CAMIONES QUE NO HICIERON NINGÚN RECORRIDO ENTRE EL 10 Y 17 DE JULIO DE 2023
SELECT * 
FROM CAMIONES
WHERE matricula NOT IN( SELECT matricula
						FROM LLEVA
                        WHERE (day(fecha_carga) BETWEEN 10 AND 17 AND month(fecha_carga)=7 AND  year(fecha_carga)=2023) 
                        OR (day(fecha_descarga) BETWEEN 10 AND 17 AND month(fecha_descarga)=7 AND  year(fecha_descarga)=2023));

-- 8 MOSTRAR LA LISTA DE ALMACENES QUE PERTENECEN A UN RECORRIDO DADO Y SU DISTANCIA CON EL CENTRO DE DISTRIBUCIÓN.
SELECT ID_almacen
FROM ORDENES
WHERE ID_troncal=1;

-- 9 MUESTRA LOS RECORRIDOS UTILIZADOS EN MAYO DEL 2023, ORDENADOS POR LA CANTIDAD DE CAMIONES QUE LO RECORRIERON DE MÁS A MENOS.
SELECT count(DISTINCT matricula)'CANTIDAD DE CAMIONES', LOTES.ID_troncal TRONCAL
FROM LLEVA
INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
WHERE month(LLEVA.fecha_descarga)=5 AND  year(LLEVA.fecha_descarga)=2023
group by LOTES.ID_troncal
order by count(matricula) DESC;

insert into lotes (ID_almacen,ID_troncal,fecha_creacion,fecha_pronto) VALUES (2,1,'2023-09-06 00:29:29','2023-09-07 00:29:29');
insert into lleva (ID_lote,matricula,fecha_carga, fecha_descarga) VALUES (16,'MNO7890','2023-09-08 00:29:29','2023-09-09 00:29:29');

-- 10 MOSTRAR MATRÍCULA DEL CAMIÓN E IDENTIFICADOR DE ALMACÉN/ES Y RECORRIDO, DE LOS CAMIONES QUE EN SEPTIEMBRE DEL 2023 VIAJARON CON MENOS DEL 100% DE SU CARGA.
SELECT sum(PAQUETES.peso)
FROM PAQUETES_LOTES
INNER JOIN PAQUETES ON PAQUETES.ID = PAQUETES_LOTES.ID_paquete
-- OLVIDATE

WHERE PAQUETES_LOTEs.ID_lote=1