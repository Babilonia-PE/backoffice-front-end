@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/ColReorder-1.7.0/css/colReorder.dataTables.min.css">
<!-- -->
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
	.dropdown.bootstrap-select > button.btn.disabled {
		background-color: #e9ecef;
    	opacity: 1;
	}
	.error{
    	font-size: 12px;
		color: red;
	}
	.element-required{
		border-color: red!important;
		color: red!important;
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
                  			<label>Propietario del paquete</label>
							@component("components.search-user", ['id'=>'owner_id', 'storage'=>'filter_packages_owners', 'placeholder' => 'Buscar por nombre, email o empresa'])
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
							@component("components.select", ['data'=>APP_LANG_PACKAGE_CATEGORY, 'id' => "category", 'placeholder' => 'Categoria', 'first' => true])
							@endcomponent
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
									<input type="date" class="form-control" id="purchased_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="date" class="form-control" id="purchased_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de expiración (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="date" class="form-control" id="expires_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="date" class="form-control" id="expires_end" placeholder="dd/mm/yyyy">
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


<!-- Modal nuevo paquete -->
<div class="modal fade p-0" id="newPackage" tabindex="-1" role="dialog" aria-labelledby="newPackageLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<h5 class="modal-title">Nuevo paquete</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row align-items-end">
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Usuario</label>
							@component("components.search-user", ['id'=>'package_owner_id', 'placeholder' => 'Buscar por nombre, email o empresa', 'class' => 'validate'])
							@endcomponent            			
						</div>
					</div>   
					<div class="col-md-6">
						<div class="form-group">
							<label>Método de pago</label>
							<select name="payment_method" id="payment_method" class="form-control selectpicker validate" title="Método de pago" placeholder="Método de pago">
								<option value="tranfer">Compra</option>
								<option value="free">Regalo</option>
								<option value="lottery">Sorteo</option>
							</select>                			
						</div>
					</div>  
					<div class="col-md-6">
						<div class="form-group">
							<label>Tipo</label>
							<select name="package_type" id="package_type" class="form-control selectpicker validate" title="Tipo de paquete" placeholder="Tipo de paquete">
								<option value="listing">Inmuebles</option>
								<!--<option value="project">Proyectos</option>-->
							</select>                			
						</div>
					</div> 
					<div class="col-md-6">
						<div class="form-group">
							<label>Agente</label>
							<select disabled name="realtor" id="realtor" class="form-control selectpicker disable validate" title="Agente" placeholder="Agente">
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número base de avisos</label>
							<select disabled name="count" id="count" class="form-control selectpicker disable validate" title="Número base de avisos" placeholder="Número base de avisos" >
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Categoría</label>
							<select disabled name="plan" id="plan" class="form-control selectpicker disable validate" title="Categoría" placeholder="Categoría" >
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos estandard</label>
                  			<input disabled type="text" class="form-control inputmask disable validate" id="standard_ads_count" placeholder="Avisos estandard">            			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos plus</label>
                  			<input disabled type="text" class="form-control inputmask disable validate" id="plus_ads_count" placeholder="Avisos plus">     	
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos premium</label>
                  			<input disabled type="text" class="form-control inputmask disable validate" id="premium_ads_count" placeholder="Avisos premium">     		
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Duración base del paquete</label>
							<select disabled name="duracion" id="duracion" class="form-control selectpicker disable validate" title="Duración base del paquete" placeholder="Duración base del paquete" >
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Duración del paquete</label>
                  			<input disabled type="date" class="form-control disable" id="days" placeholder="Duración del paquete" min="{{date('Y-m-d', strtotime('+1 day'))}}">     		
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<button disabled id="addPackage" type="button" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Crear paquete</button>
						</div>
					</div>   
				</div>        
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
<!-- -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script>
	
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
		{ "title": "Total permitidos" },
		{ "title": "Standart restantes" },
		{ "title": "Plus restantes" },
		{ "title": "Premium restantes" },
		{ "title": "ID orden" },
		{ "title": "Tipo", "code": "type", "sortable": true },
		{ "title": "Tipo Compra", "code": "type"},
		{ "title": "Fecha de compra", "code": "purchased_at", "sortable": true },
		{ "title": "Fecha de expiración", "code": "expires_at", "sortable": true },
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
			name: 'child',
			type: 'static',
			value: 'packages'
		},
		{
			name: 'id'
		},
		{
			name: 'type'
		},
		{
			name: 'owner_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_packages_owners'
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
            element.initial_standard_ads_count,
            element.is_unlimited_plus?'si':'no',
            element.initial_plus_ads_count,
            element.is_unlimited_premium?'si':'no',
            element.initial_premium_ads_count,
            element.duration,
            element.ads_count,
            element.available_standard_ads_count,
            element.available_plus_ads_count,
            element.available_premium_ads_count,
            element.order_id,
            element.type??'',
            `<span class="badge text-bg-secondary bg-${BUY_TYPE_COLORS[element.buy_type_id??'']}">${toCamelCase(element.buy_type??'')}</span>`,
			moment(element.purchased_at).format('DD/MM/YYYY'),
            `<span class="badge text-bg-secondary bg-${bagde}">${expired??''}</span>`,
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
	const columnsHidden = [4,5,6,7,8,9,10,13,14,15,16,20];
	const columnsDates = [20,21];
	const returnTable = {
		buttons: [
			{
				extend: "excelHtml5",
				exportOptions: {
					//columns: ":not(:last-child)",
					columns: function(idx, data, node) {
						return $('table').DataTable().column(idx).visible();
					}
				}
			},
			{
				extend: 'colvis',
				columns: ':not(.noVis)',
				text: "Ocultar columnas",
				columnText: function(dt, idx, title ){
					let title_clean =(typeof headers[idx] === "object" && headers[idx].hasOwnProperty("title_clean"))?headers[idx]["title_clean"]:title;
					return title_clean;
				}
			},
			{
				text: 'Reiniciar',
				action: function ( e, dt, node, config ) {
					dt.state.clear();
					window.location.reload();
				}
			},
			{
				text: 'Nuevo paquete',
				action: async function ( e, dt, node, config ) {
					let categories = [];
					const mask = {
						alias: "numeric", 
						allowMinus: false, 
						digits: '0', 
						showMaskOnHover: false, 
						rightAlign:false
					};
					$('.inputmask').inputmask("remove");
					$('#newPackage .form-control').val("");
					$('#addPackage').attr("disabled", true);
					$('#newPackage .disable').attr("disabled", true);
					$('#newPackage .selectpicker').selectpicker('refresh');
					$(document).off("change", "#package_type");
					$(document).on('change', '#package_type', async function () {
						const params = {
							parent: 'package',
							child: 'list',
							type: $(this).val()
						};
						const details = await fetchData('app/gateway', params, 'GET');
						const data = details?.data?.records??null;
						const users = details?.data?.users??null;
						$('#realtor').find('option').remove();
						$('#count').find('option').remove();
						$('#plan').find('option').remove();
						$('#duracion').find('option').remove();

						$("#standard_ads_count").val("").attr("disabled", true);
						$("#plus_ads_count").val("").attr("disabled", true);
						$("#premium_ads_count").val("").attr("disabled", true);
						$("#plan").val("").attr("disabled", true);
						$("#days").val("").attr("disabled", true);
						$("#duracion").val("").attr("disabled", true);

						data.forEach(element => {
							categories[element.id] = element.packages;
							jQuery('<option>', {
							'value': element.id,
							'text' : ( element.is_unlimited == true ) ? 'Ilimitado' : element.ads_count
							}).appendTo("#count");
						});
						users.forEach(element => {
							if( element.state == 0 ){ return; }
							jQuery('<option>', {
							'value': element.id,
							'text' : element.full_name
							}).appendTo("#realtor");
						});
						$('#realtor').attr('disabled', false);
						$('#count').attr('disabled', false);
						$('#realtor').selectpicker('refresh');
						$('#count').selectpicker('refresh');
						$('#plan').selectpicker('refresh');
						$('#duracion').selectpicker('refresh');
					});
					$(document).off("change", "#count");
					$(document).on('change', '#count', async function () {
						const id = $(this).val();
						$('#plan').find('option').remove();
						$('#duracion').find('option').remove();
						$('#plan').attr('data-key', id);
						$('#plan').attr('disabled', false);
						$('#duracion').attr('disabled', true);
						
						$('.inputmask').inputmask("remove");
						$("#standard_ads_count").removeClass('element-required');
						$("#plus_ads_count").removeClass('element-required');
						$("#premium_ads_count").removeClass('element-required');
						$("#standard_ads_count").val("").attr("disabled", true);
						$("#plus_ads_count").val("").attr("disabled", true);
						$("#premium_ads_count").val("").attr("disabled", true);
						$("#days").val("").attr("disabled", true);

						(categories[id]??[]).forEach( (element, index) => {
							jQuery('<option>', {
								'value': index,
								'text' : element.category
							}).appendTo("#plan");
							$('#plan').selectpicker('refresh');
							$('#duracion').selectpicker('refresh');
						});
					});
					$(document).off("change", "#plan");
					$(document).on('change', '#plan', async function () {
						const count_id = $(this).attr('data-key');
						const plan_id = $(this).val();
						const count = categories[count_id][plan_id];
						const standard_unlimited = count.standard?.is_unlimited??false;
						const plus_unlimited = count.plus?.is_unlimited??false;
						const premium_unlimited = count.premium?.is_unlimited??false;
						const standard_count = ( standard_unlimited == true ) ? 'Ilimitado' : ( count.standard?.ads_count??0 );
						const plus_count = ( plus_unlimited == true ) ? 'Ilimitado' : ( count.plus?.ads_count??0 );
						const premium_count = ( premium_unlimited == true ) ? 'Ilimitado' : ( count.premium?.ads_count??0 );
						if( !standard_unlimited ){
							$("#standard_ads_count").attr("disabled", false);
							setMask('#standard_ads_count', mask);
						}
						if( !plus_unlimited ){
							$("#plus_ads_count").attr("disabled", false);
							setMask('#plus_ads_count', mask);
						}
						if( !premium_unlimited ){
							$("#premium_ads_count").attr("disabled", false);
							setMask('#premium_ads_count', mask);
						}
						$("#standard_ads_count").val(standard_count);
						$("#plus_ads_count").val(plus_count);
						$("#premium_ads_count").val(premium_count);
						$("#standard_ads_count").removeClass('element-required');
						$("#plus_ads_count").removeClass('element-required');
						$("#premium_ads_count").removeClass('element-required');
						$("#days").val("").attr("disabled", true);
						$('#duracion').find('option').remove();
						$('#duracion').attr('disabled', false);
						(count.products??[]).forEach( (element, index) => {
							jQuery('<option>', {
								'value': element.key,
								'text' : element.duration
							}).appendTo("#duracion");
							$('#duracion').selectpicker('refresh');
						});
					});
					$(document).off("change", "#duracion");
					$(document).on('change', '#duracion', async function () {
						const option = $(this).find(":selected").text();
						const dt = new Date(); // June 1, 2022 UTC time
						dt.setDate(dt.getDate() + parseInt(option)); // Add 30 days
						
						const date = [
							dt.getFullYear(),
							('0' + (dt.getMonth() + 1)).slice(-2),
							('0' + dt.getDate()).slice(-2)
						].join('-');
					
						$("#days").val(date);
						$("#days").attr("disabled", false);
					});
					$(document).off("click", "#addPackage");
					$(document).on('click', '#addPackage', async function () {
						setMessageInput("#package_owner_id");
						setMessageInput("#count");
						setMessageInput("#plan");
						setMessageInput("#standard_ads_count");
						setMessageInput("#plus_ads_count");
						setMessageInput("#premium_ads_count");
						setMessageInput("#duracion");
						setMessageInput("#days");
									
						const type = $("#package_type").val();
						const agent_id = $("#realtor").val();
						const user_id = $("#package_owner_id").val();
						const product_key = $("#duracion").val();
						const expires_at = $("#days").val();
						const payment_method = $("#payment_method").val();
						const standard_ads_count = $("#standard_ads_count").val();
						const plus_ads_count = $("#plus_ads_count").val();
						const premium_ads_count = $("#premium_ads_count").val();
						const now = new Date()
						const duration = moment(expires_at).diff(moment(), 'days') + 1;		
						const params = {
							type: type,
							agent_id: agent_id,
							user_id: user_id,
							product_key: product_key,
							duration: duration,
							expires_at: expires_at,
							payment_method: payment_method,
							standard_ads_count: standard_ads_count,
							plus_ads_count: plus_ads_count,
							premium_ads_count: premium_ads_count,
						}
						try {
							const response = await fetchData('app/package/packages', params, 'POST');
							if (response.hasOwnProperty('code')){ 
								AppValidateHttpCode(response);
								return false;
							}
							restartForm();
							$("#newPackage").modal('hide');
							localStorage.setItem('message', response?.data?.data?.message??'');
							window.location.reload();
						} catch (error) {
							console.log(error);
						}
					});

					$("#newPackage").modal('show');
				}
			}
		]
	};
	const options = {
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_packages',
		columnsHidden,
		columnsDates,
		returnTable,
		modalOrder,
		modalTitle,
		initParams,
		initParamsModal,
		url: 'app/gateway'
	};
	
	datatable(options);
	copyToClipboard();
	showMessage();
	//VALIDACIONES
	let disableButton = true;
	const restartForm = () => {
		$('#newPackage .form-control').val("");
		$('#addPackage').attr("disabled", true);
		$('#newPackage .disable').attr("disabled", true);
		$('#newPackage .selectpicker').selectpicker('refresh');
	}
	const enableButtonSubmitform = () => {
		$("#addPackage").prop("disabled", disableButton);
	}
	const serviceValidateForm = () => {
		disableButton = false;
		$('#newPackage *').filter(':input').each(function () {
			if( ( $(this).val() === '' ||  $(this).val() === null ) && $(this).hasClass('validate') ){
				disableButton = true;
			}
		});
	}
	$(document).on('focusout change', '#newPackage select', async function () {
		disableButton = false;
		if( $(this).val() !== '' ){
			$(this).next().removeClass('element-required');
		}else{
			if( $(this).hasClass('validate') ){
				$(this).next().addClass('element-required');
			}
		}
		serviceValidateForm();
        enableButtonSubmitform();
	});
	$(document).on('blur input keyup change', '#newPackage input', async function () {
		disableButton = false;
		if( $(this).val() !== '' ){
			$(this).removeClass('element-required');
		}else{
			if( $(this).hasClass('validate') ){
				$(this).addClass('element-required');
			}
		}
		serviceValidateForm();
        enableButtonSubmitform();
	});
</script>
@endsection