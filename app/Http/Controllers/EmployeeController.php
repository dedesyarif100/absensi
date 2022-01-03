<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        // $employee = Employee::orderBy('id', 'DESC')->paginate(Employee::count());
        // $employee = DB::select("SELECT employee.Nik, employee.Name, history.AuthenDate, MAX(history.AuthenTime) AS JamDatang, MIN(history.AuthenTime) AS JamPulang,
        //                         CONCAT (
        //                             DATEDIFF( HOUR, MAX(history.AuthenTime), MIN(history.AuthenTime) ) % 24, ':',
        //                             DATEDIFF( MINUTE, MAX(history.AuthenTime), MIN(history.AuthenTime) ) % 60
        //                         ) AS JumlahJamKerja
        //                         -- DATEDIFF(MINUTE, MAX(history.AuthenTime), MIN(history.AuthenTime) ) - ( DATEDIFF( HOUR, MAX(history.AuthenTime), MIN(history.AuthenTime) * 60) ) AS JumlahJamKerja
        //                         FROM dbo.EmployeeInformation employee
        //                         JOIN dbo.HistoryAttendance history
        //                         ON employee.EmployeeCardId = history.EmployeeCardId
        //                         WHERE employee.EmployeeCardId = 7
        //                         -- AND
        //                         -- (
        //                         --     (history.AuthenTime >= '00:00:00' AND history.AuthenTime <= '12:00:00')
        //                         --     OR
        //                         --     (history.AuthenTime >= '12:00:00' AND history.AuthenTime <= '23:59:00')
        //                         -- )
        //                         -- (CONVERT(varchar, history.AuthenTime, 108) BETWEEN '01:00:00' AND '12:00:00') AS JamDatang
        //                         GROUP BY history.AuthenDate, employee.Name, employee.Nik");
        // dd($employee);
        return view('employee.index');
    }

    public function getEmployee(Request $request)
    {
        // $get = Employee::all();
        // dd($get);

        // // $employee = DB::select("SELECT employee.Nik, employee.Name, history.AuthenDate, MAX(history.AuthenTime) AS JamDatang, MIN(history.AuthenTime) AS JamPulang,
        // //                         CONCAT (
        // //                             DATEDIFF( HOUR, MAX(history.AuthenTime), MIN(history.AuthenTime) ) % 24, ':',
        // //                             DATEDIFF( MINUTE, MAX(history.AuthenTime), MIN(history.AuthenTime) ) % 60
        // //                         ) AS JumlahJamKerja
        // //                         FROM dbo.EmployeeInformation employee
        // //                         JOIN dbo.HistoryAttendance history
        // //                         ON employee.EmployeeCardId = history.EmployeeCardId
        // //                         -- WHERE employee.EmployeeCardId =
        // //                         GROUP BY history.AuthenDate, employee.Name, employee.Nik");
        // // dd(collect($employee));

        $employee = DB::select("SELECT history.EmployeeName, history.AuthenDate, history.TimeIn, history.TimeOut, history.Hours, history.Note
                                FROM dbo.vwMonsterHistoryAttendance history
                                WHERE history.AuthenDate BETWEEN ? AND ?
                                ORDER BY history.EmployeeName", [$request->awal, $request->akhir]);
        // dd(DB::select("SELECT * FROM dbo.vwMonsterHistoryAttendance WHERE TimeIn >= '09:00:00'"));
        // dd($employee);
        return $employee;
    }

    public function chart(Request $request)
    {
        // dd(session('login'));
        return view('employee.chart');
    }

    public function getChartEmployee(Request $request)
    {
        // dd($request);
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
