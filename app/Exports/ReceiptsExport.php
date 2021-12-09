<?php

namespace App\Exports;

use App\Models\Receipt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReceiptsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $receipts = DB::table('receipts')
            ->join('categories', 'receipts.id_category', '=','categories.id')
            ->join('kitchens', 'receipts.id_kitchen', '=','kitchens.id')
            ->join('users', 'receipts.id_user', '=','users.id')
            ->select('receipts.id', 'receipts.name', 'receipts.cooking_hours', 'receipts.cooking_minutes', 'receipts.main_img as image', 'categories.category', 'kitchens.kitchen', 'users.name as username', 'users.surname', 'users.email', 'receipts.advice')
            ->get();

        return $receipts;
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'cooking_hours',
            'cooking_minutes',
            'image',
            'category',
            'kitchen',
            'username',
            'surname',
            'email',
            'advice,'
        ];
    }
}
