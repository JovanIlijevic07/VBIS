<?php

namespace app\core;

class Form
{
    public function value($params, $name)
    {
        if ($params != null && $params->{$name} != null) {
            return $params->{$name};
        }

        return "";
    }

    public function error($params, $name)
    {
        if ($params !== null && $params->errors) {
            foreach ($params->errors as $objectNum => $item) {
                if ($objectNum == $name) {
                    return "<div class='form-text text-danger'>$item[0]</div>";
                }
            }
        }
    }

    public function renderInput($params, $name, $label, $type, $placeholder)
    {
        $value = $this->value($params, $name);
        $error = $this->error($params, $name);

        $labelClass = "form-label";
        $inputClass = "form-control";
        $inputFirst = false;

        if ($type == "checkbox") {
            $labelClass = "form-check-label";
            $inputClass = "form-check-input";
            $inputFirst = true;
        }

        if ($inputFirst) {
            echo "<input class='$inputClass' type='$type' name='$name' placeholder='$placeholder' value='$value'>";
            echo "<label class='$labelClass ms-2'>$label</label>$error";
        } else {
            echo "<label class='$labelClass'>$label</label>";
            echo "<input class='$inputClass' type='$type' name='$name' placeholder='$placeholder' value='$value'>$error";
        }
    }
}