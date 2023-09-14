USE piston_logistics;
-- 1. MOSTRAR LOS PAQUETES ENTREGADOS EN EL MES DE MAYO DEL 2023 CON DESTINO A LA CIUDAD DE MELO
select * 
from paquetes where ciudad = 'melo' AND '2023-05-01'<=cast(fecha_registrado as date) and cast(fecha_registrado as date) <'2023-06-01';

-- 2. MOSTRAR TODOS LOS ALMACENES Y LOS PAQUETES QUE FUERON ENTREGADOS EN LOS MISMOS DURANTE EL 2023, ORDENARLOS ADEMAS DE LOS QUE RECIBIERON MAS PAQUETES A LOS QUE RECIBIERON MENOS.
/*select * 
from paquetes_lotes
inner join_lotes
;*/
SELECT
*
    /*lote.ID_almacen AS NombreAlmacen,
    paquetes_lotes.ID_paquete AS NombrePaquete,
    COUNT(*) AS CantidadPaquetesEntregados*/
FROM lotes
inner join paquetes_lotes ON lotes.ID = paquetes_lotes.ID_lote
inner join estados on estados.ID_lote=lotes.ID
/*WHERE
    YEAR(estados.fecha) = 2023
GROUP BY
    A.Nombre, P.Nombre
ORDER BY
    CantidadPaquetesEntregados DESC*/;


-- 3. MOSTRAR TODOS LOS CAMIONES REGISTRADOS Y QUE TAREA SE ENCUENTRAN REALIZANDO EN ESTE MOMENTO 



-- 4. MOSTRAR TODOS LOS CAMIONES QUE VISITARON DURANTE EL MES DE JUNIO UN ALMACEN DADO

select distinct lleva.matricula
from lleva
inner join lotes on lotes.id=lleva.ID_lote
inner join destino_lote on destino_lote.ID_lote=lotes.ID
where lotes.ID_almacen=6 or (destino_lote.ID_almacen=6 and lleva.fecha_descarga is not null);

-- 5. MOSTRAR DESTINO, LOTE, ALMACEN DE DESTINO Y CAMIÓN QUE TRANSPORTA UN PAQUETE DADO.

SELECT paquetes.calle, paquetes.numero, paquetes.ciudad, paquetes.id_pickup, lotes.ID ,destino_lote.ID_lote
FROM paquetes
LEFT JOIN paquetes_lotes ON paquetes.id = paquetes_lotes.ID_paquete
LEFT JOIN lotes ON paquetes_lotes.ID_lote = lotes.ID
LEFT JOIN destino_lote ON lotes.ID = destino_lote.ID_lote
LEFT JOIN lleva ON lotes.id = lleva.id_lote
WHERE paquetes.ID= 3;

-- 6. MOSTRAR EL IDENTIFICADOR DEL PAQUETE, IDENTIFICADOR DE LOTE, MATRICULA DEL CAMION QUE LO TRANSPORTA, ALMACEN DE DESTINO, DIRECCIÓN FINAL Y EL ESTADO DEL ENVÍO, PARA LOS PAQUETES QUE SE RECIBIERON HACE MAS DE 3 DÍAS.

SELECT *
FROM paquetes
LEFT JOIN paquetes_lotes ON paquetes.id = paquetes_lotes.ID_paquete
LEFT JOIN lotes ON paquetes_lotes.ID_lote = lotes.ID
LEFT JOIN destino_lote ON lotes.ID = destino_lote.ID_lote
LEFT JOIN lleva ON lotes.id = lleva.id_lote
WHERE paquetes.fecha_registrado < DATE_SUB(current_timestamp(), INTERVAL 3 DAY);

