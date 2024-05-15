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
	.external-data{
		display: flex;
		gap: 0.5rem;
		flex-wrap: wrap;
		align-items: center;
    	position: relative;
	}
	.external-data .links{
		display: none;
    	position: absolute;
		gap: 0.5rem;
		right: 0;
    	padding: 0 0 0 1rem;
		background: #FFFFFFD5;
	}
	.external-data.title .links{
		display: flex;
    	position: relative;
    	padding: 0;
	}
	.external-data.title i{
		font-size: 16px;
	}
	.external-data i{
		color: #000000DE;
	}
	.external-data:hover .links{
		display: flex;
	}
	.swal2-popup.swal2-toast .swal2-html-container{
		margin: .5em 0;
	}
</style>
@endsection

@section('page')

Avisos

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
                  			<label>ID del aviso</label>
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
                  			<label>Tipo de operación</label>
							  @component("components.select", ['data'=>APP_LANG_LISTING_TYPE, 'id' => "listing_type", 'placeholder' => 'Tipo de operación'])
							  @endcomponent                  			
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Tipo de inmueble</label>
                  			@component("components.select", ['data'=>APP_LANG_PROPERTY_TYPE, 'id' => "property_type", 'placeholder' => 'Tipo de inmueble'])
							@endcomponent
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Propietario del aviso</label>
							@component("components.search-user", ['id'=>'owner_id', 'storage'=>'filter_listing_owners', 'placeholder' => 'Buscar por nombre, email o empresa'])
							@endcomponent
                		</div>
                	</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Precio (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="price_from" placeholder="desde">
								</div>
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="price_to" placeholder="hasta">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de creación (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="created_start" placeholder="dd/mm/yyyy" value="{{date('d-m-Y', strtotime('-3 month'))}}">
								</div>
								<div class="col-6">
									<input type="text" class="form-control form-control-sm" id="created_end" placeholder="dd/mm/yyyy" value="{{date('d-m-Y')}}">
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
<script src="@asset("public/assets/js/components/datatable.js")?v={{ APP_VERSION }}"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script src="public/plugins/datetimepicker/date-time-picker.min.js"></script>
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
			{ "title": "ID", "code": "id", "sortable": true },
			{ "title": "Operación", "code": "listing_type" },
			{ "title": "Inmueble", "code": "property_type" },
			{ "title": "Precio", "code": "price", "sortable": true },
			{ "title": "Dirección" },
			{ "title": "Distrito" },
			{ "title": "Provincia" },
			{ "title": "Departamento" },
			{ "title": "País" },
			{ "title": "Estado", "code": "state", "sortable": true },
			{ "title": "Fecha de creación", "created_at": "id", "sortable": true },
			{ "title": "Fecha de publicación", "code": "ad_purchased_at", "sortable": true },
			{ "title": "Nombres" },
            { "title": "Categoria" },
            { "title": "Rol" },
            { "title": "Cuartos" },
            { "title": "Baños" },
            { "title": "Area total" },
            { "title": "Área techada" },
            { "title": "Estacionamientos" },
            { "title": "Estacionamiento para visitas" },
            { "title": "Año de construcción" },
            { "title": "Número de pisos" },
            { "title": "Piso del inmueble" },
            { "title": "Pet friendly" },
            { "title": "Comodidades" },
            { "title": "Adicionales" },
            { "title": "Descripción" },
            { "title": "Numero de fotos" },
            { "title": "Video" },
            { "title": "Numero de vistas" },
            { "title": "Número de favoritos" },
            { "title": "Numero de contactos" },
            { "title": "Fecha de actualización", "code": "updated_at", "sortable": true },
            { "title": "Fecha de expiración", "code": "ad_expires_at", "sortable": true },
            { "title": "Email" },
            { "title": "Teléfono" },
			{ "title": "External" },
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
			value: 'listings'
		},
		{
			name: 'id'
		},
		{
			name: 'state'
		},
		{
			name: 'listing_type'
		},
		{
			name: 'property_type'
		},
		{
			name: 'owner_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_listing_owners'
		},
		{
			name: 'price_from',			
		},
		{
			name: 'price_to',			
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
			(element.listing_type??''),
			(element.property_type??''),
			element.price??'',
			( ( element.location ) ? element.location.address??'':'' ),
			( ( element.location ) ? element.location.district??'':'' ),
			( ( element.location ) ? element.location.province??'':'' ),
			( ( element.location ) ? element.location.department??'':'' ),
			( ( element.location ) ? element.location.country??'':'' ),
			`<span class="badge text-bg-secondary ${element.state_id}">${element.state??''}</span>`,
			element.created_at??'',
			element.ad_purchased_at??'',
			element.full_name??'',
			element.ad_plan??'',
			element.publisher_role??'',
			element.bedrooms_count??'',
			element.bathrooms_count??'',
			element.area,
			element.built_area,
			element.parking_slots_count??'',
			element.parking_for_visits ? 'Si': 'No',
			element.year_of_construction??'',
			element.total_floors_count??'',
			element.floor_number??'',
			element.pet_friendly ? 'Si' : 'No',
			(element.facilities && element.facilities.length>0)?(element.facilities.map((item)=> item.title).join(', ')):'',
			(element.advanced_details && element.advanced_details.length>0)?(element.advanced_details.map((item)=> item.title).join(', ')):'',
			element.description??'',
			element.images.length??'',
			element.videos.length === 0 ? 'No' : (element.videos[0].content ? `<a href="${element.videos[0].content}" target="_blank">${element.videos[0].content}</a>` : 'No existe la url'),
			element.views_count??'',
			element.favourites_count??'',
			element.contacts_count??'',
			element.updated_at??'',
			element.ad_expires_at??'',
			element.email??'',
			getFullNumber(prefix, phone),
			( ( element.external_data == '' ) ? '-' : `
			<div class="external-data">
				${element.external_data}
				<div class="links">
					<a title="Copiar URL" role="button" onclick="copyText('${element.external_data}')"><i class="far fa-copy"></i></a>
					<a title="Abrir en una pestaña nueva" href="${element.external_data}" target="_blank"><i class="fas fa-external-link-alt"></i></a>
				</div>
			</div>
			` )
			
		];
	}
	const modalOrder =  [
		0, 	//ID del listing
		37, //External data
		9, 	//Estado
		10, //Fecha de creación
		11, //Fecha de publicación
		33, //Fecha de actualización
		34, //Fecha de expiración
		1,  //Tipo de operación
		2,  //Tipo de inmueble
		3, 	//Precio
		4, 	//Direccion
		5, 	//Distrito
		6, 	//Provincia
		7, 	//Departamento
		8, 	//Pais
		12, //Nombre del usuario
		35, //Email
		36, //Telefono
		13, //Categoria
		14, //Rol
		30, //Numero de vistas
		31, //Número de favoritos
		32, //Numero de contactos
		15, //Cuartos
		16, //Baños
		17, //Area total
		18, //Área techada
		19, //Estacionamientos
		20, //Estacionamiento para visitas
		21, //Año de construcción
		22, //Número de pisos
		23, //Piso del inmueble
		24, //Pet friendly
		25, //Comodidades
		26, //Adicionales
		27, //Descripción
		28, //Numero de fotos
		29	//Video
	];
	const copyText = (text = '') => {
		navigator.clipboard.writeText(text);
		Toast.fire({
			icon: 'info',
			title: 'Mensaje del sistema',
			text: 'Se ha copiado la URL en el portapapeles'
		})
	}
	const modalTitle = (element, globalRecords = []) =>{
		let rowInfo = globalRecords.filter((item)=> item.id == element);
		let url_external = URL_WEB_FRONT + rowInfo[0].url?.share ?? '';
		return `
			<div class="external-data title">
				Detalles para ${element}
				<div class="links">
					<a title="Copiar URL" role="button" onclick="copyText('${url_external}')"><i class="far fa-copy"></i></a>
					<a title="Abrir en una pestaña nueva" href="${url_external}" target="_blank"><i class="fas fa-external-link-alt"></i></a>
				</div>
			</div>
		`;
	}
	const columnsHidden = [7, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34,35,36, 37];
	const columnsDates = [10, 11, 33, 34];
	const options = {
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_avisos',
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		url: 'app/gateway'
	};
	
	datatable(options);
</script>
@endsection