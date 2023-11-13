-- MISMA TRONCAL

SELECT origen.ID_almacen, destino.ID_almacen, origen.ID_troncal, destino.ID_troncal
FROM (
select ORDENES.* from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1
) origen
INNER JOIN (
select ORDENES.* from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=4
) destino ON origen.ID_troncal = destino.ID_troncal;

-- ENCONTRAR ALMACEN MEDIO ENTRE 2 ALMACENES DE DISTINTA TRONCAL QUE INTERSECTAN 
-- select o1.ID_almacen as almacen, o1.ID_troncal as troncal
select *
from (
select * 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
AND ID_almacen!=1
) o1
JOIN (
select * 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=6)
AND ID_almacen!=6) o2 ON o1.ID_almacen=o2.ID_almacen;

-- having ID_troncal =1 and ID_troncal=3;

select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1;

select * 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
AND ID_almacen!=1;

select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8;

select * 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8)
AND ID_almacen!=8;


-- TRONCALES DEL ALMACEN 1
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1;

-- ALMACENES A LOS QUE SE PUEDE IR DESDE EL ALMACEN 1
select ID_almacen 
from ORDENES
where id_troncal in (


select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)


AND ID_almacen!=1;

-- TRONCALES A LAS QUE SE PUEDE IR DESDE LOS ALMACENES QUE VEN AL ALMACEN 1 Y QUE NO SE PUEDE LLEGAR DIRECTAMENTE DEL ALMACEN 1
select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
AND ID_almacen!=1)
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1
);

select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8)
AND ID_almacen!=8)
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8);


-- TRONCALES MEDIAS ENTRE DOS TRONCALES
select *
from(
select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
AND ID_almacen!=1)
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
)as d
INNER JOIN (
select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8)
AND ID_almacen!=8)
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8)
)as o ON d.id_troncal = o.id_troncal;



-- ENCONTRAR PROXIMO ALMACEN AL QUE TIENE QUE IR UN LOTE QUE CUYO DESINO ES UN ALMACEN QUE ESTA EN UNA TRONCAL QUE INTERSECTA CON OTRA TRONCAL QUE INTERSECTA CON UNA TRONCAL DEL ALMACEN ORIGEN.

select o1.ID_almacen, o1.ID_troncal
from (
select * 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
AND ID_almacen!=1
) o1
JOIN (
select * 
from ORDENES
where id_troncal in (
select d.ID_troncal
from(
select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
AND ID_almacen!=1)
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=1)
)as d
INNER JOIN (
select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8)
AND ID_almacen!=8)
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=8)
)as o ON d.id_troncal = o.id_troncal)
) o2 ON o1.ID_almacen=o2.ID_almacen;




set @o =8;
set @d =1;
select o1.ID_almacen, o1.ID_troncal
from (
select * 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=@o) -- origen
AND ID_almacen!=@o 											-- origen
) o1
JOIN (
select * 
from ORDENES
where id_troncal in (
select d.ID_troncal
from(
select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=@o) -- origen
AND ID_almacen!=@o)											 -- origen
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=@o) -- origen
)as d
INNER JOIN (
select distinct ID_troncal 
from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
select ID_almacen 
from ORDENES
where id_troncal in (
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=@d) -- destino
AND ID_almacen!=@d) 									     -- destino
AND id_troncal not in(
select distinct ID_troncal from ORDENES
INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=@d) -- destino
)as o ON d.id_troncal = o.id_troncal)
) o2 ON o1.ID_almacen=o2.ID_almacen;

INSERT INTO PAQUETES (codigo, ID_almacen, fecha_registrado, ID_pickup, direccion, peso, fecha_entregado, mail, estado,cedula) VALUES
("PeUiL3dt" ,2, '2023-09-15 07:37:40',1  ,'Calle 123, florida', 1000, NULL, 'correo1@example.com',1,'47283726');-- 1 ok

select * from PAQUETES where codigo='PEUiL3dt';
select * from PAQUETES;




SELECT VEHICULOS.matricula, ifnull(sum(peso),0) carga_asignada, VEHICULOS.peso_max, max(LOTES.ID_troncal) troncal
        FROM CAMIONES
        INNER JOIN VEHICULOS ON VEHICULOS.matricula=CAMIONES.matricula
        LEFT JOIN (select * from LLEVA where fecha_carga is null) LLEVA ON VEHICULOS.matricula=LLEVA.matricula
        LEFT JOIN PESO_LOTES ON PESO_LOTES.lote = LLEVA.ID_lote
        LEFT JOIN LOTES ON LOTES.ID= LLEVA.ID_lote
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        group by VEHICULOS.matricula
        having carga_asignada + ?<peso_max
        and troncal = ? or troncal is null;