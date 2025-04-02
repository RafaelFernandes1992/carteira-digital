<?php

namespace App\Traits;

use App\Exceptions\UnauthorizedScopeException;
use Illuminate\Support\Facades\Auth;

trait ValidateScopeTrait
{
    public function validateScope(string $modelUserId, $message = null)
    {
        if (!$message) {
            $message = 'Recurso não pertence ao usuário autenticado';
        }

        $user = Auth::user();

        if ($user->id != $modelUserId) {
            return throw new UnauthorizedScopeException($message);
        }
    }
}