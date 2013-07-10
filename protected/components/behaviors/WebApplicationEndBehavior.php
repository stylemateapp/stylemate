<?php

class WebApplicationEndBehavior extends CBehavior
{
    // name of needed part of site
    
    private $_endName;

    // getter $_endName;

    public function getEndName()
    {
        return $this->_endName;
    }

    // application run

    public function runEnd($name)
    {
        $this->_endName = $name;

        // event of module creation

        $this->onModuleCreate = array($this, 'changeModulePaths');
        $this->onModuleCreate(new CEvent ($this->owner));

        $this->owner->run();
    }

    // onModuleCreate event handler

    public function onModuleCreate($event)
    {
        $this->raiseEvent('onModuleCreate', $event);
    }

    // changing of file paths

    protected function changeModulePaths($event)
    {
        // adding parts (like 'frontend' and 'backend' to view path and controller path)

        $event->sender->controllerPath .= DIRECTORY_SEPARATOR . $this->_endName;
        $event->sender->viewPath .= DIRECTORY_SEPARATOR . $this->_endName;
    }
}