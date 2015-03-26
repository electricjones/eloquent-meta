<?php namespace Phoenix\EloquentMeta;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;

class CreateMetaTableCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:metatable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration for new metadata tables.';

    /**
     * Create a new instance
     * @param Filesystem $filesystem
     */
    public function __construct(FileSystem $filesystem)
    {
        $this->fs = $filesystem;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $table_name = strtolower($this->argument('name'));
        $migration = "create_{$table_name}_table";

        // The template file is the migration that ships with the package
        $template_dir = __DIR__;
        $template_file = 'SchemaTemplate.php';
        $template_path = $template_dir . '/' . $template_file;

        // Make sure the template path exists
        if (! $this->fs->exists($template_path)) {
            return $this->error('Unable to find template: ' . $template_path);
        }

        // Set the Destination Directory
        $dest_dir = base_path() . '/database/migrations/';
        $dest_file = date("Y_m_d_His").'_'.$migration.'.php';
        $dest_path = $dest_dir . $dest_file;

        // Make Sure the Destination Directory exists
        if (!$this->fs->isDirectory($dest_dir)) {
            return $this->error('Unable to find destination directory: ' . $dest_dir);
        }

        // Read Template File
        $template = $this->fs->get($template_path);

        // Replace what is necessary
        $classname = 'Create'.studly_case(ucfirst($table_name)).'Table';

        $contents = str_replace("'__meta__'", "'".$table_name."'", $template);
        $contents = str_replace('SchemaTemplate', $classname, $contents);

        // Write new Migration to destination
        $this->fs->put($dest_path, $contents);

        // Dump-Autoload
//        $this->call('dump-autoload');

        $this->info($table_name . ' migration created. run "php artisan migrate" to create the table');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the metatable to be built.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
