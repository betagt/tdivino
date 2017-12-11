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

		if(isset($doc['data_vigencia_inicial']) and !is_null($doc['data_vigencia_inicial']))
			$doc['data_vigencia_inicial'] = implode('-', array_reverse(explode('/', $doc['data_vigencia_inicial'])));

		if(isset($doc['data_vigencia_fim']) and !is_null($doc['data_vigencia_fim']))
			$doc['data_vigencia_fim'] = implode('-', array_reverse(explode('/', $doc['data_vigencia_fim'])));

		if(isset($doc['data_conclusao']) and !is_null($doc['data_conclusao']))
			$doc['data_conclusao'] = implode('-', array_reverse(explode('/', $doc['data_conclusao'])));

		if(isset($doc['data_emissao']) and !is_null($doc['data_emissao']))
			$doc['data_emissao'] = implode('-', array_reverse(explode('/', $doc['data_emissao'])));

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