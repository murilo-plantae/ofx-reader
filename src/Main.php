<?php

namespace OfxReader;

use Exception;
use OfxReader\Readers\BankReader;

class Main
{
    /**
     * Read OFXFile and parse it to an associative array.
     * 
     * @return array
     * @throws Exception - On error
     */
    public static function readFile(string $fileLocation): array
    {
        $handle = fopen($fileLocation, 'r');

        if (!$handle)
            throw new Exception('Couldn\'t find the file.');

        $contents = fread($handle, filesize($fileLocation));

        fclose($handle);

        if (!$contents)
            throw new Exception('Couldn\'t read the file.');

        return self::read($contents);
    }

    public static function readString(string $contents): array
    {
        return self::read($contents);
    }

    protected static function read($contents): array
    {
        // Filter the content to be only the OFX tag and inside content.
        $handleOnlyOfx = strstr($contents, '<OFX>');

        // Remove all line breaks
        $handleOnlyOfx = trim(preg_replace('/\s\s+/', ' ', $handleOnlyOfx));

        $xmlOfx = simplexml_load_string($handleOnlyOfx);

        if (!$xmlOfx)
            throw new Exception('Couldn\'t parse the file with SimpleXML');

        return (new BankReader($xmlOfx))->read();
    }
}