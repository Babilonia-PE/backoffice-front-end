@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
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
	.badge.badge-5{
		background-color: #000000;
		color: #ffffff;
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
                  			<label>Paquete ID</label>
                  			<input type="text" class="form-control" id="id" placeholder="User ID">
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
                  			<select class="form-control" id="type" name="type">
								<option value="">- Seleccione una opción -</option>
								<option value="listing">listing</option>
								<option value="project">project</option>
							</select>
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Cantidad de paquetes</label>
                  			<select class="form-control" id="ads_count" name="ads_count">
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
                  			<select class="form-control" id="category" name="category">
								<option value="">- Seleccione una opción -</option>
								<option value="essentials">essentials</option>
                                <option value="pro">pro</option>
                                <option value="prestige">prestige</option>
							</select>
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Duración del paquete</label>
                  			<select class="form-control" id="duration" name="duration">
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
                <table class="display table table-striped nowrap compact responsive d-none" cellspacing="0" width="100%">
                    
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
<script src="@asset("js/components/datatable.js")"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script>
	setMask('#created_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#created_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
</script>
<script>
	let state = [];
		state[1] = 'Activo';
		state[2] = 'Bloqueado';
		state[3] = 'Baneado';
		state[5] = 'Eliminado';
		
	const headers = [
		{ "title": "ID del paquete" },
		{ "title": "Categoria" },
		{ "title": "Standard ilimitado" },
		{ "title": "Standard ilimitado cantidad" },
		{ "title": "Plus ilimitado" },
		{ "title": "Plus ilimitado cantidad" },
		{ "title": "Premium ilimitado" },
		{ "title": "Premium ilimitado cantidad" },
		{ "title": "Duración" },
		{ "title": "Fecha de compra" },
		{ "title": "Fecha de expiración" },
		{ "title": "Total de anuncios permitidos" },
		{ "title": "Total de anuncios standart restantes" },
		{ "title": "Total de anuncios plus restantes" },
		{ "title": "Total de anuncios premium restantes" },
		{ "title": "ID orden" },
		{ "title": "Tipo" },
		{ "title": "Acciones" }
	];
	const filtersFields = [
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

		return [
			element.id,
            element.category,
            element.is_unlimited_standard?'si':'no',
            element.available_standard_ads_count,
            element.is_unlimited_plus?'si':'no',
            element.available_plus_ads_count,
            element.is_unlimited_premium?'si':'no',
            element.available_premium_ads_count,
            element.duration,
            moment(element.purchased_at).format('DD/MM/YYYY h:mm a'),
            moment(element.expires_at).format('DD/MM/YYYY h:mm a'),
            element.ads_count,
            element.initial_standard_ads_count,
            element.initial_plus_ads_count,
            element.initial_premium_ads_count,
            element.order_id,
            element.type,
		];
	}
	const modalOrder =  [];
	const modalTitle = (element, globalRecords = []) =>{
	}
	const initParams = ()=>{
	}
	const initParamsModal = ()=>{
	}
	const columnsHidden = [2,3,4,5,6,7,12,13,14];
	const columnsDates = [9,10];
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
		url: 'https://services-testing.babilonia.io/app/package/packages'
	};
	
	datatable(options);

	copyToClipboard();
</script>
@endsection