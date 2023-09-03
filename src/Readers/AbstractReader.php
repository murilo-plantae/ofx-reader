<?php

namespace OfxReader\Readers;

use DateTime;
use DateTimeZone;
use SimpleXMLElement;

abstract class AbstractReader implements ReaderContract
{
    protected SimpleXMLElement $data;

    public function __construct(SimpleXMLElement $data)
    {
        $this->data = $data;
    }

    protected function parseTimeStampIntoDateTime(string $timestamp): DateTime
    {
        $timezone = null;
        $timezoneRegex = '/\[(.*?)\]/';
        preg_match($timezoneRegex, $timestamp, $matches);

        if (!empty($matches[1])) {
            $matches[1] = strstr($matches[1], ':', true);
            $timezone = new DateTimeZone(str_pad($matches[1], 2, '0'));
        }
        
        return new DateTime($this->removeTimeZoneFromTimeStamp($timestamp), $timezone);
    }

    protected function removeTimeZoneFromTimeStamp(string $timestamp): string
    {
        return substr($timestamp, 0, 8);
    }
}