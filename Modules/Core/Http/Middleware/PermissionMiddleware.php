<?php

namespace Modules\Core\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Modules\User\Contracts\Authentication;

class PermissionMiddleware
{
    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @var Route
     */
    private $route;

    public function __construct(Authentication $auth, Route $route)
    {
        $this->auth = $auth;
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $action = $this->route->getActionName();
        $actionMethod = substr($action, strpos($action, '@') + 1);

        $segmentPosition = $this->getSegmentPosition($request);
        $moduleName = $this->getModuleName($request, $segmentPosition);
        $entityName = $this->getEntityName($request, $segmentPosition);
        $permission = $this->getPermission($moduleName, $entityName, $actionMethod);

        if (! $this->auth->hasAccess($permission)) {
            return redirect()->back()->withError(trans('core::core.permission denied', ['permission' => $permission]));
        }

        return $next($request);
    }

    /**
     * Get the correct segment position based on the locale or not
     *
     * @return mixed
     */
    private function getSegmentPosition(Request $request)
    {
        $segmentPosition = config('laravellocalization.hideDefaultLocaleInURL', false) ? 3 : 4;

        if ($request->segment($segmentPosition) == config('asgard.core.core.admin-prefix')) {
            return ++$segmentPosition;
        }

        return $segmentPosition;
    }

    private function getPermission($moduleName, $entityName, $actionMethod): string
    {
        return ltrim($moduleName.'.'.$entityName.'.'.$actionMethod, '.');
    }

    protected function getModuleName(Request $request, $segmentPosition): string
    {
        return $request->segment($segmentPosition - 1);
    }

    protected function getEntityName(Request $request, $segmentPosition): string
    {
        $entityName = $request->segment($segmentPosition);

        return $entityName ?: 'dashboard';
    }
}
