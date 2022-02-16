<?php
// ПОРОЖДАЮЩИЕ ШАБЛОНЫ

// Разработать и реализовать на PHP собственную ORM (Object-Relational Mapping —прослойку между базой данных и кодом) посредством абстрактной фабрики. Фабрики будут реализовывать интерфейсы СУБД MySQLFactory, PostgreSQLFactory, OracleFactory. Каждая фабрика возвращает объекты, характерные для конкретной СУБД. Пример компонентов:
// DBConnection — соединение с базой,
// DBRecrord — запись таблицы базы данных,
// DBQueryBuiler — конструктор запросов к базе.
// Должна получиться гибкая система, позволяющая динамически менять базу данных и инкапсулирующая взаимодействие с ней внутри продуктов конкретных фабрик. Углубляться в детали компонента не обязательно — достаточно их наличия.

abstract class DBFactory {

}

interface DBConnection {}
interface DBRecord {}
interface DBQueryBuilder {}

class MySQLDBConnection implements DBConnection {}
class PostgreSQLConnection implements DBConnection {}
class OracleConnection implements DBConnection {}

class MySQLDBRecord implements DBRecord {}
class PostgreSQLRecord implements DBRecord {}
class OracleRecord implements DBRecord {}

class MySQLDBQueryBuilder implements DBQueryBuilder {}
class PostgreSQLQueryBuilder implements DBQueryBuilder {}
class OracleQueryBuilder implements DBQueryBuilder {}
