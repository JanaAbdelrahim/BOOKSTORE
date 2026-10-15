<?php

require_once __DIR__ . "/../core/Database.php";

class validation
{
    private array $errors = [];

    public function __construct(
        private array $data,
        private array $rules
    ) {}

    public function validate(): array
    {
        foreach ($this->rules as $field => $fieldRules) {
            $value = $this->data[$field] ?? null;

            foreach ($fieldRules as $rule) {

                [$ruleName, $ruleArg] = array_pad(explode(':', $rule, 2), 2, null);

                switch ($ruleName) {
                    case "required":
                        $this->validateRequired($field, $value);
                        break;

                    case "email":
                        $this->validateEmail($field, $value);
                        break;

                    case "EGPhone":
                        $this->validatePhone($field, $value);
                        break;

                    case "min":
                        $this->validateMin($field, $value, (int) ($ruleArg ?? 8));
                        break;

                    case "unique":
                        [$table, $column, $exceptId] = array_pad(explode(',', $ruleArg, 3), 3, null);
                        $this->validateUnique($field, $value, $table, $exceptId ? (int)$exceptId : null, $column);
                        break;

                    case "exists":
                        [$table, $column] = array_pad(explode(',', $ruleArg, 2), 2, null);
                        $this->validateExists($field, $value, $table, $column);
                        break;

                    case "in":

                        $allowed = explode(',', $ruleArg ?? '');
                        $this->validateIn($field, $value, $allowed);
                        break;

            
                }

                if (isset($this->errors[$field])) {
                    break;
                }
            }
        }

        return $this->errors;
    }

    private function validateRequired(string $field, mixed $value): void
    {
        if (trim((string)$value) === "" || $value === null) {
            $this->addError($field, "The {$field} is required");
        }
    }

    private function addError(string $field, mixed $msg): void
    {
        $this->errors[$field][] = $msg;
    }

    private function validateEmail(string $field, mixed $value): void
    {
        if (empty($value)) return;
        $regex = "/^[A-Za-z_][A-Za-z_0-9\.\-]+@(gmail|yahoo)\.(com|org)$/";
        if (!preg_match($regex, $value)) {
            $this->addError($field, "invalid {$field} (example@gmail.com)");
        }
    }

    private function validateMin(string $field, mixed $value, int $min = 8): void
    {
        if (empty($value)) return;
        if (strlen($value) < $min) {
            $this->addError($field, "{$field} must be at least {$min} characters or numbers");
        }
    }

    private function validateUnique(string $field, mixed $value, string $tableName, ?int $exceptId = null, ?string $column = null): void
    {
        if (empty($value)) return;
        $column = $column ?: $field;

        $DB = Database::getConnection();
        $sql = "SELECT id FROM {$tableName} WHERE {$column} = :value";
        $params = ['value' => $value];

        if ($exceptId !== null) {
            $sql .= " AND id != :id";
            $params['id'] = $exceptId;
        }

        $stmt = $DB->prepare($sql);
        $stmt->execute($params);

        if ($stmt->fetch()) {
            $this->addError($field, "{$field} already exists");
        }
    }


    private function validateExists(string $field, mixed $value, string $tableName, string $columnName): void
    {
        if (empty($value)) return;


        $DB = Database::getConnection();
        $stmt = $DB->prepare("SELECT id FROM {$tableName} WHERE {$columnName} = :value LIMIT 1");
        $stmt->execute(['value' => $value]);

        if (!$stmt->fetch()) {
            $this->addError($field, "{$field} does not exist");
        }
    }

    private function validatePhone(string $field, mixed $value): void
    {
        if (empty($value)) return;
        $regex = "/^(02)?01(2|1|5|0)[0-9]{8}$/";
        if (!preg_match($regex, $value)) {
            $this->addError($field, "Please enter {$field} valid EGPhone");
        }
    }

    private function validateIn(string $field, mixed $value, array $allowed): void
    {
        if (empty($value)) return;

        if (!in_array((string) $value, $allowed, true)) {
            $this->addError($field, "{$field} must be one of: " . implode(', ', $allowed));
        }
    }


}
