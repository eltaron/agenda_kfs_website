<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'منظومة كفر الشيخ لإدارة الاجتماعات');
        $this->migrator->add('general.site_logo', null);
        $this->migrator->add('general.contact_phone', '201000000000');
        $this->migrator->add('general.whatsapp_message', 'مرحباً، أود الاستفسار عن الاجتماع.');
        $this->migrator->add('general.system_active', true);
        $this->migrator->add('general.address', 'ديوان عام محافظة كفر الشيخ');
    }
};
