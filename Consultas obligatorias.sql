USE surno;
-- 1. MOSTRAR LOS PAQUETES ENTREGADOS EN EL MES DE MAYO DEL 2023 CON DESTINO A LA CIUDAD DE MELO

select * from paquetes where direccion like('% melo') AND '2023-05-01'<=cast(fecha_registrado as date) and cast(fecha_registrado as date) <'2023-06-01';

-- 2. MOSTRAR TODOS LOS ALMACENES Y LOS PAQUETES QUE FUERON ENTREGADOS EN LOS MISMOS DURANTE EL 2023, ORDENARLOS ADEMAS DE LOS QUE RECIBIERON MAS PAQUETES A LOS QUE RECIBIERON MENOS.
/*select *
from paquetes_lotes
inner join
where YEAR(lotes) = 2023;

select * 
from paquetes_lotes
inner join_lotes
;
SELECT
*
    lote.ID_almacen AS NombreAlmacen,
    paquetes_lotes.ID_paquete AS NombrePaquete,
    COUNT(*) AS CantidadPaquetesEntregados
FROM lotes
inner join paquetes_lotes ON lotes.ID = paquetes_lotes.ID_lote
inner join estados on estados.ID_lote=lotes.ID
/*WHERE
    YEAR(estados.fecha) = 2023
GROUP BY
    A.Nombre, P.Nombre
ORDER BY
    CantidadPaquetesEntregados DESC;

*/
-- 3. MOSTRAR TODOS LOS CAMIONES REGISTRADOS Y QUE TAREA SE ENCUENTRAN REALIZANDO EN ESTE MOMENTO 

select distinct vehiculos.*,
CASE
    WHEN lleva.id_lote is not null and trae.ID_paquete is not null THEN 'El camion esta llevando lotes y trayendo paquetes'
    WHEN lleva.id_lote is not null THEN 'El camion esta llevando lotes'
    WHEN trae.ID_paquete is not null THEN 'El camion esta trayendo paquetes'
    WHEN vehiculos.es_operativo=0 THEN 'El camion esta fuera de servicio'
    ELSE 'El camion no esta realizando nunguna tarea	'
  END AS MATRICULA
from vehiculos
LEFT JOIN (select * from lleva where fecha_descarga is null) lleva ON vehiculos.matricula = lleva.matricula
LEFT JOIN (select * from trae where fecha_descarga is null) trae ON vehiculos.matricula = trae.matricula
where vehiculos.matricula in (select matricula from camiones)
group by vehiculos.matricula;

/*insert into lotes (ID_troncal, ID_almacen) values(1,2);
insert into lleva (matricula,ID_lote) values ('PQR1234',12);
insert into trae (ID_paquete,matricula) values (15,'PQR1234');
delete from trae where ID_paquete >15;
select* from trae;*/


-- 4. MOSTRAR TODOS LOS CAMIONES QUE VISITARON DURANTE EL MES DE JUNIO UN ALMACEN DADO

select distinct lleva.matricula
from lleva
left join lotes on lotes.id=lleva.ID_lote
left join destino_lote on destino_lote.ID_lote=lotes.ID
where lotes.ID_almacen=2 or (destino_lote.ID_almacen=2 and lleva.fecha_descarga is not null);

-- 5. MOSTRAR DESTINO, LOTE, ALMACEN DE DESTINO Y CAMIÓN QUE TRANSPORTA UN PAQUETE DADO.

SELECT paquetes.direccion, paquetes.id_pickup as 'almacen destino', lotes.ID as lote ,lleva.matricula
FROM paquetes
LEFT JOIN paquetes_lotes ON paquetes.id = paquetes_lotes.ID_paquete
LEFT JOIN lotes ON paquetes_lotes.ID_lote = lotes.ID
LEFT JOIN destino_lote ON lotes.ID = destino_lote.ID_lote
LEFT JOIN lleva ON lotes.id = lleva.id_lote
WHERE paquetes.ID= 6;

-- 6. MOSTRAR EL IDENTIFICADOR DEL PAQUETE, IDENTIFICADOR DE LOTE, MATRICULA DEL CAMION QUE LO TRANSPORTA, ALMACEN DE DESTINO, DIRECCIÓN FINAL Y EL ESTADO DEL ENVÍO, PARA LOS PAQUETES QUE SE RECIBIERON HACE MAS DE 3 DÍAS.

