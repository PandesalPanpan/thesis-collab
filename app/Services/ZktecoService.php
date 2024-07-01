<?php

namespace App\Services;

use Vendor\ZktecoSDK\ZktecoClient;
use App\Models\Fingerprint;

class ZktecoService
{
    protected $zktecoClient;
    protected $host;
    protected $port;
    protected $username;
    protected $password;

    public function __construct(ZktecoClient $zktecoClient, $host, $port, $username, $password)
    {
        $this->zktecoClient = $zktecoClient;
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;

        $this->configureZktecoClient();
    }

    protected function configureZktecoClient()
    {
        $this->zktecoClient->setHost($this->host);
        $this->zktecoClient->setPort($this->port);
        $this->zktecoClient->setUsername($this->username);
        $this->zktecoClient->setPassword($this->password);
    }

    public function fetchAttendanceRecords()
    {

    }

    public function saveFingerprintData($employeeId, $fingerprintData)
    {
        try {
            $fingerprint = new Fingerprint();
            $fingerprint->employee_id = $employeeId;
            $fingerprint->fingerprint_data = $fingerprintData;
            $fingerprint->save();

            return $fingerprint;
        } catch (\Exception $e) {

            return null;
        }
    }
}
