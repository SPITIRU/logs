<?php

namespace ArtemiyKudin\log\Traits;

use ArtemiyKudin\log\Models\Log;
use Beauty\Modules\Common\Models\Profile;
use Beauty\Modules\Common\Objects\Logs\Constants\LogsTypes;
use Beauty\Modules\Common\Objects\Profile\Profile as Profiles;
use Carbon\Carbon;

trait LogService
{
    public function saveClientImportLog(int $userID, int $profileID, array $arrStatuses): void
    {
        $logTypes = new LogsTypes();
        $clientsCount = (int) $arrStatuses['success'] + (int) $arrStatuses['failed'];

        $message = __('logs.save_client_import_log');
        $message = str_replace(
            ['{count}', '{success}', '{failed}'],
            [$clientsCount, $arrStatuses['success'], $arrStatuses['failed']],
            $message
        );

        resolve(Log::class)->saveLog($userID, $profileID, $logTypes->importType(), $message);
    }

    public function getLogs(object $data, int $profileID): array
    {
        $arrLogs = [];
        $logTypes = new LogsTypes();
        $take = $this->settings['take_logs'];
        $skip = $data->skip;
        $employeeID = $data->logEmployeeFilter;
        $typeID = $data->logTypeFilter;

        $logs = $this->model->where('profileID', $profileID);
        $arrLogs['count'] = $logs->count();

        $logs->take($take);

        if ($employeeID) {
            $logs->where('userID', $employeeID);
        }

        if ($typeID) {
            $logs->where('typeID', $typeID);
        }

        if ($skip) {
            $logs->skip($skip);
        }

        $logs = $logs->get();

        $arrLogs['logs'] = [];
        if (count($logs)) {
            foreach ($logs as $log) {
                $arrLogs['logs'][] = [
                    'logID' => $log->logID,
                    'user' => isset($log, $log->user, $log->user->name) ? $log->user->name : $log->user->phone,
                    'type' => $logTypes->typeName($log->typeID),
                    'message' => $log->message,
                    'date' => Carbon::parse($log->careate_at)->format('d.m.Y H:i'),
                    'isRead' => $log->isRead
                ];
            }
        }

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

    public function getEmployees(Profile $profile): array
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

    public function saveLoginLog(object $user): void
    {
        $logTypes = new LogsTypes();

        $profile = new Profiles($user);
        $profile = $profile->profile();

        $message = __('logs.save_client_login_log');

        resolve(Log::class)->saveLog($user->userID, $profile->profileID, $logTypes->loginType(), $message);
    }

    public function deleteLog(object $data, int $profileID): array
    {
        $model = $this->model->find($data->logID);
        $model->delete();

        return $this->getLogs($data, $profileID);
    }

//    public function deleteLogs()
//    {
////        if (isset($logID)) {
////            $this->model->delete($logID);
////        } else {
////
////        }
//
//        return;
//    }
}