SELECT paquetes.ID, lotes.ID, lleva.ID_lote, lleva.fecha_descarga
FROM paquetes
LEFT JOIN paquetes_lotes ON paquetes.id = paquetes_lotes.ID_paquete
LEFT JOIN lotes ON paquetes_lotes.ID_lote = lotes.ID
LEFT JOIN destino_lote ON lotes.ID = destino_lote.ID_lote
LEFT JOIN lleva ON lotes.id = lleva.id_lote
WHERE paquetes.fecha_registrado < DATE_SUB(current_timestamp(), INTERVAL 0 DAY);

-- 6. MOSTRAR EL IDENTIFICADOR DEL PAQUETE, IDENTIFICADOR DE LOTE, MATRICULA DEL CAMION QUE LO TRANSPORTA, ALMACEN DE DESTINO, DIRECCIÓN FINAL Y EL ESTADO DEL ENVÍO, PARA LOS PAQUETES QUE SE RECIBIERON HACE MAS DE 3 DÍAS.

SELECT paquetes.id as 'ID PAQUETE', lotes.id as 'ID LOTE',
CASE
    WHEN trae.matricula is not null and trae.fecha_descarga is null THEN trae.matricula
    WHEN lleva.matricula is not null and lleva.fecha_descarga is null THEN lleva.matricula
    WHEN reparte.matricula is not null and reparte.fecha_descarga is null THEN reparte.matricula
    ELSE null
  END AS MATRICULA,
  destino_lote.ID_almacen as 'ALMACEN DESTINO', paquetes.direccion, paquetes.id_pickup,
  CASE
	WHEN paquetes.fecha_entregado is not null then 'Entregado'
    WHEN reparte.matricula is not null and reparte.fecha_descarga is null THEN 'Llevando hacia el destino final'
    WHEN lotes.ID is not null and tipo = 1 THEN 'Paquete esperando en pickUp'
    WHEN lleva.matricula is not null and lleva.fecha_descarga is null THEN 'Transportando hacia almacen secundario'
    WHEN trae.matricula is not null and trae.fecha_descarga is null THEN 'Trayendo hacia almacenes de QC'
    WHEN trae.ID_paquete is null THEN 'En almacenes del proveedor'
    ELSE 'En almacenes de QC'
  END AS 'ESTADO ENVIO'
  
FROM paquetes
LEFT JOIN (
SELECT paquetes_lotes.id_paquete, paquetes_lotes.id_lote, paquetes_lotes.fecha FROM paquetes_lotes INNER JOIN (
	SELECT id_paquete, MAX(fecha) AS max_fecha FROM paquetes_lotes GROUP BY id_paquete ) subquery
		ON paquetes_lotes.id_paquete = subquery.id_paquete AND paquetes_lotes.fecha = subquery.max_fecha 
) paquetes_lotes ON paquetes.id = paquetes_lotes.id_paquete
LEFT JOIN lotes ON paquetes_lotes.ID_lote = lotes.ID
LEFT JOIN destino_lote ON lotes.ID = destino_lote.ID_lote
LEFT JOIN lleva ON lotes.ID = lleva.id_lote
LEFT JOIN trae ON paquetes.ID = trae.id_paquete
LEFT JOIN reparte ON paquetes.ID = reparte.id_paquete
WHERE paquetes.fecha_registrado < DATE_SUB(current_timestamp(), INTERVAL 0 DAY);

-- 7. MOSTRAR TODOS LOS PAQUETES A LOS QUE AÚN NO SE LES HA ASIGNADO UN LOTE Y LA FECHA EN LA QUE FUERON RECIBIDOS.

select * 
from paquetes
where ID not in (select ID_paquete from trae where fecha_descarga is not null) and fecha_entregado is null;

-- 8. MOSTRAR MATRICULA DE LOS CAMIONES QUE SE ENCUENTRAN FUERA DE SERVICIO.

select matricula
from vehiculos
where es_operativo=0 and baja=0 and matricula in(select matricula from camiones);

-- 9. MOSTRAR TODOS LOS CAMIONES QUE NO TIENEN UN CONDUCTOR ASIGNADO Y SU ESTADO OPERATIVO.
select *from vehiculos
where es_operativo=1 and baja=0 and matricula in(select matricula from camiones) and matricula not in(select matricula from conducen where hasta is null);

-- 10. MOSTRAR TODOS LOS ALMACENES QUE SE ENCUENTRAN EN UN RECORRIDO DADO.

select ALMACENES.* 
from ordenes
inner join ALMACENES on ordenes.ID_almacen=ALMACENES.ID
where ordenes.ID_troncal=2 and almacenes.baja=0;


describe camioneros;



