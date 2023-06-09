<?php

namespace Modules\Isite\Traits;

use Illuminate\Support\Str;
use Modules\Isite\Entities\Tokenable as Token;

trait Tokenable
{
    public function generateToken($expiresAt = null, $usesToken = 0)
    {
        $expiresAt = $expiresAt ?? setting('isite::timeExpiredToken');
        $today = date('Y-m-d h:i:s');
        $expiresAt = date('Y-m-d h:i:s', strtotime($today.'+ '.$expiresAt.' days'));
        $token = Str::random(32);

        //Clear tokens
        $this->clearTokens();

        //Create and return the token
        return Token::create([
            'token' => $token,
            'expires_at' => $expiresAt,
            'entity_id' => $this->id,
            'entity_type' => $this->entity,
            'uses' => $usesToken,
            'used' => 0,
        ]);
    }

    public function validateToken($token, $selfThrow = false)
    {
        $today = date('Y-m-d h:i:s');
        //Search the token
        $token = Token::where('token', $token)
          ->where('expires_at', '>=', $today)
          ->where(function ($query) {
              $query->where('uses', 0)
                ->orWhereRaw('used < uses');
          })->first();

        //If exist the token
        if (isset($token->id)) {
            //Validate if token expires

            if ($token->uses >= 1) {
                $token->used++;
                $token->save();
            }

            //Clear all tokens expired
            $this->clearTokens();

            return true;
        } else {
            if ($selfThrow) {
                throw new \Exception(trans('isite::common.messages.tokensValidate'), 403);
            }

            return false;
        }
    }

    /** Delete token by token column */
    public function clearTokens()
    {
        $today = date('Y-m-d h:i:s');
        Token::whereDate('expires_at', '<', $today)->orWhere(
            function ($query) {
                $query->where('uses', '>', 0)
                  ->whereRaw('used >= uses');
            }
        )->delete();
    }
}
