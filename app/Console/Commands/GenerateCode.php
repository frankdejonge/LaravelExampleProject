<?php

namespace App\Console\Commands;

use EventSauce\EventSourcing\CodeGeneration\CodeDumper;
use EventSauce\EventSourcing\CodeGeneration\DefinitionGroup;
use EventSauce\EventSourcing\CodeGeneration\YamlDefinitionLoader;
use function file_put_contents;
use Illuminate\Console\Command;
use function var_dump;

class GenerateCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventsauce:generate-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate EventSauce Code.';

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
    public function handle()
    {
        $definitionPath = (array) config('eventsauce.definition');
        $outputPath = config('eventsauce.output');
        $loader = new YamlDefinitionLoader();
        $definitionGroup = new DefinitionGroup();
        $dumper = new CodeDumper();

        foreach ($definitionPath as $path) {
            $definitionGroup = $loader->load($path, $definitionGroup);
        }

        file_put_contents($outputPath, $dumper->dump($definitionGroup));
        $this->output->writeln('Code generated!');
    }
}
