<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Data([
            'timestamp_bawaan' => $row['TIMESTAMP'],
            'witel'=> $row['WITEL'],
            'id_valins'=> $row['ID VALINS'],
            'eviden1'=> $row['Upload Eviden Web Valins'],
            'eviden2'=> $row['Tambahan Eviden Web Valins'],
            'eviden3'=> $row['Eviden Tambahan Untuk Pelanggan Non Indihome / Dinas'],
            'id_valins_lama'=> $row['ID VALINS LAMA'],
            'approve_aso'=> $row['Approve ASO (OK/NOK)'],
            'keterangan_aso'=> $row['KET ASO'],
            'ram3'=> $row['RAM3'],
            'rekon'=> $row['REKON'],
            'keterangan_ram3'=> $row['KET RAM3'],
        ]);
    }
}
