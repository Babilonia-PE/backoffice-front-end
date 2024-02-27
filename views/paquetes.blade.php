@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/ColReorder-1.7.0/css/colReorder.dataTables.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
	.badge:is(.published,.not_published,.unpublished,.expired,.deleted,.state-1,.type-lead,.type-alert,.type-similar,.state-0){
		box-shadow: 2px 2px 17px 1px rgba(0, 0, 0, 0.2)
	}
	.badge.published,
	.badge.state-1,
	.badge.type-alert
	{
		background-color: #198754;
		color: #ffffff;
	}
	.badge.type-lead
	{
		background-color: #0dcaf0;
		color: #ffffff;
	}
	.badge.type-similar
	{
		background-color: #ffc107;
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
	.badge.expired,
	.badge.state-0{
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

Paquetes

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
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>ID del paquete</label>
                  			<input type="text" class="form-control" id="id" placeholder="ID del paquete">
                		</div>
                	</div>
                    <div class="col-md-4">
                        {{-- user_id --}}
                		<div class="form-group">
                  			<label>Cliente</label>
							@component("components.search-user") 
							@endcomponent
                		</div>
                	</div>               		
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo</label>
                  			@component("components.select", ['data'=>APP_LANG_ADS_TYPE, 'id' => "type", 'placeholder' => 'Tipo', 'first' => true])
							@endcomponent                  			
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Cantidad de paquetes</label>
                  			<select class="form-control select2" id="ads_count" name="ads_count">
								<option value="">- Seleccione una opción -</option>
								<option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="700">700</option>
                                <option value="1000">1000</option>
                                <option value="1300">1300</option>
                                <option value="1500">1500</option>
                                <option value="999999">999999</option>
							</select>
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Categoria</label>
							@component("components.select", ['data'=>APP_LANG_PACKAGE_CATEGORY, 'id' => "category", 'placeholder' => 'Categoria', 'first' => true])
							@endcomponent
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Duración del paquete</label>
                  			<select class="form-control select2" id="duration" name="duration">
                                <option value="">- Seleccione una opción -</option>
								<option value="90">90</option>
                                <option value="180">180</option>
                                <option value="365">365</option>
							</select>
                		</div>
                	</div>
                    <div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de compra (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control" id="purchased_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="purchased_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de expiración (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control" id="expires_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="expires_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<button id="applyfiltters" type="button" class="btn btn-primary btn-block"><i class="fas fa-filter"></i> Aplicar filtros</button>
								</div>
								<div class="col-auto">
									<button id="removefiltters" type="button" class="btn btn-secondary"><i class="fas fa-trash"></i></button>
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
                <table class="display table table-bordered table-striped nowrap compact responsive d-none" cellspacing="0" width="100%">
                    
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
<script src="public/plugins/LibDataTables/datatables.min.js"></script>
<script src="public/plugins/LibDataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="public/plugins/LibDataTables/ColReorder-1.7.0/js/dataTables.colReorder.min.js"></script>
<script src="@asset("public/assets/js/components/datatable.js")?v={{ APP_VERSION }}"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script>
	setMask('#purchased_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#purchased_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#expires_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#expires_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
</script>
<script>
	let state = [];
		state[1] = 'Activo';
		state[2] = 'Bloqueado';
		state[3] = 'Baneado';
		state[5] = 'Eliminado';

	const BUY_TYPE_COLORS = {
		"free" : "light",
		"lottery" : "warning",
		"buyed" : "success",
		"expired" : "danger"
	};
		
	const headers = [
		{ "title": "ID", "code": "id", "sortable": true },
		{ "title": "Nombres" },
		{ "title": "Email" },
		{ "title": "Avisos disponibles", "code": "ads_count", "sortable": true },
		{ "title": "Categoría", "code": "category", "sortable": true },
		{ "title": "Standard ilimitado" },
		{ "title": "Cantidad standard" },
		{ "title": "Plus ilimitado" },
		{ "title": "Cantidad plus" },
		{ "title": "Premium ilimitado" },
		{ "title": "Cantidad premium" },
		{ "title": "Duración", "code": "duration", "sortable": true },
		{ "title": "Estado", "code": "state", "sortable": true },
		{ "title": "Compra", "code": "purchased_at", "sortable": true },
		{ "title": "Expiración", "code": "expires_at", "sortable": true },
		{ "title": "Total permitidos" },
		{ "title": "Standart restantes" },
		{ "title": "Plus restantes" },
		{ "title": "Premium restantes" },
		{ "title": "ID orden" },
		{ "title": "Tipo", "code": "type", "sortable": true },
		{ "title": "Tipo Compra", "code": "type"},
		{ "title": "Teléfono", "code": "type"},
		{ "title": "Acciones" }
	];
	const filtersFields = [
		{
			name: 'parent',
			type: 'static',
			value: 'package'
		},
		{
			name: 'id'
		},
		{
			name: 'type'
		},
		{
			name: 'user_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_packages_users'
		},
		{
			name: 'ads_count'
		},
		{
			name: 'category'
		},
		{
			name: 'duration'
        },
		{
			name: 'state'
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
		}
	];
	const processParams = (element) =>{
		let expired = moment(element.expires_at).format('DD/MM/YYYY');
		let endDate= new Date(Date.parse(element.expires_at));
		let currentDate = new Date();
		let bagde = ( endDate < currentDate ) ? 'danger' : 'success';
		return [
			element.id,
			element.full_name,
			element.email,
			element.ads_count?((element.ads_count=='999999')?'Ilimitado':element.ads_count):'',
            element.category??'',
            element.is_unlimited_standard?'si':'no',
            element.available_standard_ads_count,
            element.is_unlimited_plus?'si':'no',
            element.available_plus_ads_count,
            element.is_unlimited_premium?'si':'no',
            element.available_premium_ads_count,
            element.duration,
            `<span class="badge text-bg-secondary state-${element.state_id??''}">${element.state??''}</span>`,
            moment(element.purchased_at).format('DD/MM/YYYY'),
            `<span class="badge text-bg-secondary bg-${bagde}">${expired??''}</span>`,
            element.ads_count,
            element.initial_standard_ads_count,
            element.initial_plus_ads_count,
            element.initial_premium_ads_count,
            element.order_id,
            element.type??'',
            `<span class="badge text-bg-secondary bg-${BUY_TYPE_COLORS[element.buy_type_id??'']}">${toCamelCase(element.buy_type??'')}</span>`,
			getFullNumber(element.prefix, element.phone_number)
		];
	}
	const modalOrder =  [];
	const modalTitle = (element, globalRecords = []) =>{
	}
	const initParams = ()=>{
	}
	const initParamsModal = ()=>{
	}
	const columnsHidden = [4,5,6,7,8,9,10,13,14,15,16,17,18];
	const columnsDates = [13,14];
	const options = {
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_packages',
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
</script>
@endsection