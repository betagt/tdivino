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
}
