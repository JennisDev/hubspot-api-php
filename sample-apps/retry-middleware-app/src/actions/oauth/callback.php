<?php

use Helpers\OAuth2Helper;
use HubSpot\Factory;
use Repositories\TokensRepository;
use HubSpot\Client\Auth\OAuth\Model\TokenResponseIF;

// https://developers.hubspot.com/docs-beta/working-with-oauth
$token = Factory::create()->auth()->oAuth()->defaultApi()->createToken(
    'authorization_code',
    $_GET['code'],
    OAuth2Helper::getRedirectUri(),
    OAuth2Helper::getClientId(),
    OAuth2Helper::getClientSecret()
);

if ($token instanceof TokenResponseIF) {
    TokensRepository::save([
        'refresh_token' => $token->getRefreshToken(),
        'access_token' => $token->getAccessToken(),
        'expires_in' => $token->getExpiresIn(),
    ]);
}

header('Location: /');
