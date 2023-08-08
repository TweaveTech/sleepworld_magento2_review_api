<?php

namespace Tweave\ReviewApi\Plugin;

use Magento\Framework\Exception\AuthorizationException;

class RequestValidatorPlugin
{
    public function aroundValidate(
        \Magento\Webapi\Controller\Rest\RequestValidator $subject,
        callable $proceed
    ) {
        try {
            $proceed();
        } catch (AuthorizationException $e) {
            throw new AuthorizationException(
                new \Magento\Framework\Phrase('Access denied!')
            );
        }
    }
}
