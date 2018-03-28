<?php

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function DummyFunction()
    {

    }

    if (!function_exists('mask')) {

        /**
         * say hello
         *
         * @param string $name
         * @return string
         */
        function mask($val, $mask)
        {
            $maskared = '';
            $k = 0;
            for ($i = 0; $i <= strlen($mask) - 1; $i++) {
                if ($mask[$i] == '#') {
                    if (isset($val[$k]))
                        $maskared .= $val[$k++];
                } else {
                    if (isset($mask[$i]))
                        $maskared .= $mask[$i];
                }
            }
            return $maskared;
        }
    }
    if (!function_exists('csv_load')) {

        /**
         * say hello
         *
         * @param string $csv_file_locationname
         * @param string $name
         * @return array
         */
        function csv_load($csv_file_location)
        {
            $rows   = array_map('str_getcsv', file($csv_file_location));
            $header = array_shift($rows);
            $csv    = array();
            foreach($rows as $row) {
                $csv[] = array_combine($header, $row);
            }
            return $csv;
        }
    }
	if (!function_exists('validate_date')) {
		function converter_data($date, $format = 'Y-m-d', $time = false)
		{
			if($time){
				$format = 'Y-m-d H:i:s';
			}
			$d = DateTime::createFromFormat($format, $date);
			return $d && $d->format($format) == $date;
		}
	}
    if (!function_exists('validar_cnpj')) {

        /**
         * say hello
         *
         * @param string $name
         * @return string
         */
        function validar_cnpj($cnpj)
        {
            $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
            // Valida tamanho
            if (strlen($cnpj) != 14)
                return false;
            // Valida primeiro dígito verificador
            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
            {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            $resto = $soma % 11;
            if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
                return false;
            // Valida segundo dígito verificador
            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
            {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            $resto = $soma % 11;
            return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
        }

    }

    if (!function_exists('validar_cpf')) {
        /**
         * say hello
         *
         * @param string $name
         * @return string
         */
        function validar_cpf($cpf)
        {
            $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
            $invalidos = array('00000000000',
                '11111111111',
                '22222222222',
                '33333333333',
                '44444444444',
                '55555555555',
                '66666666666',
                '77777777777',
                '88888888888',
                '99999999999');
            if (in_array($cpf, $invalidos)) {
                return false;
            }
            // Valida tamanho
            if (strlen($cpf) != 11)
                return false;
            // Calcula e confere primeiro dígito verificador
            for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
                $soma += $cpf{$i} * $j;
            $resto = $soma % 11;
            if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
                return false;
            // Calcula e confere segundo dígito verificador
            for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
                $soma += $cpf{$i} * $j;
            $resto = $soma % 11;
            return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
        }
    }
    if (!function_exists('checkProd')) {
        function checkProd(){
            return !env('PUSHER_PROD')?"dev.":null;
        }
    }
}
