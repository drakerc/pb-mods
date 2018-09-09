<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    public function getModificationSizeName()
    {
        if ($this->size === 0) {
            return 'Niewielka, pojedyńcza modyfikacja';
        }
        if ($this->size === 1) {
            return 'Średniej wielkości modyfikacja';
        }
        return 'Duża, kompletna modyfikacja';
    }

    public function getModificationDevStatus()
    {
        if ($this->development_status === 0) {
            return 'Nierozpoczęty';
        }
        if ($this->development_status === 1) {
            return 'W trakcie tworzenia';
        }
        if ($this->development_status === 2) {
            return 'W trakcie testów';
        }
        if ($this->development_status === 3) {
            return 'Wydany';
        }
        return 'Wstrzymany';
    }
}
