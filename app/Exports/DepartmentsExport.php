<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Department;

class DepartmentsExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $departments = Department::select('uuid', 'name', 'description', 'created_at', 'updated_at')
                ->whereNull('deleted_at')->get();

        return view('reports.excel.lists_departments', ['departments' => $departments]);
    }
}
