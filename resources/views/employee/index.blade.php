@extends('main')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.common.css" />
<link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.light.css" />
<style>
    .demo-container {
        height: 570px;
    }
    ​
    #gridContainer {
        height: 440px;
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
                {{-- <div id="exportButton"></div> --}}
                <div class="input-daterange">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="awal">awal</label>
                            <input type="date" class="form-control" name="awal" id="awal">
                        </div>
                        <div class="col-md-4">
                            <label for="akhir">akhir</label>
                            <input type="date" class="form-control" name="akhir" id="akhir">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="filter" id="filter" class="btn btn-primary btn-sm" style="margin-top: 2.22rem; width: 120px;">Filter</button>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="range-selector" id="gridContainer" data-bind="dxDataGrid: grid"></div>
            </div>
        </div>
        <div class="option">
            <div id="showNavButtons"></div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn3.devexpress.com/jslib/21.1.5/js/dx.all.js"></script>
{{-- <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script> --}}

<!-- Export Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<!-- End Export Pdf -->

{{-- Export Pdf --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
{{-- End Export Pdf --}}

{{-- <script src="https://cdn3.devexpress.com/jslib/21.1.5/js/dx.all.js"></script> --}}

<script>
    window.jsPDF = window.jspdf.jsPDF;
    applyPlugin(window.jsPDF);
    let _token = $('meta[name="csrf-token"]').attr('content');

    $(function() {
        var date = new Date();
        $('#filter').on('click', function () {
            let awal = $('#awal').val();
            let akhir = $('#akhir').val();
            prosesDesktop(awal, akhir);
        });

        function myFunction(x) {
            if (x.matches) { // If media query matches
                prosesResponsive();
            } else {
                prosesDesktop();
            }
        }

        var x = window.matchMedia("(max-width: 700px)");
        myFunction(x);
        x.addListener(myFunction);

        function prosesResponsive(awal = '', akhir = '') {
            var grid = $("#gridContainer").dxDataGrid({
                dataSource: `{{ url('employee/getEmployee') }}?awal=${awal}&akhir=${akhir}`,
                data: {awal: awal, akhir: akhir, _token: _token},
                dataType: "json",
                keyExpr: "ID",
                columnsAutoWidth: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                // scrolling: { mode: "infinite" },
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
                onExporting: function(e) {
                    var workbook = new ExcelJS.Workbook();
                    var worksheet = workbook.addWorksheet('Employees');

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
                columns: [
                    {
                        dataField: "Nik",
                        dataType: "number",
                    },
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
                        minWidth: 100,
                        render: function (value) {
                            return moment(value).format('H:M:s');
                        }
                    },
                    {
                        dataField: "TimeOut",
                        dataType: "datetime",
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
                },
                allowColumnReordering: true,
                allowColumnResizing: true,
                rowPrepared: function (rowElement, rowInfo) {
                    if (rowInfo.data.Nik == '21') {
                        rowElement.css('background', 'green');
                    }
                }
            }).dxDataGrid('instance');
        }

        function prosesDesktop(awal = '', akhir = '') {
            var grid = $("#gridContainer").dxDataGrid({
                dataSource: `{{ url('employee/getEmployee') }}?awal=${awal}&akhir=${akhir}`,
                data: {awal: awal, akhir: akhir, _token: _token},
                dataType: "json",
                keyExpr: "ID",
                columnsAutoWidth: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                // scrolling: { mode: "infinite" },
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
                // columnWidth: 100,
                onExporting: function(e) {
                    var workbook = new ExcelJS.Workbook();
                    var worksheet = workbook.addWorksheet('Employees');

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
                grouping: {
                    contextMenuEnabled: true
                },
                groupPanel: {
                    visible: true   // or "auto"
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
                        // render: function (value) {
                        //     return moment(value).format('H:M:s');
                        // }
                    },
                    {
                        dataField: "TimeOut",
                        dataType: "datetime",
                        minWidth: 100,
                        format: 'HH:mm:ss',
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
                },
                allowColumnReordering: true,
                allowColumnResizing: true,
                rowPrepared: function (rowElement, rowInfo) {
                    if (rowInfo.data.Nik == '21') {
                        rowElement.css('background', 'green');
                    }
                }
            }).dxDataGrid('instance');
            // console.log(grid);
        }

        // $("#gridContainer").dxDataGrid({
        //     dataSource: generateData(rowCount, columnCount),
        //     keyExpr: "field1",
        //     columnWidth: 100,
        //     showBorders: true,
        //     scrolling: {
        //         columnRenderingMode: "virtual"
        //     },
        //     paging: {
        //         enabled: false
        //     }
        // });

        // const navButtons = $("#showNavButtons").dxCheckBox({
        //     text: "Show Navigation Buttons",
        //     value: true,
        //     onValueChanged: function(data) {
        //         dataGrid.option("pager.showNavigationButtons", data.value);
        //     }
        // }).dxCheckBox("instance");

        // function getOrderDay(rowData) {
        //     return (new Date(rowData.OrderDate)).getDay();
        // }
    });
</script>
@endsection
