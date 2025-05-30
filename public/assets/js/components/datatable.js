const datatable = async (options = {})=>{
	const { Modal, ModalStepper, Loader, Croppie, OneTap } = await import (`./modal.js`);
    window.globalRecords = [];
    const {
		crud = {
			view: true,
			edit: false,
			delete: false
		},
		download = {
			active: false, 
			modal: false,
			filename: null
		},
		recovery_password = {
			active: false,
		},
        headers,
        filtersFields = [],
        columnsHidden = [],
        columnsDates = [],
		modalFunction = null,
		returnTable = null,
        modalOrder = [],
		modalTitle = function(){},
        processParams = function(){},
        initFunctions = function(){},
        initParams = function(){},
		initParamsModal = function(){},
        storageView = '',
        url = '',
		show = false,
    } = options ?? {};

    let tableSaved = null;
	let dtDraw = 1;
	let filters = [];    
    
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
	const Buttons = [/*
		{
			extend: "excelHtml5",
			exportOptions: {
				//columns: ":not(:last-child)",
				columns: function(idx, data, node) {
					return $('table').DataTable().column(idx).visible();
				}
			}
		},*/
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
			text: 'Descargar',
            action: async function ( e, dt, node, config ) {
				if( !download.active ){
					console.log("descarga no activa");
					return;
				}
				if(  download.modal ){
					const structure = {
						title:'Atencion', 
						content:'Te recordamos que el <b>ÚNICO</b> filtro funcional es [Fecha de creación].<br /> Favor considera ajustarlo para reducir el tiempo de espera.', 
						buttons: true, 
						btnsuccess:'Procesar', 
						btnCancel:'Cerrar'}
					const funtions = {
						success:{
							function: async () => {
								$(node).attr('disabled', true);
								$(node).html('<span class="spinner-border spinner-border-sm"></span> Descargando');

								const $preloader = $(".preloader");
								if ($preloader) {
									$preloader.removeAttr('style');
									setTimeout(function () {
										$preloader.children().show();
									}, 200);
								}
								let params = {};
								for(let i in filtersFields){
									let {
										name='',
										type='',
										value=''
									} = filtersFields[i] ?? {};

									if( type == 'static' ){
										params[name] = value;
									}else{
										let element = document.getElementById(name);
										if( element == null || element.value == '' || ( element.type == 'checkbox' && !element.checked ) ) continue;
						
										let fieldValue = document.getElementById(name).value;
										params[name] = fieldValue;
									}
								}
								const response = await fetchData('app/downloads', params, 'GET', true);				
								if (window.navigator && window.navigator.msSaveOrOpenBlob) { // IE variant
									window.navigator.msSaveOrOpenBlob(new Blob([response.data],
											{ type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }
										),
										download.filename
									);
								} else {
									const url = window.URL.createObjectURL(new Blob([response.data],
										{ type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }));
									const link = document.createElement('a');
									link.href = url;
									link.setAttribute('download', download.filename);
									document.body.appendChild(link);
									link.click();
								}
								
								$(node).attr('disabled', false);
								$(node).html('Descargar');
								if ($preloader) {
									$preloader.css('height', 0);
									setTimeout(function () {
										$preloader.children().hide();
									}, 200);
								}
							}
						}
					};
					new Modal(structure, funtions);
					return;
				}
				$(node).attr('disabled', true);
				$(node).html('<span class="spinner-border spinner-border-sm"></span> Descargando');

				const $preloader = $(".preloader");
				if ($preloader) {
					$preloader.removeAttr('style');
					setTimeout(function () {
						$preloader.children().show();
					}, 200);
				}
				let params = {};
				for(let i in filtersFields){
					let {
						name='',
						type='',
						value=''
					} = filtersFields[i] ?? {};

					if( type == 'static' ){
						params[name] = value;
					}else{
						let element = document.getElementById(name);
						if( element == null || element.value == '' || ( element.type == 'checkbox' && !element.checked ) ) continue;
		
						let fieldValue = document.getElementById(name).value;
						params[name] = fieldValue;
					}
				}
				const response = await fetchData('app/downloads', params, 'GET', true);				
				if (window.navigator && window.navigator.msSaveOrOpenBlob) { // IE variant
					window.navigator.msSaveOrOpenBlob(new Blob([response.data],
							{ type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }
						),
						download.filename
					);
				} else {
					const url = window.URL.createObjectURL(new Blob([response.data],
						{ type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }));
					const link = document.createElement('a');
					link.href = url;
					link.setAttribute('download', download.filename);
					document.body.appendChild(link);
					link.click();
				}
				
				$(node).attr('disabled', false);
				$(node).html('Descargar');
				if ($preloader) {
					$preloader.css('height', 0);
					setTimeout(function () {
						$preloader.children().hide();
					}, 200);
				}
            }
		},
		{
			text: 'Reiniciar',
            action: function ( e, dt, node, config ) {
				tableSaved.state.clear();
				window.location.reload();
            }
		}
	];
	//FUNCIONES
	jQuery.fn.checkConditions=function(conditions, element){
		let retorno = true;
		(conditions??[]).forEach(condition => {
			if( !$(this).checkCondition(condition, element) ){
				retorno = false;
				return false;
			}
		});
		return retorno;
	}
	jQuery.fn.checkCondition=function(condition, element){
		let retorno = true;
		switch (condition.operator??null) {
			case "=":
				retorno = ( element[condition.key] == condition.value ) ? true : false;
				break;
			case "!=":
				retorno = ( element[condition.key] != condition.value ) ? true : false;
				break;
			default:
				break;
		}
		return retorno;
	}
	//POBLAR FILTROS
	jQuery.fn.populatefilters=function(){
		
		if(show == false){
			const filter_storage = JSON.parse(localStorage.getItem(storageView));
			if(storageView =='' || filter_storage == null) return false;

			for(let i in filtersFields){
				let {
					name='',
					type='',
					search=false,
					storage=''
				} = filtersFields[i] ?? {};

				let fieldValue = filter_storage[name]??'';

				if(document.getElementById(name) == null) continue;

				if(type == filtersParamsTypes.USER && search){		
					let filter_user_field = JSON.parse(localStorage.getItem(storage)) ?? [];
					if(filter_user_field.length > 0){
						let selectUser = document.getElementById(name);
						filter_user_field.forEach((item) => {	
							let option = document.createElement("option");
							option.value = item.id;
							option.innerHTML = `${item.data??''}`;
							selectUser.append(option);
						});
					}
											
				}else if(type == filtersParamsTypes.DATE){				
					fieldValue = fieldValue??'';
				}else if(type == filtersParamsTypes.CHECKBOX){	
					if( fieldValue && fieldValue != '' ){
						$(`#${name}`).prop("checked", true);
					}			
				} 
				$(`#${name}`).val(fieldValue);
			}
			
			$("#table-box").removeClass("d-none");
			$(this).createDataTable(searchBuilder, columnDefs, returnTable, 25, true, headers);
			$("#filter_box").removeClass("collapsed-card");
			$("#icon_filter_box").addClass("fa-minus").removeClass("fa-plus");
		}else{
			$("#table-box").removeClass("d-none");
			$(this).createDataTable(searchBuilder, columnDefs, returnTable, 25, true, headers);
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
			filt?.replace(/(<([^>]+)>)/ig, '');
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
		var dom = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('dom') ) ? returnTable.dom : 'Bilrtip'; //f: buscador
		var element =  ( attr == 'class' ) ? $('table.'+ value):$('table['+ attr +'="'+ value +'"]');
		var buttons = ( !jQuery.isEmptyObject(returnTable) && returnTable.hasOwnProperty('buttons') ) ? returnTable.buttons:Buttons;
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
			buttons: buttons,
			"lengthMenu": [ ( (lengthMenu == 25) ? 25:lengthMenu ), 50, 100, 200, 500 ],
			"pageLength": lengthMenu,
			"order": [],
			//"data": data,

			ajax: {
				"url": APP_BASE_EP + url,
				"type": 'GET',
				"data": function ( data ) {
					let start = parseInt(data.start);
					let length = parseInt(data.length);
					let pagestored = ( start / length ) + 1 ;
					filters = [];
					data.page = ( tableSaved ) ? ( tableSaved.page.info().page + 1 ) : (pagestored ?? 1);
					data.per_page = ( tableSaved ) ? ( tableSaved.page.info().length ) : (length ?? 25);
					data.order.forEach(element => {
						data.order_by = headers[element.column].code;
						data.sort_by = element.dir;
					});

                    //CARGA DE DATA PARA FILTROS DESPUES DE RECARGAR UNA PAGINA
                    for(let i in filtersFields){
                        let {
                            name='',
                            type='',
                            value=''
                        } = filtersFields[i] ?? {};

						if( type == 'static' ){
							data[name] = value;
						}else{
							let element = document.getElementById(name);
							if( element == null || element.value == '' || ( element.type == 'checkbox' && !element.checked ) ) continue;
			
							let fieldValue = document.getElementById(name).value;
							data[name] = fieldValue;
						}
                    }

					delete data.length;
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
				},
				"dataSrc": function ( json ) {

					if(!json.hasOwnProperty("data")){						
						setTimeout(() => {
							Toast.fire({
								icon: 'error',
								title: 'Se genero un error inesperado, vuelva a intentar porfavor.'
							});
						}, 250);					  
						return false;
					}
					const data = json.data??{};
					const records = data.records??[];
					globalRecords=records;					
					let object = {
						"draw": 1,
						"recordsTotal": data.listings_count,
						"recordsFiltered": data.listings_count,
						"data": []
					};
					records.forEach((element, index) => {

                        const resultParams = processParams(element)??[];
						const id = ( element.id??null ) ? element.id : element.owner_id;
						const record = globalRecords.find((item)=> item.id == id) ?? null;
						
						const edit = crud?.edit??null;
						const e_key = edit?.key??'id';

						const c_delete = ( typeof crud.delete === "object" ) ? (
							( $(this).checkConditions(crud.delete.conditions, element) ) ?  true : false
						) : crud.delete;
						object.data.push([
                            ...resultParams,
                            `<div class="dropdown btn-group ">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
									Acciones
								</button>
								<ul class="dropdown-menu dropdown-menu-end" x-placement="right">
									<a class="dropdown-item details" data-id="${id??''}" data-index="${index}" role="button"><i class="fas fa-eye"></i>&nbsp;&nbsp;Ver</a>` 
									+ ( ( edit ) ? `<a class="dropdown-item" data-action="update" data-id="${element[e_key]??''}" data-index="${index}" role="button"><i class="fas fa-edit"></i>&nbsp;&nbsp;Editar</a>`: ``)
									+ ( ( c_delete ) ? `<a class="dropdown-item" data-action="delete" data-id="${element.id??''}" data-index="${index}" role="button"><i class="fas fa-trash"></i>&nbsp;&nbsp;Eliminar</a>`: ``)
									+ `${recovery_password.active && record.sign_method.toLowerCase() == 'email' && record.email ? `<a class="dropdown-item recovery-passwords" data-id="${id??''}" data-index="${index}" role="button"><i class="fas fa-paper-plane"></i>&nbsp;&nbsp;Recuperar contraseña</a>` : ''}
									<!--- <a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Eliminar</a> --->
								</ul>
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
                initParams();
				$( 'p[name=\'loading\']' ).remove();
				$("body").addClass("table-success");
				$(this).removeClass( 'd-none' );
			},
			//fixedHeader: true,
			search: {
				//return: true
			},
			processing: true,
			serverSide: true,
			stateSave: true,
			colReorder: true,
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
			json.recordsTotal = json.data.pagination.total_records??null;
			json.recordsFiltered = json.data.pagination.total_records??null;
			json.draw = dtDraw;
			dtDraw += 1;
		} );
		if( !jQuery.isEmptyObject(returnTable) && ( returnTable.return??false ) == true ){
			return table;
		}else{
			tableSaved = table;
		}
	}
	const columnDefs = [
		{
			targets: columnsHidden,
			visible: false,
			/*class: "none"*/
		},
		{ type: "date", targets: columnsDates },
		{ orderable: false, targets: ['_all'] }

	];
	const searchBuilder = {
		depthLimit: 1,
		columns: [1, 2, 3, 4],
		conditions: {
			string: {
				"=" : {
                    init: function(that, fn, preDefined = null, array = false) {
						let column = that.dom.data.children('option:selected').val();
						//let indexArray = that.s.dt.rows().indexes().toArray();
						//let settings = that.s.dt.settings()[0];
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
	await initFunctions();
	$(this).populatefilters();
	
	if( ( jQuery.isEmptyObject(returnTable) || ( returnTable?.actions??true ) == true ) ){
		$("#applyfiltters").on('click', function (e) {
			let filters = {};
	
			//GUARDAR LOS FILTROS EN LOCAL
			for(let i in filtersFields){
				let {
					name='',
					type=''
				} = filtersFields[i] ?? {};
	
				if(document.getElementById(name) == null || document.getElementById(name).value == '') continue;
	
				let fieldValue = document.getElementById(name).value;
				filters[name] = fieldValue;
			}
	
			if(!$.isEmptyObject(filters)){
				localStorage.setItem(storageView, JSON.stringify(filters));
			}
			if( tableSaved ){
				tableSaved.ajax.reload();
			}else{
				$("#table-box").removeClass("d-none");
				$(this).createDataTable(searchBuilder, columnDefs, returnTable, 25, true, headers);
			}
		});
		$("#removefiltters").on('click', function (e) {
	
			localStorage.removeItem(storageView);
	
			for(let i in filtersFields){
				let {
					name='',
					type='',
					storage=''
				} = filtersFields[i] ?? {};
	
				if(document.getElementById(name) == null || document.getElementById(name).value == '') continue;
	
				if(type === filtersParamsTypes.USER){
					localStorage.removeItem(storage);
					$(`#${name}`).val('');
					$(`#${name}`).html('');
					$(`#${name}`).selectpicker('refresh');
				}else if(type === filtersParamsTypes.CHECKBOX){
					$(`#${name}`).prop("checked", false);
				}else{
					$(`#${name}`).val('');
				}
			}
	
			$('.select2').val(null).trigger('change');
	
			//tableSaved.ajax.reload();
		});
	}
	
	$('.select2').select2({
      	theme: 'bootstrap4'
    })

	setTimeout(() => {
		$(".dtsb-add").on('click', function (e) {

		})
	}, 2000);

	$(document).on("click", "a.details", async function(e) {
		e.preventDefault();
		if ( modalFunction ){
			const id = $(this).attr('data-id');
			$('#rowDetails').off('show.bs.modal');
			$('#rowDetails').off('shown.bs.modal');
			$('#rowDetails').off('hide.bs.modal');
			$('#rowDetails').off('hidden.bs.modal');
			$('#rowDetails').on('show.bs.modal', async function (e) {
				if (modalFunction.hasOwnProperty('show')){
					if ( typeof modalFunction.show == 'function' ) { 
						try {
							await modalFunction.show(id); 
						} catch (error) {
							console.log(error);
						}
					}
				}  
			})
			$('#rowDetails').on('shown.bs.modal', async function (e) {
				if (modalFunction.hasOwnProperty('shown')){
					if ( typeof modalFunction.shown == 'function' ) { 
						try {
							await modalFunction.shown(id); 
						} catch (error) {
							console.log(error);
						}
					}
				}  
			})
			$('#rowDetails').on('hide.bs.modal', async function (e) {
				if (modalFunction.hasOwnProperty('hide')){
					if ( typeof modalFunction.hide == 'function' ) { 
						try {
							await modalFunction.hide(id); 
						} catch (error) {
							console.log(error);
						}
					}
				}  
			})
			$('#rowDetails').on('hidden.bs.modal', async function (e) {
				if (modalFunction.hasOwnProperty('hidden')){
					if ( typeof modalFunction.hidden == 'function' ) { 
						try {
							await modalFunction.hidden(id); 
						} catch (error) {
							console.log(error);
						}
					}
				}  
			})
			$("#rowDetails").modal('show');
			return;
		}
		const target = $(this).attr('data-index');
		let data = tableSaved.rows( target ).data()[0];
		$("#rowDetails .modal-body").html("");

		let newHeader = headers;
		if(modalOrder.length > 0){
			data = modalOrder.map(i => data[i]);
			newHeader = modalOrder.map(i => headers[i]);
		}

		data.forEach((element, 
		index, array) => {
			if (index + 1 === array.length){ return; }
			if (index === 0){
				let customHeader = modalTitle(element, globalRecords)??`Detalles para ${element}`;
				$("#rowDetails .modal-title").html(customHeader);
			}
			$("#rowDetails .modal-body").append(`
				<div class="box-details">
					<div>${newHeader[index]?.title??''}</div>
					<div>${element}</div>
				</div>
			`);
		});
		
		$("#rowDetails").modal('show');
		initParamsModal();
	})
	$(document).on("click", ".recovery-passwords", async function(e) {
		e.preventDefault();
		const id = $(this).attr('data-id');
		const record = globalRecords.find((item)=> item.id == id) ?? null;
		if(!record && !record.email) return;
		const params = {
			email: record.email
		}
		try {
			const response = await fetchData('auth/recover', params, 'POST', true);
			const message = response.data.data.message ?? 'Revisa tu bandeja de entrada y sigue las instrucciones para restablecer tu contraseña';
			alertShort('success', message);
		} catch (error) {
			alertShort('error', 'Error Network', error);
		}
	})
	$(document).on("click", "a[data-action=\"delete\"]", async function(e) {
		e.preventDefault();
		const c_del = crud?.delete??null;
		const param = ( c_del.key ) ? c_del.key : 'id';
		const key = $(this).attr("data-id");
		const index_parent = filtersFields.findIndex(x => x.name === 'parent');
		const parent = filtersFields[index_parent]??null;
		const structure = {
			title:'Atencion', 
			content:'¿Estás seguro que deseas eliminar el registro ' + key + '?', 
			buttons: true, 
			btnsuccess:'Procesar', 
			btnCancel:'Cancelar'
		}
		const funtions = {
			success:{
				function: async () => {
					const params = { parent: parent?.value };
					params[param] = key;
					const response = await fetchData('app/gateway', params, 'DELETE');	
					if (response.hasOwnProperty('code')){ 
						AppValidateHttpCode(response);
						return false;
					}	
					localStorage.setItem('message', response?.data?.data?.message??'');
					window.location.reload();
				}
			}
		}
		new Modal(structure, funtions);
	})
    
}