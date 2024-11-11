@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/LibDataTables/ColReorder-1.7.0/css/colReorder.dataTables.min.css')?{{env('APP_CSS_VERSION')}}">
<!-- Select2 -->
<link rel="stylesheet" href="@asset('public/plugins/select2/css/select2.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
<style>
	
    /*
    @media(max-width: 575px) {
		div.dtsp-panesContainer div.dtsp-searchPanes div.dtsp-searchPane {
			max-width: 100%;
		}
    }
	.dtsp-searchPane:first-child {
		display: none;
	}*/
	div.dataTables_wrapper div.dataTables_processing {
		position: fixed;
		top: 30%!important;
		left: calc(50% - 100px);
		/*left: 50%;*/
		margin: 0;
		z-index: 999;
		width: 200px;
	}
    .dataTables_wrapper .dt-buttons{
        gap: .5rem;
    }
    .dataTables_wrapper .dataTables_length label{
        margin: .5rem;
    }
    .table td, .table th {
        padding: 0.3rem 0.5rem;
    }
	.dtr-bs-modal{
		padding: 0!important;
	}
	span.dtr-data {
		word-wrap: unset;
		overflow-wrap: anywhere;
		text-wrap: wrap;
	}
    @media(max-width: 575px) {
        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            justify-content: center;
            flex-wrap: wrap;
        }
    }
	.box-details{
		display: flex;
		flex-direction: row;
		gap: 1rem;
		align-items: center;
    	padding: 0.3rem 0.5rem;
	}
	.box-details:not(:last-child) {
		border-bottom: 1px solid #dee2e6;
	}
	.box-details > div{
		overflow-wrap: anywhere;
	}
	.box-details > div:last-child {
		flex: 1;
	}
	.box-details > div:first-child {
		font-weight: 600;
	}
	.badge:is(.published,.not_published,.unpublished,.expired,.deleted){
		box-shadow: 2px 2px 17px 1px rgba(0, 0, 0, 0.2)
	}
	.badge{
		box-shadow: 1px 1px 4px 0px rgba(0,0,0,0.15);
	}
	.badge.published{
		background-color: #198754;
		color: #ffffff;
	}
	.badge.not_published{
		background-color: #ffffff;
		color: #000000;
	}
	.badge.unpublished{
		background-color: #ff8300;
		color: #000000;
	}
	.badge.expired{
		background-color: #dc3545;
		color: #ffffff;
	}
	.badge.deleted{
		background-color: #000000;
		color: #ffffff;
	}
    @media(max-width: 400px) {
		.box-details{
			flex-direction: column;
			gap: 0rem;
			align-items: start;
        }
    }
	.chatdetail{
		display: flex;
		flex-direction: column;
		gap: 1rem;
	}
	.chatdetail > div{
		display: flex;
		flex-direction: column;
    	align-items: flex-start;
	}
	.chatdetail > div.user{
    	align-items: flex-end;
	}
	.chatdetail p.message{
		max-width: 85%;
		margin: 0;
		border-radius: 20px;
		padding: 10px;
		background: #ededed;
		color: #212529;
    	border-top-left-radius: 0;
	}
	
	.chatdetail > div.user p.message{
		background: #5585ff;
		color: #FFF;
		border-radius: 20px;
		border-top-right-radius: 0;
	}
	.chatdetail span.date{
		display: inline-block;
		background: #f7f7f7;
		border-radius: 6px;
		border: 1px solid white;
		line-height: 9px;
		position: relative;
		z-index: 99;
		padding: 2px 3px;
		color: #858585;
		font-size: 14px;
	}
	#rowDetails{
		max-height: 100%;
	}
</style>
@endsection

@section('page')

Equipos

@endsection

