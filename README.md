# Dependency Injection
##Как все работает
основано на PSR 7 спецификации

### Инициализация
```php
use Sweetkit\Foundation\Di\Container;
use Sweetkit\Foundation\Di\Reader;
use Sweetkit\Foundation\Di\Adapter\ArrayFileAdapter;

$di = new Container;
```

### Подготовленная загрузка
```php
$file = "/Volumes/data/data/www/localhost/services.php";
$di = new Container(new Reader(new ArrayFileAdapter($file)));
```

### Добавление элемента
```php
$di->set("Имя элемента", 'Класс элемента','Загружать каждый');
$di->set("log","Sweetkit\Foundation\Log\Logger",true);
```

### Назначение параметров
##### Параметры конструктора
```php
$di->setArgument("log", "/volumes/file");
```
##### Аттрибуты класса
```php
$di->setAttribute("log","log_param", "log_value");
```
##### Вызов методов
```php
$di->setMethodCall("log", "print", [new LoggerViewHtml]);
```
### Получение элемента
```php
$log = $di->get("log");
```

##На будущее 
- Добавить тэги 