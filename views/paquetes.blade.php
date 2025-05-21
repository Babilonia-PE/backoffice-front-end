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

@section('button')
<button id="btnNewPackage" type="button" class="btn btn-primary btn-block text-truncate btn-sm"><i class="fas fa-save"></i> Nuevo paquete</button>
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
                  			<label>ID del paquete</label>
                  			<input type="text" class="form-control form-control-sm" id="id" placeholder="ID del paquete">
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
                  			<label>Origen</label>
                  			@component("components.select", ['data'=>APP_LANG_SOURCE, 'id' => "source", 'placeholder' => 'Origen', 'first' => true])
							@endcomponent                  			
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Cantidad de paquetes</label>
                  			<select class="form-control select2 form-control-sm" style="width: 100%;" id="ads_count" name="ads_count">
                                <option selected disabled value="">Elige una opción</option>
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
                  			<label>Expiración del paquete</label>
                  			<select class="form-control select2 form-control-sm" style="width: 100%;" id="duration" name="duration">
                                <option selected disabled value="">Elige una opción</option>
								<option value="90">90</option>
                                <option value="180">180</option>
                                <option value="365">365</option>
							</select>
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Renovaciones</label>
                  			<select class="form-control select2 form-control-sm" style="width: 100%;" id="renovations" name="renovations">
                                <option selected disabled value="">Elige una opción</option>
								<option value="true">Si</option>
                                <option value="false">No</option>
                                <option value="">Todos</option>
							</select>
                		</div>
                	</div>
					<div class="col-md-4">
                		<div class="form-group">
                  			<label>Comerciales</label>
                  			<select class="form-control select2 form-control-sm" style="width: 100%;" id="agent_id" name="agent_id">
                                <option selected disabled value="">Elige una opción</option>
							</select>
                		</div>
                	</div>
                    <div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de compra (Desde - Hasta)</label>
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
							<label>Tipo</label>
							<select name="package_type" id="package_type" class="form-control form-control-sm selectpicker validate" title="Tipo de paquete" placeholder="Tipo de paquete">
								<option value="listing">Inmuebles</option>
								<option value="project">Proyectos</option>
							</select>                			
						</div>
					</div>  
					<div class="col-md-6">
						<div class="form-group">
							<label>Método de pago</label>
							<select name="payment_method" id="payment_method" class="form-control form-control-sm selectpicker validate" title="Método de pago" placeholder="Método de pago">
								<option value="transfer">Compra</option>
								<option value="gift">Regalo</option>
								<option value="lottery">Sorteo</option>
							</select>                			
						</div>
					</div> 
					<div class="col-md-6">
						<div class="form-group">
							<label>Agente</label>
							<select disabled name="realtor" id="realtor" class="form-control form-control-sm selectpicker disable validate" title="Agente" placeholder="Agente">
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Cliente</label>
							@component("components.search-user", ['id'=>'package_owner_id', 'placeholder' => 'Buscar por nombre, email o empresa', 'class' => 'validate'])
							@endcomponent            			
						</div>
					</div>  
					<div class="col-md-6">
						<div class="form-group">
							<label>Tipo de documento</label>
							<select name="type_document" id="type_document" class="form-control form-control-sm selectpicker validate" title="Tipo de documento" placeholder="Tipo de documento">
								<option value="boleta">Boleta</option>
								<option value="factura">Factura</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de documento</label>
							<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="document" placeholder="Número de documento">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número base de avisos</label>
							<select disabled name="count" id="count" class="form-control form-control-sm selectpicker disable validate" title="Número base de avisos" placeholder="Número base de avisos" >
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Categoría</label>
							<select disabled name="plan" id="plan" class="form-control form-control-sm selectpicker disable validate" title="Categoría" placeholder="Categoría" >
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos estandard</label>
                  			<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="standard_ads_count" placeholder="Avisos estandard">            			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos plus</label>
                  			<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="plus_ads_count" placeholder="Avisos plus">     	
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos premium</label>
                  			<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="premium_ads_count" placeholder="Avisos premium">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Duración base del paquete</label>
							<select disabled name="duracion" id="duracion" class="form-control form-control-sm selectpicker disable validate" title="Duración base del paquete" placeholder="Duración base del paquete" >
							</select>                			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Expiración del paquete</label>
                  			<input disabled type="date" class="form-control form-control-sm disable" id="days" placeholder="Expiración del paquete" min="{{date('Y-m-d', strtotime('+1 day'))}}">     		
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Consultas del paquete</label>
							<input disabled type="text" class="form-control form-control-sm disable" id="sentinel_counter" placeholder="Cantidad de consultas sentinel" title="Cantidad de consultas sentinel">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Adicionales</label>
							<input disabled type="text" class="form-control form-control-sm disable" id="sentinel_additional" placeholder="Consultas adicionales para sentinel" title="Consultas adicionales para sentinel">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Cuotas</label>
							<select name="cuotas" id="cuotas" class="form-control form-control-sm selectpicker validate" title="Cuotas" placeholder="Cuotas">
								<option value="1">1 cuota</option>
								<option value="12">12 cuotas</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Subtotal</label>
							<input disabled type="text" class="form-control form-control-sm disable" id="subtotal" placeholder="Subtotal" title="Subtotal">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>IGV</label>
							<input disabled type="text" class="form-control form-control-sm disable" id="igv" placeholder="IGV" title="IGV">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Descuento</label>
							<input disabled type="text" class="form-control form-control-sm disable" id="descuento" placeholder="Descuento" title="Descuento" maxlength="3">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Total</label>
							<input disabled type="text" class="form-control form-control-sm disable" id="total" placeholder="Total" title="Total" data-original="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<button disabled id="addPackage" type="button" class="btn btn-primary btn-block btn-sm"><i class="fas fa-plus"></i> Crear paquete</button>
						</div>
					</div>   
				</div>        
			</div>
		</div>
	</div>
