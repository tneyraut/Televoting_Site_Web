<?php

class Dispatcher extends Object
{

    public static function dispatch(Request $request)
    {
        $controllerClassName = ucfirst($request->getControllerName()) . 'Controller';

        if(!class_exists($controllerClassName)) {
            throw new Exception("$controllerClassName does not exists.");
        }

        $controller = new $controllerClassName($request);
        return $controller;
    }

}