<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(16)
            ->sequence(
                [
                    'name' => 'Дуров Павел Валерьевич',
                    'email' => 'test@mail.ru',
                    'password' => '12345678'
                ],
                ['name' => 'Александр Юльевич Панин'],
                ['name' => 'Громов Иван Иванович'],
                ['name' => 'Петр Сергеевич Кузнецов'],
                ['name' => 'Геральд Сероголовый'],
                ['name' => 'Григорьева Ксения Андреевна'],
                ['name' => 'Круг Анастасия Александровна'],
                ['name' => 'Кожемякин Артемий Юрьевич'],
                ['name' => 'Оби Ван Кеноби'],
                ['name' => 'Тур Влад Романович'],
                ['name' => 'Игорь Александрович Ким'],
                ['name' => 'Ирина Васильевна Ткач'],
                ['name' => 'Соловей ака Разбойник'],
                ['name' => 'Шуманович Алина Игоревна'],
                ['name' => 'Куприянова Анна Ивановна'],
                ['name' => 'Павел Павлович Павлов'],
            )
            ->create();
    }
}
