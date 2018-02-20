<?php

namespace Modules\Transporte\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Modules\Transporte\Repositories\DocumentoRepository;

class ValidarDocuemento implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DocumentoRepository $documentoRepository)
    {
        $documentoRepository->documentosVencidos();
    }
}
