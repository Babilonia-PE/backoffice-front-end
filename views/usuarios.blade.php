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
		left: 50%;
		margin: 0;
		z-index: 999;
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
	.badge{
		box-shadow: 1px 1px 4px 0px rgba(0,0,0,0.15);
	}
	.badge.badge-1{
		background-color: #198754;
		color: #ffffff;
	}
	.badge.badge-3{
		background-color: #ffffff;
		color: #000000;
	}
	.badge.badge-2{
		background-color: #dc3545;
		color: #ffffff;
	}
	.badge.badge-4{
		background-color: #083766;
		color: #ffffff;
	}
	.badge.badge-5{
		background-color: #000000;
		color: #ffffff;
	}
	.badge[data-copy]{
		border: none;
	}
	.table tbody tr td button[data-copy="inner"]{
		display: none !important;
	}
    @media(max-width: 400px) {
		.box-details{
			flex-direction: column;
			gap: 0rem;
			align-items: start;
        }
    }
	.open-modal{
		cursor: pointer;
	}
</style>
@endsection

@section('page')

Usuarios

@endsection

@section('content')

<div class="row">
	<div class="col-12">
        <div id="filter_box" class="card">
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
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Usuario</label>
                  			<input type="text" class="form-control form-control-sm" id="user" placeholder="User ID, nombre, correo o telefono">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Empresa</label>
                  			<input type="text" class="form-control form-control-sm" id="company" placeholder="RUC, razon social o nombre comercial">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Estado</label>
							@component("components.select", ['data'=>APP_LANG_USER_STATE, 'id' => "state", 'placeholder' => 'Estado', 'first' => true])
							@endcomponent  
                		</div>
                	</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de creación (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="created_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="created_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group custom-control">
							<input type="checkbox" class="custom-control-input" id="only_agents" value="true">
							<label class="custom-control-label" for="only_agents">Ver solo agentes</label>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<div class="form-row">
								<div class="col-sm-6 pb-2 pb-sm-0">
									<button id="applyfiltters" type="button" class="btn btn-primary btn-block text-truncate btn-sm"><i class="fas fa-filter"></i> Aplicar filtros</button>
								</div>
								<div class="col-sm-6">
									<button id="removefiltters" type="button" class="btn btn-secondary btn-block text-truncate btn-sm"><i class="fas fa-trash"></i> Limpiar filtros</button>
								</div>
							</div>
						</div>
					</div>
                </div>
			</div>
        </div>
	</div>
    <div id="table-box" class="col-12 d-none">
        <div class="card">
            <div class="card-body table-responsive table-usuarios">
				<p class="text-center" name="loading"><img src="public/assets/img/loading.gif" width="50" /></p>
                <table class="display table table-bordered table-hover nowrap compact responsive d-none" cellspacing="0" width="100%">
                    
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade p-0" id="rowDetails" tabindex="-1" role="dialog" aria-labelledby="rowDetailsLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<h5 class="modal-title">Detalles para</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="box-details"></div>
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
	showMessage();
</script>
<script type="module">
	const { Modal } = await import (`/public/assets/js/components/modal.js`);		
	const headers = [
		{ "title": "ID", "code": "id", "sortable": true },
		{ "title": "Nombre", "code": "full_name", "sortable": true },
		{ "title": "Verif. correo" },
		{ "title": "Email", "code": "email", "sortable": true },
		{ "title": "Verif. Telefono" },
		{ "title": "Teléfono", "code": "phone_number", "sortable": true },
		{ "title": "Tarjeta asociada" },
		{ "title": "Nombre comercial" },
		{ "title": "Fecha de creación", "code": "created_at", "sortable": true },
		{ "title": "Fecha de último acceso", "code": "last_login", "sortable": true },
		{ "title": "Estado", "code": "state", "sortable": true },
		{ "title": "Razon social" },
		{ "title": "RUC" },
		{ "title": "Dirección" },
		{ "title": "Descripción" },
		{ "title": "Colecciones" },
		{ "title": "Interesados" },
		{ "title": "Avisos" },
		{ "title": "Proyectos" },
		{ "title": "Estadísticas" },
		{ "title": "URL" },			
		{ "title": "Auth", "code": "sign_method", "sortable": true },
		{ "title": "Fecha de actualización" },
		{ "title": "Acciones" }
	];
	const filtersFields = [
		{
			name: 'parent',
			type: 'static',
			value: 'user'
		},
		{
			name: 'child',
			type: 'static',
			value: 'users'
		},
		{
			name: 'user'
		},
		{
			name: 'company'
		},
		{
			name: 'state'
		},
		{
			name: 'created_start',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'created_end',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'only_agents',
			type: filtersParamsTypes.CHECKBOX
		}
	];
	const processParams = (element) =>{

		let urlClient = URL_WEB_FRONT + ((element.url && element.url!=null)?element.url:'');
		let card_action = ( element?.card??false ) ? true : false;
		let card_data = ( card_action ) ? 'data-id="' + ( element.id??'' ) + '"' : '';
		let card_class = ( card_action ) ? 'open-modal"' : '';
		return [
			element.id??'',
			element.full_name??'',
			(element.verify?.email??false ? `<span class="badge text-bg-secondary badge-4">Verificado</span>` : `<span class="badge text-bg-secondary badge-2">No verificado</span>`),
			(element.email) ? `${element.email} <button class="badge text-bg-primary btn-primary text-danger-emphasis text-dark" type="button" data-copy="inner" data-value="${element.email}"><i class="far fa-copy text-white"></i></button>`:'',
			(element.verify?.phone_number??false ? `<span class="badge text-bg-secondary badge-4">Verificado</span>` : `<span class="badge text-bg-secondary badge-2">No verificado</span>`),
			getFullNumber(element.prefix, element.phone_number),
			(`<span ${card_data} class="badge text-bg-secondary badge-${(element?.card??false) ? 1 : 2} ${card_class}">${(element?.card??false) ? 'SI' : 'NO'}</span>`),
			( ( element.company ) ? element.company.commercial_name??'':'' ),
			element.created_at??'',
			element.last_login??'',
			(`<span class="badge text-bg-secondary badge-${element.state_id}">${element.state}</span>`),
			( ( element.company ) ? element.company.name??'':'' ),
			( ( element.company ) ? element.company.id??'':'' ),
			( ( element.company ) ? element.company.commercial_address??'':'' ),
			( ( element.company ) ? element.company.commercial_description??'':'' ),
			( element.permissions??{} ).collections? 'SI':'NO',
			( element.permissions??{} ).interested? 'SI':'NO',
			( element.permissions??{} ).my_listings? 'SI':'NO',
			( element.permissions??{} ).my_projects? 'SI':'NO',
			( element.permissions??{} ).stadistics? 'SI':'NO',
			( element.url && element.url!=null) ? `<a href="${urlClient}" target="_blank">${urlClient} <i class="fas fa-external-link-alt"></i></a>` : '',							
			( element.sign_method??"" ),
			element.update_at??''
		];
	}
	const modalOrder =  [];
	const modalTitle = (element, globalRecords = []) =>{
	}
	const initParams = ()=>{
		copyToClipboard();
	}
	const initParamsModal = ()=>{
		copyToClipboard();
	}
	const columnsHidden = [2, 4, 9, 11, 12, 13, 14, 15, 16, 17, 18,19,20, 21, 22];
	const columnsDates = [8, 21];
	const download = { active: true, filename: 'Usuarios.xlsx' };
	const recovery_password = { active: true };
	const crud = {
		view: true,
		delete: {
			active: true,
			conditions: [
				{
					key: 'state',
					operator: "!=",
					value: 'Eliminado'
				}
			],
			key: 'user_id'
		}
	}
	const options = {
		recovery_password,
		crud,
		download,
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_usuarios',
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		initParams,
		initParamsModal,
		url: 'app/gateway'
	};
	
	datatable(options);

	copyToClipboard();
	$(document).on('click', 'span.open-modal', async function () {
		/*
		const id = $(this).attr('data-id');
		const params = {
			parent: 'card',
			owner_id: id,
			page: 1,
			per_page: 25
		}
		const response = await fetchData('app/gateway', params, 'GET');	
		const cards = response?.data?.data?.records??null;
		console.log(cards);
		*/
		const id = $(this).attr('data-id');
		const structure = {
			type:'cards'
		}
		const funtions = {
			shown:{
				function: async () => {
					const headers = [
						{ "title": "Primaria" },
						{ "title": "Proveedor" },
						{ "title": "Tipo" },
						{ "title": "Nombre" },
						{ "title": "Número" },
						{ "title": "Fecha de expiración" },
						{ "title": "Estado" },
					];
					const processParams = (element) =>{
						return [
							( element.primary??false) ? 'SI' : 'NO',
							element.provider??'',
							element.type??'',
							element.name??'',
							element.number??'',
							element.expiration??'',
							element.state??''
						];
					}
					const filtersFields = [
						{
							name: 'parent',
							type: 'static',
							value: 'card'
						},
						{
							name: 'owner_id',
							type: 'static',
							value: id
						}
					];
					const returnTable = {
						attr: 'id',
						value: 'cards-table',
						dom: 'rtip'
					}
					const options = {
						headers,
						processParams,
						filtersFields,
						returnTable,
						url: 'app/gateway'
					};
					
					datatable(options);
				}
			}
		}
		new Modal(structure, funtions);
		return;
	});
</script>
@endsection