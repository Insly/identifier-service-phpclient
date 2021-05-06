<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SETS, [
        SetList::PSR_12,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::CLEAN_CODE,
    ]);

    $parameters->set(Option::SKIP, []);

    $parameters->set(Option::PATHS, ["src"]);
};

