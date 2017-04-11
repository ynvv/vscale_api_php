# VSCALE.IO API client
API клиент для связи с vscale.io.
Для работы класса нужна библиотека [Unirest](https://github.com/Mashape/unirest-php)

# Пример

```php
require 'vscale.class.php';
$vscale = new Vscale('token');

// Получаем баланс
$balance = $vscale->getBalance();

// Сам баланс
echo $balance['balance'];

// Бонусы
echo $balance['bonus'];
```

# Методы

Метод | Описание
------------ | -------------
getAccountDetails() | Информация об аккаунте
createScalet($system, $plan, $name, $password, $location) | Создание скалета. Получить имя образа, план и локацию можно через методы ниже
getScaletInfo($scaletid) | Информация о скалете
restartScalet($scaletid)| Перезагрузка скалета
reinstallScalet($scaletid, $new_password)| Переустановка системы
stopScalet($scaletid)| Остановка скалета
startScalet($scaletid)| Запуск скалета
upgradeScalet($scaletid, $to_plan)| Апгрейд тарифного плана (только в большую сторону)
deleteScalet($scaletid)| Удаление скалета
getTasks()| Получение активных заданий (установка, перезапуск, etc)
addScaletKeys($scaletid, $keys)| Добавление SSH ключа
createBackup($scaletid, $name)| Создание бекапа
restoreBackup($scaletid, $backup)| Восстановление бекапа
addTags($tagname, $scalets)| Создание тегов к скалетам
getTags()| Получение списка тегов
getTagInfo($tagid)| Получение информации о теге
updateTag($tagid, $name, $scalets)| Обновление информации о теге
deleteTag($tagid)| Удаление тега
getBackupList()| Получение списка бекапов
getBackupInfo($backupid)| Получение информации о бекапе
deleteBackup($backupid)| Удаление бекапа
relocateBackup($backupid, $to)| Перемещение бекапа между локациями
getLocations()| Получение информации о локациях
getImageList()| Получение информации об образах систем
getPlanList()| Получение информации о тарифных планах
getPrices()| Получение цен 
getSSHkeys()| Получение списка SSH ключей
addSSHkey($name, $key)| Добавление SSH ключа
deleteSSHKey($keyid)| Удаление SSH ключа
getNotifyBalance()| Получение баланса, при котором придет уведомление о малом балансе
setNotifyBalance($value)| Изменение баланса, о котором сказано выше
getBalance()| Получение информации о балансе
getPayments()| Получение списка транзакций
getRangePayments($start, $end)| Получение транзакций в определенный период (в формате ГГГГ-ММ-ДД)
getDomainsList()| Получение списка доменов
addDomain($domain)| Добавление домена
getDomainInfo($domainid)| Получение информации о домене
updateDomainInfo($domainid, $tags)| Обновление информации о домене
deleteDomain($domainid)| Удаление домена
getDomainRecords($domainid)| Получение DNS записей домена
addDomainRecord($domainid, $domain, $type, $content, $ttl)| Добавление DNS записи 
updateDomainRecord($domainid, $recordid, $domain, $type, $content, $ttl)| Обновление DNS записи у домена
deleteDomainRecord($domainid, $recordid)| Удаление DNS записи
getDomainRecord($domainid, $recordid)| Получение DNS записи
addDomainTag($tagname)| Добавление тега к домену
getDomainTags()| Получение списка тегов для доменов
getDomainTagInfo($tagid)| Получение информации у тега
updateDomainTag($tagid, $name, $domains)| Обновление тега домена
deleteDomainTag($tagid)| Удаление тега домена
addPTRrecord($ip, $content)| Добавление PTR записи к IP
getPTRrecords()| Получение списка PTR записей
updatePTRrecord($ptrid, $ip, $content)| Обновление PTR записи
deletePTRrecord($ptrid)| Удаление PTR записи
