<?php
return [
    'enabled' => true,
    'middleware'=>'web',
    'width'=>250,
    'rules' => [
        \Fazanis\LaravelAntibot\Rules\IsBotBlockRules::class,
        \Fazanis\LaravelAntibot\Rules\IsNotUserAgentRules::class,
        \Fazanis\LaravelAntibot\Rules\IsNotReferRules::class,
        \Fazanis\LaravelAntibot\Rules\IsBotRules::class,
        \Fazanis\LaravelAntibot\Rules\IsCaptchaPassedRules::class,
    ]
];
