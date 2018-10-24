<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\SugeridoD;
use App\Convert_to_csv;
use App\Bodega;

class SugeridoDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $bodegas = Bodega::distinct()->get(['bodega'])->sortBy('bodega');

        return view('sugerido_distribucion.index',compact('bodegas'));
    }

    public function body(Request $request)
    {
        $fechaentrada = $request->fecha;
        $fecha = date("Y-m-d", strtotime($fechaentrada));
        $bodegas = $request->bodega;


        $calculo = $this->calculo($fecha, $bodegas);

        /**
         * lLAMADO AL CALENDARIO PARA OBTENER LAS FECHAS DE LAS CONSULTAS
         */


        $calendario = DB::table('calendarios')
            ->select('dia_despacho','lead_time','tiempo_entrega');


        /**
         * Obtención de las ventas para  12 semanas atrás
         */

/*
    

        $semana_1 = $this->dias_sumatoria($mov_salida_3,8,1);
        $semana_2 = $this->dias_sumatoria($mov_salida_4,16,9);
        $semana_3 = $this->dias_sumatoria($mov_salida_5,24,17);
        $semana_4 = $this->dias_sumatoria($mov_salida_6,32,25);
        $semana_5 = $this->dias_sumatoria($mov_salida_7,33,40);
        $semana_6 = $this->dias_sumatoria($mov_salida_8,41,48);
        $semana_7 = $this->dias_sumatoria($mov_salida_9,49,56);
        $semana_8 = $this->dias_sumatoria($mov_salida_10,57,64);
        $semana_9 = $this->dias_sumatoria($mov_salida_11,65,72);
        $semana_10 = $this->dias_sumatoria($mov_salida_12,73,80);
        $semana_11 = $this->dias_sumatoria($mov_salida_13,81,88);
        $semana_12 = $this->dias_sumatoria($mov_salida_14,89,96);





        //return view('sugerido.body', compact('semana_1'));


        /**
        *  Llamado a la función que calcula el precio de los productos
        */
/*
        $diasx = $this->diasx($mov_salida_1, 8,1);
        $diasx1 = $this->diasx($mov_salida_2, 16,9);



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

        //return view('sugerido_distribucion.body', compact('sugerido'));
    }

    /**
     * Función que llama a la venta de productos de las últimas 12 semanas.
     *
     * @return ventas de productos de las últimas semanas
     */


    public function dias_sumatoria($query, $d1, $d2)
    {
        $carbon = new \Carbon\Carbon();
        $date_inicial = $carbon->now();
        $date_final = $carbon->now();

        return $query
            ->select('bodega','sku', \DB::raw("CONCAT(bodega,'_',sku) as cod_art, sum(qty) as cantidad"))
            ->whereBetween( 'fecha',[$date_inicial->subDay($d1), $date_final->subDay($d2)])
            ->groupBy('fecha','bodega','sku')
            ->orderBy('cantidad','desc')
            ->get();
    }




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


    public function calculo($fecha,$bodega)
    {

        DB::table('calculos')->truncate();
        

        DB::select(\DB::raw("with mov_salida1 as(
            select
                trim( upper( bodega )) as bodega,
                trim( upper( sku )) as sku,
                case
                    when qty > 3 then 1
                    else qty
                end as qty,
                fecha,
                netamount
            from
                mov_salida
            where
                bodega is not null
                and fecha is not null
                and invoice_id is not null
                and fecha > '2018-08-01'
        ),
        stocksem as(
            select
                trim( upper( s.bodega )) as bodega,
                trim( upper( s.sku )) as sku,
                s.cantidad
            from
                stock as s
        ),
        stockcd as(
            select
                trim( upper( s.bodega )) as bodega,
                trim( upper( s.sku )) as sku,
                s.cantidad
            from
                stock as s
            where
                trim( upper( s.bodega ))= 'RUTA68'
        ),
        tran as(
            select
                trim( upper( g.bodega_hasta )) as bodega,
                trim( upper( g.sku )) as sku,
                sum( g.qty_requested - g.qty_received ) as transito
            from
                transito as g
            where
                g.qty_requested - g.qty_received > 0
            group by
                trim( upper( g.bodega_hasta )),
                trim( upper( g.sku ))
        ),
        diasprecio1 as(
            select
                bodega,
                sku,
                case
                    when sum( qty )= 0 then 0
                    else sum( netamount )/ sum( qty )
                end as p1
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 8 and date_trunc(
                    'day',
                    current_date
                )::date - 1
            group by
                bodega,
                sku
        ),
        diasprecio2 as(
            select
                bodega,
                sku,
                case
                    when sum( qty )= 0 then 0
                    else sum( netamount )/ sum( qty )
                end as p1
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 16 and date_trunc(
                    'day',
                    current_date
                )::date - 9
            group by
                bodega,
                sku
        ),
        dias1 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 8 and date_trunc(
                    'day',
                    current_date
                )::date - 1
            group by
                bodega,
                sku
        ),
        dias2 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 16 and date_trunc(
                    'day',
                    current_date
                )::date - 9
            group by
                bodega,
                sku
        ),
        dias3 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 24 and date_trunc(
                    'day',
                    current_date
                )::date - 17
            group by
                bodega,
                sku
        ),
        dias4 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 32 and date_trunc(
                    'day',
                    current_date
                )::date - 25
            group by
                bodega,
                sku
        ),
        dias5 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 40 and date_trunc(
                    'day',
                    current_date
                )::date - 33
            group by
                bodega,
                sku
        ),
        dias6 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 48 and date_trunc(
                    'day',
                    current_date
                )::date - 41
            group by
                bodega,
                sku
        ),
        dias7 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 56 and date_trunc(
                    'day',
                    current_date
                )::date - 49
            group by
                bodega,
                sku
        ),
        dias8 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 64 and date_trunc(
                    'day',
                    current_date
                )::date - 57
            group by
                bodega,
                sku
        ),
        dias9 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 72 and date_trunc(
                    'day',
                    current_date
                )::date - 65
            group by
                bodega,
                sku
        ),
        dias10 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 80 and date_trunc(
                    'day',
                    current_date
                )::date - 73
            group by
                bodega,
                sku
        ),
        dias11 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 88 and date_trunc(
                    'day',
                    current_date
                )::date - 81
            group by
                bodega,
                sku
        ),
        dias12 as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                fecha::date between date_trunc(
                    'day',
                    current_date
                )::date - 96 and date_trunc(
                    'day',
                    current_date
                )::date - 89
            group by
                bodega,
                sku
        ),
        total2 as(
            select
                trim( upper( bodega )) as bodega,
                trim( upper( sku )) as sku,
                sum( qty ) as Venta2dias
            from
                mov_salida
            where
                fecha between '2018-08-24' and '2018-10-24'
                and bodega is not null
                and fecha is not null
                and invoice_id is not null
            group by
                trim( upper( bodega )),
                trim( upper( sku ))
        ),
        total as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            group by
                bodega,
                sku
        ),
        totalx as(
            select
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                (
                    case
                        when bodega like '%TAG%' then 'TMAR'
                        when bodega like '%TKIV%' then 'TMAR'
                        when bodega like '%TMAR%' then 'TMAR'
                    end
                )= 'TMAR'
            group by
                sku
        ),
        week as(
            select
                bodega,
                sku,
                sum( qty ) as Venta2dias
            from
                mov_salida1
            where
                (
                    extract(
                        week
                    from
                        fecha::date
                    )
                )=(
                    extract(
                        week
                    from
                        current_date - 1
                    )
                )
            group by
                bodega,
                sku
        ),
        base as(
            select
                v.bodega,
                v.sku,
                dias1.Venta2dias as semana1,
                dias2.Venta2dias as semana2,
                dias3.Venta2dias as semana3,
                dias4.Venta2dias as semana4,
                dias5.Venta2dias as semana5,
                dias6.Venta2dias as semana6,
                dias7.Venta2dias as semana7,
                dias8.Venta2dias as semana8,
                dias9.Venta2dias as semana9,
                dias10.Venta2dias as semana10,
                dias11.Venta2dias as semana11,
                dias12.Venta2dias as semana12,
                total.Venta2dias as todos,
                totalx.venta2dias as todosall,
                total2.Venta2dias as todosant,
                WEEK.Venta2dias as WK,
                diasprecio1.p1 as p1,
                diasprecio2.p1 as p2
            from
                mov_salida1 as v
            left join dias1 on
                dias1.bodega = v.bodega
                and dias1.sku = v.sku
            left join dias2 on
                dias2.bodega = v.bodega
                and dias2.sku = v.sku
            left join dias3 on
                dias3.bodega = v.bodega
                and dias3.sku = v.sku
            left join dias4 on
                dias4.bodega = v.bodega
                and dias4.sku = v.sku
            left join dias5 on
                dias5.bodega = v.bodega
                and dias5.sku = v.sku
            left join dias6 on
                dias6.bodega = v.bodega
                and dias6.sku = v.sku
            left join dias7 on
                dias7.bodega = v.bodega
                and dias7.sku = v.sku
            left join dias8 on
                dias8.bodega = v.bodega
                and dias8.sku = v.sku
            left join dias9 on
                dias9.bodega = v.bodega
                and dias9.sku = v.sku
            left join dias10 on
                dias10.bodega = v.bodega
                and dias10.sku = v.sku
            left join dias11 on
                dias11.bodega = v.bodega
                and dias11.sku = v.sku
            left join dias12 on
                dias12.bodega = v.bodega
                and dias12.sku = v.sku
            left join total on
                total.bodega = v.bodega
                and total.sku = v.sku
            left join total2 on
                total2.bodega = v.bodega
                and total2.sku = v.sku
            left join totalx on
                totalx.sku = v.sku
            left join week on
                WEEK.bodega = v.bodega
                and WEEK.sku = v.sku
            left join diasprecio1 on
                diasprecio1.bodega = v.bodega
                and diasprecio1.sku = v.sku
            left join diasprecio2 on
                diasprecio2.bodega = v.bodega
                and diasprecio2.sku = v.sku
            group by
                v.bodega,
                v.sku,
                dias1.venta2dias,
                dias2.venta2dias,
                dias3.venta2dias,
                dias4.venta2dias,
                dias5.venta2dias,
                dias6.venta2dias,
                dias7.venta2dias,
                dias8.venta2dias,
                dias9.venta2dias,
                dias10.venta2dias,
                dias11.venta2dias,
                dias12.venta2dias,
                total.venta2dias,
                total2.venta2dias,
                totalx.venta2dias,
                diasprecio1.p1,
                diasprecio2.p1,
                WEEK.Venta2dias
        ),
        demand as(
            select
                mix.tienda as codigo_bodega,
                mix.sku,
                mix.cod_art,
                case
                    when b.semana1 is null then 0
                    when b.semana1 < 0 then 0
                    when b.semana1 > 22 then 2
                    else b.semana1
                end,
                case
                    when b.semana2 is null then 0
                    when b.semana2 < 0 then 0
                    when b.semana2 > 22 then 2
                    else b.semana2
                end,
                case
                    when b.semana3 is null then 0
                    when b.semana3 < 0 then 0
                    when b.semana3 > 22 then 2
                    else b.semana3
                end,
                case
                    when b.semana4 is null then 0
                    when b.semana4 < 0 then 0
                    when b.semana4 > 22 then 2
                    else b.semana4
                end,
                case
                    when b.semana5 is null then 0
                    when b.semana5 < 0 then 0
                    when b.semana5 > 22 then 2
                    else b.semana5
                end,
                case
                    when b.semana6 is null then 0
                    when b.semana6 < 0 then 0
                    when b.semana6 > 22 then 2
                    else b.semana6
                end,
                case
                    when b.semana7 is null then 0
                    when b.semana7 < 0 then 0
                    when b.semana7 > 22 then 2
                    else b.semana7
                end,
                case
                    when b.semana8 is null then 0
                    when b.semana8 < 0 then 0
                    when b.semana8 > 22 then 2
                    else b.semana8
                end,
                case
                    when b.semana9 is null then 0
                    when b.semana9 < 0 then 0
                    when b.semana9 > 22 then 2
                    else b.semana9
                end,
                case
                    when b.semana10 is null then 0
                    when b.semana10 < 0 then 0
                    when b.semana10 > 22 then 2
                    else b.semana10
                end,
                case
                    when b.semana11 is null then 0
                    when b.semana11 < 0 then 0
                    when b.semana11 > 22 then 2
                    else b.semana11
                end,
                case
                    when b.semana12 is null then 0
                    when b.semana12 < 0 then 0
                    when b.semana12 > 22 then 2
                    else b.semana12
                end,
                b.todos,
                b.todosall,
                b.todosant,
                b.WK,
                b.p1,
                b.p2,
                case
                    when sm.cantidad is null then 0
                    else sm.cantidad
                end as stocktienda,
                case
                    when cd.cantidad is null then 0
                    else cd.cantidad
                end as stockcd,
                case
                    when t.transito is null then 0
                    else t.transito
                end as transito,
                mix.delivery,
                mix.minimo
            from
                mix
            left join stocksem as sm on
                sm.sku = mix.sku
                and sm.bodega = mix.tienda
            left join stockcd as cd on
                cd.sku = mix.sku
            left join tran as t on
                t.bodega = mix.tienda
                and t.sku = mix.sku
            left join base as b on
                b.bodega = mix.tienda
                and b.sku = mix.sku
        ),
        demand2 as(
            select
                codigo_bodega,
                sku,
                cod_art,
                semana1,
                semana2,
                semana3,
                semana4,
                semana5,
                semana6,
                semana7,
                semana8,
                semana9,
                semana10,
                semana11,
                semana12,
                todos,
                todosall,
                todosant,
                WK,
                (
                    semana1*0.25 + semana2*0.2 + semana3*0.1 + semana4*0.07 + semana5*0.05 + semana6*0.05 + semana7*0.05 + semana8*0.05 + semana9*0.05 + semana10*0.05 + semana11*0.05 + semana12*0.03
                ) as calculo,
                case
                    when(
                        case
                            when semana1 > 0
                            and semana2 > 0 then 2
                            else 0
                        end
                    )>(
                        case
                            when semana1 > 0
                            and semana2 = 0
                            and semana3 > 0 then 2
                            else 0
                        end
                    ) then(
                        case
                            when semana1 > 0
                            and semana2 > 0 then 2
                            else 0
                        end
                    )
                    else(
                        case
                            when semana1 > 0
                            and semana2 = 0
                            and semana3 > 0 then 2
                            else 0
                        end
                    )
                end as f1,
                case
                    when(
                        case
                            when stocktienda < 2
                            and semana1 > 0
                            and todos > 2 then 2
                            else 0
                        end
                    )>(
                        case
                            when semana1 > 1
                            and semana2 > 0 then(
                                (
                                    (
                                        semana1 + semana2
                                    )/ 2
                                )* 2
                            )
                            else(
                                case
                                    when semana2 > 0
                                    and semana3 > 0 then 2
                                    else 0
                                end
                            )
                        end
                    ) then(
                        case
                            when stocktienda < 2
                            and semana1 > 0
                            and todos > 2 then 2
                            else 0
                        end
                    )
                    else(
                        case
                            when semana1 > 1
                            and semana2 > 0 then(
                                (
                                    (
                                        semana1 + semana2
                                    )/ 2
                                )* 2
                            )
                            else(
                                case
                                    when semana2 > 0
                                    and semana3 > 0 then 2
                                    else 0
                                end
                            )
                        end
                    )
                end as f2,
                stocktienda,
                stockcd,
                transito,
                delivery,
                minimo,
                p1,
                p2
            from
                demand
        ),
        demand3 as(
            select
                codigo_bodega,
                sku,
                cod_art,
                semana1,
                semana2,
                semana3,
                semana4,
                semana5,
                semana6,
                semana7,
                semana8,
                semana9,
                semana10,
                semana11,
                semana12,
                todos,
                todosall,
                todosant,
                WK,
                p1,
                p2,
                round(( case when f2 > 0 then( case when f2 > calculo*3.7 then f2 else calculo*3.7 end ) else( case when f1 > 0 then( case when f1 > calculo*3.7 then f1 else calculo*3.7 end ) else calculo*2.7 end ) end ), 0 ) as valor,
                case
                    when delivery <> 'D9999' then minimo
                    else(
                        case
                            when calculo > 0.3 then 2
                            else 1
                        end
                    )
                end as maxmix,
                stocktienda,
                stockcd,
                transito,
                delivery,
                minimo,
                calculo,
                trim( case when to_char( current_date, 'd' )= '1' then 'DOMINGO' when to_char( current_date, 'd' )= '2' then 'LUNES' when to_char( current_date, 'd' )= '3' then 'MARTES' when to_char( current_date, 'd' )= '4' then 'MIERCOLES' when to_char( current_date, 'd' )= '5' then 'JUEVES' when to_char( current_date, 'd' )= '6' then 'VIERNES' when to_char( current_date, 'd' )= '7' then 'SABADO' end ) as dia
            from
                demand2
        ),
        maxcompra as(
            select
                sku,
                case
                    when(
                        (
                            case
                                when valor > maxmix then valor
                                else maxmix
                            end
                        )- stocktienda - transito
                    )< 0 then 0
                    else(
                        (
                            case
                                when valor > maxmix then valor
                                else maxmix
                            end
                        )- stocktienda - transito
                    )
                end as compra
            from
                demand3
        ),
        maxcompraacum as(
            select
                sku,
                sum( compra ) as acum
            from
                maxcompra
            group by
                sku
        ),
        maestro as(
            select
                distinct trim( upper( codigo_color )) as codigo_color,
                trim( upper( descripcion_color )) as descripcion_color,
                trim( upper( codigo_talla )) as codigo_talla,
                trim( upper( descripcion_talla )) as descripcion_talla,
                precio_iva_incl as pvp,
                costo,
                trim( upper( marca )) as marca,
                trim( upper( area )) as area,
                trim( upper( linea )) as linea,
                trim( upper( negocio )) as negocio,
                trim( upper( division )) as division,
                trim( upper( temporada )) as temporada,
                trim( upper( desc_producto )) as desc_producto,
                trim( upper( familia )) as familia,
                trim( upper( sub_familia )) as sub_familia,
                trim( upper( sku )) as sku1,
                trim( upper( itemid )) as itemid1,
                trim( upper( categoria )) as categoria,
                trim( upper( desc_producto )) as descripcion
            from
                maestro_articulos
        ),
        maestroc as(
            select
                distinct *
            from
                maestro
        ),
        demand4 as(
            select
                codigo_bodega as warehouse,
                case
                    when codigo_bodega like '%TAG%' then 'TAG'
                    when codigo_bodega like '%TKIV%' then 'TKIV'
                    when codigo_bodega like '%TMAR%' then 'TMAR'
                    when codigo_bodega like '%TMMU%' then 'TMMU'
                    when codigo_bodega like '%TGAP%' then 'TGAP'
                end as tienda,
                demand3.sku as alm_art,
                cod_art as articlecode,
                valor as ordercicle,
                stocktienda as stockonhand,
                stockcd as stockonhandcd,
                (
                    case
                        when valor > maxmix then valor
                        else maxmix
                    end
                ) as orderlevel,
                transito as stockOnOrder,
                case
                    when(
                        (
                            case
                                when valor > maxmix then valor
                                else maxmix
                            end
                        )- stocktienda - transito
                    )< 0 then 0
                    else(
                        (
                            case
                                when valor > maxmix then valor
                                else maxmix
                            end
                        )- stocktienda - transito
                    )
                end as roundedOrderQuantity,
                maxcompraacum.acum as maxstockrounded,
                WK,
                semana1 as demand1,
                semana2 as demand2,
                semana3 as demand3,
                semana4 as demand4,
                semana5 as demand5,
                semana6 as demand6,
                semana7 as demand7,
                semana8 as demanad8,
                stockcd - maxcompraacum.acum as ava_cd_ship,
                'RUTA68' as ALMACEN_ORIGEN,
                codigo_bodega as ALMACEN_DESTINO,
                2 as TIPO_PEDIDO,
                maestroc.itemid1 as ESTILO_COLOR,
                maestroc.codigo_talla as TALLA,
                maestroc.marca as MARCA,
                maestroc.temporada as TEMPORADA,
                maestroc.familia,
                maestroc.sub_familia,
                maestroc.categoria,
                maestroc.pvp,
                maestroc.codigo_talla,
                maestroc.descripcion_color as codigo_color,
                maestroc.area,
                todos,
                todosall,
                todosant,
                calculo,
                p1,
                p2,
                case
                    when dia = 'LUNES'
                    and codigo_bodega in(
                        'TAGAERO',
                        'TGAPVINA',
                        'TGAPTREBOL',
                        'TGAPALC',
                        'TGAPCCENTE',
                        'TGAPLDA',
                        'TGAPPARAUC',
                        'TMMUALC',
                        'TMMUCCENTE',
                        'TMARTEM',
                        'TAGPVESPUC',
                        'TKIVVINA',
                        'TAGTEMUCO',
                        'TAGOSORNO',
                        'TAGPMONTT',
                        'TAGVALDIVI',
                        'TAGMALLSPO',
                        'TAGPEGANA',
                        'TAGEBRO',
                        'TMARCONCEP',
                        'TMARVINA',
                        'TMARPARAUC',
                        'TMARLDA',
                        'TKIVTEMUCO',
                        'TKIVVALDIV',
                        'TKIVPMONTT'
                    ) then date_trunc(
                        'day',
                        current_date
                    )::date + 2
                    when dia = 'MARTES'
                    and codigo_bodega in(
                        'TAGAERO',
                        'TGAPALC',
                        'TGAPCCENTE',
                        'TGAPLDA',
                        'TGAPPARAUC',
                        'TMMUALC',
                        'TMMUCCENTE',
                        'TAGPVESPUC',
                        'TAGTREBOL',
                        'TAGANGELES',
                        'TAGANTOFA',
                        'TAGMALLSPO',
                        'TAGPEGANA',
                        'TAGEBRO',
                        'TMARRANCAG',
                        'TMARPARAUC',
                        'TMARLDA',
                        'TKIVPNORTE',
                        'TKIVCHILLA',
                        'TKIVMAIPU'
                    ) then date_trunc(
                        'day',
                        current_date
                    )::date + 2
                    when dia = 'MIERCOLES'
                    and codigo_bodega in(
                        'TAGAERO',
                        'TGAPALC',
                        'TGAPCCENTE',
                        'TGAPLDA',
                        'TGAPPARAUC',
                        'TMMUALC',
                        'TMMUCCENTE',
                        'TAGPVESPUC',
                        'TAGPARENAS',
                        'TAGMALLSPO',
                        'TAGPEGANA',
                        'TAGEBRO',
                        'TMARPARAUC',
                        'TMARLDA'
                    ) then date_trunc(
                        'day',
                        current_date
                    )::date + 2
                    when dia = 'JUEVES'
                    and codigo_bodega in(
                        'TAGAERO',
                        'TGAPVINA',
                        'TGAPTREBOL',
                        'TGAPALC',
                        'TGAPCCENTE',
                        'TGAPLDA',
                        'TGAPPARAUC',
                        'TMMUALC',
                        'TMMUCCENTE',
                        'TAGPVESPUC',
                        'TMARTEM',
                        'TKIVVINA',
                        'TAGTEMUCO',
                        'TAGOSORNO',
                        'TAGPMONTT',
                        'TAGVALDIVI',
                        'TAGMALLSPO',
                        'TAGPEGANA',
                        'TAGEBRO',
                        'TMARCONCEP',
                        'TMARVINA',
                        'TMARPARAUC',
                        'TMARLDA',
                        'TKIVTEMUCO',
                        'TKIVVALDIV',
                        'TKIVPMONTT'
                    ) then date_trunc(
                        'day',
                        current_date
                    )::date + 4
                    when dia = 'VIERNES'
                    and codigo_bodega in(
                        'TAGAERO',
                        'TGAPALC',
                        'TGAPCCENTE',
                        'TGAPLDA',
                        'TGAPPARAUC',
                        'TMMUALC',
                        'TMMUCCENTE',
                        'TAGPVESPUC',
                        'TAGCURICO',
                        'TAGTALCA',
                        'TAGTREBOL',
                        'TAGANGELES',
                        'TAGANTOFA',
                        'TAGCASTRO',
                        'TAGLOSANDE',
                        'TAGMALLSPO',
                        'TAGPEGANA',
                        'TAGEBRO',
                        'TMARRANCAG',
                        'TMARPARAUC',
                        'TMARLDA',
                        'TKIVCOPIAP',
                        'TKIVCHILLA'
                    ) then date_trunc(
                        'day',
                        current_date
                    )::date + 4
                    when dia = 'DOMINGO'
                    and codigo_bodega in(
                        'TAGAERO',
                        'TAGANGELES',
                        'TAGANTOFA',
                        'TAGCASTRO',
                        'TAGCURICO',
                        'TAGEBRO',
                        'TAGLOSANDE',
                        'TAGMALLSPO',
                        'TAGOSORNO',
                        'TAGPARENAS',
                        'TAGPEGANA',
                        'TAGPMONTT',
                        'TAGPVESPUC',
                        'TAGTALCA',
                        'TAGTREBOL',
                        'TAGVALDIVI',
                        'TKIVCHILLA',
                        'TKIVCOPIAP',
                        'TKIVMAIPU',
                        'TKIVPMONTT',
                        'TKIVPNORTE',
                        'TKIVTEMUCO',
                        'TKIVVALDIV',
                        'TKIVVINA',
                        'TMARCONCEP',
                        'TMARLDA',
                        'TMARPARAUC',
                        'TMARRANCAG',
                        'TMARTEM',
                        'TMARVINA'
                    ) then date_trunc(
                        'day',
                        current_date
                    )::date + 4
                end as FECHA_DESPACHO,
                case
                    when(
                        (
                            case
                                when valor > maxmix then valor
                                else maxmix
                            end
                        )- stocktienda - transito
                    )< 0 then 0
                    else(
                        (
                            case
                                when valor > maxmix then valor
                                else maxmix
                            end
                        )- stocktienda - transito
                    )
                end as CANTIDAD,
                transito as TRANSITO,
                delivery,
                minimo,
                descripcion
            from
                demand3
            left join maxcompraacum on
                maxcompraacum.sku = demand3.sku
            left join maestroc on
                maestroc.sku1 = demand3.sku
        ),
        maxcompracd as(
            select
                alm_art,
                sum( roundedOrderQuantity ) as sumacompra
            from
                demand4
            where
                FECHA_DESPACHO is not null
                and stockonhandcd > 0
            group by
                alm_art
        ),
        maxbodega as(
            select
                warehouse,
                sum( roundedOrderQuantity ) as sumatienda
            from
                demand4
            where
                stockonhandcd > 0
            group by
                warehouse
        ) select
            demand4.warehouse,
            tienda,
            demand4.alm_art,
            articlecode,
            ordercicle,
            stockonhand,
            stockonhandcd,
            orderlevel,
            stockOnOrder,
            roundedOrderQuantity,
            maxcompracd.sumacompra as maxstockrounded,
            WK,
            demand1,
            demand2,
            demand3,
            demand4,
            demand5,
            demand6,
            demand7,
            demanad8,
            stockonhandcd - maxcompracd.sumacompra as ava_cd_ship,
            ALMACEN_ORIGEN,
            ALMACEN_DESTINO,
            TIPO_PEDIDO,
            ESTILO_COLOR,
            TALLA,
            MARCA,
            FECHA_DESPACHO,
            CANTIDAD,
            TRANSITO,
            delivery,
            minimo,
            TEMPORADA,
            familia,
            sub_familia,
            categoria,
            pvp,
            codigo_talla,
            codigo_color,
            area,
            descripcion,
            case
                when todos is null then 0
                else todos
            end as todos,
            case
                when todosall is null then 0
                else todosall
            end as todosall,
            case
                when todosant is null then 0
                else todosant
            end as todosant,
            p1,
            p2,
            calculo
        from
            demand4
        left join maxcompracd on
            maxcompracd.alm_art = demand4.alm_art
        left join maxbodega on
            maxbodega.warehouse = demand4.warehouse
        where
            marca = 'MARMOT'"));

        return view('sugerido_distribucion.body');

    //$sugerido = $this->sugerido();

    }

