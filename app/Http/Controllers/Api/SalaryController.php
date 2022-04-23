<?php

namespace App\Http\Controllers\Api;

use App\Models\Model\Salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function paid(Request $request, $id)
    {
        $validateData = $request->validate([
            'salary_month' => 'required',
        ]);

        $salary = Salary::where('employee_id', $id)->where('salary_month', $request->salary_month)->first();

        if(!$salary)
        {
            $data = array(
                'employee_id' => $id,
                'amount' => $request->salary,
                'salary_date' => date('d/m/Y'),
                'salary_month' => $request->salary_month,
                'salary_year' => date('Y'),
            );
    
            Salary::insert($data);
        }else{
            return response()->json(['isvalid'=>false, 'errors'=> 'Salary already Paid'], 401);
        }
    }

    public function allSalary()
    {
        $salary = Salary::select('salary_month')->groupBy('salary_month')->get();

        return response()->json($salary);
    }

    public function viewSalary($id)
    {
        $view = Salary::join('employees', 'salaries.employee_id', 'employees.id')
                        ->select('employees.name', 'salaries.*')
                        ->where('salaries.salary_month', $id)
                        ->get();
                    
        return response()->json($view);
    }

    public function editSalary($id)
    {
        $view = Salary::join('employees', 'salaries.employee_id', 'employees.id')
        ->select('employees.name', 'employees.email', 'salaries.*')
        ->where('salaries.id', $id)
        ->first();
    
        return response()->json($view);
    }

    public function updateSalary(Request $request, $id)
    {
        $data = array(
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'salary_month' => $request->salary_month
        );

        Salary::where('id', $id)->update($data);
    }
}
