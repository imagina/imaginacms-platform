<?php

namespace Modules\Icheckin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icheckin\Entities\Shift;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class CanCheckout extends BaseApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct()
    {
    }

    public function handle(Request $request, Closure $next)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            if (isset($params->permissions['icheckin.shifts.edit']) && $params->permissions['icheckin.shifts.edit']) {
                return $next($request);
            } else {
                $shift = Shift::find($request->criteria);
                if (! $shift) {
                    return response('Invalid Shift id', 404);
                }

                if ($shift->checkin_by != $params->user->id) {
                    return response('You can\'t do check out in a shift of another agent', 401);
                }

                return $next($request);
            }
        } catch (\Exception $error) {
            $response = ['errors' => 'Bad Request'];

            return response($response, Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
