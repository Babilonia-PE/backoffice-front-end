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

Clientes

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
                  			<label>User ID</label>
                  			<input type="text" class="form-control" id="id" placeholder="User ID">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>RUC</label>
                  			<input type="text" class="form-control" id="company_id" placeholder="RUC">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Razón social</label>
                  			<input type="text" class="form-control" id="company_name" placeholder="Razón social">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Estado</label>
							@component("components.select", ['data'=>APP_LANG_CLIENTS_STATE, 'id' => "state", 'placeholder' => 'Estado', 'first' => true])
							@endcomponent
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Nombre comercial</label>
                  			<input type="text" class="form-control" id="commercial_name" placeholder="Nombre comercial">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Nombre completo</label>
                  			<input type="text" class="form-control" id="full_name" placeholder="Nombre completo">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Correo</label>
                  			<input type="email" class="form-control" id="email" placeholder="Correo">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Teléfono</label>
                  			<input type="phone_number" class="form-control" id="phone_number" placeholder="Teléfono">
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
<script src="@asset("js/components/datatable.js")"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script>
	setMask('#created_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#created_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
</script>
<script>
		
	const headers = [
		{ "title" : "ID del usuario" },
		{ "title": "Nombre Completo" },
		{ "title": "Correo electronico" },
		{ "title": "Teléfono" },
		{ "title": "Nombre comercial" },
		{ "title": "Fecha y hora de creación" },
		{ "title": "Estado" },
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
		{ "title": "Metodo de authenticación" },
		{ "title": "Acciones" }
	];
	const filtersFields = [
		{
			name: 'id'
		},
		{
			name: 'company_id'
		},
		{
			name: 'company_name'
		},
		{
			name: 'state'
		},
		{
			name: 'commercial_name',
		},
		{
			name: 'full_name',
		},
		{
			name: 'email',
		},
		{
			name: 'phone_number',
		},
		{
			name: 'created_start',
			type: filtersParamsTypes.DATE
		},
		{
			name: 'created_end',
			type: filtersParamsTypes.DATE
		}
	];
	const processParams = (element) =>{

		let urlClient = URL_WEB_FRONT + ((element.url && element.url!=null)?element.url:'');

		return [
			element.id,
			element.full_name,
			(element.email) ? `${element.email} <button class="btn btn-sm btn-primary text-danger-emphasis text-dark" type="button" data-copy="inner" data-value="${element.email}"><i class="far fa-copy text-white"></i></button>`:'',
			element.phone_number,
			( ( element.company ) ? element.company.commercial_name??'':'' ),
			moment(element.created_at).format('DD/MM/YYYY h:mm a'),
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
			( element.url && element.url!=null) ? `<a href="${urlClient}" target="_blank">${urlClient}</a>` : '',							
			( element.sign_method??"" ),
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
	const columnsHidden = [0, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
	const columnsDates = [15];
	const options = {
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_clientes',
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		initParams,
		initParamsModal,
		url: 'https://services-testing.babilonia.io/app/user/users'
	};
	
	datatable(options);

	copyToClipboard();
</script>
@endsection