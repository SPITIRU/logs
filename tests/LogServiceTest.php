<?php

namespace ArtemiyKudin\log\Test;

use ArtemiyKudin\log\Models\Log;
use ArtemiyKudin\log\Traits\LogService;
use Beauty\database\seeds\tests\CrmSeeder;
use Beauty\Modules\Common\Models\RoleN;
use Illuminate\Http\Request;
use Tests\BaseTest;

class LogServiceTest extends BaseTest
{
    use LogService;

    public function testSaveClientImportLog(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $arrStatuses = [
            'success' => random_int(1, 10),
            'failed' => random_int(1, 4)
        ];
        $this->saveClientImportLog($user->userID, $user->profile->profileID, $arrStatuses);

        $this->assertEmpty(null);
    }

    public function testGetLogs(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $request = new Request();

        $result = $this->getLogs($request, $user->profile->profileID);

        $this->assertIsArray($result);
    }

    public function testGetTypes(): void
    {
        $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $result = $this->getTypes();

        $this->assertIsArray($result);
    }

    public function testGetEmployees(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $result = $this->getEmployees($user->profile);

        $this->assertIsArray($result);
    }

    public function testsaveLoginLog(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $this->saveLoginLog($user);

        $this->assertEmpty(null);
    }

    public function testDeleteLog(): void
    {
        $user = $this->seedDatabaseAndGetUserWithRole(RoleN::STUDIO_OWNER, CrmSeeder::class);
        $log = resolve(Log::class)->latest()->first();
        $request = new Request();
        $request->logID = $log->logID;

        $result = $this->deleteLog($request, $user->profile->profileID);

        $this->assertIsArray($result);
    }
}
