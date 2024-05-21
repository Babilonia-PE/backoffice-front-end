@extends('Layout.master')

@section('styles')
<link rel="stylesheet" href="@asset('public/plugins/select2/css/select2.min.css')?{{env('APP_CSS_VERSION')}}">
<link rel="stylesheet" href="@asset('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')?{{env('APP_CSS_VERSION')}}">
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
  .charjs-pie{
    min-height: 550px; 
    height: 550px; 
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
          <button type="button" id="owners" class="btn btn-default btn-sm active userbtn">Propietarios</button>
          <button type="button" id="realtors" class="btn btn-default btn-sm userbtn">Agentes</button>
        </div>
        <div class="row align-items-end">
					<div class="col-md-12">
            <canvas id="OwnersChart1" class="charjs"></canvas>
            <canvas hidden id="RealtorsChart1" class="charjs"></canvas>
          </div>
					<div class="col-md-12">
            <canvas id="OwnersChart2" class="charjs"></canvas>
            <canvas hidden id="RealtorsChart2" class="charjs"></canvas>
          </div>
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
        <div class="row align-items-end">
					<div class="col-md-12">
            <canvas id="listingsChart1" class="charjs"></canvas>
          </div>
					<div class="col-md-12">
            <canvas id="listingsChart2" class="charjs"></canvas>
          </div>
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
        <div class="row align-items-end">
					<div class="col-md-12">
            <canvas id="projectsChart1" class="charjs"></canvas>
          </div>
					<div class="col-md-12">
            <canvas id="projectsChart2" class="charjs"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card">
      <div class="card-header" role="button" data-card-widget="collapse">
          <h5 class="card-title">Top 10 distritos más visitados</h5>
          <div class="card-tools">
              <button type="button" class="btn btn-tool">
                <i id="icon_filter_box" class="fas fa-plus"></i>
              </button>
          </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="viewsChart" class="charjs-pie"></canvas>
        </div>
      </div>
    </div>
  </div>


</div>
@endsection

@section('scripts')
<script>
  let ownerChart1 = null;
  let ownerChart2 = null;
  let realtorChart1 = null;
  let realtorChart2 = null;
  let listingChart1 = null;
  let listingChart2 = null;
  let projectChart1 = null;
  let projectChart2 = null;
  let viewsChart = null;


  let initial = true;
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

      listingChart1.config.type = 'bar';
      listingChart1.options = tempOptions['listings1'].vertical;
      listingChart1.update('');
      listingChart2.config.type = 'bar';
      listingChart2.options = tempOptions['listings2'].vertical;
      listingChart2.update('');
      
      projectChart1.config.type = 'bar';
      projectChart1.options = tempOptions['projects1'].vertical;
      projectChart1.update('');
      projectChart2.config.type = 'bar';
      projectChart2.options = tempOptions['projects2'].vertical;
      projectChart2.update('');
      
      ownerChart1.config.type = 'bar';
      ownerChart1.options = tempOptions['owners1'].vertical;
      ownerChart1.update('');
      ownerChart2.config.type = 'bar';
      ownerChart2.options = tempOptions['owners2'].vertical;
      ownerChart2.update('');
      
      realtorChart1.config.type = 'bar';
      realtorChart1.options = tempOptions['realtors1'].vertical;
      realtorChart1.update('');
      realtorChart2.config.type = 'bar';
      realtorChart2.options = tempOptions['realtors2'].vertical;
      realtorChart2.update('');
    }else{
      if( orientation == 'horizontal' ){
        return;
      }
      orientation = 'horizontal';

      listingChart1.config.type = 'horizontalBar';
      listingChart1.options = tempOptions['listings1'].horizontal;
      listingChart1.update('');
      listingChart2.config.type = 'horizontalBar';
      listingChart2.options = tempOptions['listings2'].horizontal;
      listingChart2.update('');
      
      projectChart1.config.type = 'horizontalBar';
      projectChart1.options = tempOptions['projects1'].horizontal;
      projectChart1.update('');
      projectChart2.config.type = 'horizontalBar';
      projectChart2.options = tempOptions['projects2'].horizontal;
      projectChart2.update('');
      
      ownerChart1.config.type = 'horizontalBar';
      ownerChart1.options = tempOptions['owners1'].horizontal;
      ownerChart1.update('');
      ownerChart2.config.type = 'horizontalBar';
      ownerChart2.options = tempOptions['owners2'].horizontal;
      ownerChart2.update('');
      
      realtorChart1.config.type = 'horizontalBar';
      realtorChart1.options = tempOptions['realtors1'].horizontal;
      realtorChart1.update('');
      realtorChart2.config.type = 'horizontalBar';
      realtorChart2.options = tempOptions['realtors2'].horizontal;
      realtorChart2.update('');
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
  const getChartPie = (labels, dataset, colors, {title = '', subtitle = ''}) => {
    return {
      data: {
        labels: labels,
        datasets:[
          {
            label: title,
            data: dataset,
            backgroundColor: colors
          }
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        title: {
            display: true,
            text: [title, subtitle],
        },
        animation: {
          animateScale: true,
          animateRotate: true
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var currentLabel = data.labels[tooltipItem.index];
              var currentValue = dataset.data[tooltipItem.index];
              var label = currentLabel + ': ' + ( currentValue + '%' );         
              return label;
            }
          }
        }
      }
    }
  }
  const getChartData = (labels, dataset) => {
    return areaChartData = {
      daily: {
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
        ]
      },
      total: {
        labels  : labels,
        datasets: [
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
  }
  const getOptions = ({title = '', subtitle = ''}, max_label) =>{
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
                  userCallback: function(label, index, labels) {
                    if (Math.floor(label) === label) {
                        return label;
                    }
                  }
                }
            }]
        },
        title: {
            display: true,
            text: [title,subtitle],
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
                  userCallback: function(label, index, labels) {
                    if (Math.floor(label) === label) {
                        return label;
                    }
                  }
                }
            }]
        },
        title: {
            display: true,
            text: [title,subtitle],
        }
      },
    }
    if( max_label == 0 ){
      opciones.vertical.scales.yAxes[0].ticks.max = 5;
      opciones.horizontal.scales.xAxes[0].ticks.max = 5;
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
    let updated_at = details?.data?.data?.updated_at??null;
    if( updated_at ){
      updated_at = 'Ultima actualizacion: ' + updated_at;
    }
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
    //CARGAR GRÁFICO
    const areaChartData = getChartData(labels, { 
      title_today: 'Avisos en el día', data_today: data_today,
      title_total: 'Avisos totales', total_data: total_data
    });
    const barChartCanvas1 = $('#listingsChart1').get(0).getContext('2d')
    const barChartCanvas2 = $('#listingsChart2').get(0).getContext('2d')
    
    const barChartOptions1 = getOptions({title: 'Avisos publicados por día', subtitle: updated_at}, max);
    const barChartOptions2 = getOptions({title: 'Avisos publicados totales', subtitle: updated_at}, max);
    tempOptions['listings1'] = barChartOptions1;
    tempOptions['listings2'] = barChartOptions2;
    if( listingChart1 ){
      listingChart1.destroy();
    }
    listingChart1 = new Chart(barChartCanvas1, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartData.daily,
      options: (windowWidth > 768) ? barChartOptions1.vertical : barChartOptions1.horizontal
    })
    if( listingChart2 ){
      listingChart2.destroy();
    }
    listingChart2 = new Chart(barChartCanvas2, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartData.total,
      options: (windowWidth > 768) ? barChartOptions2.vertical : barChartOptions2.horizontal
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
    let updated_at = details?.data?.data?.updated_at??null;
    if( updated_at ){
      updated_at = 'Ultima actualizacion: ' + updated_at;
    }
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
    //CARGAR GRÁFICO
    const areaChartData = getChartData(labels, { 
      title_today: 'Proyectos en el día', data_today: data_today,
      title_total: 'Proyectos totales', total_data: total_data
    });
    const barChartCanvas1 = $('#projectsChart1').get(0).getContext('2d')
    const barChartCanvas2 = $('#projectsChart2').get(0).getContext('2d')
    
    
    const barChartOptions1 = getOptions({title: 'Proyectos publicados por día', subtitle: updated_at}, max);
    const barChartOptions2 = getOptions({title: 'Proyectos publicados totales', subtitle: updated_at}, max);
    tempOptions['projects1'] = barChartOptions1;
    tempOptions['projects2'] = barChartOptions2;
    if( projectChart1 ){
      projectChart1.destroy();
    }
    projectChart1 = new Chart(barChartCanvas1, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartData.daily,
      options: (windowWidth > 768) ? barChartOptions1.vertical : barChartOptions1.horizontal
    })
    if( projectChart2 ){
      projectChart2.destroy();
    }
    projectChart2 = new Chart(barChartCanvas2, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartData.total,
      options: (windowWidth > 768) ? barChartOptions2.vertical : barChartOptions2.horizontal
    })
  }
  const loadStadisticsDistricts = async (month = null) => {
    const current_mont = getMonth();
    const params = {
			parent: 'homepage',
			child: 'views',
			month: ( month ) ? month : current_mont
		};
    const details = await fetchData('app/gateway', params, 'GET');
		const data = details?.data?.data?.records?.views??[];
    let updated_at = details?.data?.data?.updated_at??null;
    if( updated_at ){
      updated_at = 'Ultima actualizacion: ' + updated_at;
    }
    let labels = [];
    let data_percent = [];
    let colors = [];
    data.forEach(element => {
      const department = element.department??'';
      const district = element.district??'';
      const province = element.province??'';
      const qty_impressions = element.qty_impressions??0;
      const percentage_impressions = element.percentage_impressions??0;
      const color = element.color??'';
      const label = [department + ' - ' + district + ' - ' + province];
      labels.push(label);
      colors.push(color);
      data_percent.push(percentage_impressions);
    });
    //OBTENER DATA
    const areaChartData = getChartPie(labels, data_percent, colors, {title: updated_at});
    //CARGAR GRÁFICO
    const barChartCanvas = $('#viewsChart').get(0).getContext('2d')
    if( viewsChart ){
      viewsChart.destroy();
    }
    viewsChart = new Chart(barChartCanvas, {
      type: 'doughnut',
      ...areaChartData
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
    let updated_at = details?.data?.data?.updated_at??null;
    if( updated_at ){
      updated_at = 'Ultima actualizacion: ' + updated_at;
    }
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
    const areaChartDataOwner = getChartData(labels_owner, { 
      title_today: 'Clientes del día', data_today: data_today_owner,
      title_total: 'Clientes totales', total_data: total_data_owner
    });
    const barChartCanvasOwner1 = $('#OwnersChart1').get(0).getContext('2d');
    const barChartCanvasOwner2 = $('#OwnersChart2').get(0).getContext('2d');
    const barChartOptionsOwner1 = getOptions({title: 'Clientes por dia | Propietarios', subtitle: updated_at}, max_owner);
    const barChartOptionsOwner2 = getOptions({title: 'Clientes totales | Propietarios', subtitle: updated_at}, max_owner);
    tempOptions['owners1'] = barChartOptionsOwner1;
    tempOptions['owners2'] = barChartOptionsOwner2;
    options1 = barChartOptionsOwner1;
    options2 = barChartOptionsOwner2;
    if( ownerChart1 ){
      ownerChart1.destroy();
    }
    ownerChart1 = new Chart(barChartCanvasOwner1, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartDataOwner.daily,
      options: (windowWidth > 768) ? barChartOptionsOwner1.vertical : barChartOptionsOwner1.horizontal
    })
    if( ownerChart2 ){
      ownerChart2.destroy();
    }
    ownerChart2 = new Chart(barChartCanvasOwner2, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartDataOwner.total,
      options: (windowWidth > 768) ? barChartOptionsOwner2.vertical : barChartOptionsOwner2.horizontal
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
    const areaChartDataRealtor = getChartData(labels_owner, { 
      title_today: 'Clientes del día', data_today: data_today_realtor,
      title_total: 'Clientes totales', total_data: total_data_realtor
    });
    const barChartCanvasRealtor1 = $('#RealtorsChart1').get(0).getContext('2d');
    const barChartCanvasRealtor2 = $('#RealtorsChart2').get(0).getContext('2d');
    const barChartOptionsRealtor1 = getOptions({title: 'Clientes por dia | Agentes', subtitle: updated_at}, max_realtor);
    const barChartOptionsRealtor2 = getOptions({title: 'Clientes totales | Agentes', subtitle: updated_at}, max_realtor);
    tempOptions['realtors1'] = barChartOptionsRealtor1;
    tempOptions['realtors2'] = barChartOptionsRealtor1;
    if( realtorChart1 ){
      realtorChart1.destroy();
    }
    realtorChart1 = new Chart(barChartCanvasRealtor1, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartDataRealtor.daily,
      options: (windowWidth > 768) ? barChartOptionsRealtor1.vertical : barChartOptionsRealtor1.horizontal
    })

    if( realtorChart2 ){
      realtorChart2.destroy();
    }
    realtorChart2 = new Chart(barChartCanvasRealtor2, {
      type: (windowWidth > 768) ? 'bar' : 'horizontalBar',
      data: areaChartDataRealtor.total,
      options: (windowWidth > 768) ? barChartOptionsRealtor2.vertical : barChartOptionsRealtor2.horizontal
    })
  }
  const init = () => {
    return new Promise(async (resolve, reject) => {
        try {
          await loadStadisticsUsers();
          await loadStadisticsListings();
          await loadStadisticsProjects();
          await loadStadisticsDistricts();
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
    $("#OwnersChart1").attr('hidden', false);
    $("#OwnersChart2").attr('hidden', false);
    $("#RealtorsChart1").attr('hidden', true);
    $("#RealtorsChart2").attr('hidden', true);
  });
  $(document).on('click', '#realtors', async function () {
    $(".userbtn").removeClass("active")
    $(this).addClass("active")
    $("#OwnersChart1").attr('hidden', true);
    $("#OwnersChart2").attr('hidden', true);
    $("#RealtorsChart1").attr('hidden', false);
    $("#RealtorsChart2").attr('hidden', false);
  });
  window.addEventListener('resize', changeDirectionBar);
</script>
@endsection