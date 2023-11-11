<?php

namespace Database\Seeders;

use App\Models\Data;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Data::insert([
            'timestamp_bawaan' => '9/29/2023 16:30:32',
            'witel' => 'BANDUNG BARAT',
            'id_valins' => '20981474',
            'eviden1' => 'https://drive.google.com/open?id=1a9MfNNk8R2S2vC_VlD8YmRHCKUw27isC',
            'eviden2' => 'https://drive.google.com/open?id=1vvHWjZrdquhNYzEsROj5CKn_lrByAk5d',
            'eviden3' => 'https://drive.google.com/open?id=1vvHWjZrdquhNYzEsROj5CKn_lrByAk5d',
            'id_valins_lama' => '',
            'approve_aso' => '',
            'keterangan_aso' => '',
            'ram3' => 'NOK',
            'rekon' => 'SEPTEMBER',
            'keterangan_ram3' => 'BT/NONE >=50% Jumlah Dropcore',
            'id_eviden1' => '1a9MfNNk8R2S2vC_VlD8YmRHCKUw27isC',
            'id_eviden2' => '1vvHWjZrdquhNYzEsROj5CKn_lrByAk5d',
            'id_eviden3' => '1vvHWjZrdquhNYzEsROj5CKn_lrByAk5d',
            'status' => 1,
            'upload_by' => 'admin',
            'unique_id' => 'blablabla'
        ]);
    }
}
