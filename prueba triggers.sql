SELECT * FROM `paquetes` WHERE ID = 20; 
SELECT * FROM paquetes_almacenes;
use surno;

describe paquetes;

insert into paquetes (id_almacen,id_pickup,direccion) values (18,1,'casa');
select * from camiones;
insert into trae (matricula,ID_paquete) values('ABC1234',20);
call descargar_trae(20,1,@error);
select @error;
select * from camionetas;
insert into reparte (matricula,ID_paquete) values ('ABD2399',20);
call entregar_paquete(20,@error);


insert into paquetes (id_almacen,id_pickup,direccion) values (18,1,'casa');
insert into trae (matricula,ID_paquete) values('ABC1234',21);
call descargar_trae(21,3,@error);
select @error;
select * from ordenes where id_almacen =1;
select * from ordenes where id_almacen in(2,1);
select * from lotes;
insert into lotes(ID_almacen,ID_troncal) values (3,4);
insert into destino_lote(ID_lote,ID_troncal,ID_almacen)values(12,4,2);
insert into paquetes_lotes(ID_paquete,ID_lote) values(21,12);
select * from camiones;
insert into lleva(matricula,ID_lote) values('ABC1234',12);
update lleva set fecha_descarga=current_timestamp() where ID_lote=12;
update lotes set fecha_cerrado=current_timestamp() where ID=12;
insert into lotes(ID_almacen,ID_troncal) values (2,5);
insert into destino_lote(ID_lote,ID_troncal,ID_almacen)values(13,5,1);
insert into paquetes_lotes(ID_paquete,ID_lote) values(21,13);
insert into lleva(matricula,ID_lote) values('ABC1234',13);
update lleva set fecha_descarga=current_timestamp() where ID_lote=13;
update lotes set fecha_cerrado=current_timestamp() where ID=13;
insert into reparte (matricula,ID_paquete) values ('ABD2399',21);
update reparte set fecha_descarga=current_timestamp() where ID_paquete=21;
update paquetes set fecha_entregado=current_timestamp() where ID=21;