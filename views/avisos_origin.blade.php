@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/datatables.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/SearchBuilder-1.5.0/css/searchBuilder.bootstrap4.min.css">
<style>
	.dataTables_wrapper .dataTables_processing {
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
<div class="modal fade" id="rowDetails" tabindex="-1" role="dialog" aria-labelledby="rowDetailsLabel" aria-hidden="true">
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
<script src="public/plugins/LibDataTables/datatables.js"></script>
<script src="public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="public/plugins/LibDataTables/SearchBuilder-1.5.0/js/searchBuilder.bootstrap4.min.js"></script>
<script src="public/plugins/LibDataTables/DateTime-1.5.1/js/dataTables.dateTime.min.js"></script>
<script>
    let tableSaved = null;
	let dtDraw = 1;
	let filters = [];
	const headers = [
			{ "title": "ID del listing", "code": "id" },
			{ "title": "Estado", "code": "state" },
			{ "title": "Tipo de operación", "code": "listing_type" },
			{ "title": "Tipo de inmueble", "code": "property_type" },
			{ "title": "Precio", "code": "price" },
			{ "title": "Direccion", "code": "id" },
			{ "title": "Distrito", "code": "id" },
			{ "title": "Provincia", "code": "id" },
			{ "title": "Ciudad", "code": "id" },
			{ "title": "Pais", "code": "id" },
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
		]
    const lenguaje = {
		"processing": "Procesando...",
		"lengthMenu": "Mostrar _MENU_ registros",
		"zeroRecords": "No se encontraron resultados",
		"emptyTable": "Ningún dato disponible en esta tabla",
		"infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
		"infoFiltered": "(filtrado de un total de _MAX_ registros)",
		"search": "Buscar:",
		"infoThousands": ",",
		"loadingRecords": "Cargando...",
		"paginate": {
			"first": "Primero",
			"last": "Último",
			"next": "Siguiente",
			"previous": "Anterior"
		},
		"aria": {
			"sortAscending": ": Activar para ordenar la columna de manera ascendente",
			"sortDescending": ": Activar para ordenar la columna de manera descendente"
		},
		"buttons": {
			"copy": "Copiar",
			"colvis": "Visibilidad",
			"collection": "Colección",
			"colvisRestore": "Restaurar visibilidad",
			"copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
			"copySuccess": {
				"1": "Copiada 1 fila al portapapeles",
				"_": "Copiadas %ds fila al portapapeles"
			},
			"copyTitle": "Copiar al portapapeles",
			"csv": "CSV",
			//"excel": "Excel",
			"excel": "Exportar página actual a Excel",
			"pageLength": {
				"-1": "Mostrar todas las filas",
				"_": "Mostrar %d filas"
			},
			"pdf": "PDF",
			"print": "Imprimir",
			"renameState": "Cambiar nombre",
			"updateState": "Actualizar",
			"createState": "Crear Estado",
			"removeAllStates": "Remover Estados",
			"removeState": "Remover",
			"savedStates": "Estados Guardados",
			"stateRestore": "Estado %d"
		},
		"autoFill": {
			"cancel": "Cancelar",
			"fill": "Rellene todas las celdas con <i>%d<\/i>",
			"fillHorizontal": "Rellenar celdas horizontalmente",
			"fillVertical": "Rellenar celdas verticalmentemente"
		},
		"decimal": ",",
		"searchBuilder": {
			"add": "Añadir filtro",
			"button": {
				"0": "Constructor de búsqueda",
				"_": "Constructor de búsqueda (%d)"
			},
			"clearAll": "Borrar todo",
			"condition": "Condición",
			"conditions": {
				"date": {
					"after": "Despues",
					"before": "Antes",
					"between": "Entre",
					"empty": "Vacío",
					"equals": "Igual a",
					"notBetween": "No entre",
					"notEmpty": "No Vacio",
					"not": "Diferente de"
				},
				"number": {
					"between": "Entre",
					"empty": "Vacio",
					"equals": "Igual a",
					"gt": "Mayor a",
					"gte": "Mayor o igual a",
					"lt": "Menor que",
					"lte": "Menor o igual que",
					"notBetween": "No entre",
					"notEmpty": "No vacío",
					"not": "Diferente de"
				},
				"string": {
					"contains": "Contiene",
					"empty": "Vacío",
					"endsWith": "Termina en",
					"equals": "Igual a",
					"notEmpty": "No Vacio",
					"startsWith": "Empieza con",
					"not": "Diferente de",
					"notContains": "No Contiene",
					"notStarts": "No empieza con",
					"notEnds": "No termina con"
				},
				"array": {
					"not": "Diferente de",
					"equals": "Igual",
					"empty": "Vacío",
					"contains": "Contiene",
					"notEmpty": "No Vacío",
					"without": "Sin"
				}
			},
			"data": "Data",
			"deleteTitle": "Eliminar regla de filtrado",
			"leftTitle": "Criterios anulados",
			"logicAnd": "Y",
			"logicOr": "O",
			"rightTitle": "Criterios de sangría",
			"title": {
				"0": "Constructor de búsqueda",
				"_": "Constructor de búsqueda (%d)"
			},
			"value": "Valor"
		},
		"searchPanes": {
			"clearMessage": "Borrar todo",
			"collapse": {
				"0": "Paneles de búsqueda",
				"_": "Paneles de búsqueda (%d)"
			},
			"count": "{total}",
			"countFiltered": "{shown} ({total})",
			"emptyPanes": "Sin paneles de búsqueda",
			"loadMessage": "Cargando paneles de búsqueda",
			"title": "Filtros Activos - %d",
			"showMessage": "Mostrar Todo",
			"collapseMessage": "Colapsar Todo"
		},
		"select": {
			"cells": {
				"1": "1 celda seleccionada",
				"_": "%d celdas seleccionadas"
			},
			"columns": {
				"1": "1 columna seleccionada",
				"_": "%d columnas seleccionadas"
			},
			"rows": {
				"1": "1 fila seleccionada",
				"_": "%d filas seleccionadas"
			}
		},
		"thousands": ".",
		"datetime": {
			"previous": "Anterior",
			"next": "Proximo",
			"hours": "Horas",
			"minutes": "Minutos",
			"seconds": "Segundos",
			"unknown": "-",
			"amPm": [
				"AM",
				"PM"
			],
			"months": {
				"0": "Enero",
				"1": "Febrero",
				"10": "Noviembre",
				"11": "Diciembre",
				"2": "Marzo",
				"3": "Abril",
				"4": "Mayo",
				"5": "Junio",
				"6": "Julio",
				"7": "Agosto",
				"8": "Septiembre",
				"9": "Octubre"
			},
			"weekdays": [
				"Dom",
				"Lun",
				"Mar",
				"Mie",
				"Jue",
				"Vie",
				"Sab"
			]
		},
		"editor": {
			"close": "Cerrar",
			"create": {
				"button": "Nuevo",
				"title": "Crear Nuevo Registro",
				"submit": "Crear"
			},
			"edit": {
				"button": "Editar",
				"title": "Editar Registro",
				"submit": "Actualizar"
			},
			"remove": {
				"button": "Eliminar",
				"title": "Eliminar Registro",
				"submit": "Eliminar",
				"confirm": {
					"_": "¿Está seguro que desea eliminar %d filas?",
					"1": "¿Está seguro que desea eliminar 1 fila?"
				}
			},
			"error": {
				"system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
			},
			"multi": {
				"title": "Múltiples Valores",
				"info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
				"restore": "Deshacer Cambios",
				"noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
			}
		},
		"info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
		"stateRestore": {
			"creationModal": {
				"button": "Crear",
				"name": "Nombre:",
				"order": "Clasificación",
				"paging": "Paginación",
				"search": "Busqueda",
				"select": "Seleccionar",
				"columns": {
					"search": "Búsqueda de Columna",
					"visible": "Visibilidad de Columna"
				},
				"title": "Crear Nuevo Estado",
				"toggleLabel": "Incluir:"
			},
			"emptyError": "El nombre no puede estar vacio",
			"removeConfirm": "¿Seguro que quiere eliminar este %s?",
			"removeError": "Error al eliminar el registro",
			"removeJoiner": "y",
			"removeSubmit": "Eliminar",
			"renameButton": "Cambiar Nombre",
			"renameLabel": "Nuevo nombre para %s",
			"duplicateError": "Ya existe un Estado con este nombre.",
			"emptyStates": "No hay Estados guardados",
			"removeTitle": "Remover Estado",
			"renameTitle": "Cambiar Nombre Estado"
		}
	};
	const Buttons = [
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
			text: "Ocultar columnas"
		}
	];
	window.state = [
		{
			"name": "Eliminados",
			"code": "deleted"
		},
		{
			"name": "Visibles",
			"code": "visible"
		},
		{
			"name": "Ocultas",
			"code": "hidden"
		}
	]
	window.listing_type = [
		{
			"name": "Venta",
			"code": "sale"
		},
		{
			"name": "Alquiler",
			"code": "rent"
		},
		{
			"name": "Todos",
			"code": "all"
		}
	]
	window.property_type = [
		{
			"name": "Todos",
			"code": "all"
		},
		{
			"name": "Departamento",
			"code": "apartment"
		},
		{
			"name": "Casa",
			"code": "house"
		},
		{
			"name": "Local Comercial",
			"code": "commercial"
		},
		{
			"name": "Oficina",
			"code": "office"
		},
		{
			"name": "Terreno",
			"code": "land"
		},
		{
			"name": "Cuarto",
			"code": "room"
		},
		{
			"name": "Local industrial",
			"code": "local_industrial"
		},
		{
			"name": "Terreno agrícola",
			"code": "land_agricultural"
		},
		{
			"name": "Terreno industrial",
			"code": "land_industrial"
		},
		{
			"name": "Terreno comercial",
			"code": "land_commercial"
		},
		{
			"name": "Casa de campo",
			"code": "cottage"
		},
		{
			"name": "Casa de playa",
			"code": "beach_house"
		},
		{
			"name": "Edificio",
			"code": "building"
		},
		{
			"name": "Hotel",
			"code": "hotel"
		},
		{
			"name": "Depósito",
			"code": "deposit"
		},
		{
			"name": "Estacionamiento",
			"code": "parking"
		},
		{
			"name": "Aires",
			"code": "airs"
		}
	]
    //REDIMENSIONAR DATATABLE
	jQuery.fn.redimensionarTable=function(){
		if(tableSaved != null){
			tableSaved.responsive.recalc();
		}
    };
	//CREAR SELECT DATATABLE
	window.createSelect = function(field, that, fn, preDefined = null) {
		let el = $('<select/>')
			.addClass(Criteria.classes.value)
			.addClass(Criteria.classes.dropDown)
			.addClass(Criteria.classes.italic)
			.addClass(Criteria.classes.select)
			.append(that.dom.valueTitle)
			.on('change.dtsb', function() {
				$(this).removeClass(Criteria.classes.italic);
				fn(that, this);
			});

		if (that.c.greyscale) {
			el.addClass(Criteria.classes.greyscale);
		}

		let added = [];
		let options = [];
		// Function to add an option to the select element
		let addOption = (filt, text) => {
			if (that.s.type.includes('html') && filt !== null && typeof filt === 'string') {
			filt.replace(/(<([^>]+)>)/ig, '');
			}
			// Add text and value, stripping out any html if that is the column type
			let opt = $('<option>', {
			type: Array.isArray(filt) ? 'Array' : 'String',
			value: filt
			})
			.data('sbv', filt)
			.addClass(that.classes.option)
			.addClass(that.classes.notItalic)
			// Have to add the text this way so that special html characters are not escaped - &amp; etc.
			.html(
			typeof text === 'string' ?
			text.replace(/(<([^>]+)>)/ig, '') :
			text
			);

			let val = opt.val();
			
			// Check that this value has not already been added
			if (added.indexOf(val) === -1) {
			added.push(val);
			options.push(opt);
			
			if (preDefined !== null && Array.isArray(preDefined[0])) {
				preDefined[0] = preDefined[0].sort().join(',');
			}

			// If this value was previously selected as indicated by preDefined, then select it again
			if (preDefined !== null && opt.val() === preDefined[0]) {
				opt.prop('selected', true);
				el.removeClass(Criteria.classes.italic);
				that.dom.valueTitle.removeProp('selected');
			}
			}
		};
		/*****************************************************************************************/
		(window[field]).forEach(element => {
			addOption(element.code, element.name)
		});
		/*****************************************************************************************/
		for (let opt of options) {
			el.append(opt);
		}
		return el;
	}
	//CREAR INPUT DATATABLE
	window.createInput = function(that, fn, preDefined = null) {
		// Declare the input element
		let el = $('<input/>')
			.addClass(that.classes.value)
			.addClass(that.classes.input)
			.on('input', function() { fn(that, this); });

		// If there is a preDefined value then add it
		if (preDefined !== null) {
			$(el).val(preDefined[0]);
		}
		return el;
	}
	const Criteria = $.fn.dataTable.Criteria;
    jQuery.fn.createDataTable=function(searchBuilder = null, columnDefs = null, returnTable = {}, lengthMenu = 25, dom = true, columns = null, data = null){
		var attr = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('attr') ) ? returnTable.attr:'class';
		var value = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('value') ) ? returnTable.value:'display';
		var dom = ( dom ) ? 'QBlrtip':'lfrtip'; //f: buscador
		var element =  ( attr == 'class' ) ? $('table.'+ value):$('table['+ attr +'="'+ value +'"]');
		var table = element
		//.on( 'search.dt', function () { $(this).redimensionarTable(); } )
		//.on( 'page.dt', function () { $(this).redimensionarTable(); } )
		
		.on('preXhr.dt', function ( e, settings, data ) {
			
			//console.log(data);
			//console.log(data['searchBuilder']);
			//delete data.searchBuilder;
		} )
		.DataTable({
			dom: dom,
			buttons: Buttons,
			"lengthMenu": [ ( (lengthMenu == 25) ? 25:lengthMenu ), 50, 75, 100, 200, 500 ],
			"pageLength": lengthMenu,
			"order": [],
			//"data": data,

			ajax: {
				"url": 'https://services-testing.babilonia.pe/app/listing/listings',
				"type": 'GET',
				"data": function ( data ) {
					filters = [];
					data.page = ( tableSaved ) ? ( tableSaved.page.info().page + 1 ) : 1;
					data.per_page = ( tableSaved ) ? ( tableSaved.page.info().length ) : 25;
					data.order.forEach(element => {
						data.order_by = headers[element.column].code;
						data.order_dir = element.dir;
					});
					if(tableSaved?.searchBuilder){
						const searchBuilder = tableSaved.searchBuilder.getDetails();
						let criterios = [];
						(searchBuilder.criteria??[]).forEach(element => {
							if( typeof element.condition == 'undefined'){
								return;
							}
							let index = headers.findIndex(x => x.title === element.data??null);
							if( filters.includes(headers[index].code)){
								return;
							}
							switch (element.condition) {
								case '=':
									data[headers[index].code] = element.value[0];
									break;
								case 'between':
									data[headers[index].code + '[from]'] = element.value[0];
									data[headers[index].code + '[to]'] = element.value[1];
									break;
							}
							filters.push(headers[index].code);
						});
						//data.criterios = criterios;
					}
					console.log(data);
					delete data.searchBuilder;
					delete data.start;
					delete data.draw;
					delete data.columns;
					delete data.order;
					delete data.search;
				},
				"dataSrc": function ( json ) {
					const data = json.data??{};
					const records = data.records??[];
					let object = {
						"draw": 1,
						"recordsTotal": data.listings_count,
						"recordsFiltered": data.listings_count,
						"data": []
					};
					records.forEach((element, index) => {
						object.data.push([
							element.id,
							element.status??'',
							element.listing_type??'',
							element.property_type??'',
							element.price??'',
							( ( element.location ) ? element.location.address??'':'' ),
							( ( element.location ) ? element.location.district??'':'' ),
							( ( element.location ) ? element.location.province??'':'' ),
							( ( element.location ) ? element.location.department??'':'' ),
							( ( element.location ) ? element.location.country??'':'' ),
							new Date(Date.parse(element.created_at)).toLocaleDateString("default", {
								year: "numeric",
								month: "2-digit",
								day: "2-digit",
							}),
							new Date(Date.parse(element.created_at)).toLocaleDateString("default", { 
								year: "numeric",
								month: "2-digit",
								day: "2-digit",
							}),
							( ( element.user ) ? element.user.full_name??'':'' ),
							element.ad_plan??'',
							element.publisher_role??'',
							element.days_remain??'',
							element.bedrooms_count??'',
							element.bathrooms_count??'',
							element.area??'',
							element.built_area??'',
							element.parking_slots_count??'',
							element.parking_for_visits ? 'SI': 'NO',
							element.year_of_construction??'',
							element.total_floors_count??'',
							element.floor_number??'',
							element.pet_friendly ? 'SI' : 'NO',
							element.facilities??[].toString(),
							element.advanced_details??[].toString(),
							element.description??'',
							element.images.length??'',
							element.videos.length === 0 ? 'SI' : 'NO',
							element.views_count??'',
							element.favourites_count??'',
							element.contacts_count??'',
							new Date(Date.parse(element.updated_at)).toLocaleDateString("default", { 
								year: "numeric",
								month: "2-digit",
								day: "2-digit",
							}),
							new Date(Date.parse(element.ad_expires_at)).toLocaleDateString("default", { 
								year: "numeric",
								month: "2-digit",
								day: "2-digit",
							}),
							`
							<div class="dropdown">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
									Acciones
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item details" data-index="${index}" role="button"><i class="fas fa-eye"></i>&nbsp;&nbsp;Ver</a>
									<a class="dropdown-item" href="#"><i class="fas fa-edit"></i>&nbsp;&nbsp;Editar</a>
									<a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Eliminar</a>
								</div>
							</div>
							`
						]);
					});
					return object.data;
				}
			},

			"columns": columns,
			"pagingType": "numbers",
			"language": lenguaje,
			"drawCallback": function( settings ) {
				$(this).redimensionarTable();
			},
			"initComplete": function(settings, json) {
				$( 'p[name=\'loading\']' ).remove();
				$(this).removeClass( 'd-none' );
			},
			fixedHeader: true,
			processing: true,
			serverSide: true,
			searchBuilder: searchBuilder,
			columnDefs: columnDefs
		})
		.on('xhr.dt', function ( e, settings, json, xhr ) {
			json.recordsTotal = json.data.pagination.total_records;
			json.recordsFiltered = json.data.pagination.total_records;
			json.draw = dtDraw;
			dtDraw += 1;
		} );
		if( !jQuery.isEmptyObject(returnTable) ){
			return table;
		}else{
			tableSaved = table;
		}
	}
	const columnDefs = [{
		targets: [0, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35],
		visible: false,
		class: "none"
	},{ type: "date", targets: [10, 11, 34, 35] }];
	const searchBuilder = {
		depthLimit: 1,
		columns: [1, 2, 3, 4],
		conditions: {
			string: {
				"=" : {
                    init: function(that, fn, preDefined = null, array = false) {
						let column = that.dom.data.children('option:selected').val();
						let indexArray = that.s.dt.rows().indexes().toArray();
						let settings = that.s.dt.settings()[0];
						that.dom.valueTitle.prop('selected', true);
						const field = headers[column];

						switch (field.code) {
							case 'state':
								return createSelect(field.code, that, fn, preDefined);
								break;
							case 'listing_type':
								return createSelect(field.code, that, fn, preDefined);
								break;
							case 'property_type':
								return createSelect(field.code, that, fn, preDefined);
								break;
							default:
								return createInput(that, fn, preDefined);
								break;
						}
					},
					inputValue: function(el, that) {
                        return [$(el[0]).val()];
                    }
                },
				"!=": null,
				"!null": null,
				"contains": null,
				"!contains": null,
				"ends": null,
				"!ends": null,
				"null": null,
				"starts": null,
				"!starts": null
			},
			num: {
				"!=": null,
				"!null": null,
				"<": null,
				"<=": null,
				"=": null,
				">": null,
				">=": null,
				//"between": null,
				"!between": null,
				"null": null,
			},
			date: {
				"!=": null,
				"!null": null,
				"<": null,
				"=": null,
				">": null,
				//"between": null,
				"!between": null,
				"null": null,
			}
		},
	};
	$(this).createDataTable(searchBuilder, columnDefs, false, 25, true, headers);
	tableSaved.on('click', '.details', function (e) {
		e.preventDefault();
		const target = $(this).attr('data-index');
		const data = tableSaved.rows( target ).data()[0];
		$("#rowDetails .modal-body").html("");
		data.forEach((element, index, array) => {
			if (index + 1 === array.length){ return; }
			if (index === 0){
				$("#rowDetails .modal-title").html("Detalles para " + element);
			}
			$("#rowDetails .modal-body").append(`
				<div class="box-details">
					<div>${headers[index].title}</div>
					<div>${element}</div>
				</div>
			`);
		});
		
		$("#rowDetails").modal('show');
	});
	setTimeout(() => {
		$(".dtsb-add").on('click', function (e) {
			/*
				e.preventDefault();
			const details = tableSaved.searchBuilder.getDetails();
			console.log(details.criteria.length)
			if( details.criteria.length > 3 ){
				console.log("Solo se pueden establecer 3 condiciones");
				e.preventDefault();
				return false;
			}
			console.log(tableSaved.searchBuilder.getDetails());*/
		})
	}, 2000);
	

	


	/*
    async function myAjax(param) {
        let result
        try {
            result = await $.ajax({
                url: 'https://services-testing.babilonia.io/public/listing/listings',
                type: 'GET',
                //data: jQuery.param( { "obtener-registros-marcacion": 1, "semestreid": param } ) ,
                dataType: 'JSON',
            })
            return result
        } catch (error) {
            console.error(error)
        }
    }
	function aleatorio(inferior, superior) {
		var numPosibilidades = superior - inferior;
		var aleatorio = Math.random() * (numPosibilidades + 1);
		aleatorio = Math.floor(aleatorio);
		return inferior + aleatorio;
	}
	tableSaved = 
		new DataTable('.display', {
		ajax: {
			"url": 'https://services-testing.babilonia.io/app/listing/listings',
			"type": 'GET',
			"data": function ( d ) {
				d.page = ( tableSaved ) ? ( tableSaved.page.info().page + 1 ) : 1;
				d.per_page = ( tableSaved ) ? ( tableSaved.page.info().length ) : 25;
			},
			"dataSrc": function ( json ) {
				const data = json.data??{};
				const records = data.records??[];
				let object = {
					"draw": 1,
					"recordsTotal": data.listings_count,
					"recordsFiltered": data.listings_count,
					"data": []
				};
				records.forEach((element, index) => {
					object.data.push([
						element.id,
						element.status??'',
						element.listing_type??'',
						element.property_type??'',
						element.price??'',
						( ( element.location ) ? element.location.address??'':'' ),
						( ( element.location ) ? element.location.district??'':'' ),
						( ( element.location ) ? element.location.province??'':'' ),
						( ( element.location ) ? element.location.department??'':'' ),
						( ( element.location ) ? element.location.country??'':'' ),
						new Date(Date.parse(element.created_at)).toLocaleDateString("default", {
							year: "numeric",
							month: "2-digit",
							day: "2-digit",
						}),
						new Date(Date.parse(element.created_at)).toLocaleDateString("default", { 
							year: "numeric",
							month: "2-digit",
							day: "2-digit",
						}),
						( ( element.user ) ? element.user.full_name??'':'' ),
						element.ad_plan??'',
						element.publisher_role??'',
						element.days_remain??'',
						element.bedrooms_count??'',
						element.bathrooms_count??'',
						element.area??'',
						element.built_area??'',
						element.parking_slots_count??'',
						element.parking_for_visits ? 'SI': 'NO',
						element.year_of_construction??'',
						element.total_floors_count??'',
						element.floor_number??'',
						element.pet_friendly ? 'SI' : 'NO',
						element.facilities??[].toString(),
						element.advanced_details??[].toString(),
						element.description??'',
						element.images.length??'',
						element.videos.length === 0 ? 'SI' : 'NO',
						element.views_count??'',
						element.favourites_count??'',
						element.contacts_count??'',
						new Date(Date.parse(element.updated_at)).toLocaleDateString("default", { 
							year: "numeric",
							month: "2-digit",
							day: "2-digit",
						}),
						new Date(Date.parse(element.ad_expires_at)).toLocaleDateString("default", { 
							year: "numeric",
							month: "2-digit",
							day: "2-digit",
						}),
						`
						<div class="dropdown">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
								Acciones
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item details" data-index="${index}" role="button"><i class="fas fa-eye"></i>&nbsp;&nbsp;Ver</a>
								<a class="dropdown-item" href="#"><i class="fas fa-edit"></i>&nbsp;&nbsp;Editar</a>
								<a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Eliminar</a>
							</div>
						</div>
						`
					]);
				});
				return object.data;
			}
		},
		"lengthMenu": [ 25, 50, 75, 100, 200, 500 ],
		"pageLength": 25,
		"pagingType": "numbers",
		"language": lenguaje,
		"drawCallback": function( settings ) {
			$(this).redimensionarTable();
		},
		"initComplete": function(settings, json) {
			$( 'p[name=\'loading\']' ).remove();
			$(this).removeClass( 'd-none' );
		},
    	"searching": { "regex": true },
		dom: 'QBlfrtip',
		buttons: Buttons,
		search: {
			return: true
		},
		columns: headers,
		processing: true,
		serverSide: true
	})
	.on('xhr.dt', function ( e, settings, json, xhr ) {
		json.recordsTotal = json.data.pagination.total_records;
		json.recordsFiltered = json.data.pagination.total_records;
		json.draw = dtDraw;
		dtDraw += 1;
	} );
    myAjax().then((data) => {
        const listings = data?.data?.records??[]
        console.log(listings);
        const columnDefs = [{
			targets: [0, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35],
			visible: false,
			class: "none"
		},
		{ type: "date", targets: [10, 11] }];
        const searchBuilder = {};
        let object = [];
        listings.forEach((element, index) => {
            object.push([
                element.id,
                element.status??'',
                element.listing_type??'',
                element.property_type??'',
                element.price??'',
                ( ( element.location ) ? element.location.address??'':'' ),
                ( ( element.location ) ? element.location.district??'':'' ),
                ( ( element.location ) ? element.location.province??'':'' ),
                ( ( element.location ) ? element.location.department??'':'' ),
                ( ( element.location ) ? element.location.country??'':'' ),
                new Date(Date.parse(element.created_at)).toLocaleDateString("default", {
					year: "numeric",
					month: "2-digit",
					day: "2-digit",
				}),
                new Date(Date.parse(element.created_at)).toLocaleDateString("default", { 
					year: "numeric",
					month: "2-digit",
					day: "2-digit",
				}),
                ( ( element.user ) ? element.user.full_name??'':'' ),

                element.ad_plan??'',
                element.publisher_role??'',
                element.days_remain??'',
                element.bedrooms_count,
                element.bathrooms_count,
                element.area,
                element.built_area,
                element.parking_slots_count,
                element.parking_for_visits ? 'SI': 'NO',
                element.year_of_construction,
                element.total_floors_count,
                element.floor_number,
                element.pet_friendly ? 'SI' : 'NO',
                element.facilities??[].toString(),
                element.advanced_details??[].toString(),
                element.description,
                element.images.length,
                element.videos.length === 0 ? 'SI' : 'NO',
                element.views_count,
                element.favourites_count,
                element.contacts_count,
                new Date(Date.parse(element.updated_at)).toLocaleDateString("default", { 
					year: "numeric",
					month: "2-digit",
					day: "2-digit",
				}),
                new Date(Date.parse(element.ad_expires_at)).toLocaleDateString("default", { 
					year: "numeric",
					month: "2-digit",
					day: "2-digit",
				}),

				`
				<div class="dropdown">
					<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
						Acciones
					</button>
					<div class="dropdown-menu">
						<a class="dropdown-item details" data-index="${index}" role="button"><i class="fas fa-eye"></i>&nbsp;&nbsp;Ver</a>
						<a class="dropdown-item" href="#"><i class="fas fa-edit"></i>&nbsp;&nbsp;Editar</a>
						<a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Eliminar</a>
					</div>
				</div>
				`
            ]);
        });
        $(this).createDataTable(searchBuilder, columnDefs, false, 10, true, headers, object);
		tableSaved.on('click', '.details', function (e) {
			e.preventDefault();
			const target = $(this).attr('data-index');
			const data = tableSaved.rows( target ).data()[0];
			$("#rowDetails .modal-body").html("");
			data.forEach((element, index, array) => {
				if (index + 1 === array.length){ return; }
				if (index === 0){
					$("#rowDetails .modal-title").html("Detalles para " + element);
				}
				$("#rowDetails .modal-body").append(`
					<div class="box-details">
						<div>${headers[index].title}</div>
						<div>${element}</div>
					</div>
				`);
			});
			
			$("#rowDetails").modal('show');
		});
    });*/
</script>
@endsection