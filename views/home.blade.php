@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
  button.btn.btn-default.btn-sm.active {
    background: #d9dbdd;
  }
  .charjs{
    min-height: 350px; 
    height: 350px; 
    max-height: 350px; 
    max-width: 100%;
  }
  @media screen and (max-width: 768px) { 
      .charjs{
        min-height: 850px; 
        height: 850px; 
        max-height: 850px; 
      }
  }
</style>
@endsection

@section('page')

Dashboard

@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header" role="button" data-card-widget="collapse">
          <h5 class="card-title">Usuarios</h5>
          <div class="card-tools">
              <button type="button" class="btn btn-tool">
                <i id="icon_filter_box" class="fas fa-plus"></i>
              </button>
          </div>
      </div>
      <div class="card-body">
        <div class="row align-items-end">
					<div class="col-md">
              <div class="form-group">
                <select name="month_user" id="month_user" class="form-control" title="Mes" placeholder="Mes" >
                </select>                			
              </div>
          </div>
        </div>
        <div class="btn-group" id="realtime" data-toggle="btn-toggle">
          <button type="button" id="owners" class="btn btn-default btn-sm active userbtn">Owners</button>
          <button type="button" id="realtors" class="btn btn-default btn-sm userbtn">Realtors</button>
        </div>
        <div class="chart">
          <canvas id="OwnersChart" class="charjs"></canvas>
          <canvas hidden id="RealtorsChart" class="charjs"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card">
      <div class="card-header" role="button" data-card-widget="collapse">
          <h5 class="card-title">Avisos</h5>
          <div class="card-tools">
              <button type="button" class="btn btn-tool">
                <i id="icon_filter_box" class="fas fa-plus"></i>
              </button>
          </div>
      </div>
      <div class="card-body">
        <div class="row align-items-end">
					<div class="col-md">
              <div class="form-group">
                <select name="month_listing" id="month_listing" class="form-control" title="Mes" placeholder="Mes" >
                </select>                			
              </div>
          </div>
        </div>
        <div class="chart">
          <canvas id="listingsChart" class="charjs"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card">
      <div class="card-header" role="button" data-card-widget="collapse">
          <h5 class="card-title">Proyectos</h5>
          <div class="card-tools">
              <button type="button" class="btn btn-tool">
                <i id="icon_filter_box" class="fas fa-plus"></i>
              </button>
          </div>
      </div>
      <div class="card-body">
      <div class="row align-items-end">
					<div class="col-md">
              <div class="form-group">
                <select name="month_project" id="month_project" class="form-control" title="Mes" placeholder="Mes" >
                </select>                			
              </div>
          </div>
        </div>
        <div class="chart">
          <canvas id="projectsChart" class="charjs"></canvas>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  let initial = true;
  let listingChart = null;
  let projectChart = null;
  let ownerChart = null;
  let realtorChart = null;
  let tempOptions = [];
  let windowWidth = window.innerWidth;
  let orientation = (windowWidth > 768) ? 'vertical' : 'horizontal';
  const changeDirectionBar = () => {
    windowWidth = window.innerWidth;
    if( windowWidth > 768 ){
      if( orientation == 'vertical' ){
        return;
      }
      orientation = 'vertical';

      listingChart.config.type = 'bar';
      listingChart.options = tempOptions['listings'].vertical;
      listingChart.update('');
      
      projectChart.config.type = 'bar';
      projectChart.options = tempOptions['projects'].vertical;
      projectChart.update('');
      
      ownerChart.config.type = 'bar';
      ownerChart.options = tempOptions['owners'].vertical;
      ownerChart.update('');
      
      realtorChart.config.type = 'bar';
      realtorChart.options = tempOptions['realtors'].vertical;
      realtorChart.update('');
    }else{
      if( orientation == 'horizontal' ){
        return;
      }
      orientation = 'horizontal';

      listingChart.config.type = 'horizontalBar';
      listingChart.options = tempOptions['listings'].horizontal;
      listingChart.update('');
      
      projectChart.config.type = 'horizontalBar';
      projectChart.options = tempOptions['projects'].horizontal;
      projectChart.update('');
      
      ownerChart.config.type = 'horizontalBar';
      ownerChart.options = tempOptions['owners'].horizontal;
      ownerChart.update('');
      
      realtorChart.config.type = 'horizontalBar';
      realtorChart.options = tempOptions['realtors'].horizontal;
      realtorChart.update('');
    }
  }
  const getMonth = () => {
    const month = moment().format("MMMM");
    const array_month = []
    array_month["January"] = "Enero";
    array_month["February"] = "Febrero";
    array_month["March"] = "Marzo";
    array_month["April"] = "Abril";
    array_month["May"] = "Mayo";
    array_month["June"] = "Junio";
    array_month["July"] = "Julio";
    array_month["August"] = "Agosto";
    array_month["September"] = "Setiembre";
    array_month["October"] = "Octubre";
    array_month["November"] = "Noviembre";
    array_month["Dicember"] = "Diciembre";
    return (array_month[month]??'');
  }
  const getChartData = (labels, dataset) => {
    return areaChartData = {
      labels  : labels,
      datasets: [
        {
          label               : dataset.title_today,
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : dataset.data_today
        },
        {
          label               : dataset.title_total,
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : dataset.total_data
        },
      ]
    }
  }
  const getOptions = (title, max_label) =>{
    const opciones = {
      vertical: {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        legend: {
            position: 'bottom',
        },
        hover: {
            mode: 'label'
        },
        scales: {
            yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        stepValue: 5,
                        max: max_label
                    }
                }]
        },
        title: {
            display: true,
            text: title
        }
      },
      horizontal: {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        legend: {
            position: 'bottom',
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        stepValue: 5,
                        max: max_label
                    }
                }]
        },
        title: {
            display: true,
            text: title
        }
      },
    }
    return opciones;
  }
  const loadStadisticsListings = async (month = null) => {
    const current_mont = getMonth();
    const params = {
			parent: 'homepage',
			child: 'listings',
			month: ( month ) ? month : current_mont
		};
    const details = await fetchData('app/gateway', params, 'GET');
		const data = details?.data?.data?.records?.listings??[];
		const filters = details?.data?.data?.filters??[];
    let max = 0;
    let labels = [];
    let data_today = [];
    let total_data = [];
    //ACREGAR SELECT
    if( initial ){
      filters.forEach(element => {
        jQuery('<option>', {
          'value': element,
          'text' : element
        }).appendTo("#month_listing");
      });
      $('#month_listing').selectpicker('refresh');
      $('#month_listing').selectpicker('val', current_mont);
    }
    //CREAR DATA DEL GRÁFICO
    data.forEach(element => {
      const date = element.date??'';
      const day = element.qty_per_day??0;
      const total = element.qty_total??0;
      if( day > max ){ max = day; }
      if( total > max ){ max = total; }
      labels.push(date);
      data_today.push(day);
      total_data.push(total);
    });
    let max_label = ( max == 0) ? 30 : ( max + 10 );
    max_label = (max_label / 5);
    max_label = (Math.trunc(max_label) * 5);
    //CARGAR GRÁFICO
    const areaChartData = getChartData(labels, { 
      title_today: 'Avisos en el día', data_today: data_today,
      title_total: 'Avisos totales', total_data: total_data
    });
    const barChartCanvas = $('#listingsChart').get(0).getContext('2d')
    const barChartData = $.extend(true, {}, areaChartData)
    const temp0 = areaChartData.datasets[0]
    const temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0
    const barChartOptions = getOptions('Avisos publicados', max_label);
    tempOptions['listings'] = barChartOptions;
    if( listingChart ){
      listingChart.destroy();
    }
    listingChart = new Chart(barChartCanvas, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: barChartData,
      options: (windowWidth > 768) ? barChartOptions.vertical : barChartOptions.horizontal
    })
  }
  const loadStadisticsProjects = async (month = null) => {
    const current_mont = getMonth();
    const params = {
			parent: 'homepage',
			child: 'projects',
			month: ( month ) ? month : current_mont
		};
    const details = await fetchData('app/gateway', params, 'GET');
		const data = details?.data?.data?.records?.projects??[];
		const filters = details?.data?.data?.filters??[];
    let max = 0;
    let labels = [];
    let data_today = [];
    let total_data = [];
    //ACREGAR SELECT
    if( initial ){
      filters.forEach(element => {
        jQuery('<option>', {
          'value': element,
          'text' : element
        }).appendTo("#month_project");
      });
      $('#month_project').selectpicker('refresh');
      $('#month_project').selectpicker('val', current_mont);
    }
    data.forEach(element => {
      const date = element.date??'';
      const day = element.qty_per_day??0;
      const total = element.qty_total??0;
      if( day > max ){ max = day; }
      if( total > max ){ max = total; }
      labels.push(date);
      data_today.push(day);
      total_data.push(total);
    });
    let max_label = ( max == 0) ? 30 : ( max + 10 );
    max_label = (max_label / 5);
    max_label = (Math.trunc(max_label) * 5);
    //CARGAR GRÁFICO
    const areaChartData = getChartData(labels, { 
      title_today: 'Proyectos en el día', data_today: data_today,
      title_total: 'Proyectos totales', total_data: total_data
    });
    const barChartCanvas = $('#projectsChart').get(0).getContext('2d')
    const barChartData = $.extend(true, {}, areaChartData)
    const temp0 = areaChartData.datasets[0]
    const temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0
    
    const barChartOptions = getOptions('Proyectos publicados', max_label);
    tempOptions['projects'] = barChartOptions;
    if( projectChart ){
      projectChart.destroy();
    }
    projectChart = new Chart(barChartCanvas, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: barChartData,
      options: (windowWidth > 768) ? barChartOptions.vertical : barChartOptions.horizontal
    })
  }
  const loadStadisticsUsers = async (month = null) => {
    const current_mont = getMonth();
    const params = {
			parent: 'homepage',
			child: 'users',
			month: ( month ) ? month : current_mont
		};
    const details = await fetchData('app/gateway', params, 'GET');
		const owners = details?.data?.data?.records?.users?.owner??[];
		const realtors = details?.data?.data?.records?.users?.realtor??[];
		const filters = details?.data?.data?.filters??[];
    //ACREGAR SELECT
    if( initial ){
      filters.forEach(element => {
        jQuery('<option>', {
          'value': element,
          'text' : element
        }).appendTo("#month_user");
      });
      $('#month_user').selectpicker('refresh');
      $('#month_user').selectpicker('val', current_mont);
    }
    //CREAR DATA DEL GRÁFICO OWNER
    let max_owner = 0;
    let labels_owner = [];
    let data_today_owner = [];
    let total_data_owner = [];
    owners.forEach(element => {
      const date = element.date??'';
      const day = element.qty_per_day??0;
      const total = element.qty_total??0;
      if( day > max_owner ){ max_owner = day; }
      if( total > max_owner ){ max_owner = total; }
      labels_owner.push(date);
      data_today_owner.push(day);
      total_data_owner.push(total);
    });
    let max_label_owner = ( max_owner == 0) ? 30 : ( max_owner + 10 );
    max_label_owner = (max_label_owner / 5);
    max_label_owner = (Math.trunc(max_label_owner) * 5);
    const areaChartDataOwner = getChartData(labels_owner, { 
      title_today: 'Publicaciones del día', data_today: data_today_owner,
      title_total: 'Publicaciones totales', total_data: total_data_owner
    });
    const barChartCanvasOwner = $('#OwnersChart').get(0).getContext('2d')
    const barChartDataOwner = $.extend(true, {}, areaChartDataOwner)
    const temp0Owner = areaChartDataOwner.datasets[0]
    const temp1Owner = areaChartDataOwner.datasets[1]
    barChartDataOwner.datasets[0] = temp1Owner
    barChartDataOwner.datasets[1] = temp0Owner
    const barChartOptionsOwner = getOptions('Estadísticas por usuario | Owners', max_label_owner);
    tempOptions['owners'] = barChartOptionsOwner;
    options = barChartOptionsOwner;
    if( ownerChart ){
      ownerChart.destroy();
    }
    ownerChart = new Chart(barChartCanvasOwner, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: barChartDataOwner,
      options: (windowWidth > 768) ? barChartOptionsOwner.vertical : barChartOptionsOwner.horizontal
    })


    //CREAR DATA DEL GRÁFICO REALTOR
    let max_realtor = 0;
    let labels_realtor = [];
    let data_today_realtor = [];
    let total_data_realtor = [];
    realtors.forEach(element => {
      const date = element.date??'';
      const day = element.qty_per_day??0;
      const total = element.qty_total??0;
      if( day > max_realtor ){ max_realtor = day; }
      if( total > max_realtor ){ max_realtor = total; }
      labels_realtor.push(date);
      data_today_realtor.push(day);
      total_data_realtor.push(total);
    });
    let max_label_realtor = ( max_realtor == 0) ? 30 : ( max_realtor + 10 );
    max_label_realtor = (max_label_realtor / 5);
    max_label_realtor = (Math.trunc(max_label_realtor) * 5);
    const areaChartDataRealtor = getChartData(labels_owner, { 
      title_today: 'Publicaciones del día', data_today: data_today_realtor,
      title_total: 'Publicaciones totales', total_data: total_data_realtor
    });
    const barChartCanvasRealtor = $('#RealtorsChart').get(0).getContext('2d')
    const barChartDataRealtor = $.extend(true, {}, areaChartDataRealtor)
    const temp0Realtor = areaChartDataRealtor.datasets[0]
    const temp1Realtor = areaChartDataRealtor.datasets[1]
    barChartDataRealtor.datasets[0] = temp1Realtor
    barChartDataRealtor.datasets[1] = temp0Realtor
    const barChartOptionsRealtor = getOptions('Estadísticas por usuario | Realtors', max_label_realtor);
    tempOptions['realtors'] = barChartOptionsRealtor;
    if( realtorChart ){
      realtorChart.destroy();
    }
    realtorChart = new Chart(barChartCanvasRealtor, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: barChartDataRealtor,
      options: (windowWidth > 768) ? barChartOptionsRealtor.vertical : barChartOptionsRealtor.horizontal
    })
  }
  const init = () => {
    return new Promise(async (resolve, reject) => {
        try {
          await loadStadisticsUsers();
          await loadStadisticsListings();
          await loadStadisticsProjects();
          resolve(true);
        } catch (error) {
            reject(error);
        }
    });
  }
  init()
  .then((resolve)=>{
      if(resolve){
        initial = false;
      }
  });
  $(document).on('change', '#month_listing', async function () {
    const month = $(this).val();
    await loadStadisticsListings(month);
  });
  $(document).on('change', '#month_project', async function () {
    const month = $(this).val();
    await loadStadisticsProjects(month);
  });
  $(document).on('change', '#month_user', async function () {
    const month = $(this).val();
    await loadStadisticsUsers(month);
  });
  $(document).on('click', '#owners', async function () {
    $(".userbtn").removeClass("active")
    $(this).addClass("active")
    $("#OwnersChart").attr('hidden', false);
    $("#RealtorsChart").attr('hidden', true);
  });
  $(document).on('click', '#realtors', async function () {
    $(".userbtn").removeClass("active")
    $(this).addClass("active")
    $("#RealtorsChart").attr('hidden', false);
    $("#OwnersChart").attr('hidden', true);
  });
  window.addEventListener('resize', changeDirectionBar);
</script>
@endsection