<?php

namespace App\Imports;

use App\Models\PreviewData;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class DatasImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $excelTimestamp = $row['timestamp'];
        $timestamp = Carbon::createFromTimestamp(($excelTimestamp - 25569) * 86400);
        $formattedTimestamp = $timestamp->format('n/j/Y g:i:s A');

        return new PreviewData([
            'timestamp_bawaan' => $formattedTimestamp,
            'witel' => $row['witel'],
            'id_valins' => $row['id_valins'],
            'eviden1' => $row['eviden_1'],
            'eviden2' => $row['eviden_2'],
            'eviden3' => $row['eviden_3'],
            'id_valins_lama' => $row['id_valins_lama'],
            'approve_aso' => $row['approve_aso'],
            'keterangan_aso' => $row['ket_aso'],
            'ram3' => $row['ram3'],
            'rekon' => $row['rekon'],
            'keterangan_ram3' => $row['ket_ram3'],
            'unique_id' => Session('unique_id'),
            'upload_by' => Session('username')
        ]);
    }
    public function shouldSkipEmptyRows(): bool
    {
        return true;
    }
}
