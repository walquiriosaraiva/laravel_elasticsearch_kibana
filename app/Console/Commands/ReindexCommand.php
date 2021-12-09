<?php

namespace App\Console\Commands;

use App\Models\Livro;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to Elasticsearch';

    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');

        foreach (Livro::cursor() as $livro) {
            
            $this->elasticsearch->index([
                'index' => $livro->getSearchIndex(),
                'type' => $livro->getSearchType(),
                'id' => $livro->getKey(),
                'body' => $livro->toSearchArray()
            ]);            

            $this->output->write('.');
        }

        $this->output->writeln('');
        $this->info('Done!');
    }
}
