<?php

namespace OfxReader\Readers;

class TransferReader extends AbstractReader
{
    public function read(): array
    {
        $bankTranXML = $this->data->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKTRANLIST;

        $bankTran = [
            'startDate' => $this->parseTimeStampIntoDateTime((string) $bankTranXML->DTSTART),
            'endDate' => $this->parseTimeStampIntoDateTime((string) $bankTranXML->DTEND)
        ];

        foreach ($bankTranXML->STMTTRN as $transfer) {
            $bankTran['tranfers'][] = [
                'type' => (string) $transfer->TRNTYPE,
                'date' => $this->parseTimeStampIntoDateTime((string) $transfer->DTPOSTED),
                'value' => (float) $transfer->TRNAMT,
                'id' => (string) $transfer->FITID,
                'description' => (string) $transfer->MEMO
            ];
        }

        return $bankTran;
    }
}