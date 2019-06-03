@extends('layouts.home_layout')

@section('section_stylesheet')
    @parent
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs/css/select.bootstrap.min.css') }}" />
    <!-- ChartJS -->
    <link rel="stylesheet" href="{{ asset('node_modules/chart.js/dist/Chart.min.css') }}" />
@endsection

@section('section_script_main')
    @parent
@endsection

@section('content')
<!-- row -->
<div class="row">
    
    <!-- col -->
    <div class="col-sm-12">
        
        <!-- accordion -->
        <div class="panel-group" id="accordion">
            
            <!-- panel -->
            <div id="collapseTwoParent" class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#collapseTwoParent" href="#collapseTwo"><span class="glyphicon glyphicon-plus"></span>
                            @isset($departmentObj)
                                {{ $departmentObj->company_name }}
                            @endisset
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in">
                    <div class="panel-body">
                        
                        <!-- --- -->
                        <!-- row -->
                        <div class="row">
                            <!-- col -->
                            <div class="col-sm-12">
                                <!-- table -->
                                @isset ($departmentObj)
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <!-- box -->
                                        <div class="box box-primary">
                                            <!-- box-header -->
                                            <div class="box-header with-border">
                                                <h3 class="box-title">
                                                    <!-- urlencode() -->
                                                    <a href="{!! route('department.showDepartmentPDCA', [urlencode($departmentObj->company_name), urlencode($departmentObj->department_name)]) !!}">{{ $departmentObj->department_name }}</a>
                                                </h3>

                                                <div class="box-tools pull-right">
                                                    <!-- button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button -->
                                                    <!-- button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button -->
                                                </div>
                                            </div>
                                            <!-- /.box-header -->
                                            <!-- box-body -->
                                            <div class="box-body">
                                                <div class="chart">
                                                    <canvas id="chart{!! 1 !!}" style="height:250px"></canvas>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>

                                    <script>
                                    $(function(){
                                        var chartData = {
                                          labels  : ['Status'],
                                          datasets: [
                                            {
                                                label               : 'PDCA',
                                                backgroundColor: 'rgba(255,190,0,1)',
                                                borderColor: 'rgba(0,0,0,0.5)',
                                                data                : [{!! $departmentObj->pDCACompanyDepartmentAllCountPercentage !!}],
                                                dataCount      : [{!! $departmentObj->pDCACompanyDepartmentAllCount !!}],
                                                dataStatus     : {!! App\Enums\PDCAStatusEnum::DEFAULT !!}
                                            }
                                          ]
                                        };
                                        var canvasCtx = $('#chart{!! 1 !!}').get(0).getContext('2d');
                                        var chartConfig = {
                                            type: 'horizontalBar',
                                            data: chartData,
                                            options: {
                                                elements: {
                                                    rectangle: {
                                                        borderWidth: 1,
                                                    }
                                                },
                                                responsive: true,
                                                maintainAspectRatio: true,
                                                legend: {
                                                    position: 'bottom',
                                                },
                                                tooltips: {
                                                    mode: 'nearest',
                                                    callbacks: {
                                                       label: function(tooltipItem, data) {
                                                            var itemDataArray = $.makeArray( data.datasets[tooltipItem.datasetIndex].data );
                                                            var itemDataCountArray = $.makeArray( data.datasets[tooltipItem.datasetIndex].dataCount );
                                                           
                                                            var itemData = itemDataArray.shift();
                                                            var itemDataCount = itemDataCountArray.shift();
                                                            
                                                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                                            if (label) {
                                                                label += ': ';
                                                            }
                                                            label += Math.round(itemDataCount * 100) / 100;
                                                            return label;
                                                       }
                                                    }
                                                },
                                                title: {
                                                    display: false,
                                                    text: 'Chart'
                                                },
                                                animation: {
                                                    animateScale: true,
                                                    animateRotate: true
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        display: false,
                                                        gridLines: {
                                                            drawBorder: false
                                                        },
                                                        ticks: {
                                                            suggestedMin: 0,
                                                            suggestedMax: 100,
                                                            beginAtZero: true,
                                                            minStepSize: 1
                                                        }
                                                    }],
                                                    xAxes: [{
                                                        display: true,
                                                        ticks: {
                                                            suggestedMin: 0,
                                                            suggestedMax: 100,
                                                            beginAtZero: true,
                                                            minStepSize: 1
                                                            /*callback: function(value, index, values) {
                                                               if (index === values.length - 1){
                                                                   return Math.min.apply(this, dataArr = []);
                                                               }else if (index === 0){
                                                                   return Math.max.apply(this, dataArr = []);
                                                               }else{
                                                                   return '';
                                                               }
                                                            }*/
                                                        }
                                                    }]
                                                },
                                                'onClick': function (event, item) {
                                                    var activeElement = this.getElementAtEvent(event);
                                                    activeElement = activeElement.shift();
                                                    //var activeElementDataSet = this.getDatasetAtEvent(event);
                                                    var activeElementDataSet = {};
                                                    var activeElementDataStatus = null;
                                                    
                                                    if (activeElement) {
                                                        activeElementDataSet = this.data.datasets[activeElement._datasetIndex];
                                                        activeElementDataStatus = activeElementDataSet.dataStatus;
                                                        
                                                        var url = "{!! route('department.showDepartmentPDCA', [urlencode($departmentObj->company_name), urlencode($departmentObj->department_name)]) !!}";
                                                        $( location ).attr("href", url);
                                                    }
                                                }
                                            }
                                        }
                                        var chartObj = new Chart(canvasCtx, chartConfig);
                                    }); 
                                    </script>
                                @endisset
                                <!-- /.table -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <!-- --- -->
                        
                    </div>
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.accordion -->
        
    </div>
    <!-- /.col -->
    
</div>
<!-- /.row -->
@endsection

@section('section_script')
    @parent
    <!-- DataTable -->
    <script src="{{ asset('node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-responsive-bs/js/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-scroller-bs/js/scroller.bootstrap.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-select-bs/js/select.bootstrap.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('node_modules/chart.js/dist/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('node_modules/chart.js/dist/Chart.min.js') }}"></script>
@endsection