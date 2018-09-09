<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Modification;
use Illuminate\Http\Request;

class ModificationController extends Controller
{
    private function prepareModificationArray(Modification $modification, Request $request = null)
    {
        $modification->size = $modification->getModificationSizeName();
        $modification->development_status = $modification->getModificationDevStatus();
        if ($request !== null) {
            return [
                'mod' => $modification->toArray(),
                'path' => $request->getPathInfo()
            ];
        }
        return [
            'mod' => $modification->toArray(),
        ];
    }
    public function getModificationApi(Modification $mod)
    {
        return response()->json($this->prepareModificationArray($mod));
    }

    public function getModificationWeb(Modification $mod, Request $request)
    {
        return view('start', ['model' => $this->prepareModificationArray($mod, $request)]);
    }

    public function getModificationsInCategoryApi(Category $category)
    {
        return response()->json(($category->getModificationsInCategory())->toArray());
    }
}
