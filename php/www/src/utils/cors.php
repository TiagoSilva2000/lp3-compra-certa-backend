<?php
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Psr\Http\Server\MiddlewareInterface;
  use Psr\Http\Server\RequestHandlerInterface;
  use Slim\Routing\RouteContext;  


  final class CorsMiddleware implements MiddlewareInterface {
    public function process(
        Request $request, 
        RequestHandlerInterface $handler
    ): Response {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $response = $handler->handle($request);

        $response = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', implode(', ', $methods))
            ->withHeader('Access-Control-Allow-Headers', $requestHeaders ?: '*');
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
  }
  final class PreflightAction {
    public function __invoke(
        Request $request,
        Response $response
    ): Response {
        return $response;
    }
  }
?>