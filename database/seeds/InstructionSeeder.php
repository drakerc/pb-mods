<?php

use Illuminate\Database\Seeder;

class InstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instructionText = <<<TEXT
<p>By zainstalować modyfikację, należy mieć:</p><p><br></p><ul><li>Skyrim 3.0</li><li>Steam</li><li>Paczkę z modyfikacją</li></ul><p><br></p><p>Kroki instalacji:</p><ol><li>Lorem</li><li>Ipsum</li><li><span style="color: rgb(0, 0, 0);">Nunc non quam nisl. Donec ullamcorper maximus&nbsp;</span></li><li><span style="color: rgb(0, 0, 0);">Nunc non quam nisl. Donec ullamcorper maximus&nbsp;</span></li></ol><p><br></p><p><br></p><p><strong style="color: rgb(0, 0, 0);"><span class="ql-cursor">﻿﻿</span><u>Dziękujemy za pobranie i życzmy miłej gry!</u></strong></p><p><strong style="color: rgb(0, 0, 0);"><u>Pamiętaj by wystawić swoją recenzję!</u></strong></p>
TEXT;

        DB::table('instructions')->insert([
            [
                'id' => 1,
                'title' => 'Instalacji',
                'description' => $instructionText,
                'author_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('file_instruction')->insert([
            [
                'instruction_id' => 1,
                'file_id' => 1,
            ],
        ]);
    }
}
