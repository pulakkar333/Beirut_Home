<?php

namespace Botble\RealEstate\Http\Controllers\Chunk\Projects;

use Botble\RealEstate\Http\Controllers\Chunk\ChunkController;
use Botble\RealEstate\Http\Requests\ChunkFileRequest;
use Botble\RealEstate\Services\ImportProjectService;
use Exception;
use Illuminate\Support\Facades\File;

class ChunkImportController extends ChunkController
{
    public function __invoke(ChunkFileRequest $request, ImportProjectService $service)
    {
        try {
            $filePath = $this->getFilePath($request->input('file'), 'app/project-import');

        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }

        $offset = $request->integer('offset');
        $limit = $request->integer('limit', 10);
        $rows = $this->getLocationRows($filePath, $offset, $limit);
        $rowsCount = count($rows);
        $total = $offset + $rowsCount;

        if ($rowsCount <= 0) {
            File::delete($filePath);

            return $this
                ->httpResponse()
                ->setMessage(trans('plugins/real-estate::import.imported_successfully'))
                ->setData([
                    'total_message' => trans('plugins/real-estate::import.total_rows', [
                        'total' => number_format($total),
                    ]),
                ]);
        }

        $service->setUpdateExisting($request->boolean('update_existing'))->handle($rows);

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/real-estate::import.importing_message', [
                'from' => number_format($offset),
                'to' => number_format($offset + count($rows)),
            ]))
            ->setData([
                'offset' => $total,
                'count' => $rowsCount,
            ]);
    }
}
