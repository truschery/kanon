<?php

declare(strict_types=1);

namespace Truschery\Kanon;

class Json
{
    private const JSON_OPTIONS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    public static function canonicalize(mixed $data): string
    {
        return (new self)->encode($data);
    }

    private function encode(mixed $data): string
    {
        return match (true) {
            is_null($data)    => 'null',
            is_bool($data)    => $data ? 'true' : 'false',
            is_string($data)  => json_encode($data, self::JSON_OPTIONS),
            is_int($data)     => (string)$data,
            is_float($data)   => $this->formatFloat($data),
            is_array($data)   => $this->encodeArray($data),
            is_object($data)  => $this->encodeObject((array)$data),
            default           => throw new \Exception("Unsupported type"),
        };
    }

    private function encodeArray(array $array): string
    {
        if($array === []) return '[]';

        if (array_is_list($array)) {
            $items = array_map([$this, 'encode'], $array);
            return '[' . implode(',', $items) . ']';
        }

        return $this->encodeObject($array);
    }

    private function encodeObject(array $data): string
    {
        if(empty($data)) {
            return '{}';
        }

        $utf16Keys = [];
        foreach ($data as $k => $_) {
            $utf16Keys[(string)$k] = mb_convert_encoding((string)$k, 'UTF-16BE', 'UTF-8');
        }

        uksort($data, function ($a, $b) use ($utf16Keys) {
            return strcmp(
                $utf16Keys[(string) $a], $utf16Keys[(string) $b]
            );
        });

        $parts = [];
        foreach ($data as $key => $value) {
            $parts[] = json_encode((string)$key, self::JSON_OPTIONS) . ':' . $this->encode($value);
        }

        return '{' . implode(',', $parts) . '}';
    }

    private function formatFloat(float $value): string
    {
        if(is_nan($value) || is_infinite($value)) {
            return 'null';
        }

        if($value === 0.0){
            return '0';
        }

        $str = strtolower(json_encode($value));

        if(! str_contains($str, 'e')){
            return $str;
        }

        [$mantissa, $exponent] = explode('e', $str);

        if(str_contains($mantissa, '.')){
            $mantissa = rtrim($mantissa, '0');
            $mantissa = rtrim($mantissa, '.');
        }

        return $mantissa . 'e' . $exponent;
    }
}
