@extends('main')

@section('css')
<style>
    .demo-container {
        height: 570px;
    }

    #gridContainer {
        height: 520px;
    }

    .dx-filterbuilder-overlay .dx-scrollable-container {
        max-height: 400px;
    }
</style>
@endsection

@section('title', 'Dashboard')

@section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>List Employee</h1>
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
                            <input class="datepicker form-control" data-date-format="yyyy-mm-dd" name="awal" id="awal">
                        </div>
                        <div class="col-md-4">
                            <label for="akhir">akhir</label>
                            <input class="datepicker form-control" data-date-format="yyyy-mm-dd" name="akhir" id="akhir">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="filter" id="filter" class="btn btn-primary btn-sm" style="margin-top: 2.22rem; width: 120px;">Filter</button>
                        </div>
                    </div>
                    <br>
                </div>
                {{-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< RANGE TANGGAL >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
                <div class="range-selector" id="gridContainer" data-bind="dxDataGrid: grid"></div>
            </div>
        </div>
        <div class="option">
            <div id="showNavButtons"></div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

<script>
    let _token = $('meta[name="csrf-token"]').attr('content');
    $(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

        let date = new Date();
        $('#filter').on('click', function () {
            let awal = $('#awal').val();
            let akhir = $('#akhir').val();
            prosesDesktop(awal, akhir);
        });

        function myFunction(responsive) {
            if (responsive.matches) { // If media query matches
                prosesResponsive();
            } else {
                prosesDesktop();
            }
        }

        let responsive = window.matchMedia("(max-width: 700px)");
        myFunction(responsive);
        responsive.addListener(myFunction);

        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< MENAMPILKAN DATA PADA DEVICE RESPONSIVE >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
        function prosesResponsive(awal = '', akhir = '') {
            let grid = $("#gridContainer").dxDataGrid({
                dataSource: `{{ url('employee/getEmployee') }}?awal=${awal}&akhir=${akhir}`,
                data: {awal: awal, akhir: akhir, _token: _token},
                dataType: "json",
                keyExpr: "ID",
                columnsAutoWidth: true,
                filterRow: { visible: true },
                headerFilter: { visible: true },
                showBorders: true,
                paging: {
                    pageSize: 10
                },
                pager: {
                    visible: true,
                    showNavigationButtons: true,
                },
                selection: {
                    mode: 'single',
                    columnRenderingMode: "virtual"
                },
                export: {
                    enabled: true,
                    allowExportSelectedData: true
                },
                columnWidth: 200,
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< EVENT UNTUK EXPORT EXCEL >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
                onExporting: function(e) {
                    let workbook = new ExcelJS.Workbook();
                    let worksheet = workbook.addWorksheet('Employees');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet: worksheet,
                        autoFilterEnabled: true
                    }).then(function() {
                        workbook.xlsx.writeBuffer().then(function(buffer) {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Employees.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< EVENT UNTUK EXPORT EXCEL >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
                columns: [
                    {
                        dataField: "EmployeeName",
                        dataType: "string",
                        minWidth: 100,
                    },
                    {
                        dataField: "AuthenDate",
                        dataType: "date"
                    },
                    {
                        dataField: "TimeIn",
                        dataType: "datetime",
                        format: 'HH:mm:ss',
                        minWidth: 100,
                    },
                    {
                        dataField: "TimeOut",
                        dataType: "datetime",
                        format: 'HH:mm:ss',
                        minWidth: 100,
                    },
                    {
                        dataField: "Hours",
                        dataType: "string"
                    },
                    {
                        dataField: "Note",
                        dataType: "string"
                    }
                ],
                pager: { visible: true },
                editing: {
                    editEnabled: false,
                    editMode: 'row',
                    insertEnabled: false,
                    removeEnabled: false
                }
            }).dxDataGrid('instance');
        }
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< MENAMPILKAN DATA PADA DEVICE RESPONSIVE >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //

        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< MENAMPILKAN DATA PADA DEVICE KOMPUTER >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
        function prosesDesktop(awal = '', akhir = '') {
            let grid = $("#gridContainer").dxDataGrid({
                dataSource: `{{ url('employee/getEmployee') }}?awal=${awal}&akhir=${akhir}`,
                data: {awal: awal, akhir: akhir, _token: _token},
                dataType: "json",
                keyExpr: "ID",
                columnsAutoWidth: true,
                filterRow: { visible: true },
                headerFilter: { visible: true },
                showBorders: true,
                paging: {
                    pageSize: 10
                },
                pager: {
                    visible: true,
                    showNavigationButtons: true,
                },
                selection: {
                    mode: 'single',
                    columnRenderingMode: "virtual"
                },
                export: {
                    enabled: true,
                    allowExportSelectedData: true
                },
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< EVENT UNTUK EXPORT EXCEL >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
                onExporting: function(e) {
                    let workbook = new ExcelJS.Workbook();
                    let worksheet = workbook.addWorksheet('Employees');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet: worksheet,
                        autoFilterEnabled: true
                    }).then(function() {
                        workbook.xlsx.writeBuffer().then(function(buffer) {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Employees.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< EVENT UNTUK EXPORT EXCEL >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
                grouping: {
                    contextMenuEnabled: true
                },
                groupPanel: {
                    visible: true // or "auto"
                },
                columns: [
                    {
                        dataField: "EmployeeName",
                        dataType: "string",
                        minWidth: 100,
                    },
                    {
                        dataField: "AuthenDate",
                        dataType: "date",
                        format: 'dd-MM-yyyy'
                    },
                    {
                        dataField: "TimeIn",
                        dataType: "datetime",
                        format: 'HH:mm:ss',
                        minWidth: 100,
                    },
                    {
                        dataField: "TimeOut",
                        dataType: "datetime",
                        format: 'HH:mm:ss',
                        minWidth: 100,
                    },
                    {
                        dataField: "Hours",
                        dataType: "string"
                    },
                    {
                        dataField: "Note",
                        dataType: "string"
                    }
                ],
                pager: { visible: true },
                editing: {
                    editEnabled: false,
                    editMode: 'row',
                    insertEnabled: false,
                    removeEnabled: false
                }
            }).dxDataGrid('instance');
        }
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< MENAMPILKAN DATA PADA DEVICE KOMPUTER >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> //
    });
</script>
@endsection
