@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
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
	.badge:is(.published,.not_published,.unpublished,.expired,.deleted){
		box-shadow: 2px 2px 17px 1px rgba(0, 0, 0, 0.2)
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
                  			<label>Cliente</label>
							@component("components.search-user",array("storage"=>"filter_listing_users"))
							@endcomponent
                		</div>
                	</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Precio (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control" id="price_from" placeholder="desde">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="price_to" placeholder="hasta">
								</div>
							</div>
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
							<label for="exampleInputEmail1">Fecha de actualización (Desde - Hasta)</label>
							<div class="form-row">
								<div class="col-6">
									<input type="text" class="form-control" id="updated_start" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="updated_end" placeholder="dd/mm/yyyy">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Fecha de publicación (Desde - Hasta)</label>
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
<script src="@asset("js/components/datatable.js")"></script>
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<script>
	setMask('#created_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#created_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });

	setMask('#updated_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#updated_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });

	setMask('#purchased_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#purchased_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });

	setMask('#expires_start', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#expires_end', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
</script>

<script>
	const roles = {
		"realtor" : "Agente",
		"owner" : "Propietario"
	};
	const headers = [
			{ "title": "ID del listing", "code": "id" },
			
			{ "title": "Tipo de operación", "code": "listing_type" },
			{ "title": "Tipo de inmueble", "code": "property_type" },
			{ "title": "Precio", "code": "price" },
			{ "title": "Direccion", "code": "id" },
			{ "title": "Distrito", "code": "id" },
			{ "title": "Provincia", "code": "id" },
			{ "title": "Departamento", "code": "id" },
			{ "title": "Pais", "code": "id" },
			{ "title": "Estado", "code": "state" },
			{ "title": "Fecha de creación", "code": "id" },
			{ "title": "Fecha de publicación", "code": "id" },
			{ "title": "Nombre del usuario", "code": "id" },
            { "title": "Categoria", "code": "id" },
            { "title": "Duración", "code": "id" },
            { "title": "Rol", "code": "id" },
            { "title": "Cuartos", "code": "id" },
            { "title": "Baños", "code": "id" },
            { "title": "Area total", "code": "id" },
            { "title": "Área techada", "code": "id" },
            { "title": "Estacionamientos", "code": "id" },
            { "title": "Estacionamiento para visitas", "code": "id" },
            { "title": "Año de construcción", "code": "id" },
            { "title": "Número de pisos", "code": "id" },
            { "title": "Piso del inmueble", "code": "id" },
            { "title": "Pet friendly", "code": "id" },
            { "title": "Comodidades", "code": "id" },
            { "title": "Adicionales", "code": "id" },
            { "title": "Descripción", "code": "id" },
            { "title": "Numero de fotos", "code": "id" },
            { "title": "Video", "code": "id" },
            { "title": "Numero de vistas", "code": "id" },
            { "title": "Número de favoritos", "code": "id" },
            { "title": "Numero de contactos", "code": "id" },
            { "title": "Fecha de actualización", "code": "id" },
            { "title": "Fecha de expiración", "code": "id" },
			{ "title": "Acciones", "code": "id" }
	];
	const filtersFields = [
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
			name: 'user_id',
			type: filtersParamsTypes.USER,
			search: true,
			storage: 'filter_listing_users'
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

		let facilities = [], advanced_details = [];
		(element.facilities??[]).forEach(element => {
			facilities.push(element.title_lang??'');
		});
		(element.advanced_details??[]).forEach(element => {
			advanced_details.push(element.title_lang??'');
		});

		return [
			element.id,							
			(element.listing_type??[])??'',
			(element.property_type??[])??'',
			'$' + Number(element.price??'').toLocaleString("en"),
			( ( element.location ) ? element.location.address??'':'' ),
			( ( element.location ) ? element.location.district??'':'' ),
			( ( element.location ) ? element.location.province??'':'' ),
			( ( element.location ) ? element.location.department??'':'' ),
			( ( element.location ) ? element.location.country??'':'' ),
			`<span class="badge text-bg-secondary ${element.state_id}">${element.state??''}</span>`,
			( ( element.created_at ) ? moment(element.created_at).format('DD/MM/YYYY'):'' ),
			( ( element.ad_purchased_at ) ? moment(element.ad_purchased_at).format('DD/MM/YYYY'):'' ),
			( ( element.contacts ) ? element.contacts[0]?.name??'':'' ),
			element.ad_plan??'',
			( ( element.days_remain ) ? element.days_remain + ' días':'' ),
			element.publisher_role?(roles[element.publisher_role]??''):'',
			element.bedrooms_count??'',
			element.bathrooms_count??'',
			( ( element.area ) ? Number(element.area).toLocaleString("en") + ' m²':'' ),
			( ( element.built_area ) ? Number(element.built_area).toLocaleString("en") + ' m²':'' ),
			element.parking_slots_count??'',
			element.parking_for_visits ? 'Si': 'No',
			element.year_of_construction??'',
			element.total_floors_count??'',
			element.floor_number??'',
			element.pet_friendly ? 'Si' : 'No',
			facilities.join(', '),
			advanced_details.join(', '),
			element.description??'',
			element.images.length??'',
			element.videos.length === 0 ? 'No' : (element.videos[0].content ? `<a href="${element.videos[0].content}" target="_blank">${element.videos[0].content}</a>` : 'No existe la url'),
			element.views_count??'',
			element.favourites_count??'',
			element.contacts_count??'',
			( ( element.updated_at ) ? moment(element.updated_at).format('DD/MM/YYYY') :'' ),
			( ( element.ad_expires_at ) ? moment(element.ad_expires_at).format('DD/MM/YYYY') :'' ),
		];
	}
	const modalOrder =  [
		0, 	//ID del listing
		9, 	//Estado
		10, //Fecha de creación
		11, //Fecha de publicación
		34, //Fecha de actualización
		35, //Fecha de expiración
		1,  //Tipo de operación
		2,  //Tipo de inmueble
		3, 	//Precio
		4, 	//Direccion
		5, 	//Distrito
		6, 	//Provincia
		7, 	//Departamento
		8, 	//Pais
		12, //Nombre del usuario
		13, //Categoria
		14, //Duración
		15, //Rol
		31, //Numero de vistas
		32, //Número de favoritos
		33, //Numero de contactos
		16, //Cuartos
		17, //Baños
		18, //Area total
		19, //Área techada
		20, //Estacionamientos
		21, //Estacionamiento para visitas
		22, //Año de construcción
		23, //Número de pisos
		24, //Piso del inmueble
		25, //Pet friendly
		26, //Comodidades
		27, //Adicionales
		28, //Descripción
		29, //Numero de fotos
		30	//Video
	];
	const modalTitle = (element, globalRecords = []) =>{
		let rowInfo = globalRecords.filter((item)=> item.id == element);
		let url_external = URL_WEB_FRONT + rowInfo[0].url_external ?? '';

		return `Detalles para <a target="_blank" href="${url_external}">${element}</a>`;
	}
	const columnsHidden = [7, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35];
	const columnsDates = [10, 11, 34, 35];
	const options = {
		processParams,
		headers,
		filtersFields,
		storageView : 'filter_avisos',
		columnsHidden,
		columnsDates,
		modalOrder,
		modalTitle,
		url: 'https://services-testing.babilonia.io/app/listing/listings'
	};
	
	datatable(options);
</script>
@endsection