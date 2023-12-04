@extends('Layout.master')

@section('styles')

@endsection

@section('page')

Clientes

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
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

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
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
                </table>
            </div>

        </div>

    </div>
</div>

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

@endsection

@section('scripts')

			ajax: {
				"url": 'https://services-testing.babilonia.io/app/user/users',
				"type": 'GET',
				"data": function ( data ) {
					filters = [];
					data.page = ( tableSaved ) ? ( tableSaved.page.info().page + 1 ) : 1;
					//data.per_page = ( tableSaved ) ? ( tableSaved.page.info().length ) : 25;
					data.order.forEach(element => {
						data.order_by = headers[element.column].code;
						data.order_dir = element.dir;
					});
					if( $("#ruc").val() !== '' && $("#ruc").val() !== null ){
						data.ruc = $("#ruc").val();
					}
					if( $("#razon_social").val() !== '' && $("#razon_social").val() !== null){
						data.razon_social = $("#razon_social").val();
					}
					if( $("#name").val() !== '' && $("#name").val() !== null){
						data.name = $("#name").val();
					}
					if( $("#email").val() !== '' && $("#email").val() !== null){
						data.email = $("#email").val();
					}
					if( $("#date_from").val() !== '' || $("#date_to").val() !== ''){
						data.date = {
							from: $("#date_from").val(),
							to: $("#date_to").val()
						};
					}

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
			targets: [0, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
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
	});

	$("#applyfiltters").on('click', function (e) {
		let filters = {};
		if( $("#ruc").val() !== '' && $("#ruc").val() !== null ){
			filters.state = $("#ruc").val();
		}
		if( $("#razon_social").val() !== '' && $("#razon_social").val() !== null){
			filters.razon_social = $("#razon_social").val();
		}
		if( $("#name").val() !== '' && $("#name").val() !== null){
			filters.name = $("#name").val();
		}
		if( $("#email").val() !== '' && $("#email").val() !== null){
			filters.email = $("#email").val();
		}
		if( $("#date_from").val() !== '' || $("#date_to").val() !== ''){
			filters.date = {
				from: $("#date_from").val(),
				to: $("#date_to").val()
			};
		}
		if(!$.isEmptyObject(filters)){
			localStorage.setItem('filter_clientes', JSON.stringify(filters));
		}
		tableSaved.ajax.reload();
	});
	$("#removefiltters").on('click', function (e) {
		localStorage.removeItem('filter_clientes');
		$("#ruc").val('');
		$("#razon_social").val('');
		$("#name").val('');
		$("#email").val('');
		$("#date_from").val('');
		$("#date_to").val('');
		tableSaved.ajax.reload();
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