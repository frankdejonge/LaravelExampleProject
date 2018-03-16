<?php

namespace LaravelExample\Registration;

use EventSauce\EventSourcing\Event;

final class RegistrationHasStarted implements Event
{
    public function __construct(

    ) {

    }

    public static function fromPayload(array $payload): Event
    {
        return new RegistrationHasStarted();
    }

    public function toPayload(): array
    {
        return [];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function with(): RegistrationHasStarted
    {
        return new RegistrationHasStarted(
            
        );
    }
}

final class NameWasSpecified implements Event
{
    /**
     * @var string
     */
    private $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
    public static function fromPayload(array $payload): Event
    {
        return new NameWasSpecified(
            (string) $payload['name']);
    }

    public function toPayload(): array
    {
        return [
            'name' => (string) $this->name,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withName(string $name): NameWasSpecified
    {
        return new NameWasSpecified(
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

    public function __construct(
        string $email
    ) {
        $this->email = $email;
    }

    public function email(): string
    {
        return $this->email;
    }
    public static function fromPayload(array $payload): Event
    {
        return new EmailWasSpecified(
            (string) $payload['email']);
    }

    public function toPayload(): array
    {
        return [
            'email' => (string) $this->email,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withEmail(string $email): EmailWasSpecified
    {
        return new EmailWasSpecified(
            $email
        );
    }
}

final class AccountWasCreated implements Event
{
    public function __construct(

    ) {

    }

    public static function fromPayload(array $payload): Event
    {
        return new AccountWasCreated();
    }

    public function toPayload(): array
    {
        return [];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function with(): AccountWasCreated
    {
        return new AccountWasCreated(
            
        );
    }
}

final class StartRegistration
{
    /**
     * @var \EventSauce\EventSourcing\UuidAggregateRootId
     */
    private $registrationId;

    public function __construct(
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId
    ) {
        $this->registrationId = $registrationId;
    }

    public function registrationId(): \EventSauce\EventSourcing\UuidAggregateRootId
    {
        return $this->registrationId;
    }
}

final class SpecifyName
{
    /**
     * @var \EventSauce\EventSourcing\UuidAggregateRootId
     */
    private $registrationId;

    /**
     * @var string
     */
    private $name;

    public function __construct(
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId,
        string $name
    ) {
        $this->registrationId = $registrationId;
        $this->name = $name;
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
     * @var \EventSauce\EventSourcing\UuidAggregateRootId
     */
    private $registrationId;

    /**
     * @var string
     */
    private $email;

    public function __construct(
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId,
        string $email
    ) {
        $this->registrationId = $registrationId;
        $this->email = $email;
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
        \EventSauce\EventSourcing\UuidAggregateRootId $registrationId,
        string $password,
        string $verificationPassword
    ) {
        $this->registrationId = $registrationId;
        $this->password = $password;
        $this->verificationPassword = $verificationPassword;
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
