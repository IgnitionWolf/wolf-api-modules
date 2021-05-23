<?php

namespace IgnitionWolf\API\Modules\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Nwidart\Modules\Commands\GeneratorCommand;
use IgnitionWolf\API\Support\Stub;
use Illuminate\Support\Str;

class AutomapMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected Stub $stub;

    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-automap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new automap class for the specified module';

    public function __construct(Stub $stub)
    {
        parent::__construct();
        $this->stub = $stub->setBasePath(__DIR__ . '/stubs');
    }

    public function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return $this->stub->render('automap.stub', [
            '$NAMESPACE$' => $this->getClassNamespace($module),
            '$CLASS$' => $this->getClass(),
        ]);
    }

    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        return $path . 'Automap/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    protected function getFileName()
    {
        return Str::studly($this->argument('name'));
    }

    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return
            $module->config('paths.generator.automap.namespace')
                ?: $module->config('paths.generator.automap.namespace', 'Automap');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the automap attribute. Should end with "Attribute".'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }
}
