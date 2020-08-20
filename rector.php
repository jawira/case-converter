<?php declare(strict_types=1);

// Rector configuration file

use Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use Rector\Core\Configuration\Option;
use Rector\Order\Rector\ClassLike\OrderFirstLevelClassStatementsRector;
use Rector\Order\Rector\ClassLike\OrderMethodsByVisibilityRector;
use Rector\Order\Rector\ClassLike\OrderPrivateMethodsByUseRector;
use Rector\Order\Rector\ClassLike\OrderPropertiesByVisibilityRector;
use Rector\StrictCodeQuality\Rector\Stmt\VarInlineAnnotationToAssertRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(OrderFirstLevelClassStatementsRector::class);
    $services->set(OrderPropertiesByVisibilityRector::class);
    $services->set(OrderMethodsByVisibilityRector::class);
    $services->set(OrderPrivateMethodsByUseRector::class);
    $services->set(SimplifyEmptyArrayCheckRector::class);
    $services->set(VarInlineAnnotationToAssertRector::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PHP_VERSION_FEATURES, '7.1');
};
