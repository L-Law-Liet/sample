<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductStatus::insert([
           [
               'name' => 'Products for repair',
               'color' => '#3699FF'
           ],
           [
               'name' => 'Revised',
               'color' => '#008B8B'
           ],
           [
               'name' => 'In progress',
               'color' => '#8950FC'
           ],
           [
               'name' => 'Ready for audit',
               'color' => '#FFA800'
           ],
           [
               'name' => 'Audit fails',
               'color' => '#F64E60'
           ],
            [
               'name' => 'Unable for repair',
               'color' => '#8B0000'
            ],
            [
                'name' => ProductStatus::REPAIRED_NAME(),
                'color' => '#1BC5BD'
            ],
        ]);
    }
}
