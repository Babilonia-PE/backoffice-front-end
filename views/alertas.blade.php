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

Alertas

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
                  			<label>Nombre completo</label>
							@component("components.search-user", ['placeholder' => 'Buscar por nombre', 'storage'=>'filter_alert_users'])
							@endcomponent
                		</div>
                	</div>   
					<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo de operación</label>
                  			<select class="form-control select2" id="listing_type" style="width: 100%;">
								@foreach (APP_LANG_LISTING_TYPE as $k => $type)
                                    <option value="{{ $k }}">{{ $type }}</option>
                                @endforeach
							</select>
                		</div>
                	</div>           							
					<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo de propiedad</label>
                  			<select class="form-control select2" id="property_type" style="width: 100%;">
								@foreach (APP_LANG_PROPERTY_TYPE as $k => $type)
                                    <option value="{{ $k }}">{{ $type }}</option>
                                @endforeach
							</select>
                		</div>
                	</div>           							
					<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo de alerta</label>
                  			<select class="form-control select2" id="alert_type" style="width: 100%;">
                                    <option selected disabled value="">Elige una opción</option>
								@foreach (APP_LANG_ALERT_TYPE as $k => $type)
                                    <option value="{{ $k }}">{{ $type }}</option>
                                @endforeach
							</select>
                		</div>
                	</div>           							
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de creación (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control" id="created_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="created_end" placeholder="dd/mm/yyyy">
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
<script src="public/plugins/LibDataTables/datatables.min.js"></script>
<script src="public/plugins/LibDataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="public/plugins/LibDataTables/ColReorder-1.7.0/js/dataTables.colReorder.min.js"></script>
<script src="@asset("js/components/datatable.js")"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script>
	setMask('#created_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#created_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
</script>
<script> 
	const headers = [
		{ "title": "ID", "code": "id" },
		{ "title": "Nombre completo", "code": "id" },
		{ "title": "Email", "code": "email" },
		{ "title": "Celular", "code": "id" },
        { "title": "Operación", "code": "id" },
		{ "title": "Tipo de propiedad", "code": "id" },
		{ "title": "Ubicación", "code": "id" },
		{ "title": "Precio", "code": "id" },
		{ "title": "Contactar al agente", "code": "id" },
		{ "title": "Estado", "code": "id" },
		{ "title": "Tipo", "code": "id" },
		{ "title": "Fecha de creación", "code": "id" },
		{ "title": "Fecha de actualización", "code": "id" },
        { "title": "Acciones", "code": "id" }
	];
	const filtersFields = [
		{
			name: 'user_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_leads_users'
		},
		{
			name: 'listing_type',
		},
		{
			name: 'property_type',
		},
		{
			name: 'alert_type',
		},
		{
			name: 'created_start',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'created_end',
			type: filtersParamsTypes.DATE
		},
	];
	const processParams = (element) =>{

		let prefix = element.prefix ?? '';
		let phone = element.phone_number ?? '';
		let phone_full = prefix + phone;

		return [
			element.id,
			element.full_name,
			element.email,
			phone_full,
            element.listing_type,
            element.property_type,
            element.location,
            element.price,
            element.contact_agent?'Si':'No',
            `<span class="badge text-bg-secondary state-${element.state_id}">${element.state??''}</span>`,
            `<span class="badge text-bg-secondary type-${element.type_id}">${element.type??''}</span>`,
			moment(element.created_at).format('DD/MM/YYYY'),
			moment(element.updated_at).format('DD/MM/YYYY')
		];
	}
	const modalOrder =  [];
	const modalTitle = () =>{
		
	}
	const columnsHidden = [6,7,11,12];
	const columnsDates = [11,12];
	const options = {
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_alert',
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		url: 'https://services-testing.babilonia.io/app/alert/alerts'
	};
	
	datatable(options);
</script>
@endsection