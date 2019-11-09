<?php

namespace Zxdstyle\Count\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Zxdstle\Count\ServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiexing:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install xiexing and publish the required assets and configurations.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Publishing assets and congigurations..');
        $this->call('vendor:publish', [
            '--tag' => ['xiexing_assets', 'xiexing_config', 'xiexing_views']
        ]);

        $this->line('Dumping the autoloaded files and reloading all new files.. ');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        $process->setTimeout(null);
        $process->setWorkingDirectory(base_path())->run();

        $this->info('successfully installed! Enjoy 😍');
        $this->info('Visit in your browser 👻');
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }
}
