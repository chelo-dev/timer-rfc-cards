<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UsersExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $users = User::with(['roles', 'department', 'position'])
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get()
            ->map(function ($user) {
                return [
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                    'email' => $user->email,
                    'department' => optional($user->department)->name,
                    'position' => optional($user->position)->name,
                    'is_active' => $user->is_active,
                    'phone' => $user->phone,
                    'notes' => $user->notes,
                    'last_login' => is_null($user->last_login) ? 'N/A' : date('d-m-Y H:i:s', strtotime($user->last_login)),
                    'role' => optional($user->roles->first())->name ?? 'N/A',
                    'created_at' => date('d-m-Y', strtotime($user->created_at)),
                    'updated_at' => date('d-m-Y', strtotime($user->updated_at))
                ];
            });

        return view('reports.excel.lists_user', ['users' => $users]);
    }
}
