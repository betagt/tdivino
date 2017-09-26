<?php

namespace Modules\Localidade\Services;




use Portal\Services\UtilService;

class GeoService
{

    /**
     * @var UtilService
     */
    private $utilService;

    public function __construct(UtilService $utilService){
        $this->utilService = $utilService;
    }

    public function distanceCalculate($origens,$destinos){
        /*$cachePosition =  $this->geoPosition->skipPresenter(false)->getPosition($origens,$destinos);
        if($cachePosition){
            return $cachePosition;
        }*/

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origens&destinations=$destinos&mode=driving&language=pt-BR";
        $response_a = json_decode($this->utilService->curlFunction($url), true);
        if($response_a['rows'][0]['elements'][0]['status']=='ZERO_RESULTS'){
            abort(303,'Localização não encontrada');
        }
        $distanciaTotal = 0;
        foreach ($response_a['rows'] as $v => $item){
            foreach ($item['elements'] as $key=>$value){
                $distanciaTotal +=floatval(str_replace(',','.',str_replace(' km','',$value['distance']['text'])));
            }
        }
        $total = ($distanciaTotal*2)*0.75;
        /*return $this->geoPosition->create([
            'lat_log_origens'=>$origens,
            'lat_log_destinos'=>$destinos,
            'price' =>floatval($total)
        ]);*/
        return null;
    }

    public function getSinglePosition($cidade,$endereco,$estado){
        $address = urlencode($cidade.','.$endereco.','.$estado);
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Brazil";
        $response_a = json_decode($this->utilService->curlFunctionProxy($url));
        $status = $response_a->status;
        //dd('lat =>'.$response_a->results[0]->geometry->location->lat. ' long =>'.$response_a->results[0]->geometry->location->lng);
        if ( $status == 'ZERO_RESULTS' )
        {
            return FALSE;
        }
        else
        {
            $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
            return $return;
        }
    }



}