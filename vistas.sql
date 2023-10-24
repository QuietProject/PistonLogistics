CREATE OR REPLACE VIEW paquetes_en_almacenes AS
SELECT ID as paquete, paquetes_almacenes.ID_almacen as almacen, paquetes_almacenes.desde as desde, paquetes.estado as estado 
FROM PAQUETES
INNER JOIN (select * from paquetes_almacenes where hasta is null)as paquetes_almacenes ON paquetes_almacenes.ID_paquete=paquetes.ID;

-- select * from paquetes_en_almacenes;

/*CREATE OR REPLACE VIEW paquetes_en_lotes AS
SELECT lotes.*, paquetes.estado
FROM (SELECT id_paquete, id_lote ,MAX(fecha) AS fecha FROM paquetes_lotes GROUP BY id_paquete ) AS lotes
INNER JOIN PAQUETES ON PAQUETES.ID = LOTES.ID_paquete
WHERE PAQUETES.estado in (4,5,6,9);*/
CREATE OR REPLACE VIEW paquetes_en_lotes AS
SELECT lotes.*, paquetes.estado
FROM (SELECT pl1.ID_paquete, pl1.ID_lote, pl1.fecha
FROM PAQUETES_LOTES AS pl1
INNER JOIN (
    SELECT ID_paquete, MAX(fecha) AS max_fecha
    FROM PAQUETES_LOTES
    GROUP BY ID_paquete
) AS pl2
ON pl1.ID_paquete = pl2.ID_paquete AND pl1.fecha = pl2.max_fecha) AS lotes
INNER JOIN PAQUETES ON PAQUETES.ID = LOTES.ID_paquete
WHERE PAQUETES.estado in (4,5,6,9);



