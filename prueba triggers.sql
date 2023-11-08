SELECT * FROM `PAQUETES` where id>17; 
SELECT * FROM LOTES;
SELECT * FROM PAQUETES_ALMACENES;
SELECT * FROM PAQUETES_EN_LOTES;
select @error;
select @ID;
use surno;
select * from ALMACENES_CLIENTES;

#paquete 20
insert into PAQUETES (id_almacen,id_pickup,direccion,cedula) values (18,1,'casa','12312312');
SELECT SLEEP(1);
insert into TRAE (matricula,ID_paquete) values('ABC1234',20);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=20;
SELECT SLEEP(1);
call descargar_trae(20,1,@error);
insert into REPARTE (matricula,ID_paquete) values ('ABD2399',20);
SELECT SLEEP(1);
update REPARTE set fecha_carga=current_timestamp where ID_paquete=20;
SELECT SLEEP(1);
call entregar_paquete(20,@error);
select * from TRAE;

#paquete 21
insert into PAQUETES (id_almacen,id_pickup,direccion,cedula) values (18,1,'casa','12343223');
insert into TRAE (matricula,ID_paquete) values('ABC1234',21);
SELECT SLEEP(1);
update TRAE set fecha_carga=current_timestamp where ID_paquete=21;
SELECT SLEEP(1);
call descargar_trae(21,3,@error);
call lote_0(3,2,5,@ID,@error);
select @error, @ID;
SELECT SLEEP(1);
insert into PAQUETES_LOTES(ID_paquete,ID_lote) values(21,12);
SELECT SLEEP(1);
update LOTES set fecha_pronto=current_timestamp() where ID=12;
SELECT SLEEP(1);
insert into LLEVA(matricula,ID_lote) values('ABC1234',12);
SELECT SLEEP(1);
update LLEVA set fecha_carga=DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 1 SECOND) where ID_lote=12;
SELECT SLEEP(1);
update LLEVA set fecha_descarga=DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 1 SECOND) where ID_lote=12;
SELECT SLEEP(1);
update LOTES set fecha_cerrado=current_timestamp() where ID=12;


SELECT * FROM `PAQUETES` where id>17; 
call lote_0(2,1,5,@ID,@error);
SELECT SLEEP(1);
insert into PAQUETES_LOTES(ID_paquete,ID_lote) values(21,13);
SELECT SLEEP(1);
update LOTES SET fecha_pronto=CURRENT_TIMESTAMP()where ID=13;
SELECT SLEEP(1);
insert into LLEVA(matricula,ID_lote) values('ABC1234',13);
SELECT SLEEP(1);
update LLEVA set fecha_carga = CURRENT_TIMESTAMP() where ID_lote=13;
SELECT SLEEP(1);
update LLEVA set fecha_descarga = CURRENT_TIMESTAMP() where ID_lote=13;
SELECT SLEEP(1);
update LOTES set fecha_cerrado= CURRENT_TIMESTAMP()where ID=13;
SELECT SLEEP(1);
-- ACA
insert into REPARTE (matricula,ID_paquete) values ('ABD2399',21);
SELECT SLEEP(1);
call descargar_reparte(21,1,@error);
select @error, @ID;
call lote_1(1,@ID,@error);
SELECT SLEEP(1);
insert into PAQUETES_LOTES(ID_paquete,ID_lote) values(21,14);
SELECT SLEEP(1);
call entregar_paquete_pickup(21,@error);

#paquete 22
insert into PAQUETES (id_almacen,id_pickup,direccion,cedula) values (18,1,'casa','98712367');
SELECT SLEEP(1);
insert into TRAE (matricula,ID_paquete) values('ABC1234',22);
SELECT SLEEP(1);
call descargar_trae(22,3,@error);
call lote_0(3,1,5,@ID,@error);
insert into PAQUETES_LOTES(ID_lote,ID_paquete) values(15,22);

update ORDENES set baja=1 where ID_almacen=9 and ID_troncal=1;
SELECT 
    *
FROM
    ORDENES
WHERE
    ID_troncal = 5;
select * from ALMACENES where baja=0 and ID not in(select ID_almacen from ORDENES where baja=0 and ID_troncal=1);

