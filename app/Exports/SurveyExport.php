<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'title',
            'slug',
            'status',
            'image',
            'description',
            'client_id',
            'employe_id',
        ];
    }
    public function collection()
    {
        return Survey::select(
            'id',
            'user_id',
            'title',
            'slug',
            'status',
            'image',
            'description',
            'client_id',
            'employe_id',
        )->get();
    }
}
