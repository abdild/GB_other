<?php

// 1. Наблюдатель: есть сайт HandHunter.gb. На нем работники могут подыскать себе вакансию РНР-программиста. 
// Необходимо реализовать классы искателей с их именем, почтой и стажем работы. Также реализовать возможность
// в любой момент встать на биржу вакансий (подписаться на уведомления), либо же, напротив, выйти из гонки 
// за местом. Таким образом, как только появится новая вакансия программиста, все жаждущие автоматически 
// получат уведомления на почту (можно реализовать условно).

class Subject implements SplSubject
{
    /**
     * @var SplObjectStorage Список подписчиков.
     */
    private $observers;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    /**
     * Методы управления подпиской.
     */
    public function attach(SplObserver $observer) : void
    {
        echo "Attach ";
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer) : void
    {
        $this->observers->detach($observer);
        echo "Detach ";
    }

    /**
     * Запуск обновления в каждом подписчике.
     */
    public function notify() : void
    {
        echo "Message ";
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}



class Worker implements SplObserver
{
    private $name;
    private $email;
    private $experience;

    public function __construct($name, $email, $experience) 
    {
        $this->name = $name;
        $this->email = $email;
        $this->experience = $experience;
    }
    public function update(SplSubject $subject) : void
    {
        echo "$this->name, новая вакансия<br>";
    }
}



$worker1 = new Worker('Иван Иванов', 'ivanov@ivanov.ru', 1);
$worker2 = new Worker('Петр Петров', 'petrov@petrov.ru', 5);

$subject = new Subject();

$subject->attach($worker1);
$subject->attach($worker3);

$subject->notify();

$subject->detach($worker3);

$subject->notify();

// 2. Стратегия: есть интернет-магазин по продаже носков. Необходимо реализовать возможность оплаты 
// различными способами (Qiwi, Яндекс, WebMoney). Разница лишь в обработке запроса на оплату 
// и получение ответа от платёжной системы. В интерфейсе функции оплаты достаточно общей суммы 
// товара и номера телефона.

class Shop
{
    private $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }


    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }


    public function makeOrder() : void
    {
        $paySystemResponse = $this->strategy->paySystem(999, '8-999-999-99-99'); // цифры для теста
        echo $paySystemResponse[message], '<br>';
    }
}


interface Strategy
{
    public function paySystem($totalCost, $phoneNumber) : array;
}


class Qiwi implements Strategy
{
    public function paySystem($totalCost, $phoneNumber) : array
    {
        // Обработка платежа

        $response = 
        [
            'status' => 200,
            'message' => "Сумма $totalCost оплачена.",
        ];

        return $response;
    }
}


class Yandex implements Strategy
{
    public function paySystem($totalCost, $phoneNumber) : array
    {
        // Обработка платежа

        $response = 
        [
            'status' => 200,
            'message' => "Сумма $totalCost оплачена.",
        ];

        return $response;
    }
}


class WebMoney implements Strategy
{
    public function paySystem($totalCost, $phoneNumber) : array
    {
        // Обработка платежа

        $response = 
        [
            'status' => 200,
            'message' => "Сумма $totalCost оплачена.",
        ];

        return $response;
    }
}


$shop = new Shop(new Qiwi);
$shop->makeOrder();

$shop->setStrategy(new Yandex);
$shop->makeOrder();


// 3. Команда: вы — разработчик продукта Macrosoft World. Это текстовый редактор с возможностями 
// копирования, вырезания и вставки текста (пока только это). Необходимо реализовать механизм 
// по логированию этих операций и возможностью отмены и возврата действий. Т. е., в ходе работы 
// программы вы открываете текстовый файл .txt, выделяете участок кода (два значения: начало и конец) 
// и выбираете, что с этим кодом делать.

interface Command
{
    public function execute($file) : void;
}


class Copy implements Command
{
    public function __construct(int $start, int $length)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function execute($file) : void
    {
        $curentContent = $file->states[count($file->states) - 1];
        $file->buffer = mb_substr($curentContent, $this->start, $this->length);
    }
}


class Past implements Command
{
    public function __construct(int $position)
    {
        $this->position = $position;
    }

    public function execute($file) : void
    {
        $curentContent = $file->states[count($file->states) - 1];
        $newContent = substr_replace($curentContent, $file->buffer, $this->position, 0);
        $file->states[] = $newContent;
    }
}


class Cut implements Command
{
    public function __construct(int $start, int $length)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function execute($file) : void
    {
        $curentContent = $file->states[count($file->states) - 1];
        $substr = mb_substr($curentContent, $this->start, $this->length);
        $file->buffer = $substr;
        $newContent = substr_replace($curentContent, '', $this->start, $this->length);
        $file->states[] = $newContent;
    }
}


class Cancel implements Command
{
    public function execute($file) : void
    {
        array_pop($file->states);
        echo $file->states[count($file->states) - 1];
    }
}


class Save implements Command
{
    public function execute($file) : void
    {
        file_put_contents($file->filePath, $file->states[count($file->states) - 1]);
    }
}


class MSWorld {
    /**
     * @var String Путь к целевому файлу
     */
    public $filePath;
    public $fileContent;
    public $states = [];
    public $buffer = '';

    public function __construct(string $filePath) 
    {
        $this->filePath = $filePath;
        $this->fileContent = file_get_contents($filePath);
        $this->states[] = $this->fileContent;
    }

    public function execute(Command $command) : void
    {
        $command->execute($this);
    }
}


$text = new MSWorld('task.txt');
$text->execute(new Copy(22, 2));  // Копируем смайлик
$text->execute(new Past(24));     // Вставляем смайлик
$text->execute(new Past(26));     // Вставляем смайлик
$text->execute(new Past(28));     // Вставляем смайлик, теперь их 4
$text->execute(new Cut(26, 2));   // Один вырезали, снова 3
$text->execute(new Cancel);      // Отменили действие, опять 4
$text->execute(new Save);         // Сохраняем изменения в файле 