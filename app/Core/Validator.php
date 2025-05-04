<?php
namespace App\Core;

class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        foreach($rules as $field => $ruleSet) {
            $value = trim($data[$field] ?? null);

            foreach($ruleSet as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $this->errors[$field][] = "O campo {$field} é obrigatório.";
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int) explode(':', $rule)[1];
                    if(strlen($value) < $min) {
                        $this->errors[$field][] = "O campo {$field} deve ter no mínimo {$min} caracteres";
                    }
                }

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "O campo {$field} deve ser um e-mail válido";
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): ?array
    {
        return $this->errors;
    }
}
?>