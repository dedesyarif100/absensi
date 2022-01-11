<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }

    public function getEmployee(Request $request)
    {
        $employee = DB::select("SELECT history.EmployeeName, history.AuthenDate, history.TimeIn, history.TimeOut, history.Hours, history.Note
                                FROM dbo.vwMonsterHistoryAttendance history
                                WHERE history.AuthenDate BETWEEN ? AND ?
                                ORDER BY history.EmployeeName", [$request->awal, $request->akhir]);
        return $employee;
    }

    public function chart()
    {
        return view('employee.chart');
    }

    public function getChartEmployee(Request $request)
    {
        $result = [];
        $employee = DB::select("SELECT EmployeeName, SUM(Seconds) as second FROM dbo.vwMonsterHistoryAttendance WHERE AuthenDate BETWEEN ? AND ? GROUP BY EmployeeName", [$request->awal, $request->akhir]);
        foreach ($employee as $value) {
            array_push($result, [
                'name' => $value->EmployeeName,
                'hour' => $value->second / 3600,
            ]);
        }
        return $result;
    }
}
