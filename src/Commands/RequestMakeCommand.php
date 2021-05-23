<?php

namespace IgnitionWolf\API\Modules\Commands;

use Nwidart\Modules\Commands\RequestMakeCommand as OriginalRequestMakeCommand;
use IgnitionWolf\API\Http\Requests\CreateEntityRequest;
use IgnitionWolf\API\Http\Requests\DeleteEntityRequest;
use IgnitionWolf\API\Http\Requests\UpdateEntityRequest;
use IgnitionWolf\API\Http\Requests\ListEntityRequest;
use IgnitionWolf\API\Http\Requests\ReadEntityRequest;
use IgnitionWolf\API\Http\Requests\EntityRequest;
use IgnitionWolf\API\Support\Stub;
use Exception;

class RequestMakeCommand extends OriginalRequestMakeCommand
{
    protected static array $requests = [
        'create' => CreateEntityRequest::class,
        'update' => UpdateEntityRequest::class,
        'delete' => DeleteEntityRequest::class,
        'read' => ReadEntityRequest::class,
        'list' => ListEntityRequest::class
    ];

    protected Stub $stub;

    public function __construct(Stub $stub)
    {
        parent::__construct();
        $this->stub = $stub->setBasePath(__DIR__ . '/stubs');
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        $name = $this->argument('name');

        $replace = [
            '$NAMESPACE$' => $this->getClassNamespace($module),
            '$CLASS$'     => $this->getClass(),
            '$PARENT_CLASS_NAMESPACE$' => EntityRequest::class,
            '$PARENT_CLASS$' => 'EntityRequest'
        ];

        foreach (static::$requests as $keyword => $class) {
            if (strpos(strtolower($name), $keyword) !== false) {
                $replace['$PARENT_CLASS_NAMESPACE$'] = $class;
                $replace['$PARENT_CLASS$'] = substr($class, strrpos($class, '\\') + 1);
            }
        }

        return $this->stub->render(
            $replace['$PARENT_CLASS$'] === 'EntityRequest' ? 'request.stub' : 'request-api.stub',
            $replace
        );
    }
}