-- 6. MOSTRAR EL IDENTIFICADOR DEL PAQUETE, IDENTIFICADOR DE LOTE, MATRICULA DEL CAMION QUE LO TRANSPORTA, ALMACEN DE DESTINO, DIRECCIÓN FINAL Y EL ESTADO DEL ENVÍO, PARA LOS PAQUETES QUE SE RECIBIERON HACE MAS DE 3 DÍAS.
SELECT paquetes.id as 'ID PAQUETE', lotes.id as 'ID LOTE', 
CASE
    WHEN trae.matricula is not null and trae.fecha_descarga is null THEN trae.matricula
    WHEN lleva.matricula is not null and lleva.fecha_descarga is null THEN lleva.matricula
    WHEN reparte.matricula is not null and reparte.fecha_descarga is null THEN reparte.matricula
    ELSE null
  END AS MATRICULA,
  destino_lote.ID_almacen as 'ALMACEN DESTINO', paquetes.calle, paquetes.numero, paquetes.ciudad, paquetes.id_pickup,
  CASE
	WHEN paquetes.fecha_entregado is not null then 'Entregado'
    WHEN reparte.matricula is not null and reparte.fecha_descarga is null THEN 'LLevando hacia el destino'
    WHEN lleva.matricula is not null and lleva.fecha_descarga is null THEN 'Transportando hacia almacen secundario'
    WHEN trae.matricula is not null and trae.fecha_descarga is null THEN 'Trayendo hacia almacenes de QC'
    WHEN EXISTS (SELECT 1 FROM lotes WHERE lotes.ID = paquetes_lotes.ID_lote and lotes.ID not in (select 1 from lleva where lleva.ID_lote =paquetes_lotes.ID_lote) ) THEN 'En almacenes de QC'
    WHEN lotes.ID is not null and lleva.ID_lote is null THEN 'En almacenes de QC'
    WHEN trae.ID_paquete is null THEN 'En almacenes del proveedor'
  END AS 'ESTADO ENVIO'
  
FROM paquetes
LEFT JOIN paquetes_lotes ON paquetes.id = paquetes_lotes.ID_paquete
LEFT JOIN lotes ON paquetes_lotes.ID_lote = lotes.ID
LEFT JOIN destino_lote ON lotes.ID = destino_lote.ID_lote
LEFT JOIN lleva ON lotes.ID = lleva.id_lote
LEFT JOIN trae ON paquetes.ID = trae.id_paquete
LEFT JOIN reparte ON paquetes.ID = reparte.id_paquete
WHERE paquetes.fecha_registrado < DATE_SUB(current_timestamp(), INTERVAL 3 DAY);

/*INSERT INTO PAQUETES (ID_almacen, fecha_registrado, ID_pickup, calle, numero, ciudad, peso, volumen, fecha_entregado, mail, cedula)
VALUES
    (2, '2023-09-10 08:00:00', 4, 'Calle X', '111', 'Ciudad X', 15, 8, NULL, 'correoX@example.com', '44444444-4'),
    (2, '2023-09-09 09:30:00', 5, 'Calle Y', '222', 'Ciudad Y', 12, 6, NULL, 'correoY@example.com', '55555555-5'),
    (3, '2023-09-08 10:45:00', 6, 'Calle Z', '333', 'Ciudad Z', 10, 5, '2023-09-12 14:20:00', 'correoZ@example.com', '66666666-6');*/
-- 7. MOSTRAR TODOS LOS PAQUETES A LOS QUE AÚN NO SE LES HA ASIGNADO UN LOTE Y LA FECHA EN LA QUE FUERON RECIBIDOS.
select *
from paquetes
where ID not in (select ID_paquete from trae where fecha_descarga is not null);

-- 8. MOSTRAR MATRICULA DE LOS CAMIONES QUE SE ENCUENTRAN FUERA DE SERVICIO.
select matricula
from vehiculos
where es_operativo=0 and baja=0 and matricula in(select matricula from camiones);

-- 9. MOSTRAR TODOS LOS CAMIONES QUE NO TIENEN UN CONDUCTOR ASIGNADO Y SU ESTADO OPERATIVO.
select *
from vehiculos
where es_operativo=1 and baja=0 and matricula in(select matricula from camiones) and matricula not in(select matricula from conducen where hasta is null);

-- 10. MOSTRAR TODOS LOS ALMACENES QUE SE ENCUENTRAN EN UN RECORRIDO DADO.
select ALMACENES.* 
from ALMACENES_PROPIOS 
INNER JOIN ALMACENES on ALMACENES_PROPIOS.ID = ALMACENES.ID 
where ALMACENES_PROPIOS.ID in (select ID_almacen from ORDENES where ID_troncal in (select troncales.ID from troncales where baja=0)) and ALMACENES.baja=0;

/*INSERT INTO ALMACENES (nombre, calle, numero, latitud, longitud) VALUES
('Almacén D', 'Calle 1', '1232', 40.12456, -74.57920),
('Almacén E', 'Calle 2', '4561', 41.93654, -75.24536);
select * from ALMACENES;
insert into ALMACENES_PROPIOS (ID) values (7),(8);
select * from ALMACENES_PROPIOS;
INSERT INTO TRONCALES (nombre) values  ('troncal 5');
INSERT INTO ORDENES (ID_almacen,ID_troncal,orden) values (8,6,2);
select * from troncales;

update troncales set baja=1 where id=6;
update almacenes set baja=1 where id=6;
select * from ALMACENES_PROPIOS ;*/

