<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/01/2017
 * Time: 13:50
 */

namespace Modules\Transporte\Services;

use Modules\Transporte\Repositories\ServicoRepository;

class ServicoService
{
    /**
     * @var ServicoRepository
     */
    private $servicoRepository;

    public function __construct(ServicoRepository $servicoRepository)
    {
        $this->servicoRepository = $servicoRepository;
    }

    public function create($data){
        $servico = $this->servicoRepository->skipPresenter(true)->create($data);
        if (isset($data['tipo_documentos']) && is_array($data['tipo_documentos']))
            $servico->tipoDocumentos()->attach($data['tipo_documentos']);
        return $this->servicoRepository->skipPresenter(false)->find($servico->id);
    }

    public function update($data, $id){
        $servico = $this->servicoRepository->skipPresenter(true)->update($data, $id);
        if (isset($data['tipo_documentos']) && is_array($data['tipo_documentos']))
            $servico->tipoDocumentos()->sync($data['tipo_documentos']);
        return $this->servicoRepository->skipPresenter(false)->find($servico->id);
    }

}