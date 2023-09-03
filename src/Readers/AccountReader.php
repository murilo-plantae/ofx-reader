<?php

namespace OfxReader\Readers;

class AccountReader extends AbstractReader
{
    public function read(): array
    {
        $accountInfoXML = $this->data->BANKMSGSRSV1->STMTTRNRS->STMTRS;

        return [
            'currency' => (string) $accountInfoXML->CURDEF,
            'id' => (string) $accountInfoXML->BANKACCTFROM->ACCTID,
            'type' => (string) $accountInfoXML->BANKACCTFROM->ACCTTYPE,
            'balance' => (float) $accountInfoXML->LEDGERBAL->BALAMT,
            'date' => $this->parseTimeStampIntoDateTime($accountInfoXML->LEDGERBAL->DTASOF),
            'transferList' => (new TransferReader($this->data))->read()
        ];
    }
}