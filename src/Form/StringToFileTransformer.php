<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileTransformer implements DataTransformerInterface
{

    public function transform($value)
    {
        if ($value instanceof File) {
            return $value->getPathname();
        }

        return null;
    }

    public function reverseTransform($value)
    {
        if ($value instanceof File) {
            return $value;
        }

        return new File($value);
    }
}