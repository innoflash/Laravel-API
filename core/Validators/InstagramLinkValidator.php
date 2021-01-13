<?php

namespace Core\Validators;

class InstagramLinkValidator extends SocialLinkValidator
{

    function getLinkDomain(): string
    {
        return 'instagram.com';
    }
}
