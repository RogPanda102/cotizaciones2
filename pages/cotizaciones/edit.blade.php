@extends('layouts.app')
@section('content')
@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div x-data="cotizacionForm({
    tipo: '{{ old('tipo_cotizacion', $cotizacion->tipo_cotizacion) }}',
    estado: '{{ old('estado', $cotizacion->estado) }}'
})" class="container">

<form method="POST" action="{{ route('cotizaciones.update', $cotizacion) }}">
    @csrf
    @method('PUT')

    <!-- BASE -->
    <div class="card mb-3">
        <div class="card-header fw-bold">Información base</div>
        <div class="card-body row">

            <div class="col-md-4">
                <label>Empresa</label>
                <select name="empresa_id" class="form-control" required>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}"
                            {{ old('empresa_id', $cotizacion->empresa_id) == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Tipo</label>
                <select name="tipo_cotizacion" x-model="tipo" class="form-control" required>
                    <option value="omg">OMG</option>
                    <option value="dependencia_directa">Dependencia directa</option>
                    <option value="cliente_externo">Cliente externo</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Estado</label>
                <select name="estado" x-model="estado" class="form-control" required>
                    <option value="enviado">Enviado</option>
                    <option value="respaldo">Respaldo</option>
                    <option value="no_cotiza">No cotiza</option>
                </select>
            </div>

            <div class="col-md-6 mt-3">
                <label>Número</label>
                <input type="number" name="numero_cotizacion"
                    value="{{ old('numero_cotizacion', $cotizacion->numero_cotizacion) }}"
                    class="form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label>Folio</label>
                <input type="text" name="folio_externo"
                    value="{{ old('folio_externo', $cotizacion->folio_externo) }}"
                    class="form-control">
            </div>

        </div>
    </div>

    <!-- RELACIONES -->
    <div class="card mb-3">
        <div class="card-body row">

            <div class="col-md-4">
                <label>Dependencia</label>
                <select name="dependencia_id"
                        class="form-control"
                        x-bind:disabled="tipo === 'cliente_externo'">
                    @foreach($dependencias as $dep)
                        <option value="{{ $dep->id }}"
                            {{ old('dependencia_id', $cotizacion->dependencia_id) == $dep->id ? 'selected' : '' }}>
                            {{ $dep->nombre_oficial }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Departamento</label>
                <select name="departamento_id"
                        class="form-control"
                        x-bind:disabled="tipo === 'cliente_externo'">
                    @foreach($departamentos as $dep)
                        <option value="{{ $dep->id }}"
                            {{ old('departamento_id', $cotizacion->departamento_id) == $dep->id ? 'selected' : '' }}>
                            {{ $dep->nombre_departamento }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4" x-show="tipo !== 'cliente_externo'">
                <label>Analista</label>
                <select name="analista_id"
                        class="form-control"
                        x-bind:disabled="tipo === 'cliente_externo'">
                    @foreach($analistas as $a)
                        <option value="{{ $a->id }}"
                            {{ old('analista_id', $cotizacion->analista_id) == $a->id ? 'selected' : '' }}>
                            {{ $a->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <!-- FECHAS -->
    <div class="card mb-3">
        <div class="card-body row">

            <div class="col-md-6">
                <label>Fecha envío</label>
                <input type="date"
                       name="fecha_envio"
                       value="{{ old('fecha_envio', optional($cotizacion->fecha_envio)->format('Y-m-d')) }}"
                       class="form-control"
                       x-bind:disabled="estado !== 'enviado'">
            </div>

            <div class="col-md-6">
                <label>Fecha recepción</label>
                <input type="date"
                       name="fecha_recepcion"
                       value="{{ old('fecha_recepcion', optional($cotizacion->fecha_recepcion)->format('Y-m-d')) }}"
                       class="form-control">
            </div>

        </div>
    </div>

    <!-- ENTREGA -->
    <div class="card mb-3" x-show="tipo !== 'cliente_externo'">
        <div class="card-body row">

            <div class="col-md-6">
                <label>Horario</label>
                <input type="time"
                       name="horario_de_entrega"
                       value="{{ old('horario_de_entrega', optional($cotizacion->horario_de_entrega)->format('H:i')) }}"
                       class="form-control"
                       x-bind:disabled="tipo === 'cliente_externo'">
            </div>

            <div class="col-md-6">
                <label>Lugar</label>
                <input type="text"
                       name="lugar_de_entrega"
                       value="{{ old('lugar_de_entrega', $cotizacion->lugar_de_entrega) }}"
                       class="form-control"
                       x-bind:disabled="tipo === 'cliente_externo'">
            </div>

        </div>
    </div>

    <!-- FINANCIEROS -->
    <div class="card mb-3" x-show="tipo === 'omg'">
        <div class="card-body row">

            <input type="number" name="monto_total"
                   value="{{ old('monto_total', $cotizacion->monto_total) }}"
                   x-bind:disabled="tipo !== 'omg'">

            <input type="number" name="dias_credito"
                   value="{{ old('dias_credito', $cotizacion->dias_credito) }}"
                   x-bind:disabled="tipo !== 'omg'">

        </div>
    </div>

    <button class="btn btn-primary">Actualizar</button>
</form>
</div>
<script>
function cotizacionForm(data) {
    return {
        tipo: data.tipo,
        estado: data.estado
    }
}
</script>
@endsection