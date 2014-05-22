<?php

/**
 * Class AssociationMc_Route_Prefix_View
 */
class AssociationMc_Route_Prefix_View implements XenForo_Route_Interface {

    /**
     * Handles routing for view page.
     **/
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router) {
        return $router->getRouteMatch('AssociationMc_ControllerPublic_View', $routePath, 'association');
    }
}