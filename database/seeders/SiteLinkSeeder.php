<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteLink;

class SiteLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'key' => 'phone',
                'value' => '+7 (900) 123-45-67',
                'description' => 'Рабочий телефон',
                'type' => 'phone'
            ],
            [
                'key' => 'email',
                'value' => 'info@example.com',
                'description' => 'Основная почта',
                'type' => 'email'
            ],
            [
                'key' => 'whatsapp',
                'value' => 'https://wa.me/79001234567',
                'description' => 'WhatsApp',
                'type' => 'link'
            ],
            [
                'key' => 'rutube',
                'value' => 'https://rutube.ru/channel/example',
                'description' => 'RuTube канал',
                'type' => 'link'
            ],
            [
                'key' => 'telegram',
                'value' => 'https://t.me/example',
                'description' => 'Telegram канал',
                'type' => 'link'
            ],
            [
                'key' => 'zen',
                'value' => 'https://dzen.ru/example',
                'description' => 'Яндекс.Дзен',
                'type' => 'link'
            ],
            [
                'key' => 'vk',
                'value' => 'https://vk.com/example',
                'description' => 'ВКонтакте',
                'type' => 'link'
            ]
        ];

        foreach ($links as $link) {
            SiteLink::updateOrCreate(['key' => $link['key']], $link);
        }
    }
}
