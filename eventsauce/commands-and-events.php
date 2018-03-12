<?php

namespace LaravelExample\Registration;

use EventSauce\EventSourcing\Event;
use EventSauce\EventSourcing\PointInTime;

final class RegistrationHasStarted implements Event
{
    /**
     * @var PointInTime
     */
    private $timeOfRecording;

    public function __construct(
        PointInTime $timeOfRecording
    ) {
        $this->timeOfRecording = $timeOfRecording;
    }

    public function timeOfRecording(): PointInTime
    {
        return $this->timeOfRecording;
    }

    public static function fromPayload(
        array $payload,
        PointInTime $timeOfRecording): Event
    {
        return new RegistrationHasStarted(
            $timeOfRecording
        );
    }

    public function toPayload(): array
    {
        return [];
    }

    public static function with(PointInTime $timeOfRecording): RegistrationHasStarted
    {
        return new RegistrationHasStarted(
            $timeOfRecording
        );
    }

}

final class NameWasSpecified implements Event
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var PointInTime
     */
    private $timeOfRecording;

    public function __construct(
        PointInTime $timeOfRecording,
        string $name
    ) {
        $this->timeOfRecording = $timeOfRecording;
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function timeOfRecording(): PointInTime
    {
        return $this->timeOfRecording;
    }

    public static function fromPayload(
        array $payload,
        PointInTime $timeOfRecording): Event
    {
        return new NameWasSpecified(
            $timeOfRecording,
            (string) $payload['name']
        );
    }

    public function toPayload(): array
    {
        return [
            'name' => (string) $this->name,
        ];
    }

    public static function withName(PointInTime $timeOfRecording, string $name): NameWasSpecified
    {
        return new NameWasSpecified(
            $timeOfRecording,
            $name
        );
    }

}

final class EmailWasSpecified implements Event
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var PointInTime
     */
    private $timeOfRecording;

    public function __construct(
        PointInTime $timeOfRecording,
        string $email
    ) {
        $this->timeOfRecording = $timeOfRecording;
        $this->email = $email;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function timeOfRecording(): PointInTime
    {
        return $this->timeOfRecording;
    }

    public static function fromPayload(
        array $payload,
        PointInTime $timeOfRecording): Event
    {
        return new EmailWasSpecified(
            $timeOfRecording,
            (string) $payload['email']
        );
    }

    public function toPayload(): array
    {
        return [
            'email' => (string) $this->email,
        ];
    }

    public static function withEmail(PointInTime $timeOfRecording, string $email): EmailWasSpecified
    {
        return new EmailWasSpecified(
            $timeOfRecording,
            $email
        );
    }

}

final class AccountWasCreated implements Event
{
    /**
     * @var PointInTime
     */
    private $timeOfRecording;

    public function __construct(
        PointInTime $timeOfRecording
    ) {
        $this->timeOfRecording = $timeOfRecording;
    }

    public function timeOfRecording(): PointInTime
    {
        return $this->timeOfRecording;
    }

    public static function fromPayload(
        array $payload,
        PointInTime $timeOfRecording): Event
    {
        return new AccountWasCreated(
            $timeOfRecording
        );
    }

    public function toPayload(): array
    {
        return [];
    }

    public static function with(PointInTime $timeOfRecording): AccountWasCreated
    {
        return new AccountWasCreated(
            $timeOfRecording
        );
    }

}

final class StartRegistration
{
    /**
     * @var PointInTime
     */
    private $timeOfRequest;

    /**
     * @var \EventSauce\EventSourcing\UuidAggregateRootId
     */
    private $registrationId;

    public function __construct(
        PointInTime $timeOfRequest,
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId
    ) {
        $this->timeOfRequest = $timeOfRequest;
        $this->registrationId = $registrationId;
    }

    public function timeOfRequest(): PointInTime
    {
        return $this->timeOfRequest;
    }

    public function registrationId(): \EventSauce\EventSourcing\UuidAggregateRootId
    {
        return $this->registrationId;
    }

}

final class SpecifyName
{
    /**
     * @var PointInTime
     */
    private $timeOfRequest;

    /**
     * @var \EventSauce\EventSourcing\UuidAggregateRootId
     */
    private $registrationId;

    /**
     * @var string
     */
    private $name;

    public function __construct(
        PointInTime $timeOfRequest,
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId,
        string $name
    ) {
        $this->timeOfRequest = $timeOfRequest;
        $this->registrationId = $registrationId;
        $this->name = $name;
    }

    public function timeOfRequest(): PointInTime
    {
        return $this->timeOfRequest;
    }

    public function registrationId(): \EventSauce\EventSourcing\UuidAggregateRootId
    {
        return $this->registrationId;
    }

    public function name(): string
    {
        return $this->name;
    }

}

final class SpecifyEmail
{
    /**
     * @var PointInTime
     */
    private $timeOfRequest;

    /**
     * @var \EventSauce\EventSourcing\UuidAggregateRootId
     */
    private $registrationId;

    /**
     * @var string
     */
    private $email;

    public function __construct(
        PointInTime $timeOfRequest,
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId,
        string $email
    ) {
        $this->timeOfRequest = $timeOfRequest;
        $this->registrationId = $registrationId;
        $this->email = $email;
    }

    public function timeOfRequest(): PointInTime
    {
        return $this->timeOfRequest;
    }

    public function registrationId(): \EventSauce\EventSourcing\UuidAggregateRootId
    {
        return $this->registrationId;
    }

    public function email(): string
    {
        return $this->email;
    }

}

final class SpeficyPassword
{
    /**
     * @var PointInTime
     */
    private $timeOfRequest;

    /**
     * @var \EventSauce\EventSourcing\UuidAggregateRootId
     */
    private $registrationId;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $verificationPassword;

    public function __construct(
        PointInTime $timeOfRequest,
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId,
        string $password,
        string $verificationPassword
    ) {
        $this->timeOfRequest = $timeOfRequest;
        $this->registrationId = $registrationId;
        $this->password = $password;
        $this->verificationPassword = $verificationPassword;
    }

    public function timeOfRequest(): PointInTime
    {
        return $this->timeOfRequest;
    }

    public function registrationId(): \EventSauce\EventSourcing\UuidAggregateRootId
    {
        return $this->registrationId;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function verificationPassword(): string
    {
        return $this->verificationPassword;
    }

}
