CREATE OR REPLACE VIEW paquetes_en_almacenes AS
SELECT ID as paquete, paquetes_almacenes.ID_almacen as almacen, paquetes_almacenes.desde as desde, paquetes.estado as estado 
FROM PAQUETES
INNER JOIN (select * from paquetes_almacenes where hasta is null)as paquetes_almacenes ON paquetes_almacenes.ID_paquete=paquetes.ID;

-- select * from paquetes_en_almacenes;

CREATE OR REPLACE VIEW paquetes_en_lotes AS
SELECT lotes.*, paquetes.estado
FROM (SELECT id_paquete, id_lote ,MAX(fecha) AS fecha FROM paquetes_lotes GROUP BY id_paquete ) AS lotes
INNER JOIN PAQUETES ON PAQUETES.ID = LOTES.ID_paquete
WHERE PAQUETES.estado in (4,5,6,9);

#select * from paquetes_en_lotes;    
