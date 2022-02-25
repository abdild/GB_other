<?php
// ПОРОЖДАЮЩИЕ ШАБЛОНЫ

// Разработать и реализовать на PHP собственную ORM (Object-Relational Mapping —прослойку между базой данных и кодом) посредством абстрактной фабрики. Фабрики будут реализовывать интерфейсы СУБД MySQLFactory, PostgreSQLFactory, OracleFactory. Каждая фабрика возвращает объекты, характерные для конкретной СУБД. Пример компонентов:
// DBConnection — соединение с базой,
// DBRecrord — запись таблицы базы данных,
// DBQueryBuiler — конструктор запросов к базе.
// Должна получиться гибкая система, позволяющая динамически менять базу данных и инкапсулирующая взаимодействие с ней внутри продуктов конкретных фабрик. Углубляться в детали компонента не обязательно — достаточно их наличия.

abstract class DBFactory {
    abstract public function DBConnection() : Connection;
    abstract public function DBRecord() : Record;
    abstract public function DBQueryBuilder() : Query;
}

class MySQL extends DBFactory {
    public function OracleConnection() : Connection {
        return new MySQLConnection();
    }

    public function OracleRecord() : Record {
        return new MySQLRecord();
    }

    public function OracleQueryBuilder() : Query {
        return new MySQLQuery();
    }
}

class PostgreSQL extends DBFactory {
    public function OracleConnection() : Connection {
        return new PostgreSQLConnection();
    }

    public function OracleRecord() : Record {
        return new PostgreSQLRecord();
    }

    public function OracleQueryBuilder() : Query {
        return new PostgreSQLQuery();
    }
}

class Oracle extends DBFactory {
    public function OracleConnection() : Connection {
        return new OracleConnection();
    }

    public function OracleRecord() : Record {
        return new OracleRecord();
    }

    public function OracleQueryBuilder() : Query {
        return new OracleQuery();
    }
}

// Интерфейсы
interface DBConnection {
    public function connect() : string;
}

interface DBRecord {
    public function record() : string;
}

interface DBQueryBuilder {
    public function query() : array;
}


// Реализации интерфейсов

class MySQLConnection implements DBConnection {
    public function connect() : string {
        return 'MySQL';
    }
}

class PostgreSQLConnection implements DBConnection {
    public function connect() : string {
        return 'PostgreSQL';
    }
}

class OracleConnection implements DBConnection {
    public function connect() : string {
        return 'Oracle';
    }
}

class MySQLRecord implements DBRecord {
    public function record() : string {
        return 'MySQL';
    }
}

class PostgreSQLRecord implements DBRecord {
    public function record() : string {
        return 'PostgreSQL';
    }
}

class OracleRecord implements DBRecord {
    public function record() : string {
        return 'Oracle';
    }
}

class MySQLQueryBuilder implements DBQueryBuilder {
    public function query() : array {
        return $MySQLResult;
    }
}

class PostgreSQLQueryBuilder implements DBQueryBuilder {
    public function query() : array {
        return $PostgreSQLResult;
    }
}

class OracleQueryBuilder implements DBQueryBuilder {
    public function query() : array {
        return $OracleResult;
    }
}