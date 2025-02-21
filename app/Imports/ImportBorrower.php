<?php

namespace App\Imports;

use App\Models\Borrower;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBorrower implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $existingRecord = Borrower::find($row['id']); // Check if ID exists

        if ($existingRecord) {
            $existingRecord->update([
                'student_id' => $row['student_id'],
            ]);
        }
    
        return null; // Do not create a new record
    }
}
