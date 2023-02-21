<?php

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

require_once __DIR__ . '/../vendor/autoload_runtime.php';

return static function( array $context ) {
    return new class( $context[ 'APP_ENV' ], $context[ 'APP_DEBUG' ] ) extends Kernel {

        use MicroKernelTrait;

        public function registerBundles(): iterable
        {
            yield new FrameworkBundle();
        }

        public function configureContainer( ContainerConfigurator $configurator ): void
        {
            $configurator->extension( 'framework', [
                'secret' => '123456789'
            ] );
        }

        public function configureRoutes( RoutingConfigurator $configurator ): void
        {
            $configurator->add( 'app_home', '/{number}' )->controller( [ $this, 'homeAction' ] );
        }

        public function homeAction( int $number, Request $request ): Response
        {
            return new JsonResponse( [
                                         'success'        => true,
                                         'providedNumber' => $number
                                     ] );
        }
    };
};
