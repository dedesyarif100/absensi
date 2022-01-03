@extends('main')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.common.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.light.css" />
@endsection

@section('title', 'Dashboard')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Chart</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="demo-container">
                <div class="input-daterange">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="awal">awal</label>
                            <input type="date" class="form-control" name="awal" id="awal"
                                value="{{ now()->subMonth()->day(21)->toDateString() }}">
                        </div>
                        <div class="col-md-4">
                            <label for="akhir">akhir</label>
                            <input type="date" class="form-control" name="akhir" id="akhir"
                                value="{{ now()->day(20)->toDateString() }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="filter" id="filter" class="btn btn-primary btn-sm"
                                style="margin-top: 2.22rem; width: 120px;">Filter</button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="demo-container">
            <div id="chart"></div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/21.1.5/js/dx.all.js"></script>

    <script>
        $(function() {
            var x = window.matchMedia("(max-width: 700px)");    
            let awal = $('#awal').val();
            let akhir = $('#akhir').val();
            let chartOption = {
                commonSeriesSettings: {
                    type: "bar",
                    barPadding: 0.5,
                    valueField: "hour",
                    argumentField: "name",
                    ignoreEmptyPoints: true,
                    label: {
                        visible: true,
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    }
                },
                argumentAxis: {
                    label: {
                        displayMode: "rotate",
                        rotationAngle: 45,
                    }
                },
                series: {
                    argumentField: "name",
                    valueField: "hour",
                    name: "Absensi",
                    // nameField: "name",
                    type: "bar",
                    color: '#ffaa66',
                },
                seriesTemplate: {
                    nameField: "name",
                    // valueField: "hour",
                },
            };
            myFunction(x);
            x.addListener(myFunction);

            function myFunction(x) {
                prosesDesktop(x.matches);
            }

            $('#filter').on('click', function() {
                prosesDesktop();
            });

            function prosesDesktop(isResponsive = false) {
                awal = $('#awal').val();
                akhir = $('#akhir').val();
                chartOption.dataSource = `{{ url('employee/getChart') }}?awal=${awal}&akhir=${akhir}`;
                if (isResponsive) {
                    chartOption.columnWidth = 1000;
                    chartOption.legend = {
                        verticalAlignment: "bottom",
                        horizontalAlignment: "center"
                    };
                }
                $("#chart").dxChart(chartOption);
            }
        });
    </script>
@endsection
