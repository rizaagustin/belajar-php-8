<?php
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS)]
class notBlank
{

}
#[Attribute(Attribute::TARGET_PROPERTY)]
class Length
{
    public int $min;
    public int $max;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
}

class LoginRequest
{
    #[Length(min: 4,max: 10)]
    #[NotBlank]
    // ? agar bisa null
    var ?string $username;

    #[Length(min: 8,max: 10)]
    #[NotBlank]
    var ?string $password;
}

function validate(object $object): void
{
    $class = new reflectionClass($object);
    $properties = $class->getProperties();
    foreach ($properties as $property){
        validateNotBlank($property, $object);
        validateLength($property, $object);
    }
}

function validateNotBlank(ReflectionProperty $property, object $object): void
{
    $attributes =  $property->getAttributes(notBlank::class);
    if(count($attributes) > 0)
    {
        if (!$property->isInitialized($object))
            throw new Exception("Property $property->name is null");
        if ($property->getValue($object) == null)
            throw new Exception("Property $property->name is null");
    }
}

function validateLength(ReflectionProperty $property, object $object): void
{
    if (!$property->isInitialized($object) || $property->getValue($object) == null){
        return;
    }

    $value = $property->getValue($object);
    $attributes = $property->getAttributes(Length:: class);
    foreach ($attributes as $attribute){
        $length = $attribute->newInstance();
        $valueLength = strlen($value);
        if ($valueLength < $length->min)
            throw new Exception("Property $property->name is too short");
        if ($valueLength > $length->max)
            throw new Exception("Property $property->name is too long");
    }
}

$request = new LoginRequest();
$request->username = "Riza";
$request->password = "tes2222222";
//$request->password = "tes";
validate($request);