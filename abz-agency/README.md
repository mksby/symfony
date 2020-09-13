```
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
php bin/console doctrine:database:create
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

https://www.json-generator.com/
https://www.convertjson.com/json-to-sql.htm

```
[
  '{{repeat(60000)}}',
  {
    first_name: '{{firstName()}}',
    middle_name:  '{{surname()}}',
    last_name:  '{{surname()}}',
    start_date: '{{date(new Date(2020, 0, 1), new Date(), "YYYY-MM-dd hh:mm:ss")}}',
    salary: '{{integer(10000, 100000)}}'
  }
]
```

```sql
INSERT INTO worker (first_name, middle_name, last_name, start_date, salary, manager) VALUES ("first name 1", "middle name 1", "last name 1", "2020-01-30 14:15:30", 5000, NULL);
```