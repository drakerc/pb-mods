<?php

namespace App\Services;

use App\Instruction;
use App\Modification;
use App\File;
use JasperPHP\JasperPHP;

/**
 * Created by PhpStorm.
 * User: drake
 * Date: 20.10.18
 * Time: 15:04
 */

class ReportingService
{
    /**
     * Generates a PDF Instruction file and returns its path
     *
     * @param Instruction $instruction
     * @param File $file
     * @param Modification $mod
     * @return string
     * @throws Exception
     */
    public function prepareFileInstruction(Instruction $instruction, File $file, Modification $mod)
    {
        setlocale(LC_ALL, 'pl_PL');
        putenv('LANG=pl_PL.UTF-8');

        $modFile = $file->modifications->where('id', '=', $mod->id)->first();

        $jsonContent = json_encode([
            'description' => $instruction->description,
            'download_link' => '<u><a href="' . route('ModificationView', ['mod' => $mod->id]) . '">dostępnej pod tym linkiem</a></u>',
            'author' => $instruction->author_id,
            'game' => $mod->getGameTitle(),
            'file' => $modFile->pivot->title,
            'mod' => $mod->title,
            'replaces' => $mod->replaces,
            'title' => $instruction->title,
            'version' => $mod->version,
            'date_created' => $file->created_at,
            'date_updated' => $file->updated_at,
            'downloads' => $file->downloads,
        ]);
        $dataFilePath = storage_path( 'app/jasper/' . $instruction->id . '_in.json');
        file_put_contents($dataFilePath, $jsonContent);

        $params = [
            'version' => $mod->version,
            'downloads' => $file->downloads,
        ];

        $pdfFilePath = storage_path('app/jasper/') . $instruction->id . '_readme';
        $jasper = new JasperPHP();

        $jasper->process(
            resource_path('jasper/file_instruction.jasper'),
            $pdfFilePath,
            ['pdf'],
            $params,
            ['driver' => 'json', 'json_query' => '""', 'data_file' => $dataFilePath], false)
            ->execute();

        unlink($dataFilePath);

        return $pdfFilePath . '.pdf';
    }
}