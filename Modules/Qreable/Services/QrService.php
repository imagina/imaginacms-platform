<?php

namespace Modules\Qreable\Services;

use Modules\Qreable\Entities\Qr;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrService
{
    public function __construct()
    {
    }

    public function addQr($model, $redirect, $zone = null)
    {
        $entityClass = get_class($model);
        $qredRepository = app("Modules\Qreable\Repositories\QredRepository");
        $qReables = $qredRepository->getItemsBy(json_decode(json_encode(['filter' => ['qreableId' => $model->id, 'qreableType' => $entityClass, 'zone' => $zone]])));
        if ($qReables->isEmpty()) {
            $qr = new Qr(['code' => '']);
            $qr->save();
            if ($qr->qreables($entityClass)->get()->contains($model->id) === false) {
                $qr->qreables($entityClass)->attach($model, ['zone' => $zone, 'redirect' => $redirect]);
                $lastQreable = $qr->qreablesByZone($entityClass, $zone)->first();
                $qrCode = $this->generateQrCode(route('api.qreable.show', [$lastQreable->pivot->id]));
                $qr->update(['code' => $qrCode]);
            }
        }
    }

    public function generateQrCode($code)
    {
        $qrCode = QrCode::format('png')->size(256)->color(0, 0, 0)->generate($code);

        return 'data:image/png;base64,'.base64_encode($qrCode);
    }
}
