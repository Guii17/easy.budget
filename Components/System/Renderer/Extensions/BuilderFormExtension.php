<?php

namespace Components\System\Renderer\Extensions;


use Twig_Extension;

class BuilderFormExtension extends Twig_Extension
{

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction(
                'form_start', array($this, 'form_start'), [
                'is_safe' => ['html']
                ]
            ),

            new \Twig_SimpleFunction(
                'form_errors', [$this, 'form_errors'], [
                'is_safe' => ['html']
                ]
            ),

            new \Twig_SimpleFunction(
                'form_row', [$this, 'form_row'], [
                'is_safe' => ['html']
                ]
            ),

            new \Twig_SimpleFunction(
                'form_element', [$this, 'form_element'], [
                'is_safe' => ['html']
                ]
            ),

            new \Twig_SimpleFunction(
                'form_end', [$this, 'form_end'], [
                'is_safe' => ['html']
                ]
            ),
        ];
    }

    public function form_start(?array $options = [])
    {
        $view = '<form ';
        if (!empty($options['action'])) {
            $view .= 'action="'.$options['action'].'"';
        }
        if (!empty($options['method'])) {
            $view .= 'method="'.$options['method'].'"';
        }
        if (!empty($options['enctype'])) {
            $view .= 'enctype="'.$options['enctype'].'"';
        }
        if (!empty($options['class'])) {
            $view .= 'class="' . $options['class'] . '"';
        }
        $view .= '>';
        return $view;
    }

    public function form_row(?array $arrayLabel = [], ?array $arrayField = [])
    {
        if (isset($arrayLabel)) {
            $label = "<label for=\"{$arrayLabel['name']}\">{$arrayLabel['content']}</label>";
        }
        switch ($arrayField['field']) {
        case 'input':
            $input = $this->formElement($arrayField['field'], $arrayField['type'], $arrayField['name'], $arrayField['id'], $arrayField['value'], $arrayField['placeholder'], $arrayField['class']);
        case 'textarea':
            //$input = $this->formElement($arrayField['field']);
        }

        return "
            <div class=\"_fieldTop\">{$label}{$input}</div>
        ";
    }

    public function form_end()
    {
        return '</form>';
    }

    private function formElement($field, $type, $name, $id, $value, $placeholder, $class)
    {
        $input = '';

        switch ($field) {
        case 'input':
            $input = "<input type=\"{$type}\" name=\"{$name}\" id=\"{$id}\" placeholder=\"{$placeholder}\" value=\"{$value}\" class=\"{$class}\" />";
        }
        return $input;
    }

}
