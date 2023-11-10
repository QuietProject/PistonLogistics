CREATE OR REPLACE VIEW PAQUETES_EN_ALMACENES AS
SELECT ID as paquete, paquetes_almacenes.ID_almacen as almacen, paquetes_almacenes.desde as desde, PAQUETES.estado as estado 
FROM PAQUETES
INNER JOIN (select * from PAQUETES_ALMACENES where hasta is null)as paquetes_almacenes ON paquetes_almacenes.ID_paquete=PAQUETES.ID;

-- select * from paquetes_en_almacenes;

CREATE OR REPLACE VIEW PAQUETES_EN_LOTES AS
SELECT ID as paquete, paquetes_lotes.ID_lote as almacen, paquetes_lotes.desde as desde, PAQUETES.estado as estado 
FROM PAQUETES
INNER JOIN (select * from PAQUETES_LOTES where hasta is null) as paquetes_lotes ON paquetes_lotes.ID_paquete=PAQUETES.ID;

-- select * from paquetes_en_almacenes;
-- Es para una validacion
CREATE OR REPLACE VIEW ALMACENES_CLIENTES_DE_ALTA AS
SELECT ALMACENES_CLIENTES.ID AS almacenCliente
FROM ALMACENES_CLIENTES
INNER JOIN CLIENTES ON CLIENTES.RUT = ALMACENES_CLIENTES.RUT
INNER JOIN ALMACENES ON ALMACENES_CLIENTES.ID = ALMACENES.ID
WHERE CLIENTES.baja=0 AND ALMACENES.baja=0;


-- LOS LOTES QUE ESTAN EN UN ALMACEN
CREATE OR REPLACE VIEW LOTES_EN_ALMACENES AS
SELECT LOTES.ID ID_lote,
CASE
    WHEN LLEVA.fecha_carga is null THEN LOTES.ID_almacen
    WHEN LLEVA.fecha_descarga is not null THEN DESTINO_LOTE.ID_almacen
END AS ID_almacen
FROM LOTES
LEFT JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote=LOTES.ID
LEFT JOIN LLEVA ON LLEVA.ID_LOTE = LOTES.ID
WHERE LLEVA.fecha_carga IS NULL OR LLEVA.fecha_descarga IS NOT NULL ;

-- EL PESO DE CADA LOTE PRONTO Y ABIERTO
CREATE OR REPLACE VIEW PESO_LOTES AS
SELECT sum(peso) as peso, count(PAQUETES.ID) as cantidad, PAQUETES_LOTES.ID_lote AS lote 
from PAQUETES_LOTES
INNER JOIN PAQUETES ON PAQUETES_LOTES.ID_paquete= PAQUETES.ID
INNER JOIN LOTES ON PAQUETES_LOTES.ID_lote= LOTES.ID
where fecha_pronto is not null
and PAQUETES_LOTES.hasta is null
and fecha_cerrado is null
group by PAQUETES_LOTES.ID_lote;









