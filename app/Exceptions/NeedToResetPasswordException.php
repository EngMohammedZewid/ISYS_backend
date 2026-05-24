<?php

namespace App\Exceptions;

use App\Common\Enums\ErrorCode;
use App\Common\Enums\Message;
use App\Common\Response;
use Exception;

class NeedToResetPasswordException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return (new Response())->exception(Message::YOU_NEED_TO_RESET_YOUR_PASSWORD, 401, ErrorCode::RESET_YOUR_PASSWORD);
    }
}
