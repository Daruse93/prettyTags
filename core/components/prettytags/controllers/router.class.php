<?php

require_once MODX_CORE_PATH . 'components/prettytags/vendor/nikic/fast-route/src/bootstrap.php';

class PrettyTagsRouter
{
    const PRETTY_TAGS_ROUTER = 'PrettyTagsRouter';
    const EVENT = 'OnPageNotFound';

    /**
     * @var modX
     */
    protected $modx;
    /**
     * Path to routes cache file
     *
     * @var string
     */
    protected $cacheFile;
    /**
     * @var string
     */
    protected $paramsKey;
    /**
     * @var FastRoute\Dispatcher\GroupCountBased
     */
    protected $dispatcher;

    /**
     * PrettyTagsRouter constructor
     *
     * @param modX $modx
     */
    public function __construct(modX $modx)
    {
        $this->modx = $modx;
        $this->cacheFile = $modx->getOption(xPDO::OPT_CACHE_PATH) . static::PRETTY_TAGS_ROUTER . '.cache.php';
        $this->paramsKey = $modx->getOption(static::PRETTY_TAGS_ROUTER . '.paramsKey', null, static::PRETTY_TAGS_ROUTER);

        $this->registerDispatcher();
    }

    /**
     * Dispatch request
     *
     * @return null
     */
    public function dispatch()
    {
        $dispatcher = $this->getDispatcher();

        $params = $dispatcher->dispatch($this->getMethod(), $this->getUri());

        switch ($params[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                return $this->error();

            case FastRoute\Dispatcher::FOUND:
                return $this->handle($params[1], $params[2]);
        }

        return null;
    }

    /**
     * Clear routes cache
     *
     * @return void
     */
    public function clearCache()
    {
        if (file_exists($this->cacheFile)) {
            unlink($this->cacheFile);
        }
    }

    /**
     * @return bool
     */
    public function needDispatch()
    {
        $event = $this->modx->event;

        return static::EVENT === $event->name && !isset($event->params['stop']);
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Get request URI
     *
     * @return string
     */
    public function getUri()
    {
        $alias = $this->modx->getOption('request_alias', null, 'q');

        $uri = isset($_REQUEST[$alias]) && is_scalar($_REQUEST[$alias]) ? (string) $_REQUEST[$alias] : '';

        return '/' . ltrim($uri, '/');
    }

    /**
     * Get routes dispatcher
     *
     * @return FastRoute\Dispatcher|FastRoute\Dispatcher\GroupCountBased
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Register routes
     *
     * @param FastRoute\RouteCollector $router
     *
     * @return void
     */
    protected function getRoutes(FastRoute\RouteCollector $router)
    {
        $resourceId = $this->modx->getOption('prettytags_resource_id');

        if($resourceId){
            $resourceAlias = $this->modx->getObject('modResource', $resourceId)->get('alias');
            $router->addRoute('GET', '/'.$resourceAlias.'/{tag}', $resourceId);
        }
    }


    /**
     * Handle route
     *
     * @param integer|string $routeHandler
     * @param array $data
     *
     * @return null
     */
    protected function handle($routeHandler, array $data)
    {
        //
        // Send forward to resource
        //
        if (ctype_digit($routeHandler)) {
            $_REQUEST += [$this->paramsKey => $data];
            $this->modx->sendForward($routeHandler);

            return null;
        }

        // TODO: Refactor. Remove exit. What is the best way to do this?
        //
        // Call snippet
        //
        echo $this->modx->runSnippet($routeHandler, [
            $this->paramsKey => $data,
        ]);
        exit();
    }

    /**
     * Send error page
     *
     * @return null
     */
    protected function error()
    {
        $options = [
            'response_code' => $this->modx->getOption('error_page_header', null, 'HTTP/1.1 404 Not Found'),
            'error_type' => '404',
            'error_header' => $this->modx->getOption('error_page_header', null, 'HTTP/1.1 404 Not Found'),
            'error_pagetitle' => $this->modx->getOption('error_page_pagetitle', null, 'Error 404: Page not found'),
            'error_message' => $this->modx->getOption(
                'error_page_message',
                null,
                '<h1>Page not found</h1><p>The page you requested was not found.</p>'
            ),
        ];

        $this->modx->sendForward($this->modx->getOption('error_page', $options, '404'), $options);

        return null;
    }

    /**
     * Register router dispatcher
     *
     * @return void
     */
    protected function registerDispatcher()
    {
        $this->dispatcher = FastRoute\cachedDispatcher(function (FastRoute\RouteCollector $router) {
            $this->getRoutes($router);
        }, [
            'cacheFile' => $this->cacheFile,
        ]);
    }
}
