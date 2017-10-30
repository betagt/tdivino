<?php
/**
 * Created by PhpStorm.
 * User: DSOFT
 * Date: 29/10/2017
 * Time: 17:47
 */

namespace Modules\Transporte\Services;


use Modules\Core\Services\ImageUploadService;
use Modules\Transporte\Models\Documento;
use Modules\Transporte\Repositories\DocumentoRepository;

class DocumentoService
{

    /**
     * @var DocumentoRepository
     */
    private $documentoRepository;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;

    private $path;

    public function __construct(
        DocumentoRepository $documentoRepository,
        ImageUploadService $imageUploadService )
    {
        $this->documentoRepository = $documentoRepository;
        $this->imageUploadService = $imageUploadService;
        $this->path = public_path('arquivos/img/documento');
    }

    public function cadastrarDocumento($doc, \Illuminate\Database\Eloquent\Relations\MorphMany $documento, $path = null){
        if(is_null($path))
            $path = $this->path;
        if(!isset($doc['arquivos']))
            throw new \Exception('não existe a chave "arquivos" na requisição');
        $documento = $documento->create($doc);
        foreach ($doc['arquivos'] as $key=>$arquivo) {
            $aux['arquivo'] = $arquivo;
            $this->imageUploadService->upload64('arquivo', $path, $aux);
            $documento->arquivo()->create([
                'img' => $aux['arquivo'],
                'princial' => false,
                'prioridade' => $key + 1
            ]);
        }
    }

}