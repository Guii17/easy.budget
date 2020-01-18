<?php

namespace Components\System\Renderer\Extensions;

/**
 * Série d'extensions concernant les textes.
 */
class FormBuilderExtension extends \Twig_Extension
{

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction(
                'formStart', [$this, 'formStart'], [
                'is_safe' => ['html']
                ]
            ),

            new \Twig_SimpleFunction(
                'formRow', [$this, 'formRow'], [
                'is_safe' => ['html']
                ]
            ),

            new \Twig_SimpleFunction(
                'formEnd', [$this, 'formEnd'], [
                'is_safe' => ['html']
                ]
            )
        ];

    }

    /**
     * @param  null|string $action
     * @param  null|string $method
     * @param  null|string $enctype
     * @param  null|string $class
     * @return string
     */
    public function formStart(?string $action, ?string $method, ?string $enctype, ?string $class)
    {
        $view = '<form ';
        if (!empty($action)) {
            $view .= ' action="'.$action.'"';
        }
        if (!empty($method)) {
            $view .=  'method="'.$method.'"';
        }
        if (!empty($enctype)) {
            $view .= ' enctype="'.$enctype.'"';
        }
        if (!empty($class)) {
            $view .= ' class="'.$class.'"';
        }
        $view .= '>';
        return $view;
    }

    /**
     * @param  array|null $label
     * @param  array|null $field
     * @return string|void
     */
    public function formRow(?array $label, ?array $field)
    {
        switch ($field['field']) {
        case 'input':
            if ($field['type'] === 'checkbox') {
                return $this->inputCheckbox($field['type'], $field['name'], $field['id'], $field['class']);
            } elseif($field['type'] === 'text') {
                return $this->inputText($label['name'], $label['content'], $field['type'], $field['name'], $field['id'], $field['value'], $field['placeholder'], $field['class']);
            } elseif($field['type'] === 'password') {
                return $this->inputPassword($label['name'], $label['content'], $field['type'], $field['name'], $field['id'], $field['value'], $field['placeholder'], $field['class']);
            } elseif($field['type'] === 'email') {
                return $this->inputEmail($label['name'], $label['content'], $field['type'], $field['name'], $field['id'], $field['value'], $field['placeholder'], $field['class']);
            } elseif($field['type'] === 'submit') {
                return $this->inputSubmit($label['name'], $label['content'], $field['type'], $field['name'], $field['id'], $field['value'], $field['placeholder'], $field['class']);
            }
        }
    }

    /**
     * @return string
     */
    public function formEnd()
    {
        return '</form>';
    }

    public function form_row(array $field)
    {

    }

    private function inputCheckbox($type, $name, $id, $class)
    {
    }

    /**
     * @param  null|string $labelName
     * @param  null|string $labelContent
     * @param  null|string $type
     * @param  null|string $name
     * @param  null|string $id
     * @param  null|string $value
     * @param  null|string $placeholder
     * @param  null|string $class
     * @return string
     */
    private function inputText(?string $labelName, ?string $labelContent, ?string $type, ?string $name, ?string $id, ?string $value, ?string $placeholder, ?string $class)
    {
        $label = "<label for=\"{$labelName}\">{$labelContent}</label>";
        $input = "<input type=\"{$type}\" name=\"{$name}\" id=\"{$id}\" value=\"{$value}\" placeholder=\"{$placeholder}\" class=\"{$class}\" />";
        return "<div class=\"_fieldTop\">{$label}{$input}</div>";
    }

    /**
     * @param  null|string $labelName
     * @param  null|string $labelContent
     * @param  null|string $type
     * @param  null|string $name
     * @param  null|string $id
     * @param  null|string $value
     * @param  null|string $placeholder
     * @param  null|string $class
     * @return string
     */
    private function inputPassword(?string $labelName, ?string $labelContent, ?string $type, ?string $name, ?string $id, ?string $value, ?string $placeholder, ?string $class)
    {
        $label = "<label for=\"{$labelName}\">{$labelContent}</label>";
        $input = "<input type=\"{$type}\" name=\"{$name}\" id=\"{$id}\" value=\"{$value}\" placeholder=\"{$placeholder}\" class=\"{$class}\" />";
        return "<div class=\"_fieldTop\">{$label}{$input}</div>";
    }

    /**
     * @param  null|string $labelName
     * @param  null|string $labelContent
     * @param  null|string $type
     * @param  null|string $name
     * @param  null|string $id
     * @param  null|string $value
     * @param  null|string $placeholder
     * @param  null|string $class
     * @return string
     */
    private function inputEmail(?string $labelName, ?string $labelContent, ?string $type, ?string $name, ?string $id, ?string $value, ?string $placeholder, ?string $class)
    {
        $label = "<label for=\"{$labelName}\">{$labelContent}</label>";
        $input = "<input type=\"{$type}\" name=\"{$name}\" id=\"{$id}\" value=\"{$value}\" placeholder=\"{$placeholder}\" class=\"{$class}\" />";
        return "<div class=\"_fieldTop\">{$label}{$input}</div>";
    }

    private function inputSubmit($name, $content, string $type, $name1, $id, $value, $placeholder, $class)
    {
        $input = "<input type=\"{$type}\" name=\"{$name}\" id=\"{$id}\" value=\"{$value}\" placeholder=\"{$placeholder}\" class=\"{$class}\" />";
        return "<div class=\"_fieldTop\">{$input}</div>";
    }


}