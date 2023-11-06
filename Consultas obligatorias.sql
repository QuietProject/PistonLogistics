USE surno;
-- 1. MOSTRAR LOS PAQUETES ENTREGADOS EN EL MES DE MAYO DEL 2023 CON DESTINO A LA CIUDAD DE MELO

select * from PAQUETES where direccion like('% melo') AND '2023-05-01'<=cast(fecha_registrado as date) and cast(fecha_registrado as date) <'2023-06-01';

-- 2. MOSTRAR TODOS LOS ALMACENES Y LOS PAQUETES QUE FUERON ENTREGADOS EN LOS MISMOS DURANTE EL 2023, ORDENARLOS ADEMAS DE LOS QUE RECIBIERON MAS PAQUETES A LOS QUE RECIBIERON MENOS.
select cantidad.* , PAQUETES_ALMACENES.ID_paquete
from (select ID_almacen,  count(*) as "cantidad" from PAQUETES_ALMACENES group by ID_almacen) cantidad
inner join PAQUETES_ALMACENES on PAQUETES_ALMACENES.ID_almacen = cantidad.ID_almacen
where YEAR(PAQUETES_ALMACENES.desde)= 2023 OR YEAR(PAQUETES_ALMACENES.hasta)= 2023
order by cantidad.cantidad DESC;
-- 3. MOSTRAR TODOS LOS CAMIONES REGISTRADOS Y QUE TAREA SE ENCUENTRAN REALIZANDO EN ESTE MOMENTO 

select VEHICULOS.matricula,
CASE
    WHEN LLEVA.id_lote is not null and TRAE.ID_paquete is not null THEN 'El camion esta llevando lotes y trayendo paquetes'
    WHEN LLEVA.id_lote is not null THEN 'El camion esta llevando lotes'
    WHEN TRAE.ID_paquete is not null THEN 'El camion esta trayendo paquetes'
    WHEN VEHICULOS.es_operativo=0 THEN 'El camion esta fuera de servicio'
    ELSE 'El camion no esta realizando nunguna tarea'
  END AS MATRICULA
from VEHICULOS
LEFT JOIN (select * from LLEVA where fecha_descarga is null limit 1) LLEVA ON VEHICULOS.matricula = LLEVA.matricula
LEFT JOIN (select * from TRAE where fecha_descarga is null limit 1) TRAE ON VEHICULOS.matricula = TRAE.matricula
where VEHICULOS.matricula in (select matricula from CAMIONES)
;

-- 4. MOSTRAR TODOS LOS CAMIONES QUE VISITARON DURANTE EL MES DE JUNIO UN ALMACEN DADO

select distinct LLEVA.matricula
from LLEVA
left join LOTES on LOTES.id=LLEVA.ID_lote
left join DESTINO_LOTE on DESTINO_LOTE.ID_lote=LOTES.ID
where LOTES.ID_almacen=2 or (DESTINO_LOTE.ID_almacen=2 and LLEVA.fecha_descarga is not null);

-- 5. MOSTRAR DESTINO, LOTE, ALMACEN DE DESTINO Y CAMIÓN QUE TRANSPORTA UN PAQUETE DADO.

SELECT PAQUETES.direccion, PAQUETES.id_pickup as 'almacen destino', LOTES.ID as lote ,LLEVA.matricula
FROM PAQUETES
LEFT JOIN PAQUETES_LOTES ON PAQUETES.id = PAQUETES_LOTES.ID_paquete
LEFT JOIN LOTES ON PAQUETES_LOTES.ID_lote = LOTES.ID
LEFT JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
LEFT JOIN LLEVA ON LOTES.id = LLEVA.id_lote
WHERE PAQUETES.ID= 6;

-- 6. MOSTRAR EL IDENTIFICADOR DEL PAQUETE, IDENTIFICADOR DE LOTE, MATRICULA DEL CAMION QUE LO TRANSPORTA, ALMACEN DE DESTINO, DIRECCIÓN FINAL Y EL ESTADO DEL ENVÍO, PARA LOS PAQUETES QUE SE RECIBIERON HACE MAS DE 3 DÍAS.
SELECT  PAQUETES.id as 'ID PAQUETE', LOTES.id as 'ID LOTE' ,
CASE
    WHEN TRAE.matricula is not null and TRAE.fecha_descarga is null THEN TRAE.matricula
    WHEN LLEVA.matricula is not null and LLEVA.fecha_descarga is null THEN LLEVA.matricula
    WHEN REPARTE.matricula is not null and REPARTE.fecha_descarga is null THEN REPARTE.matricula
    ELSE null 
  END AS MATRICULA,
  PAQUETES.ID_pickup 'ALMACEN DESTINO', PAQUETES.direccion 'DIRECCION FINAL' ,PAQUETES.estado as 'ESTADO ENVIO'
FROM PAQUETES
LEFT JOIN PAQUETES_LOTES as PAQUETES_LOTES ON PAQUETES.id = PAQUETES_LOTES.id_paquete AND hasta is null
LEFT JOIN LOTES ON PAQUETES_LOTES.ID_lote = LOTES.ID
LEFT JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
LEFT JOIN LLEVA ON LOTES.ID = LLEVA.id_lote
LEFT JOIN TRAE ON PAQUETES.ID = TRAE.id_paquete
LEFT JOIN REPARTE ON PAQUETES.ID = REPARTE.id_paquete
WHERE PAQUETES.fecha_registrado < DATE_SUB(current_timestamp(), INTERVAL 3 DAY);

-- 7. MOSTRAR TODOS LOS PAQUETES A LOS QUE AÚN NO SE LES HA ASIGNADO UN LOTE Y LA FECHA EN LA QUE FUERON RECIBIDOS.

select PAQUETES_ALMACENES.ID_paquete PAQUETE, PAQUETES_ALMACENES.desde 'FECHA RECIBIDO'
from PAQUETES_ALMACENES
where PAQUETES_ALMACENES.hasta IS NULL;

-- 8. MOSTRAR MATRICULA DE LOS CAMIONES QUE SE ENCUENTRAN FUERA DE SERVICIO.

select matricula
from VEHICULOS
where es_operativo=0 and baja=0 and matricula in(select matricula from CAMIONES);

-- 9. MOSTRAR TODOS LOS CAMIONES QUE NO TIENEN UN CONDUCTOR ASIGNADO Y SU ESTADO OPERATIVO.
select *from VEHICULOS
where es_operativo=1 and baja=0 and matricula in(select matricula from CAMIONES) and matricula not in(select matricula from CONDUCEN where hasta is null);

-- 10. MOSTRAR TODOS LOS ALMACENES QUE SE ENCUENTRAN EN UN RECORRIDO DADO.

select ALMACENES.* 
from ORDENES
inner join ALMACENES on ORDENES.ID_almacen=ALMACENES.ID
where ORDENES.ID_troncal=2 and ALMACENES.baja=0;