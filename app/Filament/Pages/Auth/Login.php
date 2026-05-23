<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function getTitle(): string
    {
        return __('login.page_title');
    }

    public function getHeading(): string
    {
        return __('login.heading');
    }

    public function getSubheading(): ?string
    {
        return __('login.subheading');
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label(__('login.phone'))
            ->tel()
            ->required()
            ->validationMessages([
                'required' => __('login.validation.phone_required'),
            ])
            ->autocomplete('username')
            ->autofocus();
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->label(__('login.password'))
            ->validationMessages([
                'required' => __('login.validation.password_required'),
            ]);
    }

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label(__('login.submit'));
    }

    protected function getFormActions(): array
    {
        $nextLocale = app()->getLocale() === 'ar' ? 'en' : 'ar';

        return [
            $this->getAuthenticateFormAction(),
            Action::make('switchLocale')
                ->label(strtoupper($nextLocale))
                ->icon('heroicon-o-language')
                ->color('gray')
                ->link()
                ->url(route('locale.switch', ['locale' => $nextLocale])),
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.phone' => __('login.validation.invalid_credentials'),
        ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'phone' => $data['phone'],
            'password' => $data['password'],
        ];
    }
}