@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/LibDataTables/datatables.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Responsive-2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/Buttons-2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/SearchBuilder-1.5.0/css/searchBuilder.bootstrap5.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/DateTime-1.5.1/css/dataTables.dateTime.min.css">
<link rel="stylesheet" href="public/plugins/LibDataTables/StateRestore-1.3.0/css/stateRestore.bootstrap5.min.css">
<style>
    .dataTables_wrapper .dt-buttons{
        gap: .5rem;
    }
    .dataTables_wrapper .dataTables_length label{
        margin: .5rem;
    }
    .table td, .table th {
        padding: 0.3rem 0.5rem;
    }
    @media(max-width: 575px) {
        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            justify-content: center;
            flex-wrap: wrap;
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
        <div class="card">
            <!---
            <div class="card-header">
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            --->
            <div class="card-body table-responsive">
				<p class="text-center" name="loading"><img src="public/assets/img/loading.gif" width="50" /></p>
                <table class="display table table-striped nowrap compact responsive d-none" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Compañia</th>
                            <th>Dirección</th>
                            <th width="1%">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Compañia</th>
                            <th>Dirección</th>
                            <th width="1%">Acciones</th>
                        </tr>
                    </tfoot>
                    
                </table>
                <!---<table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($x=1;$x<6;$x++)
                        <tr>
                            <td>183</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-success">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        <tr>
                            <td>219</td>
                            <td>Alexander Pierce</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-warning">Pending</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        <tr>
                            <td>657</td>
                            <td>Bob Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-primary">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        <tr>
                            <td>175</td>
                            <td>Mike Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="tag tag-danger">Denied</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>--->
            </div>

        </div>

    </div>
</div>
<!---
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#">Previous</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav>
    </div>
</div>
--->

@endsection

@section('scripts')
<script src="public/plugins/LibDataTables/datatables.min.js"></script>
<script src="public/plugins/LibDataTables/Responsive-2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.print.min.js"></script>
<script src="public/plugins/LibDataTables/JSZip-3.10.1/jszip.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="public/plugins/LibDataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="public/plugins/LibDataTables/SearchBuilder-1.5.0/js/searchBuilder.bootstrap5.min.js"></script>
<script src="public/plugins/LibDataTables/DateTime-1.5.1/js/dataTables.dateTime.min.js"></script>
<script src="public/plugins/LibDataTables/StateRestore-1.3.0/js/stateRestore.bootstrap5.min.js"></script>
<script>
    let tableSaved = null;
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
			"excel": "Excel",
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
		'createState', 'savedStates',
		{
			extend: "copyHtml5",
			text: "Copiar",
			exportOptions: {
				//columns: ":not(:last-child)",
				columns: function(idx, data, node) {
					return $('table').DataTable().column(idx).visible();
				}
			}
		},
		{
			extend: "pdfHtml5",
            exportOptions: {
				//columns: ":not(:last-child)",
				columns: function(idx, data, node) {
					return $('table').DataTable().column(idx).visible();
				}
			}
		},
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
			extend: "csvHtml5",
			charset: "utf-8",
			extension: ".csv",
			fieldSeparator: ";",
			bom: true,
			exportOptions: {
				//columns: ":not(:last-child)",
				columns: function(idx, data, node) {
					return $('table').DataTable().column(idx).visible();
				}
			}
		},
		{
			extend: "print",
			text: "Imprimir",
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
    //REDIMENSIONAR DATATABLE
	jQuery.fn.redimensionarTable=function(){
		if(tableSaved != null){
			tableSaved.responsive.recalc();
		}
    };
    jQuery.fn.createDataTable=function(searchBuilder = null, columnDefs = null, returnTable = {}, lengthMenu = 25, dom = true, data = null){
		var attr = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('attr') ) ? returnTable.attr:'class';
		var value = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('value') ) ? returnTable.value:'display';
		var dom = ( dom ) ? 'QBlfrtip':'lfrtip';
		var element =  ( attr == 'class' ) ? $('table.'+ value):$('table['+ attr +'="'+ value +'"]');
        console.log(element);
		var table = element
		//.on( 'search.dt', function () { $(this).redimensionarTable(); } )
		//.on( 'page.dt', function () { $(this).redimensionarTable(); } )
		.DataTable({
			dom: dom,
			buttons: Buttons,
			"lengthMenu": [ ( (lengthMenu == 25) ? 10:lengthMenu ), 25, 50, 75, 100 ],
			"pageLength": lengthMenu,
			"order": [],
			"data": data,
			"pagingType": "full_numbers",
			"language": lenguaje,
			"drawCallback": function( settings ) {
				$(this).redimensionarTable();
			},
			"initComplete": function(settings, json) {
				$( 'p[name=\'loading\']' ).remove();
				$.when( $(this).removeClass( 'd-none' ) ).then(function( data, textStatus, jqXHR ) {
					$(this).resize();
				});
			},
			searchBuilder: searchBuilder,
			columnDefs: columnDefs
		});
		if( !jQuery.isEmptyObject(returnTable) ){
			return table;
		}else{
			tableSaved = table;
		}

		$( '.dtsb-searchBuilder .dtsb-group' ).bind("DOMSubtreeModified", function() {
			$(this).resize();
		});
	}
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
        const columnDefs = [];
        const searchBuilder = {};
        let object = [];
        users.forEach(element => {
            object.push([
                element.full_name,
                element.email,
                element.phone_number,
                ( ( element.company ) ? element.company.name??'':'' ),
                ( ( element.company ) ? element.company.comercial_address??'':'' ),
                '<button class="btn btn-primary btn-sm">Ver Publicaciones</button>'
            ]);
        });
        $(this).createDataTable(searchBuilder, columnDefs, false, 25, true, object);
    });
</script>
@endsection