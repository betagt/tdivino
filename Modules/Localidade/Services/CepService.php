<?php

namespace Modules\Localidade\Services;


use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Repositories\EstadoRepository;
use Modules\Localidade\Repositories\LocalidadeRepository;
use Portal\Services\CacheService;
use Portal\Services\UtilService;

class CepService
{

    /**
     * @var CidadeRepository
     */
    private $cidadeRepository;
    /**
     * @var EstadoRepository
     */
    private $estadoRepository;
    /**
     * @var LocalidadeRepository
     */
    private $localidadeRepository;
    /**
     * @var UtilService
     */
    private $utilService;
    /**
     * @var CacheService
     */
    private $cacheService;
    /**
     * @var GeoService
     */
    private $geoService;

    public function __construct(
        CidadeRepository $cidadeRepository,
        EstadoRepository $estadoRepository,
        LocalidadeRepository $localidadeRepository,
        GeoService $geoService,
        UtilService $utilService,
        CacheService $cacheService)
    {

        $this->cidadeRepository = $cidadeRepository;
        $this->estadoRepository = $estadoRepository;
        $this->localidadeRepository = $localidadeRepository;
        $this->utilService = $utilService;
        $this->cacheService = $cacheService;
        $this->geoService = $geoService;
    }

    public function requestCep($cep, $defaultValidate = false)
    {
        $localidade = $this->localidadeRepository->pesquisarByCep($cep);
        if(!is_null($localidade)){
            return $localidade;
        }

        $urlUri = 'https://viacep.com.br/ws/' . $cep . '/json/';
        $string = $this->utilService->curlFunctionProxy($urlUri);

        $json_file = json_decode($string, true);
        $json_file = (is_null($json_file))?[]:$json_file;

        if($defaultValidate && (array_key_exists('erro', $json_file) || empty($json_file))){
            $urlUri = 'https://viacep.com.br/ws/77020556/json/';
            $string = $this->utilService->curlFunctionProxy($urlUri);

            $json_file = json_decode($string, true);
        }else{
            if(is_null($json_file)){
                throw new \Exception('CEP Inválido');
            }
            if(array_key_exists('erro', $json_file)) {
                throw new \Exception('CEP Inválido');
            }
        }

        $estado = $this->estadoRepository->skipPresenter(false)->findWhere([
            ['uf', 'ilike', $json_file['uf']]
        ])->first();
        try{
            \DB::beginTransaction();
            $cidade = $this->cidadeRepository->skipPresenter(false)->findWhere([
                ['estado_id', '=', $estado->id],
                ['titulo', 'ilike', $json_file['localidade']]
            ])->first();
            if (is_null($cidade)) {
                $cidade = $this->cidadeRepository->skipPresenter(true)->create([
                    'titulo'=>$json_file['localidade'],
                    'estado_id'=>$estado->id,
                    'capital'=>false,
                ]);
            }
            $localidade = $this->localidadeRepository->create([
                'cep' => $cep,
                'estado_id' => $estado->id,
                'cidade_id' => $cidade->id,
                'logradouro' => $json_file['logradouro']
            ]);
            \DB::commit();
            return $localidade;
        }catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }

    public function requestCepByGeoLocation($lat, $lon)
    {
        /*$localidade = $this->localidadeRepository->pesquisarByCep($cep);
        if(!is_null($localidade)){
            return $localidade;
        }*/

        $urlUri = "http://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lon&format=json";
        $string = $this->utilService->curlFunctionProxy($urlUri);
        $json_file = json_decode($string, true);
        if(array_key_exists('error', $json_file)) {
            throw new \Exception('CEP Inválido');
        }

        $estado = $this->estadoRepository->skipPresenter(false)->findWhere([
            ['uf', 'ilike', $json_file['address']['state']]
        ])->first();

        try{
            \DB::beginTransaction();
            $cidade = $this->cidadeRepository->skipPresenter(false)->findWhere([
                ['estado_id', '=', $estado->id],
                ['titulo', 'ilike', $json_file['address']['city']]
            ])->first();
            if (is_null($cidade)) {
                $cidade = $this->cidadeRepository->skipPresenter(true)->create([
                    'titulo'=>$json_file['address']['city'],
                    'estado_id'=>$estado->id,
                    'capital'=>false,
                ]);
            }
            $localidade = $this->localidadeRepository->create([
                'cep' => $cep,
                'estado_id' => $estado->id,
                'cidade_id' => $cidade->id,
            ]);
            \DB::commit();
            return $localidade;
        }catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }



    }

    public function requestIp(){
        //$ip = $_SERVER["REMOTE_ADDR"];
        $ip = "181.222.178.20";
        $urlUri = "http://ip-api.com/json/$ip";
        if($this->cacheService->has($ip)){
            return $this->cacheService->get($ip);
        }
        $location = json_decode($this->utilService->curlFunctionProxy($urlUri), true);
        $this->cacheService->put($ip, $location,1440);
        return $location;
    }


}