@section('content')
<div class="row">
	<div class="col-12">
        <div id="filter_box" class="card collapsed-card">
			<div class="card-header" role="button" data-card-widget="collapse">
                <h5 class="card-title">Filtros de búsqueda</h5>
                <div class="card-tools">
                  	<button type="button" class="btn btn-tool">
                    	<i id="icon_filter_box" class="fas fa-plus"></i>
                  	</button>
                </div>
            </div>
            <div class="card-body">
				<div class="row align-items-end">
					<div class="col-md-6">
                		<div class="form-group">
                  			<label>Propietario del equipo</label>
							@component("components.search-user", ['id'=>'owner_id', 'storage'=>'filter_team_owners'])
							@endcomponent
                		</div>
                	</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="form-row">
								<div class="col-sm-6 pb-2 pb-sm-0">
									<button id="applyfiltters" type="button" class="btn btn-primary btn-block text-truncate"><i class="fas fa-filter"></i> Aplicar filtros</button>
								</div>
								<div class="col-sm-6">
									<button id="removefiltters" type="button" class="btn btn-secondary btn-block text-truncate"><i class="fas fa-trash"></i> Limpiar filtros</button>
								</div>
							</div>
						</div>
					</div>
                </div>
			</div>
        </div>
	</div>
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
				<p class="text-center" name="loading"><img src="public/assets/img/loading.gif" width="50" /></p>
                <table class="display table table-bordered table-hover nowrap compact responsive d-none" cellspacing="0" width="100%">
                    
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade p-0" id="rowDetails" tabindex="-1" role="dialog" aria-labelledby="rowDetailsLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<h5 class="modal-title">Detalles para</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="@asset('public/plugins/LibDataTables/datatables.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/LibDataTables/ColReorder-1.7.0/js/dataTables.colReorder.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/assets/js/components/datatable.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- Select2 -->
<script src="@asset('public/plugins/select2/js/select2.full.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/datetimepicker/date-time-picker.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script>
	//ESTBALECER MASCARAS
	setMask('#created_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#created_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	//DEFINIR DATEPICKER
	$('#created_start').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#created_end').dateTimePicker({format: 'dd/MM/yyyy'});
</script>
<script>
	const headers = [
			{ "title": "User ID", "code": "owner_id", "sortable": true },
			{ "title": "Nombre", "code": "full_name" },
			{ "title": "Correo", "code": "email" },
			{ "title": "Teléfono", "code": "phone_number" },
			{ "title": "Acciones" }
	];
	const filtersFields = [
		{
			name: 'parent',
			type: 'static',
			value: 'team'
		},
		{
			name: 'child',
			type: 'static',
			value: 'header'
		},
		{
			name: 'owner_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_team_owners'
		}
	];
	const processParams = (element) =>{
		return [
			element.owner_id??'',		
			element.full_name??'',
			element.email??'',
			getFullNumber(element.prefix, element.phone_number)
		];
	}
	const modalOrder =  [];
	const modalTitle = (element, globalRecords = []) =>{}
	const columnsHidden = [];
	const columnsDates = [1];
	const modalFunction = {
		show : async (id = '') => {
			const params = {
				parent: 'team',
				child: 'detail',
				owner_id: id,
				order_by: 'id',
				sort_by: 'asc'
			};
			const details = await fetchData('app/gateway', params, 'GET');
			const data = details?.data?.data?.records??null;
			$("#rowDetails .modal-title").html("Miembros del equipo");
			$("#rowDetails .modal-body .table-responsive").html("");
			const loader = jQuery('<p>', {
				'class': 'text-center',
				'name': 'members-loader',
				'html' : '<img src="public/assets/img/loading.gif" width="50" />'
			});
			const table = jQuery('<table>', {
				'id': 'members-table',
				'class': 'display table table-bordered table-hover nowrap compact responsive d-none',
				'width': '100%',
				'html' : `
					<thead>
						<th>Id</th>
						<th>Nombres</th>
						<th>Última actividad</th>
						<th>Correo</th>
						<th>Teléfono</th>
						<th>Estado</th>
						<th>Permisos</th>
						<th>Fecha de creación</th>
						<th>Fecha de actualización</th>
					</thead>
					<tbody id="team_members"></tbody>
				`
			});
			loader.appendTo("#rowDetails .modal-body .table-responsive");
			table.appendTo("#rowDetails .modal-body .table-responsive");
			data.forEach(element => {
				const user_id = jQuery( '<td>', { text: element.user_id??'' } );
				const full_name = jQuery( '<td>', { text: element.full_name??'' } );
				const last_activity = jQuery( '<td>', { text: element.last_activity??'' } );
				const email = jQuery( '<td>', { text: element.email??'' } );
				const phone = jQuery( '<td>', { html: getFullNumber(element.prefix, element.phone_number) } );
				const state = jQuery( '<td>', { text: element.state??'' } );
				const profile = jQuery( '<td>', { text: element.profile??'' } );
				const created_at = jQuery( '<td>', { text: element.created_at??'' } );
				const updated_at = jQuery( '<td>', { text: element.updated_at??'' } );

				const row = jQuery('<tr>');
				user_id.appendTo(row);
				full_name.appendTo(row);
				last_activity.appendTo(row);
				email.appendTo(row);
				phone.appendTo(row);
				state.appendTo(row);
				profile.appendTo(row);
				created_at.appendTo(row);
				updated_at.appendTo(row);
				row.appendTo('#team_members');
			});
		},
		shown : async (id = '') => {
			$("#members-table").DataTable({
				"bDestroy": true,
				"initComplete": function(settings, json) {
					$( 'p[name=\'members-loader\']' ).remove();
					$(this).removeClass( 'd-none' );
				},
			});
		},
		hidden : () => {
			$("#rowDetails .modal-body .table-responsive").html("");
		}
	}
	const options = {
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_team',
		modalFunction,
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		url: 'app/gateway'
	};
	
	datatable(options);
</script>
@endsection