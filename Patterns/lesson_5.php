<?php
// 1. Реализовать на PHP пример Декоратора, позволяющий отправлять уведомления несколькими различными способами

interface MessageInterface
{
    public function makeMessage(): string;
}


class Message implements MessageInterface
{
    public function makeMessage(): string
    {
        return "Уведомление";
    }
}


class MessageDecorator implements MessageInterface
{
    protected $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }


    public function makeMessage(): string
    {
        return $this->message->makeMessage();
    }
}


class SMSMessageDecorator extends MessageDecorator
{
    public function makeMessage(): string
    {
        return "SMS: " . parent::makeMessage();
    }
}


class EmailMessageDecorator extends MessageDecorator
{
    public function makeMessage(): string
    {
        return "E-mail: " . parent::makeMessage();
    }
}


class CNMessageDecorator extends MessageDecorator
{
    public function makeMessage(): string
    {
        return "Chrome: " . parent::makeMessage();
    }
}


function sendMessage(MessageInterface $message)
{
    echo $message->makeMessage();
}



$simple = new Message();
echo "Simple component:<br>";
sendMessage($simple);
echo "<br><br>";



$decorator1 = new SMSMessageDecorator($simple);
$decorator2 = new EmailMessageDecorator($decorator1);
echo "Decorated component:<br>";
sendMessage($decorator2);

// 2. Реализовать паттерн Адаптер для связи внешней библиотеки (классы SquareAreaLib и CircleAreaLib) вычисления площади квадрата (getSquareArea) и площади круга (getCircleArea) с интерфейсами ISquare и ICircle имеющегося кода. Примеры классов даны ниже. Причём во внешней библиотеке используются для расчётов формулы нахождения через диагонали фигур, а в интерфейсах квадрата и круга — формулы, принимающие значения одной стороны и длины окружности соответственно.

class CircleAreaLib
{
    public function getCircleArea(float $diagonal)
    {
        $area = (M_PI * $diagonal ** 2) / 4;

        return $area;
    }
}

class SquareAreaLib
{
    public function getSquareArea(float $diagonal)
    {
        $area = ($diagonal ** 2) / 2;

        return $area;
    }
}


interface ISquare
{
    function squareArea(float $sideSquare);
}

interface ICircle
{
    function circleArea(float $circumference);
}



class SquareAdapter implements ISquare
{
    private $target;

    public function __construct(SquareAreaLib $target)
    {
        $this->target = $target;
    }

    public function squareArea(float $sideSquare)
    {
        $diagonal = sqrt(2 * $sideSquare ** 2);
        return $this->target->getSquareArea($diagonal);
    }
}


class CircleAdapter implements ICircle
{
    private $target;

    public function __construct(CircleAreaLib $target)
    {
        $this->target = $target;
    }

    public function circleArea(float $circumference)
    {
        $diagonal = $circumference / M_PI;
        return $this->target->getCircleArea($diagonal);
    }
}



$adapter = new SquareAdapter(new SquareAreaLib());
echo $adapter->squareArea(5);
