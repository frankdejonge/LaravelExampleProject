<?php

namespace App\RegisteringMembers;

use DomainException;

class SorryRegistrationIsIncomplete extends DomainException
{
    const REASON_MISSING_NAME = 'missing.name';
    const REASON_MISSING_EMAIL = 'missing.email';
    const REASON_MISSING_PASSWORD = 'missing.password';

    private $reason;

    public function __construct(string $reason)
    {
        parent::__construct('Registration is incomplete');
        $this->reason = $reason;
    }

    public function reason(): string
    {
        return $this->reason;
    }

    public static function missingName(): SorryRegistrationIsIncomplete
    {
        return new static(self::REASON_MISSING_NAME);
    }

    public static function missingEmail(): SorryRegistrationIsIncomplete
    {
        return new static(self::REASON_MISSING_EMAIL);
    }

    public static function missingPassword(): SorryRegistrationIsIncomplete
    {
        return new static(self::REASON_MISSING_PASSWORD);
    }
}