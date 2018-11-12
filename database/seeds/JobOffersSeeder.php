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
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
                'title' => 'Grafik Komputerowy',
                'email' => 'example@example.com',
                'body' => '<div><p>Kim jesteśmy?</p><br><br><p><strong>Rockstar Games</strong> jest przedsiębiorstwem znanym z produkcji gier typowo sandboxowych, nasza sztandarową serią jest seria Grand Theft Auto.</p><p>Obecnie poszukujemy nowych grafików do naszego zespołu.</p><p>Wymagania:</p><ul><li>Znajomość narzędzi Adobe Illustrator, Photoshop</li><li>Mile widziana znajomość 3DS Max lub podobnych narzędzi</li></ul><p>Po więcej szczegółów zgłoś się na mail <a href="mailto:example@example.com">example@example.com</a>.</p><br><br><br><p>Do zobaczenia!</p><em>Zespół Rockstar Games</em></div>',
                'valid_until' => Carbon::now()->addMonth(),
                'development_studio_id' => 1
            ],
            [
                'id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'title' => 'Starszy Programista C++',
                'email' => 'example@example.com',
                'body' => '<div><p>Studio <strong>Bethesda Softworks</strong> poszukuje programisty C++. <br><br><br><br>Więcej szczegółów pod adresem email <a href="emailto:example@example.com">example@example.com</a><br><br>Do zobaczenia,</p><em>Bethesda Softworks</em></div>',
                'valid_until' => Carbon::now()->subDay(),
                'development_studio_id' => 2
            ],
            [
                'id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'title' => 'Starszy Programista C#',
                'email' => 'example@example.com',
                'body' => '<div><p>Studio <strong>Bethesda Softworks</strong> poszukuje programisty C#. <br><br><br><br>Więcej szczegółów pod adresem email <a href="emailto:example@example.com">example@example.com</a><br><br>Do zobaczenia,</p><em>Bethesda Softworks</em></div>',
                'valid_until' => Carbon::now()->addMonth(),
                'development_studio_id' => 2
            ],
            [
                'id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'title' => 'Starszy Story Designer',
                'email' => 'example@example.com',
                'body' => '<div><p>Studio <strong>Rockstar Games</strong> poszukuje scenarzysty do naszej nowej gry.</p><p>Wymagana znajomość języków C++/C#.</p> <br><br><br><br><p>Więcej szczegółów pod adresem email <a href="emailto:example@example.com">example@example.com</a></p><br><br<p>Do zobaczenia,</p><p><em>Rockstar Games</em></p></div>',
                'valid_until' => Carbon::now()->addWeek(),
                'development_studio_id' => 1
            ],
            [
                'id' => 5,
                'created_at' => Carbon::now()->subMinutes(20),
                'updated_at' => Carbon::now()->subMinutes(20),
                'title' => 'Level Designer',
                'email' => 'example@example.com',
                'body' => '<div><p>Studio <strong>Bethesda Softworks</strong> poszukuje projektanta poziomów do naszej nowej gry.</p><p>Wymagana znajomość języków C++/C# oraz narzędzi Adobe Illustrator, bądź podobnych.</p> <br><br><br><br><p>Więcej szczegółów pod adresem email <a href="emailto:example@example.com">example@example.com</a></p><br><br<p>Do zobaczenia,</p><p><em>Bethesda Softworks</em></p></div>',
                'valid_until' => Carbon::now()->addMonth(),
                'development_studio_id' => 2
            ],
            [
                'id' => 6,
                'created_at' => Carbon::now()->subMinutes(20),
                'updated_at' => Carbon::now()->subMinutes(20),
                'title' => 'Młodszy Level Designer',
                'email' => 'example@example.com',
                'body' => '<div><p>Studio <strong>Bethesda Softworks</strong> poszukuje projektanta poziomów do naszej nowej gry.</p><p>Wymagana znajomość języków C++/C# oraz narzędzi Adobe Illustrator, bądź podobnych.</p> <br><br><br><br><p>Więcej szczegółów pod adresem email <a href="emailto:example@example.com">example@example.com</a></p><br><br<p>Do zobaczenia,</p><p><em>Bethesda Softworks</em></p></div>',
                'valid_until' => Carbon::now()->addMonth(),
                'development_studio_id' => 2
            ],            [
                'id' => 7,
                'created_at' => Carbon::now()->subMinutes(25),
                'updated_at' => Carbon::now()->subMinutes(30),
                'title' => 'Starszy Level Designer',
                'email' => 'example@example.com',
                'body' => '<div><p>Studio <strong>Bethesda Softworks</strong> poszukuje projektanta poziomów do naszej nowej gry.</p><p>Wymagana znajomość języków C++/C# oraz narzędzi Adobe Illustrator, bądź podobnych.</p> <br><br><br><br><p>Więcej szczegółów pod adresem email <a href="emailto:example@example.com">example@example.com</a></p><br><br<p>Do zobaczenia,</p><p><em>Bethesda Softworks</em></p></div>',
                'valid_until' => Carbon::now()->addMonth(),
                'development_studio_id' => 2
            ],
            [
                'id' => 8,
                'created_at' => Carbon::now()->subMinutes(3),
                'updated_at' => Carbon::now()->subMinutes(3),
                'title' => 'Concept Art Designer',
                'email' => 'example@example.com',
                'body' => '<div><p>Studio <strong>Bethesda Softworks</strong> poszukuje rysownika concept-artów do naszej nowej gry.</p><p>Wymagana znajomość języków C++/C# oraz narzędzi Adobe Illustrator, bądź podobnych.</p> <br><br><br><br><p>Więcej szczegółów pod adresem email <a href="emailto:example@example.com">example@example.com</a></p><br><br<p>Do zobaczenia,</p><p><em>Bethesda Softworks</em></p></div>',
                'valid_until' => Carbon::now()->addMonth(),
                'development_studio_id' => 2
            ],

        ]);
    }
}
