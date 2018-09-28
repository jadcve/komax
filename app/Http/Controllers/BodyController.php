<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use App\Http\Controllers\Controller;    
use Illuminate\Support\Facades\Schema;
use App\Sugerido;
use App\Convert_to_csv;
use App\Tienda;

class bodyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function body(Request $request)
    {
        $fechaentrada = $request->fecha;
        $fecha = date("Y/m/d", strtotime($fechaentrada));
        $bodega = $request->bodega;



        //$bodega = 'RUTA68';

       
        $calculo = $this->calculo($fecha, $bodega);
        $sugerido = $this->sugerido();
        
/*
        $mov_salida1 = $this->mov_salida($fecha);
        $mov_salida2 = $this->mov_salida($fecha);
        $mov_salida3 = $this->mov_salida($fecha);
        $mov_salida_1 = $this->mov_salida($fecha);
        $mov_salida_2 = $this->mov_salida($fecha);
        $mov_salida_3 = $this->mov_salida($fecha);
        $mov_salida_4 = $this->mov_salida($fecha);
        $mov_salida_5 = $this->mov_salida($fecha);
        $mov_salida_6 = $this->mov_salida($fecha);
        $mov_salida_7 = $this->mov_salida($fecha);
        $mov_salida_8 = $this->mov_salida($fecha);
        $mov_salida_9 = $this->mov_salida($fecha);
        $mov_salida_10 = $this->mov_salida($fecha);
        $mov_salida_11 = $this->mov_salida($fecha);
        $mov_salida_12 = $this->mov_salida($fecha);
        $mov_salida_13 = $this->mov_salida($fecha);
        $mov_salida_14 = $this->mov_salida($fecha);
        $mov_salida_base = $this->mov_salida($fecha);
        $stocksem = DB::table('stock')
            -> select('bodega','sku','cantidad');

        $stockcd = $stocksem
            ->where('bodega','=',$bodega);

        $tran = DB::table('gid_transito')
            ->select('bodega_hasta', 'sku', \DB::raw('sum(qty_requested-qty_received) as transito'))
            ->where(\DB::raw('qty_requested-qty_received'),'>',0)
            ->groupBy('bodega_hasta','sku');
*/
        /**
        *  Llamado a la función que calcula el precio de los productos
        */
/*
        $diasx = $this->diasx($mov_salida_1, 8,1);
        $diasx1 = $this->diasx($mov_salida_2, 16,9);
        $dias3 = $this->dias_sumatoria($mov_salida_3,8,1);
        $dias4 = $this->dias_sumatoria($mov_salida_4,16,9);
        $dias5 = $this->dias_sumatoria($mov_salida_5,24,17);
        $dias6 = $this->dias_sumatoria($mov_salida_6,32,25);
        $dias7 = $this->dias_sumatoria($mov_salida_7,33,40);
        $dias8 = $this->dias_sumatoria($mov_salida_8,41,48);
        $dias9 = $this->dias_sumatoria($mov_salida_9,49,56);
        $dias10 = $this->dias_sumatoria($mov_salida_10,57,64);
        $dias11 = $this->dias_sumatoria($mov_salida_11,65,72);
        $dias12 = $this->dias_sumatoria($mov_salida_12,73,80);
        $dias13 = $this->dias_sumatoria($mov_salida_13,81,88);
        $dias14 = $this->dias_sumatoria($mov_salida_14,89,96);


        $total = $mov_salida1
                    ->select('bodega','sku',DB::raw('sum(qty) as cantidad'))
                    ->groupBy('bodega','sku');

        $totalx = $mov_salida2
            ->select('bodega','sku',DB::raw('sum(qty) as cantidad'))
            ->where(\DB::raw('(case when bodega like \'%TAG%\' then \'TMAR\' when bodega like \'%TKIV%\' then \'TMAR\' when bodega like \'%TMAR%\' then \'TMAR\' end)=\'TMAR\''))
            ->groupBy('bodega','sku');


        $week = $mov_salida3
            ->select('bodega','sku', \DB::raw('sum(qty) as cantidad'))
            ->where(\DB::raw('(extract(week from fecha))=(extract(week from current_date - 20))'))
            ->groupBy('bodega','sku');
*/
/*
        $base =  $mov_salida_base
            ->leftJoin('dias3','dias3.bodega', '=','mov_salida_base.bodega')
            ->select('mov_salida_base.bodega','mov_salida_base.sku', 'dias3.cantidad')
            ->get();
*/

        return view('sugerido.body', compact('sugerido'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function diasx($query,$d1,$d2)
    {
        $carbon = new \Carbon\Carbon();
        $date_inicial = $carbon->now();
        $date_final = $carbon->now();

         return $query
            ->select('bodega','sku', \DB::raw('case when sum(qty)=0 then 0 else sum(netamount)/sum(qty) end as cantidad'))
            ->whereBetween( 'fecha',[$date_inicial->subDay($d1), $date_final->subDay($d2)])
            ->groupBy('fecha','bodega','sku');

    }

    public function dias_sumatoria($query, $d1, $d2)
    {
        $carbon = new \Carbon\Carbon();
        $date_inicial = $carbon->now();
        $date_final = $carbon->now();

        return $query
            ->select('bodega','sku', \DB::raw('sum(qty) as cantidad'))
            ->whereBetween( 'fecha',[$date_inicial->subDay($d1), $date_final->subDay($d2)])
            ->groupBy('fecha','bodega','sku');
    }

    public function mov_salida($fecha)
    {
        return DB::table('trans', \DB::raw('case when qty>3 then 1 else qty end as qty', 'fecha','netamount'))
            -> select('bodega', 'sku')
            ->whereNotNull('bodega')
            ->where('fecha','>',$fecha);
    }

    public function calculo($fecha,$bodega)
    {
        DB::table('calculos')->truncate();

        return DB::select(\DB::raw('insert into calculos with mov_salida1 as --trae la venta desde la tabla 
(
select trim(UPPER(bodega)) as bodega ,trim(upper(sku)) as sku,case when qty>3 then 1 else qty end as qty , fecha,netamount  
from mov_salida
where  bodega is not null and fecha is not null and invoice_id is not null
and fecha>\'2018-01-01\'    
),
stocksem as  -- stock del el cliente
(
select trim(upper(s.bodega)) as bodega,trim(upper(s.sku)) as sku ,s.cantidad 
from stock as s
),
stockcd as  -- del stock del cliente se selecciona cual bodega es el CD.
(
select trim(upper(s.bodega)) as bodega,trim(upper(s.sku))as sku ,s.cantidad
from stock as s
where trim(upper(s.bodega))=\'$bodega\' 
),
tran as-- el transito que va desde el CD  la tienda.
(
select trim(upper(g.bodega_hasta)) as bodega, trim(upper(g.sku)) as sku, sum(g.qty_requested-g.qty_received) as transito
from gid_transito as g
where g.qty_requested-g.qty_received>0
group by trim(upper(g.bodega_hasta)), trim(upper(g.sku))
),
diasx as --para saber a que precio se vende el prod por semanas hacia atras (diasx)
(
select
bodega
,sku
,case when sum(qty)=0 then 0 else sum(netamount)/sum(qty) end as p1
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-8 and date_trunc(\'day\',current_date)::date-1 
group by 
bodega
,sku),
diasx1 as 
(
select
bodega
,sku
,case when sum(qty)=0 then 0 else sum(netamount)/sum(qty) end as p1
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-16and date_trunc(\'day\',current_date)::date-9
group by 
bodega
,sku),
dias3 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-8 and date_trunc(\'day\',current_date)::date-1 
group by 
bodega
,sku
),
dias4 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-16
and date_trunc(\'day\',current_date)::date-9
group by 
bodega
,sku
),
dias5 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-24
and date_trunc(\'day\',current_date)::date-17
group by 
bodega
,sku
),
dias6 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-32
and date_trunc(\'day\',current_date)::date-25
group by 
bodega
,sku
),
dias7 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-40
and date_trunc(\'day\',current_date)::date-33
group by 
bodega
,sku
),
dias8 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-48
and date_trunc(\'day\',current_date)::date-41
group by 
bodega
,sku
),
dias9 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-56
and date_trunc(\'day\',current_date)::date-49
group by 
bodega
,sku
),
dias10 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-64
and date_trunc(\'day\',current_date)::date-57
group by 
bodega
,sku
),
dias11 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-72
and date_trunc(\'day\',current_date)::date-65
group by 
bodega
,sku
),
dias12 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-80
and date_trunc(\'day\',current_date)::date-73
group by 
bodega
,sku
),
dias13 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-88
and date_trunc(\'day\',current_date)::date-81
group by 
bodega
,sku
),
dias14 as
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
where fecha::date between date_trunc(\'day\',current_date)::date-96
and date_trunc(\'day\',current_date)::date-89
group by 
bodega
,sku
),
total2 as -- cuanto se ha vendido el prod en un periodo editable
(
select
trim(upper(bodega)) as bodega
,trim(upper(sku)) as sku
,sum(qty) as Venta2dias
from mov_salida
where fecha between \'2017-07-01\' and \'2017-08-30\' and  bodega is not null and fecha is not null and invoice_id is not null
group by 
trim(upper(bodega))
,trim(upper(sku))),
total as -- historico de venta del producto no es necesario
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
group by 
bodega
,sku
),
totalx as -- venta de pro por bodegas
(
select
sku
,sum(qty) as Venta2dias
from mov_salida1
where (case when bodega like \'%TAG%\' then \'TMAR\' when bodega like \'%TKIV%\' then \'TMAR\' when bodega like \'%TMAR%\' then \'TMAR\' end)=\'TMAR\'  
group by sku
),
WEEK as -- para ver la venta de la semana en curso
(
select
bodega
,sku
,sum(qty) as Venta2dias
from mov_salida1
WHERE (extract(week from fecha::DATE))=(extract(week from current_date - 1))
group by 
bodega
,sku
),
base as
(
select
v.bodega
,v.sku
,dias3.Venta2dias as semana1
,dias4.Venta2dias as semana2
,dias5.Venta2dias as semana3
,dias6.Venta2dias as semana4
,dias7.Venta2dias as semana5
,dias8.Venta2dias as semana6
,dias9.Venta2dias as semana7
,dias10.Venta2dias as semana8
,dias11.Venta2dias as semana9
,dias12.Venta2dias as semana10
,dias13.Venta2dias as semana11
,dias14.Venta2dias as semana12
,total.Venta2dias as todos
,totalx.venta2dias as todosall
,total2.Venta2dias as todosant
,WEEK.Venta2dias AS WK
,diasx.p1 as p1
,diasx1.p1 as p2
from mov_salida1 as v
left join dias3 on dias3.bodega=v.bodega and dias3.sku=v.sku
left join dias4 on dias4.bodega=v.bodega and dias4.sku=v.sku
left join dias5 on dias5.bodega=v.bodega and dias5.sku=v.sku
left join dias6 on dias6.bodega=v.bodega and dias6.sku=v.sku
left join dias7 on dias7.bodega=v.bodega and dias7.sku=v.sku
left join dias8 on dias8.bodega=v.bodega and dias8.sku=v.sku
left join dias9 on dias9.bodega=v.bodega and dias9.sku=v.sku
left join dias10 on dias10.bodega=v.bodega and dias10.sku=v.sku
left join dias11 on dias11.bodega=v.bodega and dias11.sku=v.sku
left join dias12 on dias12.bodega=v.bodega and dias12.sku=v.sku
left join dias13 on dias13.bodega=v.bodega and dias13.sku=v.sku
left join dias14 on dias14.bodega=v.bodega and dias14.sku=v.sku
left join total on total.bodega=v.bodega and total.sku=v.sku
left join total2 on total2.bodega=v.bodega and total2.sku=v.sku
left join totalx on  totalx.sku=v.sku
LEFT JOIN WEEK on WEEK.bodega=v.bodega and WEEK.sku=v.sku
left join diasx on diasx.bodega=v.bodega and diasx.sku=v.sku
left join diasx1 on diasx1.bodega=v.bodega and diasx1.sku=v.sku
group by 
v.bodega
,v.sku
,dias3.venta2dias
,dias4.venta2dias
,dias5.venta2dias
,dias6.venta2dias
,dias7.venta2dias
,dias8.venta2dias
,dias9.venta2dias
,dias10.venta2dias
,dias11.venta2dias
,dias12.venta2dias
,dias13.venta2dias
,dias14.venta2dias
,total.venta2dias
,total2.venta2dias
,totalx.venta2dias
,diasx.p1
,diasx1.p1
,WEEK.Venta2dias
),
demand as -- calculo dre la demanda
(
select 
mix.tienda as codigo_bodega
,mix.sku
,mix.cod_art
,case when b.semana1 is null then 0 when b.semana1<0 then 0 when b.semana1>22 then 2  else b.semana1 end 
,case when b.semana2 is null then 0 when b.semana2<0 then 0 when b.semana2>22 then 2 else b.semana2 end 
,case when b.semana3 is null then 0 when b.semana3<0 then 0 when b.semana3>22 then 2 else b.semana3 end 
,case when b.semana4 is null then 0 when b.semana4<0 then 0 when b.semana4>22 then 2 else b.semana4 end 
,case when b.semana5 is null then 0 when b.semana5<0 then 0 when b.semana5>22 then 2 else b.semana5 end 
,case when b.semana6 is null then 0 when b.semana6<0 then 0 when b.semana6>22 then 2 else b.semana6 end 
,case when b.semana7 is null then 0 when b.semana7<0 then 0 when b.semana7>22 then 2 else b.semana7 end 
,case when b.semana8 is null then 0 when b.semana8 <0 then 0 when b.semana8>22 then 2 else b.semana8 end 
,case when b.semana9 is null then 0 when b.semana9<0 then 0 when b.semana9>22 then 2 else b.semana9 end 
,case when b.semana10 is null then 0 when b.semana10<0 then 0 when b.semana10>22 then 2 else b.semana10 end 
,case when b.semana11 is null then 0 when b.semana11<0 then 0 when b.semana11>22 then 2 else b.semana11 end 
,case when b.semana12 is null then 0 when b.semana12<0 then 0 when b.semana12>22 then 2 else b.semana12 end 
,b.todos
,b.todosall
,b.todosant
,b.WK
,b.p1
,b.p2
,case when sm.cantidad is null then 0 else sm.cantidad end as stocktienda
,case when cd.cantidad is null then 0 else cd.cantidad end as stockcd
,case when t.transito is null then 0 else t.transito end as transito
,mix.delivery
,mix.minimo
from mix 
left join stocksem as sm on sm.sku=mix.sku and sm.bodega=mix.tienda
left join stockcd as cd on cd.sku=mix.sku 
left join tran as t on t.bodega=mix.tienda and t.sku=mix.sku
left join base as b on b.bodega=mix.tienda and b.sku=mix.sku
),
demand2 as 
(
select 
codigo_bodega
,sku
,cod_art
,semana1
,semana2
,semana3
,semana4
,semana5
,semana6
,semana7
,semana8
,semana9
,semana10
,semana11
,semana12
,todos
,todosall
,todosant
,WK
,(semana1*.25+semana2*.2+semana3*.1+semana4*.07+semana5*.05+semana6*.05+semana7*.05+semana8*.05+semana9*.05+semana10*.05+semana11*.05+semana12*.03) as calculo
,case when (case when semana1>0 and semana2>0 then 2 else 0 end)>(case when semana1>0 and semana2=0 and semana3>0 then 2 else 0 end) then (case when semana1>0 and semana2>0 then 2 else 0 end) else (case when semana1>0 and semana2=0 and semana3>0 then 2 else 0 end) end as f1
,case when (case when stocktienda<2 and semana1>0 and todos>2  then 2 else 0 end)>(case when semana1>1 and semana2>0 then (((semana1+semana2)/2)*2) else (case when semana2>0 and semana3>0 then 2 else 0 end) end) then (case when stocktienda<2 and semana1>0 and todos>2  then 2 else 0 end) else (case when semana1>1 and semana2>0  then (((semana1+semana2)/2)*2) else (case when semana2>0 and semana3>0 then 2 else 0 end) end) end as f2
,stocktienda
,stockcd
,transito
,delivery
,minimo
,p1
,p2
from demand
),
demand3 as
(
select
codigo_bodega
,sku
,cod_art
,semana1
,semana2
,semana3
,semana4
,semana5
,semana6
,semana7
,semana8
,semana9
,semana10
,semana11
,semana12
,todos
,todosall
,todosant
,WK
,p1
,p2
--,round((case when semana1>0 and semana2>0 then calculo*3.7 else calculo*2.7 end),0) as valor
,round((case when f2>0 then  (case when f2>calculo*3.7 then f2 else calculo*3.7 end) else (case when f1>0 then (case when f1>calculo*3.7 then f1 else calculo*3.7 end) else calculo*2.7 end) end),0) as valor
,case when delivery <>\'D9999\' then minimo  else (case when calculo>0.3 then 2 else 1 end) end  as  maxmix
,stocktienda
,stockcd
,transito
,delivery
,minimo
,calculo
,trim(case  when to_char(current_date,\'d\') = \'1\' then \'DOMINGO\'
  when to_char(current_date,\'d\') = \'2\' then \'LUNES\'
  when to_char(current_date,\'d\') = \'3\' then \'MARTES\'
  when to_char(current_date,\'d\') = \'4\' then \'MIERCOLES\'
  when to_char(current_date,\'d\') = \'5\' then \'JUEVES\'
  when to_char(current_date,\'d\') = \'6\' then \'VIERNES\'
  when to_char(current_date,\'d\') = \'7\' then \'SABADO\'
  end) as dia
from demand2
),
maxcompra as
(
select
sku
,case when ((case when valor>maxmix then valor else maxmix end)-stocktienda-transito)<0 then 0 else ((case when valor>maxmix then valor else maxmix end)-stocktienda-transito) end as compra
from demand3
),
maxcompraacum as
(
select 
sku
,sum(compra) as acum
from maxcompra
group by sku
),
maestro as
(
select distinct
trim(upper(codigo_color)) as codigo_color
,trim(upper(descripcion_color)) as descripcion_color
,trim(upper(codigo_talla)) as codigo_talla
,trim(upper(descripcion_talla)) as descripcion_talla
,precio_iva_incl as pvp
,costo
,trim(upper(marca)) as marca
,trim(upper(area)) as area
,trim(upper(linea)) as linea
,trim(upper(negocio)) as negocio
,trim(upper(division)) as division
,trim(upper(temporada)) as temporada
,trim(upper(desc_producto)) as desc_producto
,trim(upper(familia)) as familia
,trim(upper(sub_familia)) as sub_familia
,trim(upper(sku)) as sku1
,trim(upper(itemid)) as itemid1
,trim(upper(categoria)) as categoria
,trim(upper(desc_producto)) as descripcion
from maestro_articulos
),
maestroc as
(
select distinct * from maestro
),
demand4 as
(
select
codigo_bodega as warehouse
,case when codigo_bodega like \'%TAG%\' then \'TAG\' when codigo_bodega like \'%TKIV%\' then \'TKIV\' when codigo_bodega like \'%TMAR%\' then \'TMAR\' when codigo_bodega like \'%TMMU%\' then \'TMMU\'  when codigo_bodega like \'%TGAP%\' then \'TGAP\' end  as tienda
,demand3.sku as alm_art
,cod_art as articlecode
,valor as ordercicle
,stocktienda as stockonhand
,stockcd as stockonhandcd
,(case when valor>maxmix then valor else maxmix end) as orderlevel
,transito as stockOnOrder
,case when ((case when valor>maxmix then valor else maxmix end)-stocktienda-transito)<0 then 0 else ((case when valor>maxmix then valor else maxmix end)-stocktienda-transito) end as roundedOrderQuantity
,maxcompraacum.acum as maxstockrounded
,WK
,semana1 as demand1
,semana2 as demand2
,semana3 as demand3
,semana4 as demand4
,semana5 as demand5
,semana6 as demand6
,semana7 as demand7
,semana8  as demanad8
,stockcd-maxcompraacum.acum as ava_cd_ship
,\'RUTA68\' as ALMACEN_ORIGEN 
,codigo_bodega as ALMACEN_DESTINO
,2 as TIPO_PEDIDO
,maestroc.itemid1 as ESTILO_COLOR
,maestroc.codigo_talla as TALLA
,maestroc.marca as MARCA
,maestroc.temporada as TEMPORADA
,maestroc.familia
,maestroc.sub_familia
,maestroc.categoria
,maestroc.pvp 
,maestroc.codigo_talla
,maestroc.descripcion_color as codigo_color
,maestroc.area
,todos
,todosall
,todosant
,calculo
,p1
,p2
--calendario
,case when dia=\'LUNES\' AND codigo_bodega IN (\'TAGAERO\',\'TGAPVINA\',\'TGAPTREBOL\',\'TGAPALC\',\'TGAPCCENTE\',\'TGAPLDA\',\'TGAPPARAUC\',\'TMMUALC\',\'TMMUCCENTE\',\'TMARTEM\',\'TAGPVESPUC\',\'TKIVVINA\',\'TAGTEMUCO\',\'TAGOSORNO\',\'TAGPMONTT\',\'TAGVALDIVI\',\'TAGMALLSPO\',\'TAGPEGANA\',\'TAGEBRO\',\'TMARCONCEP\',\'TMARVINA\',\'TMARPARAUC\',\'TMARLDA\',\'TKIVTEMUCO\',\'TKIVVALDIV\',\'TKIVPMONTT\') THEN date_trunc(\'day\',current_date)::date+2
when dia=\'MARTES\' AND codigo_bodega IN (\'TAGAERO\',\'TGAPALC\',\'TGAPCCENTE\',\'TGAPLDA\',\'TGAPPARAUC\',\'TMMUALC\',\'TMMUCCENTE\',\'TAGPVESPUC\',\'TAGTREBOL\',\'TAGANGELES\',\'TAGANTOFA\',\'TAGMALLSPO\',\'TAGPEGANA\',\'TAGEBRO\',\'TMARRANCAG\',\'TMARPARAUC\',\'TMARLDA\',\'TKIVPNORTE\',\'TKIVCHILLA\',\'TKIVMAIPU\') THEN date_trunc(\'day\',current_date)::date+2
when dia=\'MIERCOLES\' AND codigo_bodega IN (\'TAGAERO\',\'TGAPALC\',\'TGAPCCENTE\',\'TGAPLDA\',\'TGAPPARAUC\',\'TMMUALC\',\'TMMUCCENTE\',\'TAGPVESPUC\',\'TAGPARENAS\',\'TAGMALLSPO\',\'TAGPEGANA\',\'TAGEBRO\',\'TMARPARAUC\',\'TMARLDA\') THEN date_trunc(\'day\',current_date)::date+2
when dia=\'JUEVES\' AND codigo_bodega IN (\'TAGAERO\',\'TGAPVINA\',\'TGAPTREBOL\',\'TGAPALC\',\'TGAPCCENTE\',\'TGAPLDA\',\'TGAPPARAUC\',\'TMMUALC\',\'TMMUCCENTE\',\'TAGPVESPUC\',\'TMARTEM\',\'TKIVVINA\',\'TAGTEMUCO\',\'TAGOSORNO\',\'TAGPMONTT\',\'TAGVALDIVI\',\'TAGMALLSPO\',\'TAGPEGANA\',\'TAGEBRO\',\'TMARCONCEP\',\'TMARVINA\',\'TMARPARAUC\',\'TMARLDA\',\'TKIVTEMUCO\',\'TKIVVALDIV\',\'TKIVPMONTT\') THEN date_trunc(\'day\',current_date)::date+4
when dia=\'VIERNES\' AND codigo_bodega IN (\'TAGAERO\',\'TGAPALC\',\'TGAPCCENTE\',\'TGAPLDA\',\'TGAPPARAUC\',\'TMMUALC\',\'TMMUCCENTE\',\'TAGPVESPUC\',\'TAGCURICO\',\'TAGTALCA\',\'TAGTREBOL\',\'TAGANGELES\',\'TAGANTOFA\',\'TAGCASTRO\',\'TAGLOSANDE\',\'TAGMALLSPO\',\'TAGPEGANA\',\'TAGEBRO\',\'TMARRANCAG\',\'TMARPARAUC\',\'TMARLDA\',\'TKIVCOPIAP\',\'TKIVCHILLA\') THEN date_trunc(\'day\',current_date)::date+4
when dia=\'DOMINGO\' AND codigo_bodega IN (\'TAGAERO\',\'TAGANGELES\',\'TAGANTOFA\',\'TAGCASTRO\',\'TAGCURICO\',\'TAGEBRO\',\'TAGLOSANDE\',\'TAGMALLSPO\',\'TAGOSORNO\',\'TAGPARENAS\',\'TAGPEGANA\',\'TAGPMONTT\',\'TAGPVESPUC\',\'TAGTALCA\',\'TAGTREBOL\',\'TAGVALDIVI\',\'TKIVCHILLA\',\'TKIVCOPIAP\',\'TKIVMAIPU\',\'TKIVPMONTT\',\'TKIVPNORTE\',\'TKIVTEMUCO\',\'TKIVVALDIV\',\'TKIVVINA\',\'TMARCONCEP\',\'TMARLDA\',\'TMARPARAUC\',\'TMARRANCAG\',\'TMARTEM\',\'TMARVINA\') THEN date_trunc(\'day\',current_date)::date+4
END AS FECHA_DESPACHO
,case when ((case when valor>maxmix then valor else maxmix end)-stocktienda-transito)<0 then 0 else ((case when valor>maxmix then valor else maxmix end)-stocktienda-transito) end as CANTIDAD
,transito as TRANSITO
,delivery
,minimo
,descripcion
from demand3
left join maxcompraacum on maxcompraacum.sku=demand3.sku
left join maestroc on maestroc.sku1=demand3.sku
),
maxcompracd as --dependi del dia cuanto pide desp y cuanto tengo 
(
select 
alm_art
,sum(roundedOrderQuantity) as sumacompra
from demand4
where FECHA_DESPACHO IS NOT NULL and stockonhandcd>0
group by alm_art
),
maxbodega as
(
select 
warehouse
,sum(roundedOrderQuantity) as sumatienda
from demand4
where stockonhandcd>0
group by warehouse
)
select 
demand4.warehouse
,tienda
,demand4.alm_art
,articlecode
,ordercicle
,stockonhand
,stockonhandcd
,orderlevel
,stockOnOrder
,roundedOrderQuantity
,maxcompracd.sumacompra as maxstockrounded
,WK
,demand1
,demand2
,demand3
,demand4
,demand5
,demand6
,demand7
,demanad8
,stockonhandcd-maxcompracd.sumacompra as ava_cd_ship
,ALMACEN_ORIGEN
,ALMACEN_DESTINO
,TIPO_PEDIDO
,ESTILO_COLOR
,TALLA
,MARCA
,FECHA_DESPACHO
,CANTIDAD
,TRANSITO
,delivery
,minimo
,TEMPORADA
,familia
,sub_familia
,categoria
,pvp
,codigo_talla
,codigo_color
,area
,descripcion
,case when todos is null  then 0 else todos end as todos
,case when todosall is null  then 0 else todosall end as todosall
,case when todosant is null  then 0 else todosant end as todosant
,p1
,p2
,calculo
from demand4
left join maxcompracd on maxcompracd.alm_art=demand4.alm_art
left join maxbodega on maxbodega.warehouse=demand4.warehouse
where marca=\'MARMOT\''));

        /**Hasta aquí llega la query de Dennis */
    }


    public function index()
    {
        $bodegas = Tienda::distinct()->get(['bodega'])->sortBy('bodega');
        
        return view('sugerido.index', compact('bodegas'));
    }

    public function sugerido()
    {
        DB::table('sugeridos')->truncate();

        $cuenta = DB::table('calculos')
        ->leftjoin('forecast_marmot','forecast_marmot.cod_art', '=', 'calculos.articlecode')
        ->select(\DB::raw('calculos.articlecode as cod_art, calculos.minimo as minimo, 
                           calculos.ordercicle as ordercicle, round(score_m1) as score_m1,
                           case when round(score_m1) >= orderlevel then round(score_m1) else orderlevel end as sugerido'))
        ->get();
       
        foreach($cuenta as $s){
            $sugerido = new Sugerido();
            $sugerido->cod_art = $s->cod_art;
            $sugerido->minimo = $s->minimo;
            $sugerido->forecast = $s->score_m1;
            $sugerido->ordercicle = $s->ordercicle;
            $sugerido->sugerido = $s->sugerido;
            $sugerido->save();  
        }
        
        return $cuenta->take(10);
        
    }

    public function download(){
        
        $datos = DB::table('sugeridos')->get();

        $contenidoCsv = [];
        //headers del csv
        array_push($contenidoCsv, array('id', 'cod_art', 'forecast', 'ordercicle', 'minimo', 'sugerido'));
        //agrego los datos al array
        foreach ($datos as $registro) {
            array_push($contenidoCsv, array($registro->id, $registro->cod_art, $registro->forecast, $registro->ordercicle, $registro->minimo, $registro->sugerido));
        }
        //fecha para crear el nombre
        $fecha = date('Ymdhis');
        $nombreCsv = "sugeridos_".$fecha.'.csv';

        //llama al metodo para crear el csv
        Convert_to_csv::create($contenidoCsv, $nombreCsv, ',');

        return view('sugerido/download');
    }
}
