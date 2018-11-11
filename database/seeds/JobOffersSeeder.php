<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JobOffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_offers')->insert([
            [
                'id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'title' => 'Grafik Komputerowy',
                'body' => '<div><p>Kim jesteśmy?</p><br><br><p><strong>Rockstar Games</strong> jest przedsiębiorstwem znanym z produkcji gier typowo sandboxowych, nasza sztandarową serią jest seria Grand Theft Auto.</p><p>Obecnie poszukujemy nowych grafików do naszego zespołu.</p><p>Wymagania:</p><ul><li>Znajomość narzędzi Adobe Illustrator, Photoshop</li><li>Mile widziana znajomość 3DS Max lub podobnych narzędzi</li></ul><p>Po więcej szczegółów zgłoś się na mail <a href="mail-to:example@example.com">example@example.com</a>.</p><br><br><br><p>Do zobaczenia!</p><em>Zespół Rockstar Games</em></div>',
                'valid_until' => Carbon::now()->addMonth(),
                'development_studio_id' => 1
            ]
        ]);
    }
}
