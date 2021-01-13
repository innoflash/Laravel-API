<?php

namespace Core\Validators;

class FacebookLinkValidator extends SocialLinkValidator
{

    function getLinkDomain(): string
    {
        return 'facebook.com';
    }
}
