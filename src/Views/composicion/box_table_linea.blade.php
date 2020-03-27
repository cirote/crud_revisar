<tr>
    <td style="text-align: center">
        @lang('regimenes::regimenes.notificaciones_semestre', ['semestre' => $periodo->semestre, 'ano' => $periodo->anio])
    </td>

    @foreach(['ARG', 'BRA', 'PRY', 'URY', 'VNZ'] as $informante)

        @php(
            $e = $regimen->listas->filter
            (
                function ($lista) use ($periodo, $informante)
                {  
                    return $lista->notificacion->informante == $informante && $lista->anio == $periodo->anio && $lista->semestre == $periodo->semestre; 
                }
            )
            ->first()
        )

        @if($e)
            <td style="text-align: center">
                @if(0)
                    <a href="/rei/items" class="product-title">
                @endif    
                    @lang('regimenes::regimenes.notificaciones_nota', ['nota' => $e->notificacion->nota, 'fecha' => $e->notificacion->fecha->format('d/m/Y')])
                @if(0)
                    </a>
                @endif
                 &nbsp;
                <a href="{{ route('regimenes.lista.nota', ['lista' => $e]) }}" class="product-title"><i class="fa fa-clone"></i></a> &nbsp;
                <a href="{{ route('regimenes.lista.tabla', ['lista' => $e]) }}" class="product-title"><i class="fa fa-table"></i></a>
            </td>
            @else
            <td></td>
        @endif

    @endforeach
</tr>