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
            $data = array([
                'employee_id' => $id,
                'amount' => $request->salary,
                'salary_date' => date('d/m/Y'),
                'salary_month' => $request->salary_month,
                'salary_year' => date('Y'),
            ]);
    
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
        
    }
}
