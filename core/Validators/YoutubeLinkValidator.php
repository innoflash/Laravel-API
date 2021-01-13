<?php

namespace Core\Validators;

class YoutubeLinkValidator extends SocialLinkValidator
{

    function getLinkDomain(): string
    {
        return 'youtube.com';
    }
}
