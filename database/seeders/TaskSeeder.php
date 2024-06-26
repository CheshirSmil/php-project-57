<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()
            ->count(15)
            ->sequence(
                [
                    'name' => 'Исправить ошибку в какой-нибудь строке',
                    'description' => 'Я тут ошибку нашёл, надо бы её исправить и так далее и так далее',
                    'created_by_id' => User::where('name', 'Игорь Александрович Ким')->value('id'),
                    'assigned_to_id' => User::where('name', 'Петр Сергеевич Кузнецов')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Допилить дизайн главной страницы',
                    'description' => 'Вёрстка поехала в далёкие края. Нужно удалить бутстрап!',
                    'created_by_id' => User::where('name', 'Ирина Васильевна Ткач')->value('id'),
                    'assigned_to_id' => User::where('name', 'Круг Анастасия Александровна')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Отрефакторить авторизацию',
                    'description' => 'Выпилить всё легаси, которое найдёшь',
                    'created_by_id' => User::where('name', 'Александр Юльевич Панин')->value('id'),
                    'assigned_to_id' => User::where('name', 'Александр Юльевич Панин')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Доработать команду подготовки БД',
                    'description' => 'За одно добавить тестовых данных',
                    'created_by_id' => User::where('name', 'Шуманович Алина Игоревна')->value('id'),
                    'assigned_to_id' => User::where('name', 'Игорь Александрович Ким')->value('id'),
                    'status_id' => TaskStatus::where('name', 'завершена')->value('id'),
                ],
                [
                    'name' => 'Пофиксить вон ту кнопку',
                    'description' => 'Кажется она не того цвета',
                    'created_by_id' => User::where('name', 'Оби Ван Кеноби')->value('id'),
                    'assigned_to_id' => User::where('name', 'Оби Ван Кеноби')->value('id'),
                    'status_id' => TaskStatus::where('name', 'в архиве')->value('id'),
                ],
                [
                    'name' => 'Исправить поиск',
                    'description' => 'Не ищет то, что мне хочется',
                    'created_by_id' => User::where('name', 'Александр Юльевич Панин')->value('id'),
                    'assigned_to_id' => User::where('name', 'Кожемякин Артемий Юрьевич')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Добавить интеграцию с облаками',
                    'description' => 'Они такие мягкие и пушистые',
                    'created_by_id' => User::where('name', 'Кожемякин Артемий Юрьевич')->value('id'),
                    'assigned_to_id' => User::where('name', 'Тур Влад Романович')->value('id'),
                    'status_id' => TaskStatus::where('name', 'выполняется')->value('id'),
                ],
                [
                    'name' => 'Выпилить лишние зависимости',
                    'description' => '',
                    'created_by_id' => User::where('name', 'Шуманович Алина Игоревна')->value('id'),
                    'assigned_to_id' => User::where('name', 'Дуров Павел Валерьевич')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Запилить сертификаты',
                    'description' => 'Кому-то же они нужны?',
                    'created_by_id' => User::where('name', 'Дуров Павел Валерьевич')->value('id'),
                    'assigned_to_id' => User::where('name', 'Оби Ван Кеноби')->value('id'),
                    'status_id' => TaskStatus::where('name', 'выполняется')->value('id'),
                ],
                [
                    'name' => 'Выпилить игру престолов',
                    'description' => 'Этот сериал никому не нравится! :)',
                    'created_by_id' => User::where('name', 'Громов Иван Иванович')->value('id'),
                    'assigned_to_id' => User::where('name', 'Геральд Сероголовый')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Пофиксить спеку во всех репозиториях',
                    'description' => 'Передать Олегу, чтобы больше не ронял прод',
                    'created_by_id' => User::where('name', 'Шуманович Алина Игоревна')->value('id'),
                    'assigned_to_id' => User::where('name', 'Петр Сергеевич Кузнецов')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Вернуть крошки',
                    'description' => 'Андрей, это задача для тебя',
                    'created_by_id' => User::where('name', 'Александр Юльевич Панин')->value('id'),
                    'assigned_to_id' => User::where('name', 'Дуров Павел Валерьевич')->value('id'),
                    'status_id' => TaskStatus::where('name', 'в архиве')->value('id'),
                ],
                [
                    'name' => 'Установить Linux',
                    'description' => 'Не забыть потестировать',
                    'created_by_id' => User::where('name', 'Соловей ака Разбойник')->value('id'),
                    'assigned_to_id' => User::where('name', 'Кожемякин Артемий Юрьевич')->value('id'),
                    'status_id' => TaskStatus::where('name', 'новая')->value('id'),
                ],
                [
                    'name' => 'Потребовать прибавки к зарплате',
                    'description' => 'Кризис это не время, чтобы молчать!',
                    'created_by_id' => User::where('name', 'Круг Анастасия Александровна')->value('id'),
                    'assigned_to_id' => User::where('name', 'Тур Влад Романович')->value('id'),
                    'status_id' => TaskStatus::where('name', 'в архиве')->value('id'),
                ],
                [
                    'name' => 'Добавить поиск по фото',
                    'description' => 'Только не по моему',
                    'created_by_id' => User::where('name', 'Шуманович Алина Игоревна')->value('id'),
                    'assigned_to_id' => User::where('name', 'Оби Ван Кеноби')->value('id'),
                    'status_id' => TaskStatus::where('name', 'завершена')->value('id'),
                ],
            )
            ->create();
    }
}
