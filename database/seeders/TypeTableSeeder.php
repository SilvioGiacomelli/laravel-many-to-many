<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use App\Functions\Helper as Help;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['TYPE1', 'TYPE2', 'TYPE3', 'TYPE4', 'TYPE5'];
        foreach ($data as $item) {
            $new_item = new Type();
            $new_item->title = $item;
            $new_item->slug = Help::generateSlug($item, Type::class);
            $new_item->save();
        }
    }
}
