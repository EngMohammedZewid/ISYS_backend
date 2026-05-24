<?php

namespace App\Common\Enums;

enum RouteName
{
    const OTP = 'api.otp';

    const OTP_RESEND = 'api.otp.resend';

    const LOGIN = 'api.login';

    const REGISTER = 'api.register';

    const RESET_PASSWORD = 'api.reset.password';

    const FORGET_PASSWORD = 'api.forget.password';

    const VERIFY = 'api.verify';

    const SEND_VERIFY_EMAIL = 'api.send.verify.email';

    const CONTACTUS = 'api.send.contact_us';

    const CUSTOM_LIST_SESSIONS = 'api.custom_list_sessions';

    const SESSION_USER = 'session.user';

    const ATTACH_USER_SESSION = 'enrole.user_session';

    const KNOWLEDGE_CATEGORIES_INDEX = 'knowledge_categories.index';

    const KNOWLEDGE_CATEGORIES_SHOW = 'knowledge_categories.show';
}
