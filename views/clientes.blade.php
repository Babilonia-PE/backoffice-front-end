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
                  			<input type="text" class="form-control" id="client_id" placeholder="User ID">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>RUC</label>
                  			<input type="text" class="form-control" id="ruc" placeholder="RUC">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Razón social</label>
                  			<input type="text" class="form-control" id="razon_social" placeholder="Razón social">
                		</div>
                	</div>
              		<div class="col-md-4">
                		<div class="form-group">
                  			<label>Estado</label>
                  			<select class="form-control" id="state" name="" id="">
								<option value="">- Seleccione una opción -</option>
								<option value="1">Activo</option>
								<option value="0">No activo</option>
							</select>
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
                  			<input type="text" class="form-control" id="name" placeholder="Nombre completo">
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
									<input type="text" class="form-control" id="date_from" placeholder="dd/mm/yyyy">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="date_to" placeholder="dd/mm/yyyy">
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
<script>
	setMask('#date_from', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
	setMask('#date_to', { mask: "99/99/9999", showMaskOnHover: false, placeholder: "dd/mm/yyyy", rightAlign:false });
</script>
<script>
    let tableSaved = null;
	let dtDraw = 1;
	let filters = [];
	let state = [];
		state[1] = 'Activo';
		state[2] = 'Bloqueado';
		state[3] = 'Baneado';
		state[5] = 'Eliminado';
	
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
	//OBTENER DATOS DE FILTROS
	const getFiltersData = (params = {}) => {
		const { format_from="DD/MM/YYYY", format_to="YYYY-MM-DD" } = params;
		const data = {};

		if( $("#client_id").val() !== '' && $("#client_id").val() !== null ){
			data.id = $("#client_id").val();
		}
		if( $("#phone_number").val() !== '' && $("#phone_number").val() !== null ){
			data.phone_number = $("#phone_number").val();
		}
		if( $("#commercial_name").val() !== '' && $("#commercial_name").val() !== null ){
			data.commercial_name = $("#commercial_name").val();
		}
		if( $("#ruc").val() !== '' && $("#ruc").val() !== null ){
			data.company_id = $("#ruc").val();
		}
		if( $("#razon_social").val() !== '' && $("#razon_social").val() !== null){
			data.company_name = $("#razon_social").val();
		}
		if( $("#name").val() !== '' && $("#name").val() !== null){
			data.full_name = $("#name").val();
		}
		if( $("#email").val() !== '' && $("#email").val() !== null){
			data.email = $("#email").val();
		}
		if( $("#state").val() !== '' && $("#state").val() !== null){
			data.state = $("#state").val();
		}
		if( $("#date_from").val() !== ''){
			let fecha_from = $("#date_from").val();
			data.created_start = moment(fecha_from, format_from).format(format_to);
		}		
		if( $("#date_to").val() !== ''){
			let fecha_to = $("#date_to").val();
			data.created_end = moment(fecha_to, format_from).format(format_to);
		}

		return data;
	}
	//POBLAR FILTROS
	jQuery.fn.populatefilters=function(){
		if (localStorage.getItem('filter_clientes') !== null) {
			const filter_clientes = JSON.parse(localStorage.getItem('filter_clientes'));
			$("#ruc").val(filter_clientes.ruc??'');
			$("#razon_social").val(filter_clientes.razon_social??'');
			$("#name").val(filter_clientes.name??'');
			$("#email").val(filter_clientes.email??'');
			$("#date_from").val(filter_clientes.created_start?(moment(filter_clientes.created_start, 'YYYY-MM-DD').format('DD/MM/YYYY')):'');
			$("#date_to").val(filter_clientes.created_end?(moment(filter_clientes.created_end, 'YYYY-MM-DD').format('DD/MM/YYYY')):'');
			$("#filter_box").removeClass("collapsed-card");
			$("#icon_filter_box").addClass("fa-minus").removeClass("fa-plus");
		}
    };
    //REDIMENSIONAR DATATABLE
	jQuery.fn.redimensionarTable=function(){
		if(tableSaved != null){
			tableSaved.responsive.recalc();
		}
    };
    jQuery.fn.createDataTable=function(searchBuilder = null, columnDefs = null, returnTable = {}, lengthMenu = 25, dom = true, columns = null, data = null){
		var attr = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('attr') ) ? returnTable.attr:'class';
		var value = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('value') ) ? returnTable.value:'display';
		var dom = ( dom ) ? 'Blrtip':'lfrtip'; //f: buscador
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
				"url": 'https://services-testing.babilonia.io/app/user/users',
				"type": 'GET',
				"data": function ( data ) {
					filters = [];
					data.page = ( tableSaved ) ? ( tableSaved.page.info().page + 1 ) : 1;					
					data.per_page = ( tableSaved ) ? ( tableSaved.page.info().length ) : 25;
					data.order.forEach(element => {
						data.order_by = headers[element.column].code;
						data.order_dir = element.dir;
					});
					/*
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
					}*/
					delete data.searchPanes;
					delete data.searchPanesLast;
					delete data.searchPanes_null;
					delete data.searchPanes_options;
					delete data.searchBuilder;
					delete data.start;
					delete data.draw;
					delete data.columns;
					delete data.order;
					delete data.search;

					let filtersData = getFiltersData({
						format_from : 'DD/MM/YYYY',
						format_to : 'YYYY-MM-DD'
					});
					for(let idx in filtersData){
						let value = filtersData[idx] ?? '';
						if(value!="") data[idx] = value;
					}					
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
						let urlClient = URL_WEB_FRONT + ((element.url && element.url!=null)?element.url:'');
						object.data.push([
							element.id,
							element.full_name,
							(element.email) ? `<a class="text-danger-emphasis text-dark" type="button" data-copy="inner" data-value="${element.email}">${element.email}</a>`:'',
							element.phone_number,
							( ( element.company ) ? element.company.commercial_name??'':'' ),
							moment(element.created_at).format('DD/MM/YYYY h:mm a'),
							(`<span class="badge text-bg-secondary badge-${element.state}">${state[element.state]??''}</span>`),
							( ( element.company ) ? element.company.name??'':'' ),
							( ( element.company ) ? element.company.id??'':'' ),
							( ( element.company ) ? element.company.comercial_address??'':'' ),
							( ( element.company ) ? element.company.commercial_description??'':'' ),
							( element.permissions??{} ).collections? 'SI':'NO',
							( element.permissions??{} ).interested? 'SI':'NO',
							( element.permissions??{} ).my_listings? 'SI':'NO',
							( element.permissions??{} ).my_projects? 'SI':'NO',
							( element.permissions??{} ).stadistics? 'SI':'NO',
							( element.url && element.url!=null) ? `<a href="${urlClient}" target="_blank">${urlClient}</a>` : '',							
							( element.sign_method??"" ),
							`
							<div class="dropdown">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
									Acciones
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item details" data-index="${index}" role="button"><i class="fas fa-eye"></i>&nbsp;&nbsp;Ver</a>
									<!--- <a class="dropdown-item" href="#"><i class="fas fa-edit"></i>&nbsp;&nbsp;Editar</a> --->
									<!--- <a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Eliminar</a> --->
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
				copyToClipboard();
			},
			//fixedHeader: true,
			search: {
				//return: true
			},
			processing: true,
			serverSide: true,
			//stateSave: true,
			//searchBuilder: searchBuilder,
			columnDefs: columnDefs,
			/*searchPanes: {
				viewCount: false,
				initCollapsed: true,
                cascadePanes: false,
				layout: 'columns-2',
				columns: [0, 1, 2, 3, 4],
				dtOpts: {
					dom: 'tp',
					paging: true,
					pagingType: 'simple',
					searching: true
				}
			},*/
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

	const columnDefs = [
		{
			targets: [0, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
			visible: false,
			class: "none"
		},
		{ type: "date", targets: 15 },
		{ orderable: false, targets: ['_all'] }
	];
	const searchBuilder = {};
	$(this).populatefilters();
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
		copyToClipboard();
	});

	$("#applyfiltters").on('click', function (e) {
		let filters = getFiltersData({
			format_from : 'DD/MM/YYYY',
			format_to : 'YYYY-MM-DD'
		});

		if(!$.isEmptyObject(filters)){
			localStorage.setItem('filter_clientes', JSON.stringify(filters));
		}
		tableSaved.ajax.reload();
	});
	$("#filter_box :input[type='text']").on('keyup', function (e) {

		if(e.keyCode == 13){
			let filters = getFiltersData({
				format_from : 'DD/MM/YYYY',
				format_to : 'YYYY-MM-DD'
			});

			if(!$.isEmptyObject(filters)){
				localStorage.setItem('filter_clientes', JSON.stringify(filters));
			}
			tableSaved.ajax.reload();
		}
	});
	$("#removefiltters").on('click', function (e) {
		e.preventDefault();
		localStorage.removeItem('filter_clientes');
		$("#filter_box :input").val('');
		tableSaved.ajax.reload();
	});

	$(document).ready(function(){
		copyToClipboard();
	});
	/*
    async function myAjax(param) {
        let result
        try {
            result = await $.ajax({
                url: 'https://services-testing.babilonia.io/app/users/users',
                type: 'GET',
                //data: jQuery.param( { "obtener-registros-marcacion": 1, "semestreid": param } ) ,
                dataType: 'JSON',
            })
            return result
        } catch (error) {
            console.error(error)
        }
    }

    myAjax().then((data) => {
        const users = data?.data?.records??[]
        console.log(users);
        const columnDefs = [{
			targets: [0, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
			visible: false,
			class: "none"
		},
		{ type: "date", targets: 15 }];
        const searchBuilder = {};
        let object = [];
        users.forEach((element, index) => {
            object.push([
                element.id,
                element.full_name,
                element.email,
                element.phone_number,
                ( ( element.company ) ? element.company.name??'':'' ),
                ( ( element.company ) ? element.company.commercial_name??'':'' ),
                ( ( element.company ) ? element.company.id??'':'' ),
                ( ( element.company ) ? element.company.comercial_address??'':'' ),
                ( ( element.company ) ? element.company.commercial_description??'':'' ),
				( element.permissions??{} ).collections? 'SI':'NO',
				( element.permissions??{} ).interested? 'SI':'NO',
				( element.permissions??{} ).my_listings? 'SI':'NO',
				( element.permissions??{} ).my_projects? 'SI':'NO',
				( element.permissions??{} ).stadistics? 'SI':'NO',
				( element.permissions??{} ).summary? 'SI':'NO',
				new Date(Date.parse(element.created_at)).toLocaleDateString("default", { // you can use undefined as first argument
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
    });
	*/
</script>
@endsection