<?php

namespace App\Core;

interface HasLogsActivity
{

    public function __toString(): string;

    public function activityLogLink(): string;

}
