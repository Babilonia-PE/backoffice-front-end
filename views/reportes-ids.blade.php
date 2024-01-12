@extends('Layout.master')

@section('styles')

@endsection

@section('page')

Reportes

@endsection

@section('content')
<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Generar reporte de ID's</h3>
    </div>

    <div class="card-body">
        <form>            
            <div class="form-group">

                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputCSV" accept=".csv" required>
                    <label class="custom-file-label" for="inputCSV">Seleccione CSV</label>
                </div>
            </div>
            <div class="form-group">
                    <button class="btn btn-primary">Generar</button>
            </div>
        </form>
    </div>

</div>

@endsection

@section('scripts')
<script src="@asset("js/reportes/generarExcel.js")"></script>
@endsection