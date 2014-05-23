<?php

/**
 * Class AssociationMc_Route_Prefix_View
 */
class AssociationMc_Route_Prefix_View implements XenForo_Route_Interface {

    /**
     * Handles routing for view page.
     **/
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router) {
        $action = $router->resolveActionWithStringParam($routePath, $request, 'string_id');
        $actions = explode('/', $action);
        switch ($actions[0]) {
            case 'confirm':
                $controller = "Confirm";
                break;
            case 'delete':
                $controller = "Delete";
                break;
            case 'view':
            default:
                $controller = 'View';
        }
        return $router->getRouteMatch('AssociationMc_ControllerPublic_' . $controller, $routePath, 'view');
    }
}