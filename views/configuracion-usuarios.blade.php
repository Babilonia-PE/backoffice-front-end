@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<!-- Select2 -->
<link rel="stylesheet" href="@asset('public/plugins/select2/css/select2.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/assets/css/jquery.nestable.css')?{{env('APP_CSS_VERSION')}}">
<style>
.socialite { display: block; float: left; height: 35px; }
.gap-1{gap: 0.5rem}
.gap-2{gap: 1rem}
.gap-3{gap: 1.5rem}
</style>
@endsection

@section('page')

Administración de usuarios

@endsection

@section('content')
<div class="row">
	<div class="col-12">

		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">Administración de usuarios</h3>
			</div>
			<div class="card-body">

				<div class="card-body table-responsive">					
					<table class="display table table-striped nowrap compact responsive" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Nombre</th>
								<th width="150">Usuario</th>
								<th width="100">Correo</th>
								<th width="100">Celular</th>
								<th width="100">DNI</th>
								<th width="100">Permissions</th>
								<th width="80">Estado</th>
								<th width="80">2FA</th>
								<th width="100">acciones</th>
							</tr>
						</thead>
						@foreach ($data as $item)
							<tr>
								<td>{{ $item["fullname"] ?? '' }}</td>
								<td>{{ $item["username"] ?? '' }}</td>
								<td>{{ $item["email"] ?? '' }}</td>
								<td>{{ $item["celular"] ?? '' }}</td>
								<td>{{ $item["dni"] ?? '' }}</td>
								<td>{{ $item["permissionsValue"] ?? '' }}</td>
								<td><span class="badge btn {{ $item["stateClase"]??'' }}" disabled="true">{{ $item["stateValue"] }}</span></td>
								<td><span class="badge btn {{ $item["authClase"]??'' }}" disabled="true">{{ $item["authValue"] }}</span></td>
								<td>
									<div class="dropdown">
										<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
											Acciones
										</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="/administradores/{{ $item["dni"]?$item["dni"].'/user':'' }}"><i class="fas fa-edit"></i>&nbsp;&nbsp;Editar</a>
											<form action="/2fa" method="POST">
												<input type="hidden" name="type" value="delete" />
												<input type="hidden" name="username" value="{{ $item["username"] ?? '' }}">
												<button class="dropdown-item" type="submit"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Eliminar</button>
											</form>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					</table>
				</div>

			</div>

		</div>

	</div>
</div>

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
<script>
	$(document).ready( function () {
		$('.table').DataTable();
	} );
</script>
@endsection