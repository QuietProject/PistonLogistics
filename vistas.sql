CREATE OR REPLACE VIEW PAQUETES_EN_ALMACENES AS
SELECT ID as paquete, paquetes_almacenes.ID_almacen as almacen, paquetes_almacenes.desde as desde, paquetes.estado as estado 
FROM PAQUETES
INNER JOIN (select * from paquetes_almacenes where hasta is null)as paquetes_almacenes ON paquetes_almacenes.ID_paquete=paquetes.ID;

-- select * from paquetes_en_almacenes;

CREATE OR REPLACE VIEW PAQUETES_EN_LOTES AS
SELECT ID as paquete, paquetes_lotes.ID_lote as almacen, paquetes_lotes.desde as desde, paquetes.estado as estado 
FROM PAQUETES
INNER JOIN (select * from paquetes_lotes where hasta is null) as paquetes_lotes ON paquetes_lotes.ID_paquete=paquetes.ID;

-- select * from paquetes_en_almacenes;
-- Es para una validacion
CREATE OR REPLACE VIEW ALMACENES_CLIENTES_DE_ALTA AS
SELECT ALMACENES_CLIENTES.ID AS almacenCliente
FROM ALMACENES_CLIENTES
INNER JOIN CLIENTES ON CLIENTES.RUT = ALMACENES_CLIENTES.RUT
INNER JOIN ALMACENES ON ALMACENES_CLIENTES.ID = ALMACENES.ID
WHERE CLIENTES.baja=0 AND ALMACENES.baja=0;

