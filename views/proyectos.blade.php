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
</style>
@endsection

@section('page')

Proyectos

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
                  			<label>ID del proyecto</label>
                  			<input type="text" class="form-control form-control-sm" id="id" placeholder="ID del aviso">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Estado</label>
							  @component("components.select", ['data'=>APP_LANG_STATE, 'id' => "state", 'placeholder' => 'Estado', 'first' => true])
							  @endcomponent                  			
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo de proyecto</label>
							  @component("components.select", ['data'=>APP_LANG_PROJECT_TYPE, 'id' => "project_type", 'placeholder' => 'Tipo de proyecto'])
							  @endcomponent                  			
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Etapa del proyecto</label>
                  			@component("components.select", ['data'=>APP_LANG_PROJECT_STAGE, 'id' => "stage", 'placeholder' => 'Etapa'])
							@endcomponent
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Propietario del proyecto</label>
							@component("components.search-user", ['id'=>'owner_id', 'storage'=>'filter_projects_owners', 'placeholder' => 'Buscar por nombre, email o empresa'])
							@endcomponent
                		</div>
                	</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de creación (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="created_start" placeholder="dd/mm/yyyy" >
								</div>
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="created_end" placeholder="dd/mm/yyyy" >
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de actualización (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="updated_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="updated_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de publicación (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="purchased_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="purchased_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de expiración (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="expires_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="expires_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
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
	<div class="modal-dialog modal-lg" role="document">
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
	setMask('#updated_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#updated_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#purchased_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#purchased_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#expires_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#expires_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });

	//DEFINIR DATEPICKER
	$('#created_start').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#created_end').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#updated_start').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#updated_end').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#purchased_start').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#purchased_end').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#expires_start').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#expires_end').dateTimePicker({format: 'dd/MM/yyyy'});
</script>

<script>
	const roles = {
		"realtor" : "Agente",
		"owner" : "Propietario"
	};
	const headers = [
			{ "title": "Id", "code": "id", "sortable": true },
            { "title": "Categoria" },
            { "title": "Rol" },
			{ "title": "Tipo" },
			{ "title": "Etapa", "code": "stage", "sortable": true },
			{ "title": "Nombre" },
			{ "title": "Precio de mantenimiento" },
			{ "title": "Cantidad de pisos" },
			{ "title": "Cantidad de sotanos" },
			{ "title": "Cantidad de elevadores" },
			{ "title": "Cantidad de unidades" },
			{ "title": "Cantidad de unidades vendidas" },
			{ "title": "Cantidad de edificios" },
			{ "title": "Dirección" },
			{ "title": "Distrito" },
			{ "title": "Provincia" },
			{ "title": "Departamento" },
			{ "title": "País" },
			{ "title": "Referencia" },
			{ "title": "Estado", "code": "state" },
            { "title": "Cantidad de fotos" },
            { "title": "Video" },
            { "title": "Video 360" },
            { "title": "Cantidad de vistas" },
            { "title": "Cantidad de favoritos" },
            { "title": "Cantidad de contactos" },
            { "title": "Cantidad de visitas" },
            { "title": "Cantidad de correos" },
            { "title": "Cantidad de whatsapp" },
            { "title": "Data externa" },
            { "title": "Comodidades" },
            { "title": "Adicionales" },
            { "title": "Origen" },
            { "title": "Pet friendly" },
            { "title": "Año de entrega" },
            { "title": "Mes de entrega" },
            { "title": "Financiamiento" },
			{ "title": "Fecha de creación", "created_at": "id", "sortable": true },
			{ "title": "Fecha de publicación", "code": "ad_purchased_at", "sortable": true },
            { "title": "Fecha de actualización", "code": "updated_at", "sortable": true },
            { "title": "Fecha de expiración", "code": "ad_expires_at", "sortable": true },
			{ "title": "Nombres" },
            { "title": "Email" },
            { "title": "Teléfono" },
			{ "title": "Acciones" }
	];
	const filtersFields = [
		{
			name: 'parent',
			type: 'static',
			value: 'ad'
		},
		{
			name: 'child',
			type: 'static',
			value: 'projects'
		},
		{
			name: 'id'
		},
		{
			name: 'state'
		},
		{
			name: 'project_type'
		},
		{
			name: 'stage'
		},
		{
			name: 'owner_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_projects_owners'
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
			name: 'updated_start',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'updated_end',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'purchased_start',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'purchased_end',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'expires_start',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'expires_end',
			type: filtersParamsTypes.DATE
		},
	];
	const processParams = (element) =>{

		let prefix = element.prefix ?? '';
		let phone = element.phone_number ?? '';

		return [
			element.id,		
			element.ad_plan??'',
			element.publisher_role??'',
			element.project_type??'',
			element.stage??'',
			element.project_name??'',
			element.maintenance_price??'',
			element.total_floors??'',
			element.total_basements??'',
			element.total_elevators??'',
			element.total_units??'',
			element.units_sold??'',
			element.project_builts??'',
			( ( element.location ) ? element.location.address??'':'' ),
			( ( element.location ) ? element.location.district??'':'' ),
			( ( element.location ) ? element.location.province??'':'' ),
			( ( element.location ) ? element.location.department??'':'' ),
			( ( element.location ) ? element.location.country??'':'' ),
			( ( element.location ) ? element.location.reference??'':'' ),
			`<span class="badge text-bg-secondary ${element.state_id}">${element.state??''}</span>`,
			element.images.length??'',
			element.videos.length === 0 ? 'No' : (element.videos[0].content ? `<a href="${element.videos[0].content}" target="_blank">${element.videos[0].content}</a>` : 'No existe la url'),
			element.objects_360.length === 0 ? 'No' : (element.objects_360[0].content ? `<a href="${element.objects_360[0].content}" target="_blank">${element.objects_360[0].content}</a>` : 'No existe la url'),
			element.views_count??'',
			element.favourites_count??'',
			element.contacts_count??'',
			element.emails_count??'',
			element.phones_count??'',
			element.whatsapps_count??'',
			element.external_data??'',
			(element.facilities && element.facilities.length>0)?(element.facilities.map((item)=> item.title).join(', ')):'',
			(element.advanced_details && element.advanced_details.length>0)?(element.advanced_details.map((item)=> item.title).join(', ')):'',
			element.source??'',
			element.pet_friendly ? 'Si' : 'No',
			element.delivery_date_year??'',
			element.delivery_date_month??'',
			element.finance??'',
			element.created_at??'',
			element.ad_purchased_at??'',
			element.updated_at??'',
			element.ad_expires_at??'',
			element.full_name??'',
			element.email??'',
			getFullNumber(prefix, phone)
		];
	}
	const modalOrder =  [];
	const modalTitle = (element, globalRecords = []) =>{
		let rowInfo = globalRecords.filter((item)=> item.id == element);
		let url_external = URL_WEB_FRONT + rowInfo[0].url?.share ?? '';
		return `Detalles para <a target="_blank" href="${url_external}">${element}</a>`;
	}
	const columnsHidden = [2, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43];
	const columnsDates = [37, 38, 39, 40];
	const download = { active: true, filename: 'Proyectos.xlsx' };
	const options = {
		download,
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_proyectos',
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		url: 'app/gateway'
	};
	
	datatable(options);
</script>
@endsection