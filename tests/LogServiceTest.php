<?php

namespace ArtemiyKudin\log\Test;

use ArtemiyKudin\log\Models\Log;
use ArtemiyKudin\log\Services\LogService;
use Beauty\database\seeds\tests\CrmSeeder;
use Beauty\Modules\Common\Models\RoleN;
use Illuminate\Http\Request;
use Tests\BaseTest;

class LogServiceTest extends BaseTest
{
    public function testSaveClientImportLog(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $logService = resolve(LogService::class);
        $arrStatuses = [
            'success' => random_int(1, 10),
            'failed' => random_int(1, 4)
        ];
        $result = $logService->saveClientImportLog($user->userID, $user->profile->profileID, $arrStatuses);

        $this->assertEmpty($result);
    }

    public function testGetLogs(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $logService = resolve(LogService::class);
        $request = new Request();

        $result = $logService->getLogs($request, $user->profile->profileID);

        $this->assertIsArray($result);
    }

    public function testGetTypes(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $logService = resolve(LogService::class);

        $result = $logService->getTypes();

        $this->assertIsArray($result);
    }

    public function testGetEmployees(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $logService = resolve(LogService::class);

        $result = $logService->getEmployees($user->profile);

        $this->assertIsArray($result);
    }

    public function testsaveLoginLog(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $logService = resolve(LogService::class);

        $result = $logService->saveLoginLog($user);

        $this->assertEmpty($result);
    }

    public function testDeleteLog(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $logService = resolve(LogService::class);
        $log = resolve(Log::class)->latest()->first();
        $request = new Request();
        $request->logID = $log->logID;

        $result = $logService->deleteLog($request, $user->profile->profileID);

        $this->assertIsArray($result);
    }
}
