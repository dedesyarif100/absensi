@extends('main')

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
                {{-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< RANGE TANGGAL >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
                <div class="input-daterange">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="awal">awal</label>
                            <input class="datepicker form-control" data-date-format="yyyy-mm-dd" name="awal" id="awal" value="{{ now()->subMonth()->day(21)->toDateString() }}">
                        </div>
                        <div class="col-md-4">
                            <label for="akhir">akhir</label>
                            <input class="datepicker form-control" data-date-format="yyyy-mm-dd" name="akhir" id="akhir" value="{{ now()->day(20)->toDateString() }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="filter" id="filter" class="btn btn-primary btn-sm" style="margin-top: 2.22rem; width: 120px;">Filter</button>
                        </div>
                    </div>
                    <br>
                </div>
                {{-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< RANGE TANGGAL >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
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
    <script>
        $(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });

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
                    type: "bar",
                    color: '#ffaa66',
                },
                seriesTemplate: {
                    nameField: "name",
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