/**Calculo del súgerido  */

    public function sugerido()
    {
        DB::table('sugeridos')->truncate();

     $tabla_sugerido = DB::select(\DB::raw('insert into sugeridos 
        select distinct(calculos.articlecode) as cod_art, round(score_m1) as forecast,  calculos.ordercicle as ordercicle, calculos.minimo as minimo, case when round(score_m1) >= orderlevel then round(score_m1) else orderlevel end as sugerido 
        from calculos
        left join forecast_marmot on forecast_marmot.cod_art = calculos.articlecode'));

 /*        $tabla_sugerido = DB::table('calculos')
            ->leftjoin('forecast_marmot','forecast_marmot.cod_art', '=', 'calculos.articlecode')
            ->select(\DB::raw('calculos.articlecode as cod_art, calculos.minimo as minimo,
                           calculos.ordercicle as ordercicle, round(score_m1) as score_m1,
                           case when round(score_m1) >= orderlevel then round(score_m1) else orderlevel end as sugerido'))
            ->get();

        foreach($tabla_sugerido as $s){
            $sugerido = new Sugerido_d();
            $sugerido->cod_art = $s->cod_art;
            $sugerido->minimo = $s->minimo;
            $sugerido->forecast = $s->score_m1;
            $sugerido->ordercicle = $s->ordercicle;
            $sugerido->sugerido = $s->sugerido;
            $sugerido->save();
        }

    
        //$tabla_sugerido =  DB::table('sugeridos')->get();

*/
        return view('sugerido_distribucion.body');


    }


    /**
     * Descaraga la data en un csv
     */

    public function download(){

        $datos = DB::table('sugeridos')->get();

        $contenidoCsv = [];
        //headers del csv
        array_push($contenidoCsv, array('cod_art', 'forecast', 'ordercicle', 'minimo', 'sugerido'));
        //agrego los datos al array
        foreach ($datos as $registro) {
            array_push($contenidoCsv, array($registro->cod_art, $registro->forecast, $registro->ordercicle, $registro->minimo, $registro->sugerido));
        }
        //fecha para crear el nombre
        $fecha = date('Ymdhis');
        $nombreCsv = "sugeridos_".$fecha.'.csv';

        //llama al metodo para crear el csv
        Convert_to_csv::create($contenidoCsv, $nombreCsv, ',');

        return view('sugerido/download');
    }
}
