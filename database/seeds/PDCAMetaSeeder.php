<?php

use Illuminate\Database\Seeder;

use App\PDCAMeta;
use App\Enums\PDCAMetaEnum;

class PDCAMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PDCAMeta::create([
            'id' => 1,
            'meta_key' => 'RESOURCE_DIR',
            'meta_value' => PDCAMetaEnum::RESOURCE_DIR, //Storage::url('attachments'),
            'is_visible' => true
        ]);
    }
}
