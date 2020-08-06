<?php

namespace ArtemiyKudin\log\Controllers;

use ArtemiyKudin\log\Traits\LogService;
use Illuminate\Http\Request;

class LogApiController extends ApiController
{
    use LogService;

    public function index(Request $request): object
    {
        $logs = $this->getLogs($request, $this->profile->profileID);

        return $this->json($logs, self::HTTP_OK);
    }

    public function filters(): object
    {
        $types = $this->getTypes();
        $employees = $this->getEmployees($this->profile);

        return $this->json([
            'types' => $types,
            'employees' => $employees
        ], self::HTTP_OK);
    }
}
