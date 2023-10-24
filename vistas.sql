CREATE OR REPLACE VIEW paquetes_en_almacenes AS
SELECT ID as paquete, paquetes_almacenes.ID_almacen as almacen, paquetes_almacenes.desde as desde, paquetes.estado as estado 
FROM PAQUETES
INNER JOIN (select * from paquetes_almacenes where hasta is null)as paquetes_almacenes ON paquetes_almacenes.ID_paquete=paquetes.ID;

-- select * from paquetes_en_almacenes;

CREATE OR REPLACE VIEW paquetes_en_lotes AS
SELECT ID as paquete, paquetes_lotes.ID_lote as almacen, paquetes_lotes.desde as desde, paquetes.estado as estado 
FROM PAQUETES
INNER JOIN (select * from paquetes_lotes where hasta is null) as paquetes_lotes ON paquetes_lotes.ID_paquete=paquetes.ID;

-- select * from paquetes_en_almacenes;

