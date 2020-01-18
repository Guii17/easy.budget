<?php

namespace Components\Manage\Form\Builder;

class Field
{
    protected $errorMessage;

    protected $label;

    protected $name;

    protected $value;
    
    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget();

    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @return self
     */ 
    public function setLabel($label): self
    {
        if (is_string($label)) {
            $this->label = $label;
            return $this;
        }
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return self
     */ 
    public function setName($name): self
    {
        if (is_string($name)) {
            $this->name = $name;
            return $this;
        }
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return self
     */ 
    public function setValue($value): self
    {
        if (is_string($value)) {
            $this->value = $value;
            return $this;
        }
    }
}
