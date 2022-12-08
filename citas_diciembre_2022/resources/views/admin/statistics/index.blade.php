@extends('layouts.admin')

@section('title', 'Estadísticas')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">
	<a href="javascript:void(0);">Estadísticas</a>
</li>
@endsection

@section('links')
<link href="{{ asset('/admins/css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
<link href="{{ asset('/admins/vendor/apex/apexcharts.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">
	<div class="col-md-6 col-sm-12 col-12 layout-spacing">
		<div class="widget widget-chart-three">
			<div class="widget-heading">
				<div class="">
					<h5 class="">Pacientes por Rangos de Edad</h5>
				</div>
			</div>

			<div class="widget-content">
				<div id="patientsAges"></div>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-sm-12 col-12 layout-spacing">
		<div class="widget widget-chart-three">
			<div class="widget-heading">
				<div class="">
					<h5 class="">Pacientes por Género</h5>
				</div>
			</div>

			<div class="widget-content">
				<div id="patientsGenders"></div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="widget widget-chart-three">
			<div class="widget-heading">
				<div class="">
					<h5 class="">Pacientes por Localidad</h5>
				</div>
			</div>

			<div class="widget-content">
				<div id="patientsLocalities"></div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h5>Pacientes Atendidos por Año</h5>
			</div>

			<div class="widget-content">
				<div id="appointmentsAttendsYears"></div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h5>Pacientes Atendidos por Mes</h5>
			</div>

			<div class="widget-content">
				<div id="appointmentsAttendsMonths"></div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h5>Pacientes Atendidos por Semana</h5>
			</div>

			<div class="widget-content">
				<div id="appointmentsAttendsWeekly"></div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h5>Pacientes Atendidos por Día</h5>
			</div>

			<div class="widget-content">
				<div id="appointmentsAttendsDiary"></div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="widget widget-chart-three">
			<div class="widget-heading">
				<div class="">
					<h5 class="">Pacientes Atendidos por Especialidad</h5>
				</div>
			</div>

			<div class="widget-content">
				<div id="patientsSpecialties"></div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-12">
						<h4>Lista de Pacientes de Covid</h4>
					</div>
				</div>
			</div>
			<div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12">
						<p class="font-weight-bold px-4 pt-2 mb-0">Cant. Pacientes con Covid: {{ $covids->count() }}</p>
						<p class="font-weight-bold px-4 pt-2 mb-0">Cant. Internados en UCI: {{ $covids->where('uci', 'Si')->count() }}</p>
					</div>

					<div class="col-12 mt-3">
						<table class="table table-normal table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Paciente</th>
									<th>Sintomas</th>
									<th>Fecha de Contagio</th>
									<th>Estado de Recuperación</th>
									<th>Internado en UCI</th>
								</tr>
							</thead>
							<tbody>
								@foreach($covids as $covid)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $covid['user']->name.' '.$covid['user']->lastname }}</td>
									<td>
										@foreach($covid['symptoms'] as $symptom)
										{{ $symptom->symptom }}@if(!$loop->last){{ ', ' }}@endif
										@endforeach
									</td>
									<td>{{ $covid->covid_date->format('d-m-Y') }}</td>
									<td>{{ $covid->covid_state }}</td>
									<td>{{ $covid->uci }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="widget widget-chart-three">
			<div class="widget-heading">
				<div class="">
					<h5 class="">Sintomas Más Comunes del Covid</h5>
				</div>
			</div>

			<div class="widget-content">
				<div id="covidSymptoms"></div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('/admins/vendor/apex/apexcharts.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
<script type="text/javascript">
	var patientsAgesOptions={
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			}
		},
		colors: ['#5c1ac3', '#d6b007'],
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%'
			},
		},
		dataLabels: {
			enabled: false
		},
		legend: {
			position: 'bottom',
			horizontalAlign: 'center',
			fontSize: '14px',
			markers: {
				width: 10,
				height: 10,
			},
			itemMargin: {
				horizontal: 0,
				vertical: 8
			}
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		series: [{
			name: 'Total',
			data: [{{ $ages[0] }}, {{ $ages[1] }}, {{ $ages[2] }}]
		}],
		xaxis: {
			categories: ['0 a 20', '21 a 40', '41 a 70'],
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				type: 'vertical',
				shadeIntensity: 0.3,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 0.8,
				stops: [0, 100]
			}
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val
				}
			}
		}
	}
	var patientsAges=new ApexCharts(document.querySelector("#patientsAges"), patientsAgesOptions);
	patientsAges.render();

	var patientsGendersOptions={
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			}
		},
		colors: ['#5c1ac3', '#d6b007'],
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%'
			},
		},
		dataLabels: {
			enabled: false
		},
		legend: {
			position: 'bottom',
			horizontalAlign: 'center',
			fontSize: '14px',
			markers: {
				width: 10,
				height: 10,
			},
			itemMargin: {
				horizontal: 0,
				vertical: 8
			}
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		series: [{
			name: 'Total',
			data: {{ $genders->pluck('total') }}
		}],
		xaxis: {
			categories: {!! $genders->pluck('gender') !!},
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				type: 'vertical',
				shadeIntensity: 0.3,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 0.8,
				stops: [0, 100]
			}
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val
				}
			}
		}
	}
	var patientsGenders=new ApexCharts(document.querySelector("#patientsGenders"), patientsGendersOptions);
	patientsGenders.render();

	var patientsLocalitiesOptions={
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			}
		},
		colors: ['#5c1ac3', '#d6b007'],
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%'
			},
		},
		dataLabels: {
			enabled: false
		},
		legend: {
			position: 'bottom',
			horizontalAlign: 'center',
			fontSize: '14px',
			markers: {
				width: 10,
				height: 10,
			},
			itemMargin: {
				horizontal: 0,
				vertical: 8
			}
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		series: [{
			name: 'Total',
			data: {{ $localities->pluck('total') }}
		}],
		xaxis: {
			categories: {!! $localities->pluck('location.name') !!},
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				type: 'vertical',
				shadeIntensity: 0.3,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 0.8,
				stops: [0, 100]
			}
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val
				}
			}
		}
	}
	var localitiesGenders=new ApexCharts(document.querySelector("#patientsLocalities"), patientsLocalitiesOptions);
	localitiesGenders.render();

	var patientsSpecialtiesOptions={
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			}
		},
		colors: ['#5c1ac3', '#d6b007'],
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%'
			},
		},
		dataLabels: {
			enabled: false
		},
		legend: {
			position: 'bottom',
			horizontalAlign: 'center',
			fontSize: '14px',
			markers: {
				width: 10,
				height: 10,
			},
			itemMargin: {
				horizontal: 0,
				vertical: 8
			}
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		series: [{
			name: 'Total',
			data: {{ $specialties->pluck('total') }}
		}],
		xaxis: {
			categories: {!! $specialties->pluck('specialty.name') !!},
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				type: 'vertical',
				shadeIntensity: 0.3,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 0.8,
				stops: [0, 100]
			}
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val
				}
			}
		}
	}
	var patientsSpecialties=new ApexCharts(document.querySelector("#patientsSpecialties"), patientsSpecialtiesOptions);
	patientsSpecialties.render();


	var appointmentsAttendsYearsOptions={
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			}
		},
		colors: ['#5c1ac3', '#d6b007'],
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%'
			},
		},
		dataLabels: {
			enabled: false
		},
		legend: {
			position: 'bottom',
			horizontalAlign: 'center',
			fontSize: '14px',
			markers: {
				width: 10,
				height: 10,
			},
			itemMargin: {
				horizontal: 0,
				vertical: 8
			}
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		series: [{
			name: 'Total',
			data: {!! $appointmentsYears->pluck('total') !!}
		}],
		xaxis: {
			categories: {!! $appointmentsYears->pluck('year') !!},
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				type: 'vertical',
				shadeIntensity: 0.3,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 0.8,
				stops: [0, 100]
			}
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val
				}
			}
		}
	}
	var appointmentsAttendsYears=new ApexCharts(document.querySelector("#appointmentsAttendsYears"), appointmentsAttendsYearsOptions);
	appointmentsAttendsYears.render();

	var appointmentsAttendsMonthsOptions={
		chart: {
			fontFamily: 'Nunito, sans-serif',
			height: 365,
			type: 'area',
			zoom: {
				enabled: false
			},
			dropShadow: {
				enabled: true,
				opacity: 0.2,
				blur: 10,
				left: -7,
				top: 22
			},
			toolbar: {
				show: false
			},
			events: {
				mounted: function(ctx, config) {
					const highest1 = ctx.getHighestValueInSeries(0);
					const highest2 = ctx.getHighestValueInSeries(1);

					ctx.addPointAnnotation({
						x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
						y: highest1,
						label: {
							style: {
								cssClass: 'd-none'
							}
						},
						customSVG: {
							SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
							cssClass: undefined,
							offsetX: -8,
							offsetY: 5
						}
					})

					ctx.addPointAnnotation({
						x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
						y: highest2,
						label: {
							style: {
								cssClass: 'd-none'
							}
						},
						customSVG: {
							SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
							cssClass: undefined,
							offsetX: -8,
							offsetY: 5
						}
					})
				},
			}
		},
		colors: ['#1b55e2', '#e7515a'],
		dataLabels: {
			enabled: false
		},
		markers: {
			discrete: [{
				seriesIndex: 0,
				dataPointIndex: 7,
				fillColor: '#000',
				strokeColor: '#000',
				size: 5
			}, {
				seriesIndex: 2,
				dataPointIndex: 11,
				fillColor: '#000',
				strokeColor: '#000',
				size: 4
			}]
		},
		stroke: {
			show: true,
			curve: 'smooth',
			width: 2,
			lineCap: 'square'
		},
		series: [{
			name: 'Total',
			data: {!! $appointmentsMonths->pluck('total') !!}
		}],
		labels: {!! $appointmentsMonths->pluck('new_date') !!},
		xaxis: {
			axisBorder: {
				show: false
			},
			axisTicks: {
				show: false
			},
			crosshairs: {
				show: true
			},
			labels: {
				offsetX: 0,
				offsetY: 5,
				style: {
					fontSize: '12px',
					fontFamily: 'Nunito, sans-serif',
					cssClass: 'apexcharts-xaxis-title',
				},
			}
		},
		yaxis: {
			labels: {
				offsetX: -22,
				offsetY: 0,
				style: {
					fontSize: '12px',
					fontFamily: 'Nunito, sans-serif',
					cssClass: 'apexcharts-yaxis-title',
				},
			}
		},
		grid: {
			borderColor: '#e0e6ed',
			strokeDashArray: 5,
			xaxis: {
				lines: {
					show: true
				}
			},   
			yaxis: {
				lines: {
					show: false,
				}
			},
			padding: {
				top: 0,
				right: 0,
				bottom: 0,
				left: -10
			}, 
		}, 
		legend: {
			position: 'top',
			horizontalAlign: 'right',
			offsetY: -50,
			fontSize: '16px',
			fontFamily: 'Nunito, sans-serif',
			markers: {
				width: 10,
				height: 10,
				strokeWidth: 0,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,
				onClick: undefined,
				offsetX: 0,
				offsetY: 0
			},    
			itemMargin: {
				horizontal: 0,
				vertical: 20
			}
		},
		tooltip: {
			theme: 'dark',
			marker: {
				show: true,
			},
			x: {
				show: false,
			}
		},
		fill: {
			type:"gradient",
			gradient: {
				type: "vertical",
				shadeIntensity: 1,
				inverseColors: !1,
				opacityFrom: .28,
				opacityTo: .05,
				stops: [45, 100]
			}
		},
		responsive: [{
			breakpoint: 575,
			options: {
				legend: {
					offsetY: -30,
				},
			},
		}]
	}
	var appointmentsAttendsMonths=new ApexCharts(document.querySelector("#appointmentsAttendsMonths"), appointmentsAttendsMonthsOptions);
	appointmentsAttendsMonths.render();

	var appointmentsAttendsWeeklyOptions={
		chart: {
			fontFamily: 'Nunito, sans-serif',
			height: 365,
			type: 'area',
			zoom: {
				enabled: false
			},
			dropShadow: {
				enabled: true,
				opacity: 0.2,
				blur: 10,
				left: -7,
				top: 22
			},
			toolbar: {
				show: false
			},
			events: {
				mounted: function(ctx, config) {
					const highest1 = ctx.getHighestValueInSeries(0);
					const highest2 = ctx.getHighestValueInSeries(1);

					ctx.addPointAnnotation({
						x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
						y: highest1,
						label: {
							style: {
								cssClass: 'd-none'
							}
						},
						customSVG: {
							SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
							cssClass: undefined,
							offsetX: -8,
							offsetY: 5
						}
					})

					ctx.addPointAnnotation({
						x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
						y: highest2,
						label: {
							style: {
								cssClass: 'd-none'
							}
						},
						customSVG: {
							SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
							cssClass: undefined,
							offsetX: -8,
							offsetY: 5
						}
					})
				},
			}
		},
		colors: ['#1b55e2', '#e7515a'],
		dataLabels: {
			enabled: false
		},
		markers: {
			discrete: [{
				seriesIndex: 0,
				dataPointIndex: 7,
				fillColor: '#000',
				strokeColor: '#000',
				size: 5
			}, {
				seriesIndex: 2,
				dataPointIndex: 11,
				fillColor: '#000',
				strokeColor: '#000',
				size: 4
			}]
		},
		stroke: {
			show: true,
			curve: 'smooth',
			width: 2,
			lineCap: 'square'
		},
		series: [{
			name: 'Total',
			data: {!! $appointmentsWeekly->pluck('total') !!}
		}],
		labels: {!! $appointmentsWeekly->pluck('week') !!},
		xaxis: {
			axisBorder: {
				show: false
			},
			axisTicks: {
				show: false
			},
			crosshairs: {
				show: true
			},
			labels: {
				offsetX: 0,
				offsetY: 5,
				style: {
					fontSize: '12px',
					fontFamily: 'Nunito, sans-serif',
					cssClass: 'apexcharts-xaxis-title',
				},
			}
		},
		yaxis: {
			labels: {
				offsetX: -22,
				offsetY: 0,
				style: {
					fontSize: '12px',
					fontFamily: 'Nunito, sans-serif',
					cssClass: 'apexcharts-yaxis-title',
				},
			}
		},
		grid: {
			borderColor: '#e0e6ed',
			strokeDashArray: 5,
			xaxis: {
				lines: {
					show: true
				}
			},   
			yaxis: {
				lines: {
					show: false,
				}
			},
			padding: {
				top: 0,
				right: 0,
				bottom: 0,
				left: -10
			}, 
		}, 
		legend: {
			position: 'top',
			horizontalAlign: 'right',
			offsetY: -50,
			fontSize: '16px',
			fontFamily: 'Nunito, sans-serif',
			markers: {
				width: 10,
				height: 10,
				strokeWidth: 0,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,
				onClick: undefined,
				offsetX: 0,
				offsetY: 0
			},    
			itemMargin: {
				horizontal: 0,
				vertical: 20
			}
		},
		tooltip: {
			theme: 'dark',
			marker: {
				show: true,
			},
			x: {
				show: false,
			}
		},
		fill: {
			type:"gradient",
			gradient: {
				type: "vertical",
				shadeIntensity: 1,
				inverseColors: !1,
				opacityFrom: .28,
				opacityTo: .05,
				stops: [45, 100]
			}
		},
		responsive: [{
			breakpoint: 575,
			options: {
				legend: {
					offsetY: -30,
				},
			},
		}]
	}
	var appointmentsAttendsWeekly=new ApexCharts(document.querySelector("#appointmentsAttendsWeekly"), appointmentsAttendsWeeklyOptions);
	appointmentsAttendsWeekly.render();

	var appointmentsAttendsDiaryOptions={
		chart: {
			fontFamily: 'Nunito, sans-serif',
			height: 365,
			type: 'area',
			zoom: {
				enabled: false
			},
			dropShadow: {
				enabled: true,
				opacity: 0.2,
				blur: 10,
				left: -7,
				top: 22
			},
			toolbar: {
				show: false
			},
			events: {
				mounted: function(ctx, config) {
					const highest1 = ctx.getHighestValueInSeries(0);
					const highest2 = ctx.getHighestValueInSeries(1);

					ctx.addPointAnnotation({
						x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
						y: highest1,
						label: {
							style: {
								cssClass: 'd-none'
							}
						},
						customSVG: {
							SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
							cssClass: undefined,
							offsetX: -8,
							offsetY: 5
						}
					})

					ctx.addPointAnnotation({
						x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
						y: highest2,
						label: {
							style: {
								cssClass: 'd-none'
							}
						},
						customSVG: {
							SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
							cssClass: undefined,
							offsetX: -8,
							offsetY: 5
						}
					})
				},
			}
		},
		colors: ['#1b55e2', '#e7515a'],
		dataLabels: {
			enabled: false
		},
		markers: {
			discrete: [{
				seriesIndex: 0,
				dataPointIndex: 7,
				fillColor: '#000',
				strokeColor: '#000',
				size: 5
			}, {
				seriesIndex: 2,
				dataPointIndex: 11,
				fillColor: '#000',
				strokeColor: '#000',
				size: 4
			}]
		},
		stroke: {
			show: true,
			curve: 'smooth',
			width: 2,
			lineCap: 'square'
		},
		series: [{
			name: 'Total',
			data: {!! $appointmentsDiary->pluck('total') !!}
		}],
		labels: {!! $appointmentsDiary->pluck('new_date') !!},
		xaxis: {
			axisBorder: {
				show: false
			},
			axisTicks: {
				show: false
			},
			crosshairs: {
				show: true
			},
			labels: {
				offsetX: 0,
				offsetY: 5,
				style: {
					fontSize: '12px',
					fontFamily: 'Nunito, sans-serif',
					cssClass: 'apexcharts-xaxis-title',
				},
			}
		},
		yaxis: {
			labels: {
				offsetX: -22,
				offsetY: 0,
				style: {
					fontSize: '12px',
					fontFamily: 'Nunito, sans-serif',
					cssClass: 'apexcharts-yaxis-title',
				},
			}
		},
		grid: {
			borderColor: '#e0e6ed',
			strokeDashArray: 5,
			xaxis: {
				lines: {
					show: true
				}
			},   
			yaxis: {
				lines: {
					show: false,
				}
			},
			padding: {
				top: 0,
				right: 0,
				bottom: 0,
				left: -10
			}, 
		}, 
		legend: {
			position: 'top',
			horizontalAlign: 'right',
			offsetY: -50,
			fontSize: '16px',
			fontFamily: 'Nunito, sans-serif',
			markers: {
				width: 10,
				height: 10,
				strokeWidth: 0,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,
				onClick: undefined,
				offsetX: 0,
				offsetY: 0
			},    
			itemMargin: {
				horizontal: 0,
				vertical: 20
			}
		},
		tooltip: {
			theme: 'dark',
			marker: {
				show: true,
			},
			x: {
				show: false,
			}
		},
		fill: {
			type:"gradient",
			gradient: {
				type: "vertical",
				shadeIntensity: 1,
				inverseColors: !1,
				opacityFrom: .28,
				opacityTo: .05,
				stops: [45, 100]
			}
		},
		responsive: [{
			breakpoint: 575,
			options: {
				legend: {
					offsetY: -30,
				},
			},
		}]
	}
	var appointmentsAttendsDiary=new ApexCharts(document.querySelector("#appointmentsAttendsDiary"), appointmentsAttendsDiaryOptions);
	appointmentsAttendsDiary.render();

	var covidSymptomsOptions={
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			}
		},
		colors: ['#5c1ac3', '#d6b007'],
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%'
			},
		},
		dataLabels: {
			enabled: false
		},
		legend: {
			position: 'bottom',
			horizontalAlign: 'center',
			fontSize: '14px',
			markers: {
				width: 10,
				height: 10,
			},
			itemMargin: {
				horizontal: 0,
				vertical: 8
			}
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		series: [{
			name: 'Total',
			data: {{ $symptoms->pluck('total') }}
		}],
		xaxis: {
			categories: {!! $symptoms->pluck('symptom') !!},
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				type: 'vertical',
				shadeIntensity: 0.3,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 0.8,
				stops: [0, 100]
			}
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val
				}
			}
		}
	}
	var covidSymptoms=new ApexCharts(document.querySelector("#covidSymptoms"), covidSymptomsOptions);
	covidSymptoms.render();
</script>
@endsection