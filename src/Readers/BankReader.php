<?php

namespace OfxReader\Readers;

class BankReader extends AbstractReader
{
    public function read(): array
    {
        $institutionInfo = $this->data->SIGNONMSGSRSV1;
        $bankData = $this->data->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKACCTFROM;

        return [
            'bankId' => (string) $bankData->BANKID,
            'branchId' => (string) $bankData->BRANCHID,
            'instituition' => (string) $institutionInfo->SONRS->FI->ORG,
            'account' => (new AccountReader($this->data))->read()
        ];
    }
}