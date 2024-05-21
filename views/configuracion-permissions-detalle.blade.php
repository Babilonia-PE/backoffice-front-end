@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<!-- Select2 -->
<link rel="stylesheet" href="@asset('public/plugins/select2/css/select2.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">

<style>
    .socialite {
        display: block;
        float: left;
        height: 35px;
    }

    .gap-1 {
        gap: 0.5rem
    }

    .gap-2 {
        gap: 1rem
    }

    .gap-3 {
        gap: 1.5rem
    }
</style>
@endsection

@section('page')

{{ $data["title"]??'' }}

@endsection

@section('content')
<form action="/permisos" method="POST">
    <div class="row">
        <div class="col-12">

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Detalle</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombrePermisos">Nombre</label>
                        <input type="text" class="form-control" id="nombrePermisos" name="nombrePermisos" placeholder="Nombre" value="{{ $data["name"]??'' }}" required>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Vista</th>
                                        @foreach($data["actions"] as $action)
                                            <th width="120px">{{ $action }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data["permissions"] as $k => $permission)
                                    <tr>
                                        <td>
                                            @if (isset($permission["url"]) && ($permission["url"] == '' || $permission["url"]== '#'))<strong>@endif
                                            {{ $permission["label"] }}
                                            @if (isset($permission["url"]) && ($permission["url"] == '' || $permission["url"]== '#'))</strong>@endif
                                            <input type="hidden" name="form[{{ $k }}][id]" value="{{ $permission["id"]??'' }}">
                                            <input type="hidden" name="form[{{ $k }}][url]" value="{{ $permission["url"]??'' }}">
                                            <input type="hidden" name="form[{{ $k }}][label]" value="{{ $permission["label"]??'' }}">
                                            <input type="hidden" name="form[{{ $k }}][controller]" value="{{ $permission["controller"]??'' }}">
                                        </td>

                                        @foreach($data["actions"] as $ak => $action)
                                            @if(isset($permission[$ak]))
                                            <td width="120px">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="checkbox{{ $ak }}{{ $k }}" name="form[{{ $k }}][{{ $ak }}]" @if($permission[$ak]===true) checked @endif>                                                    
                                                    <label for="checkbox{{ $ak }}{{ $k }}"></label>
                                                </div>
                                            </td>
                                            @endif
                                        @endforeach                                        
                                    </tr>
                                    @endforeach      
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <div class="d-flex flex-row gap-1">

                        <input type="hidden" name="type" value="{{ $data["type"]??'' }}">
                        <input type="hidden" name="id" value="{{ $data["id"]??'' }}">

                        <button type="submit" class="btn btn-success">Guardar</button>
                        <a href="/permisos" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@section('scripts')
<script src="@asset('public/plugins/LibDataTables/datatables.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- Select2 -->
<script src="@asset('public/plugins/select2/js/select2.full.min.js')?{{env('APP_JS_VERSION')}}"></script>
@endsection
@push("child-scripts")
<script>
    $("#nombrePermisos").on("input", function(e){
        $(".content-header h1").html((e.target.value && e.target.value!="")?e.target.value:'{{ $data["title"]??'' }}');
    });
</script>
@endpush