<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Printer;

class PrinterSeeder extends Seeder
{
    public function run()
    {
        Printer::create([
            'name' => 'Demo IPP Printer',
            'ip_address' => '192.168.1.254', // Replace with your printer's IP
        ]);
    }
}
