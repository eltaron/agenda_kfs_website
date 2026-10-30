<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public ?string $site_logo;
    public string $contact_phone;
    public string $whatsapp_message;
    public bool $system_active;
    public ?string $address;

    public static function group(): string
    {
        return 'general';
    }
}
