<?php

namespace OfxReader\Readers;
use SimpleXMLElement;

interface ReaderContract
{
    public function __construct(SimpleXMLElement $data);
    public function read(): array;
}