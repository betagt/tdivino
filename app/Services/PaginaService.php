<?php
namespace Portal\Services;

use Portal\Repositories\PaginaRepository;


/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 03/01/17
 * Time: 14:49
 */
class PaginaService
{

    /**
     * @var PaginaRepository
     */
    private $paginaRepository;

    public function __construct(PaginaRepository $paginaRepository)
    {

        $this->paginaRepository = $paginaRepository;
    }

    /**
     * @param $request
     * @return PaginaRepository
     */
    public function create($data){
        $data['slug'] = self::validateSlug($data['slug']);
        return $this->paginaRepository->create($data);
    }

    public function update($data, $id){
        $data['slug'] = self::validateSlug($data['slug']);
        return $this->paginaRepository->update($data, $id);
    }

    private static function validateSlug($str): string{
        return str_slug($str);
    }

}