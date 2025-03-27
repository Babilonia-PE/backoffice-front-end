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

Central de riesgo

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
                  			<label>Propietario</label>
							@component("components.search-user", ['id'=>'owner_id', 'storage'=>'filter_sentinel_owners', 'placeholder' => 'Buscar por nombre, email o empresa'])
							@endcomponent
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
<!-- Modal editar sentinel -->
<div class="modal fade p-0" id="editSentinel" tabindex="-1" role="dialog" aria-labelledby="editSentinelLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<h5 class="modal-title" id="user_id">Editar paquete</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row align-items-end">					
					<div class="col-md-12">
						<div class="form-group">
							<label>Número de consultas</label>
							<input type="text" id="update_total" class="form-control form-control-sm inputmask disable" placeholder="Número base de avisos">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<button id="btnEditSentinel" type="button" class="btn btn-primary btn-block btn-sm">
								<span class="babilonia-pencil"></span>
								Editar registro
							</button>
						</div>
					</div>   
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
<script src="@asset('public/plugins/LibDataTables/ColReorder-1.7.0/js/dataTables.colReorder.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/assets/js/components/datatable.js')?{{env('APP_JS_VERSION')}}"></script>
<!-- Select2 -->
<script src="@asset('public/plugins/select2/js/select2.full.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script src="@asset('public/plugins/datetimepicker/date-time-picker.min.js')?{{env('APP_JS_VERSION')}}"></script>
<script type="module">
	const { Modal } = await import (`/public/assets/js/components/modal.js`);		
	const headers = [
		{ "title": "Nombre", "code": "full_name" },
		{ "title": "Email", "code": "email" },
		{ "title": "Teléfono", "code": "phone_number" },
		{ "title": "Consultas realizadas", "code": "current" },
		{ "title": "Consultas disponibles", "code": "total" },
		{ "title": "Acciones" }
	];
	const filtersFields = [
		{
			name: 'parent',
			type: 'static',
			value: 'provider'
		},
		{
			name: 'child',
			type: 'static',
			value: 'sentinel'
		},
		{
			name: 'owner_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_sentinel_owners'
		},
	];
	const processParams = (element) =>{

		return [
			element.full_name??'',
			element.email??'',
			getFullNumber(element.prefix, element.phone_number),
			element.current??'',
			element.total??''
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
	const setMessageInput = (selector)=>{
		const element = $(selector);
		const disabled = element.attr("disabled");
		if(element.val() == '' && ( disabled == false || typeof disabled == 'undefined' ) ){
			if( element.prop('type') == 'select-one' ){
				element.next().addClass('element-required');
			}else{
				element.addClass('element-required');
			}
		}
	}
	const columnsHidden = [];
	const columnsDates = [];
	const crud = {
		view: true,
		edit: {
			active: true,
			key: 'user_id'
		}
	}
	const options = {
		crud,
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_documentos',
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

	showMessage();
	$(document).on("click", "a[data-action=\"update\"]", async function(e) {
		e.preventDefault();
		const key = $(this).attr("data-id");
		const detail = globalRecords.find(item => item.user_id === Number(key));
		$("#user_id").text('Editar consultas sentinel del usuario ' + detail.user_id??'');
		$("#update_total").val(detail.total??'');
		setMask('#update_total', { mask: "9{3}", placeholder : "", showMaskOnHover: false, rightAlign:false });

		$(document).off("click", "#btnEditSentinel");
		$(document).on('click', '#btnEditSentinel', async function () {

			setMessageInput("#total");

			$("#btnEditSentinel").attr('disabled', true);
			$("#btnEditSentinel span").removeClass();
			$("#btnEditSentinel span").addClass('spinner-border spinner-border-sm');
						
			const user_id = key;
			const total = $("#update_total").val();
			const params = {
				user_id: user_id,
				total: total
			}
			try {
				const response = await fetchData('app/provider/sentinel', params, 'PUT');
				if (response.hasOwnProperty('code')){ 
					AppValidateHttpCode(response);
					$("#btnEditSentinel").attr('disabled', false);
					$("#btnEditSentinel span").removeClass();
					$("#btnEditSentinel span").addClass('babilonia-pencil');
					return false;
				}
				$("#btnEditSentinel").attr('disabled', false);
				$("#btnEditSentinel span").removeClass();
				$("#btnEditSentinel span").addClass('babilonia-pencil');
				$("#editSentinel").modal('hide');
				localStorage.setItem('message', response?.data?.data?.message??'');
				window.location.reload();
			} catch (error) {
				console.log(error);
				$("#btnEditSentinel").attr('disabled', false);
				$("#btnEditSentinel span").removeClass();
				$("#btnEditSentinel span").addClass('babilonia-pencil');
			}
		});


		$("#editSentinel").modal('show');
	})
</script>
@endsection