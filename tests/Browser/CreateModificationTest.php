<?php

namespace Tests\Browser;

use App\File;
use App\Modification;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\UserTest;
use Faker\Factory as Faker;

class CreateModificationTest extends DuskTestCase
{
    public function getHumanReadableFilesizeAttribute($filesize, $decimals = 1)
    {
        if ($filesize == 0)
            return "0 B";

        $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($filesize, 1024));

        return round($filesize/pow(1024, $e), 2).$s[$e];
    }

    public function testCreateModification()
    {
        $faker = Faker::create();

        $user = new UserTest();
        $user->login('gallanonim@anonim.com', 'anonim');

        $data = [
            'title' => $faker->text(40),
            'replaces' => $faker->word,
            'version' => $faker->numberBetween(1, 5) . $faker->randomLetter,
            'description' => $faker->text(1000),
        ];

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit('/mods/2/category/2')
                ->assertSee('Nowe bronie')
                ->waitUntilMissing('.vld-overlay', 15)
                ->click('#create-new-mod')
                ->waitForText('Tworzenie nowej modyfikacji do gry The Elder Scrolls V Skyrim')
                ->assertSee('Tworzenie nowej modyfikacji do gry The Elder Scrolls V Skyrim')
                ->assertSee('W pierwszym kroku')
                ->type('title', $data['title'])

                ->click('.size-multiselect')
                ->waitForText('Średniej wielkości modyfikacja')
                ->click('.multiselect__element')
                ->waitForText('Niewielka, pojedyńcza modyfikacja')

                ->click('.development-status-multiselect')
                ->waitForText('Nierozpoczęty')
                ->click('.development-status-multiselect > .multiselect__content-wrapper > .multiselect__content > .multiselect__element')
                ->waitForText('Nierozpoczęty')

                ->type('replaces', $data['replaces'])
                ->type('version', $data['version'])

                ->click('#release_date')
                ->waitFor('.vdp-datepicker__calendar')
                ->click('.vdp-datepicker__calendar > div > .sat')

                ->type('#description > .ql-editor', $data['description'])

                ->press('Wyślij')

                ->waitForText('Modyfikacja: ' . $data['title'])
                ->assertSee('Modyfikacja: ' . $data['title'])
                ->assertSeeIn('@title', $data['title'])
                ->assertSeeIn('@development_status', 'Nierozpoczęty')
                ->assertSeeIn('@size', 'Niewielka, pojedyńcza modyfikacja')
                ->assertSeeIn('@replaces', $data['replaces'])
                ->assertSeeIn('@version', $data['version'])
                ->assertSeeIn('@creator_name', 'gallanonim')
                ->assertSeeIn('@downloads_count', 0)
                ->assertSeeIn('@timestamps', 'Stworzono dnia: ' . date('j.m.Y'))
                ->assertSeeIn('@description', $data['description']);
        });
    }

    public function testAddFiles()
    {
        $faker = Faker::create();
        $lastMod = Modification::where('creator', '=', 1)->latest()->first();

        $file = public_path('storage/modification_files/testzip.zip');
        $size = $this->getHumanReadableFilesizeAttribute(filesize($file));
        $extension = mime_content_type($file);

        $user = new UserTest();
//        $user->login('gallanonim@anonim.com', 'anonim');

        $data = [
            'title' => $faker->text(40),
            'description' => $faker->text(1000),
        ];

        $this->browse(function (Browser $browser) use ($data, $lastMod, $file, $size, $extension) {
            $browser->visit('/mods/2')
                ->assertSee('Modyfikacje do gry The Elder Scrolls V Skyrim')
                ->press('Moje modyfikacje')
                ->waitFor('.mod-card', 15)
                ->assertSee('Przeglądasz modyfikacje autorstwa użytkownika gallanonim.')
                ->click('#mod-card-' . $lastMod->id . ' > .card > .text-center')
                ->waitFor('@author-button')
                ->assertVisible('@author-button')
                ->click('@author-button')
                ->assertSee('To menu widoczne jest wyłącznie dla autorów modyfikacji.')
                ->assertVisible('@author-add-files')
                ->click('@author-add-files')
                ->waitForText('Dodajesz pliki do modyfikacji', 15)
                ->assertSee('Dodajesz pliki do modyfikacji')
                ->type('files[1][title]', $data['title'])
                ->type('.ql-editor', $data['description'])
                ->attach('files[1]', $file)
                ->press('Wyślij')

                ->waitFor('@files-button')
                ->assertVisible('@files-button')
                ->click('@files-button')
                ->waitUntilMissing('.vld-overlay', 15)
                ->assertSeeIn('@file-title', $data['title'])
                ->assertSeeIn('@file-extension', $extension)
                ->assertSeeIn('@file-size', $size)
                ->assertSeeIn('@file-uploader', 'gallanonim')
                ->assertSeeIn('@file-downloads', '0')
                ->assertSeeIn('@file-description', $data['description']);
        });
        $this->deleteTestMod();
    }

    private function deleteTestMod()
    {
        $lastMod = Modification::where('creator', '=', 1)->latest()->first();
        $lastMod->delete();
    }
}
