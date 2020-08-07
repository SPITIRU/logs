<?php

namespace ArtemiyKudin\log\Traits;

use ArtemiyKudin\log\Models\Log;
use ArtemiyKudin\log\Objects\Constants\LogsMessages;
use ArtemiyKudin\log\Objects\Constants\LogsTypes;
use Beauty\Modules\Common\Objects\Profile\Profile as Profiles;
use Carbon\Carbon;

trait LogService
{
    public function deleteLog(object $data, int $profileID): array
    {
        $model = resolve(Log::class)->find($data->logID);
        $model->delete();

        return $this->getLogs($data, $profileID);
    }

    public function getEmployees($profile): array
    {
        $employees = $profile->employees;

        $arrEmployees = [];
        if ($employees->count()) {
            foreach ($employees as $employee) {
                $arrEmployees[] = [
                    'value' => $employee->userID,
                    'text' => $employee->name ?? $employee->associatePhone
                ];
            }
        }

        return $arrEmployees;
    }

    public function getLogs(object $data, int $profileID): array
    {
        $arrLogs = [];
        $take = config('artLog.take_logs');
        $skip = $data->skip;
        $employeeID = $data->logEmployeeFilter;
        $typeID = $data->logTypeFilter;

        $logs = Log::where('profileID', $profileID);
        $arrLogs['count'] = $logs->count();

        $logs = $logs->take($take)
            ->when(isset($employeeID), function ($query) use ($employeeID) {
                $query->where('userID', $employeeID);
            })
            ->when(isset($typeID), function ($query) use ($typeID) {
                $query->where('typeID', $typeID);
            })
            ->when(isset($skip), function ($query) use ($skip) {
                $query->skip($skip);
            })->get();

        $arrLogs['logs'] = $this->logs($logs);

        return $arrLogs;
    }

    public function getTypes(): array
    {
        $arrTypes = [];
        $logTypes = new LogsTypes();

        foreach ($logTypes->typeArray() as $key => $type) {
            $arrTypes[] = [
                'value' => $key,
                'text' => $type
            ];
        }

        return $arrTypes;
    }

    public function saveClientImportLog(int $userID, int $profileID, array $arrStatuses): void
    {
        $logTypes = new LogsTypes();
        $logMessages = new LogsMessages();
        $clientsCount = (int) $arrStatuses['success'] + (int) $arrStatuses['failed'];
        $message = $logMessages->clientImportLog();

        $message = str_replace(
            ['{count}', '{success}', '{failed}'],
            [$clientsCount, $arrStatuses['success'], $arrStatuses['failed']],
            $message
        );

        resolve(Log::class)->saveLog($userID, $profileID, $logTypes->importType(), $message);
    }

    public function saveLoginLog(object $user): void
    {
        $logTypes = new LogsTypes();
        $logMessages = new LogsMessages();
        $profile = new Profiles($user);
        $profile = $profile->profile();

        resolve(Log::class)->saveLog(
            $user->userID,
            $profile->profileID,
            $logTypes->loginType(),
            $logMessages->clientLoginLog()
        );
    }

    private function logs(?object $logs): array
    {
        $arrLogs = [];
        $logTypes = new LogsTypes();
        $logMessages = new LogsMessages();

        if (isset($logs) && count($logs)) {
            foreach ($logs as $log) {
                $arrLogs[] = [
                    'logID' => $log->logID,
                    'user' => isset($log, $log->user, $log->user->name) ? $log->user->name : $log->user->phone,
                    'type' => $logTypes->typeName($log->typeID),
                    'message' => $logMessages->messageName($log->message),
                    'date' => Carbon::parse($log->careate_at)->format('d.m.Y H:i'),
                    'isRead' => $log->isRead
                ];
            }
        }

        return $arrLogs;
    }
}