</div>


<!-- Modal editar paquete -->
<div class="modal fade p-0" id="editPackage" tabindex="-1" role="dialog" aria-labelledby="editPackageLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<h5 class="modal-title" id="package_id">Editar paquete</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row align-items-end">
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Usuario</label>
							<input disabled type="text" id="update_package_owner_id" class="form-control form-control-sm inputmask disable" placeholder="Usuario">            			
						</div>
					</div>   
					<div class="col-md-6">
						<div class="form-group">
							<label>Método de pago</label>
							<input disabled type="text" id="update_payment_method" class="form-control form-control-sm inputmask disable" placeholder="Método de pago">        			
						</div>
					</div>  
					<div class="col-md-6">
						<div class="form-group">
							<label>Tipo</label>
							<input disabled type="text" id="update_package_type" class="form-control form-control-sm inputmask disable" placeholder="Tipo">             			
						</div>
					</div> 
					<div class="col-md-6">
						<div class="form-group">
							<label>Agente</label>
							<input disabled type="text" id="update_agent_name" class="form-control form-control-sm inputmask disable" placeholder="Agente">           			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número base de avisos</label>
							<input disabled type="text" id="update_ads_count" class="form-control form-control-sm inputmask disable" placeholder="Número base de avisos">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Categoría</label>
							<input disabled type="text" id="update_category" class="form-control form-control-sm inputmask disable" placeholder="Categoría">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos estandard</label>
                  			<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="update_standard_ads_count" placeholder="Avisos estandard">            			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos plus</label>
                  			<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="update_plus_ads_count" placeholder="Avisos plus">     	
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Número de avisos premium</label>
                  			<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="update_premium_ads_count" placeholder="Avisos premium">     		
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Duración base del paquete</label>
                  			<input disabled type="text" class="form-control form-control-sm inputmask disable validate" id="update_duration" placeholder="Duración base del paquete">     			
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Expiración del paquete</label>
                  			<input disabled type="text" class="form-control form-control-sm disable" id="update_expires_at" placeholder="Expiración del paquete" min="{{date('Y-m-d', strtotime('+1 day'))}}">     		
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Estado del paquete</label>
							<select name="update_state" id="update_state" class="form-control form-control-sm selectpicker validate" title="Estado" placeholder="Estado">
								<option value="1">Activo</option>
								<option value="0">inactivo</option>
							</select>   		
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<button id="btnEditPackage" type="button" class="btn btn-primary btn-block btn-sm">
								<span class="babilonia-pencil"></span>
								Editar paquete
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
<script>
	window.realtor = false;
	//ESTBALECER MASCARAS
	setMask('#purchased_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#purchased_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#expires_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#expires_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	//DEFINIR DATEPICKER
	$('#purchased_start').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#purchased_end').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#expires_start').dateTimePicker({format: 'dd/MM/yyyy'});
	$('#expires_end').dateTimePicker({format: 'dd/MM/yyyy'});
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
	const BUY_TYPE_STATE = {
		"1" : "success",
		"0" : "danger"
	};
		
	const headers = [
		{ "title": "ID", "code": "id", "sortable": true },
		{ "title": "ID de usuario", "code": "user_id", "sortable": true },
		{ "title": "Nombres", "code": "full_name", "sortable": true },
		{ "title": "Email" },
		{ "title": "Comercial asignado", "code": "agent_name", "sortable": true},
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
		{ "title": "Estado"},
		{ "title": "Fecha de compra", "code": "purchased_at", "sortable": true },
		{ "title": "Fecha de expiración", "code": "expires_at", "sortable": true },
		{ "title": "Teléfono", "code": "type"},
		{ "title": "Origen", "code": "source"},
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
			name: 'source'
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
			name: 'renovations'
        },
		{
			name: 'agent_id'
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
		let endDate= moment(element.expires_at, 'DD/MM/YYYY HH:mm');
		let currentDate = moment();
		let bagde = ( endDate < currentDate ) ? 'danger' : 'success';
		return [
			element.id,
			element.user_id,
			element.full_name,
			element.email,
			element.agent_name,
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
			`<span class="badge text-bg-secondary bg-${BUY_TYPE_STATE[element.state_id??'']}">${element.state??''}</span>`,
			element.purchased_at??'',
            `<span class="badge text-bg-secondary bg-${bagde}">${element.expires_at??''}</span>`,
			getFullNumber(element.prefix, element.phone_number),
			element.source??''
		];
	}
	const modalOrder =  [];
	const modalTitle = (element, globalRecords = []) =>{
	}
	const initParams = ()=>{
	}
	const initParamsModal = ()=>{
	}
	const initFunctions = async () => {
		const params = {
			parent: 'package',
			child: 'list',
			type: 'listing'
		};
		const details = await fetchData('app/gateway', params, 'GET');
		const users = details?.data?.users??null;
		users.forEach(user => {
			$('#agent_id').append($('<option>', {
				value: user.id,
				text: user.full_name
			}));
		});
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
	const columnsHidden = [3,6,7,8,9,10,11,12,13,14,15,16,17,18,22,23,24,25];
	const columnsDates = [22,23];
	const crud = {
		view: true,
		edit: false
	}
	const download = { active: true, filename: 'Paquetes.xlsx' };
	const options = {
		download,
		crud,
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_packages',
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		initFunctions,
		initParams,
		initParamsModal,
		url: 'app/gateway'
	};
	$(document).on("click", "#btnNewPackage", async function(e) {
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
		setMask('#subtotal', {
				alias: "currency",
				digits: '0',
				prefix: 'S/ ',
				rightAlign:false
			});
		setMask('#descuento', {
				alias: "currency",
				digits: '0',
				suffix: ' %',
				rightAlign:false,
				min: 0,
				max: 99,
				integerDigits: 2
			});
		setMask('#igv', {
				alias: "currency",
				digits: '0',
				prefix: 'S/ ',
				rightAlign:false
			});
		setMask('#total', {
				alias: "currency",
				digits: '0',
				prefix: 'S/ ',
				rightAlign:false
			});
		const getBalancePrice = (params = {}) => {
			const{
				total = 0, 
				descuento = 0, // % discount , example 15%
				isBoleta = true
			} = params ?? {};
			
			let sub = 0;			
			let igv = 0;

			let _total = total.toString();
				_total = _total.replace(/[S/.]/g, '');
				_total = _total.replace(/ /g,'');
				_total = parseFloat(_total);

			let _descuento = descuento.toString();
				_descuento = _descuento.replace(/[%]/g,'');
				_descuento = _descuento.replace(/ /g,'');
				_descuento = parseFloat(_descuento);

			if(_descuento > 0) _descuento = _descuento/100;

			if(_total == 0) return {sub,igv};
			
			sub = _total/(1-_descuento);

			if(isBoleta == false){
				sub = _total/((1-_descuento)*(1+0.18));
				igv = sub * 0.18;
			}
						
			return {sub, igv};
		}

		$(document).off("change", "#type_document");
		$(document).on('change', '#type_document', async function () {
			$("#descuento").trigger("input");
		});
		$(document).off("change", "#package_type");
		$(document).on('change', '#package_type', async function () {
			const params = {
				parent: 'package',
				child: 'list',
				type: $(this).val()
			};
			if( $(this).val() == 'project' ){
				window.realtor = true;
				const selectUser = document.getElementById('package_owner_id');
				selectUser.innerHTML="";
				$(selectUser).selectpicker('refresh');
			}else{
				window.realtor = false;
			}
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

			$("#sentinel_counter")
				.val("");
			$("#sentinel_additional")
				.attr("disabled", true)
				.val("");
			$("#subtotal")
				.val("");
			$("#descuento")
				.attr("disabled", true)
				.val("");
			$("#igv")
				.val("");
			$("#total")
				.val("");

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
			$("#sentinel_counter")
				.val("");
			$("#sentinel_additional")
				.attr("disabled", true)
				.val("");
			$("#subtotal")
				.val("");
			$("#descuento")
				.attr("disabled", true)
				.val("");
			$("#igv")
				.val("");
			$("#total")
				.val("");
			
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
			//const 
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

			$("#sentinel_counter")
				.val("");
			$("#sentinel_additional")
				.attr("disabled", true)
				.val("");
			$("#subtotal")
				.val("");
			$("#descuento")
				.attr("disabled", true)
				.val("");
			$("#igv")
				.val("");
			$("#total")				
				.val("");
			

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
			const duracionValue = $(this).val();
			
			const count_id = $('#plan').attr('data-key');
			const plan_id = $('#plan').val();
			const count = categories[count_id][plan_id];
			const productos = count.products ?? [];			
			const sentinel_counter = productos.find(producto => producto.key == duracionValue)?.sentinel_counter ?? 0;
			const total = productos.find(producto => producto.key == duracionValue)?.price ?? 0;
			const descuento = 0;
			const isBoleta = $("#type_document").val() == "boleta";
			//const igv = ( total * 0.18 ).toFixed(2);
			//const subtotal = ( total - igv ).toFixed(2);
			const {igv, sub} = getBalancePrice({isBoleta, descuento, total});
			$("#sentinel_counter").val(sentinel_counter);
			$("#sentinel_additional")
				.val(0)
				.removeAttr("disabled");

			$("#descuento").val(descuento)
				.removeAttr("disabled");
			$("#subtotal").val(sub);
			$("#igv").val(igv);
			$("#total")
				.val(total.toFixed(2))
				.attr("data-original", total);

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
			setMessageInput("#sentinel_additional");
			setMessageInput("#type_document");
			setMessageInput("#cuotas");
						
			const type = $("#package_type").val();
			const agent_id = $("#realtor").val();
			const user_id = $("#package_owner_id").val();
			const product_key = $("#duracion").val();
			const expires_at = $("#days").val();
			const payment_method = $("#payment_method").val();
			const standard_ads_count = $("#standard_ads_count").val();
			const plus_ads_count = $("#plus_ads_count").val();
			const premium_ads_count = $("#premium_ads_count").val();
			const sentinel_counter = $("#sentinel_counter").val() ?? 0;
			const sentinel_additional = $("#sentinel_additional").val() ?? 0;
			const type_document = $("#type_document").val() ?? 0;
			const cuotas = $("#cuotas").val() ?? 0;
			const subtotal = $("#subtotal").val().replaceAll(/[S/.]/g, '').replaceAll(/,/g, '').replaceAll(/ /g, '');
			const descuento = $("#descuento").val().replaceAll(/[%]/g, '').replaceAll(/,/g, '').replaceAll(/ /g, '');
			const igv = $("#igv").val().replaceAll(/[S/.]/g, '').replaceAll(/,/g, '').replaceAll(/ /g, '');
			const total = $("#total").val().replaceAll(/[S/.]/g, '').replaceAll(/,/g, '').replaceAll(/ /g, '');

			const now = new Date()
			//const duration = moment(expires_at).diff(moment(), 'days') + 1;		
			const duration = $( "#duracion option:selected" ).text();	
			const params = {
				parent: 'package',
				child: 'packages',
				type: type,
				agent_id: agent_id,
				user_id: user_id,
				product_key: product_key,
				duration: duration,
				expires_at: expires_at,
				payment_method: payment_method,
				standard_ads_count: ( standard_ads_count == 'Ilimitado') ? 999999 : standard_ads_count,
				plus_ads_count: ( plus_ads_count == 'Ilimitado') ? 999999 : plus_ads_count,
				premium_ads_count: ( premium_ads_count == 'Ilimitado') ? 999999 : premium_ads_count,
				sentinel_counter: sentinel_counter,
				sentinel_additional: sentinel_additional,
				subtotal,
				igv,
				total,
			}
			try {
				const response = await fetchData('app/gateway', params, 'POST');
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
		$("#descuento").off("input");
		$("#descuento").on("input", function(){
			let descuento = $(this).val();
			let total = $("#total").attr("data-original");		
			let isBoleta = $("#type_document").val() == "boleta";
			
			if(descuento == '' || parseFloat(descuento) >= 100 || parseFloat(descuento) < 0){				
				descuento = 0;
				$(this).val(descuento);
			}

			const {igv, sub} = getBalancePrice({isBoleta, descuento, total});

			$("#subtotal").val(sub);
			$("#igv").val(igv);
		});

		$("#newPackage").modal('show');
	})
	$(document).on("click", "a[data-action=\"update\"]", async function(e) {
		e.preventDefault();
		const key = $(this).attr("data-id");
		const detail = globalRecords.find(item => item.id === Number(key));
		console.log(detail);
		$("#package_id").text('Editar paquete ' + detail.id??'');
		$("#update_package_owner_id").val(detail.full_name??'');
		$("#update_payment_method").val(detail.buy_type??'');
		$("#update_package_type").val(detail.type??'');
		$("#update_agent_name").val(detail.agent_name??'');
		$("#update_ads_count").val(detail.ads_count??'');
		$("#update_category").val(detail.category??'');
		$("#update_state").val(detail.state_id??'');
		$("#update_state").selectpicker('refresh');
		if( !(detail.is_unlimited_standard??false) ){
			$("#update_standard_ads_count").val(detail.initial_standard_ads_count??'');
			$("#update_standard_ads_count").attr('disabled', false);
		}else{
			$("#update_standard_ads_count").val('Ilimitado');
			$("#update_standard_ads_count").attr('disabled', true);
		}
		if( !(detail.is_unlimited_plus??false) ){
			$("#update_plus_ads_count").val(detail.initial_plus_ads_count??'');
			$("#update_plus_ads_count").attr('disabled', false);
		}else{
			$("#update_plus_ads_count").val('Ilimitado');
			$("#update_plus_ads_count").attr('disabled', true);
		}
		if( !(detail.is_unlimited_premium??false) ){
			$("#update_premium_ads_count").val(detail.initial_premium_ads_count??'');
			$("#update_premium_ads_count").attr('disabled', false);
		}else{
			$("#update_premium_ads_count").val('Ilimitado');
			$("#update_premium_ads_count").attr('disabled', true);
		}
		$("#update_duration").val(detail.duration??'');
		$("#update_expires_at").val(detail.expires_at??'');
		$("#update_expires_at").attr('disabled', false);
		setMask('#update_expires_at', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
		$('#update_expires_at').dateTimePicker({format: 'dd/MM/yyyy'});

		$(document).off("click", "#btnEditPackage");
		$(document).on('click', '#btnEditPackage', async function () {

			setMessageInput("#standard_ads_count");
			setMessageInput("#plus_ads_count");
			setMessageInput("#premium_ads_count");
			setMessageInput("#days");

			$("#btnEditPackage").attr('disabled', true);
			$("#btnEditPackage span").removeClass();
			$("#btnEditPackage span").addClass('spinner-border spinner-border-sm');
						
			const id = key;
			const expires_at = $("#update_expires_at").val();
			const standard_ads_count = $("#update_standard_ads_count").val();
			const plus_ads_count = $("#update_plus_ads_count").val();
			const premium_ads_count = $("#update_premium_ads_count").val();	
			const state = $("#update_state").val();	
			const params = {
				parent: 'package',
				child: 'packages',
				id: id,
				expires_at: expires_at,
				standard_ads_count: ( standard_ads_count == 'Ilimitado') ? 999999 : standard_ads_count,
				plus_ads_count: ( plus_ads_count == 'Ilimitado') ? 999999 : plus_ads_count,
				premium_ads_count: ( premium_ads_count == 'Ilimitado') ? 999999 : premium_ads_count,
				state: state
			}
			try {
				const response = await fetchData('app/gateway', params, 'PUT');
				if (response.hasOwnProperty('code')){ 
					AppValidateHttpCode(response);
					$("#btnEditPackage").attr('disabled', false);
					$("#btnEditPackage span").removeClass();
					$("#btnEditPackage span").addClass('babilonia-pencil');
					return false;
				}
				$("#btnEditPackage").attr('disabled', false);
				$("#btnEditPackage span").removeClass();
				$("#btnEditPackage span").addClass('babilonia-pencil');
				$("#editPackage").modal('hide');
				localStorage.setItem('message', response?.data?.data?.message??'');
				window.location.reload();
			} catch (error) {
				console.log(error);
				$("#btnEditPackage").attr('disabled', false);
				$("#btnEditPackage span").removeClass();
				$("#btnEditPackage span").addClass('babilonia-pencil');
			}
		});


		$("#editPackage").modal('show');
	})
	


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