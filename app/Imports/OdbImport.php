<?php

namespace App\Imports;

use App\Odb;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OdbImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Odb|null
     */
    public function model(array $row)
    {
        return new Odb([
            'datel' => $row['datel'],
            'locn_x' => $row['locn_x'],
            'locn_y' => $row['locn_y'],
            'nama_odp' => $row['nama_odp'],
            'real_isiska_avai' => $row['real_isiska_avai'],
            'real_isiska_total' => $row['real_isiska_total'],
            'real_occupancy' => $row['real_occupancy'],
            'status' => $row['status'],
            'sto' => $row['sto'],
            'witel' => $row['witel']
        ]);
    }
}
