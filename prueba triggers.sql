SELECT * FROM `paquetes` where id>17; 
SELECT * FROM LOTES;
SELECT * FROM paquetes_almacenes;
SELECT * FROM paquetes_en_lotes;
select @error;
select @ID;
use surno;
select * from almacenes_clientes;

#paquete 20
insert into paquetes (id_almacen,id_pickup,direccion) values (18,1,'casa');
insert into trae (matricula,ID_paquete) values('ABC1234',20);
SELECT SLEEP(1);
call descargar_trae(20,1,@error);
insert into reparte (matricula,ID_paquete) values ('ABD2399',20);
SELECT SLEEP(1);
call entregar_paquete(20,@error);

#paquete 21
insert into paquetes (id_almacen,id_pickup,direccion) values (18,1,'casa');
insert into trae (matricula,ID_paquete) values('ABC1234',21);
SELECT SLEEP(1);
call descargar_trae(21,3,@error);
call lote_0(3,2,5,@ID,@error);
select @error, @ID;
SELECT SLEEP(1);
insert into paquetes_lotes(ID_paquete,ID_lote) values(21,12);
SELECT SLEEP(1);
update lotes set fecha_pronto=current_timestamp() where ID=12;
SELECT SLEEP(1);
insert into lleva(matricula,ID_lote) values('ABC1234',12);
SELECT SLEEP(1);
update lleva set fecha_descarga=DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 1 SECOND) where ID_lote=@ID;
SELECT SLEEP(1);
update lotes set fecha_cerrado=current_timestamp() where ID=12;

SELECT * FROM `paquetes` where id>17; 
call lote_0(2,1,5,@ID,@error);
SELECT SLEEP(1);
insert into paquetes_lotes(ID_paquete,ID_lote) values(21,13);
SELECT SLEEP(1);
update lotes set fecha_pronto=CURRENT_TIMESTAMP()where ID=13;
SELECT SLEEP(1);
insert into lleva(matricula,ID_lote) values('ABC1234',13);
SELECT SLEEP(1);
update lleva set fecha_descarga = CURRENT_TIMESTAMP() where ID_lote=13;
SELECT SLEEP(1);
update lotes set fecha_cerrado= CURRENT_TIMESTAMP()where ID=13;
SELECT SLEEP(1);
-- ACA
insert into reparte (matricula,ID_paquete) values ('ABD2399',21);
SELECT SLEEP(1);
call descargar_reparte(21,1,@error);
select @error, @ID;
call lote_1(1,@ID,@error);
SELECT SLEEP(1);
insert into paquetes_lotes(ID_paquete,ID_lote) values(21,14);
SELECT SLEEP(1);
call entregar_paquete_pickup(21,@error);

#paquete 22
insert into paquetes (id_almacen,id_pickup,direccion) values (18,1,'casa');
SELECT SLEEP(1);
insert into trae (matricula,ID_paquete) values('ABC1234',22);
SELECT SLEEP(1);
call descargar_trae(22,3,@error);
call lote_0(3,1,5,@ID,@error);
insert into paquetes_lotes(ID_lote,ID_paquete) values(15,22);



