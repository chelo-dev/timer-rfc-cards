<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NormalizedExists implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $normalizedValue = mb_strtolower($value, 'UTF-8');
        return DB::table($this->table)
            ->whereRaw("LOWER(unaccent($this->column)) = LOWER(unaccent(?))", [$normalizedValue])
            ->exists();
    }

    public function message()
    {
        return 'El valor ingresado no es válido o no existe en los registros.';
    }
}
