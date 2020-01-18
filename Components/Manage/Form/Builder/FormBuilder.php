<?php

namespace Components\Manage\Form\Builder;

/**
 * Form builder.
 */
class FormBuilder
{
    private $entity;
    private $action;
    private $method;
    private $enctype;
    private $class;

    public function __construct($action, $method, $enctype, $class)
    {
        $this->action = $action;
        $this->method = $method;
        $this->enctype = $enctype;
        $this->class = $class;
    }
    public function addElement(Field $field): self
    {
        return $this->fields[] = $field;
    }

    public function generateForm()
    {
        // On génère le formulaire
        $view = '<form ';
        if (!empty($action)) {
            $view .= 'action"'.$action.'"';
        }
        if (!empty($method)) {
            $view .= 'method"'.$method.'"';
        }
        if (!empty($enctype)) {
            $view .= 'enctype"'.$enctype.'"';
        }
        if (!empty($class)) {
            $view .= 'class"'.$class.'"';
        }
        $view .= '>';
        foreach ($this->fields as $field) {
            $view .= $field->buildWidget();
        }
        $view .= '</form>';
        return $view;
    }

    /**
     * Get the value of entity
     */ 
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set the value of entity
     *
     * @return self
     */ 
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }
}
