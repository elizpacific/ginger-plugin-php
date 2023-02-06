<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfDiapasonException;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

trait SingleFieldTrait
{
    /**
     * @param $propertyName - This attribute will be used while parsing in toArray method as key
     * @param $value - This attribute will be used while parsing in toArray method as value
     * @return \GingerPluginSdk\Bases\BaseField
     */
    protected function createSimpleField($propertyName, $value): BaseField
    {
        $new_class = new class($propertyName) extends BaseField {
             public function __construct($propertyName)
            {
                parent::__construct($propertyName);
            }
        };
        $new_class->set($value);
        return $new_class;
    }

    protected function createEnumeratedField($propertyName, $value, $enum): ValidateFieldsInterface|BaseField
    {
        $new_class = new class($propertyName, $enum) extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

             public function __construct($propertyName, $enum)
            {
                $this->enum = $enum;
                parent::__construct($propertyName);
            }

            public function validate($value)
            {
                $this->validateEnum($value);
            }
        };
        $new_class->set($value);
        return $new_class;
    }

    protected function createFieldInDateTimeISO8601($propertyName, $value): ValidateFieldsInterface|BaseField
    {
        $new_class = new class($propertyName) extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

             public function __construct($propertyName)
            {
                $this->propertyName = $propertyName;
                parent::__construct($propertyName);
            }

            public function validate($value)
            {
                $income_date = \DateTime::createFromFormat("Y-m-d\TH:i:s.uO", $value);

                if (!$income_date) {
                    throw new OutOfPatternException(
                        $this->propertyName
                    );
                }
            }
        };
        $new_class->set($value);
        return $new_class;
    }

    protected function createFieldForTimePeriodISO8601($propertyName, $value): ValidateFieldsInterface|BaseField
    {
        $new_class = new class($propertyName) extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

             public function __construct($propertyName)
            {
                $this->propertyName = $propertyName;
                parent::__construct($propertyName);
            }

            public function validate($value)
            {
                try {
                    $income_date = new \DateInterval($value);
                } catch (\Exception $exception) {
                    throw new OutOfPatternException(
                        $this->propertyName
                    );
                }
            }
        };
        $new_class->set($value);
        return $new_class;
    }

    protected function createFieldWithDiapasonOfValues(string $propertyName, mixed $value, int $min, int $max = null): ValidateFieldsInterface|BaseField
    {
        $new_class = new class($propertyName, $value, $min, $max) extends BaseField implements ValidateFieldsInterface {
            use FieldsValidatorTrait;

            private int $min;
            private ?int $max;

             public function __construct($propertyName, $value, $min, $max)
            {
                $this->min = $min;
                $this->max = $max;
                parent::__construct($propertyName);
            }

            public function validate($value)
            {
                if ($value < $this->min) throw new OutOfDiapasonException($this->getPropertyName(), $value, $this->min);
                if ($this->max && $value > $this->max) throw new OutOfDiapasonException($this->getPropertyName(), $value, $this->min, $this->max);
            }
        };
        $new_class->set($value);
        return $new_class;
    }
}