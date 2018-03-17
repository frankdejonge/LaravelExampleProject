<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\RegisteringMembers\RegistrationCommandHandler;
use App\RegisteringMembers\SorryInvalidEmailProvided;
use App\RegisteringMembers\SorryInvalidNameProvided;
use App\RegisteringMembers\SorryPasswordIsInsecure;
use App\RegisteringMembers\SorryPasswordVerificationFailed;
use function compact;
use EventSauce\EventSourcing\UuidAggregateRootId;
use Illuminate\Http\Request;
use LaravelExample\Registration\ConfirmRegistration;
use LaravelExample\Registration\SpecifyEmail;
use LaravelExample\Registration\SpecifyName;
use LaravelExample\Registration\SpecifyPassword;
use LaravelExample\Registration\StartRegistration;
use function redirect;
use function view;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register.start');
    }

    public function start()
    {
        $this->handleCommand(new StartRegistration(
            $id = UuidAggregateRootId::create()
        ));

        return redirect()->route('register.name_form', ['applicationId' => $id->toString()]);
    }

    public function showNameForm(UuidAggregateRootId $registrationId)
    {
        return view('register.name', compact('registrationId'));
    }

    public function processNameForm(UuidAggregateRootId $registrationId, Request $request)
    {
        try {
            $this->handleCommand(new SpecifyName(
                $registrationId,
                $request->input('name')
            ));
        } catch (SorryInvalidNameProvided $exception) {
            return redirect()->back()->withErrors(['name' => 'The name is not valid.']);
        }

        return redirect()->route('register.email_form', ['registrationId' => $registrationId->toString()]);
    }

    public function showEmailForm(UuidAggregateRootId $registrationId)
    {
        return view('register.email', compact('registrationId'));
    }

    public function processEmailForm(UuidAggregateRootId $registrationId, Request $request)
    {
        try {
            $this->handleCommand(new SpecifyEmail(
                $registrationId,
                $request->input('email')
            ));
        } catch (SorryInvalidEmailProvided $exception) {
            return redirect()->back()->withErrors(['name' => 'The e-mail address is not valid.']);
        }

        return redirect()->route('register.password_form', ['registrationId' => $registrationId->toString()]);
    }

    public function showPasswordForm(UuidAggregateRootId $registrationId)
    {
        return view('register.password', compact('registrationId'));
    }

    public function processPasswordForm(UuidAggregateRootId $registrationId, Request $request)
    {
        try {
            $this->handleCommand(new SpecifyPassword(
                $registrationId,
                $request->input('password'),
                $request->input('verification_password')
            ));
        } catch (SorryPasswordIsInsecure $exception) {
            return redirect()->back()->withErrors(['password' => 'The password is not secure enough.']);
        } catch (SorryPasswordVerificationFailed $exception) {
            return redirect()->back()->withErrors(['password' => 'The password does not match the verification.']);
        }

        return redirect()->route('register.confirm_form', ['registrationId' => $registrationId->toString()]);
    }

    public function showConfirmForm(UuidAggregateRootId $registrationId)
    {
        return view('register.confirm', compact('registrationId'));
    }

    public function processConfirmForm(UuidAggregateRootId $registrationId)
    {
        $this->handleCommand(new ConfirmRegistration($registrationId));

        return redirect()->route('login');
    }

    private function handleCommand($command)
    {
        resolve(RegistrationCommandHandler::class)->handle($command);
    }
}
