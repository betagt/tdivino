<?php

namespace Modules\Transporte\Console;

use Illuminate\Console\Command;
use Modules\Transporte\Repositories\DocumentoRepository;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ValidarDocumento extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'validar:documento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica com todos os documentos vencido.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire(DocumentoRepository $documentoRepository)
    {
        $documentoRepository->documentosVencidos();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
