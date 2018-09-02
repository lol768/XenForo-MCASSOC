<?php

/**
 * Class AssociationMc_Route_Prefix_View
 */
class AssociationMc_Route_Prefix_View implements XenForo_Route_Interface {

    /**
     * Handles routing for view page.
     **/
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router) {
        // Many thanks to Jaxel for his documentation on this (http://xenforo.com/community/threads/13605/)
        $components = explode('/', $routePath);
        $subPrefix = strtolower(array_shift($components));
        $subSplits = explode('.', $subPrefix);
        $slice = false;
        switch ($subPrefix) {
            case 'confirm':
                $controller = "Confirm";
                break;
            case 'delete':
                $controller = "Delete";
                break;
            case 'api':
                $controller = "Api";
                break;
            case "visibility":
                $controller = "VisibilityManagement";
                break;
            case "search":
                $controller = "Search";
                break;
            case 'view':
            default:
                $controller = 'View';
        }
        $routePathAction = ($slice ? implode('/', array_slice($components, 0, 2)) : $routePath).'/';
        $routePathAction = str_replace('//', '/', $routePathAction);

        $action = $router->resolveActionWithStringParam($routePathAction, $request, "string_id");
        return $router->getRouteMatch('AssociationMc_ControllerPublic_' . $controller, $action, 'view');
    }
}
