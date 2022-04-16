<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return auth()->user()->tarefas()->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id da Tarefa',
            'Tarefa',
            'Data limite de conclusão',
        ];
    }

    /**
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->tarefa,
            date('d/m/Y', strtotime($row->data_limite_conclusao))
        ];
    }
}
