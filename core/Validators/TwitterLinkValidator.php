<?php

namespace Core\Validators;

class TwitterLinkValidator extends SocialLinkValidator
{

    function getLinkDomain(): string
    {
        return 'twitter.com';
    }
}
