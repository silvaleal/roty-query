# roty-query
Um construtor de Query SQL.

```php
$query = new QueryBuilder();
$query->q_setTable("user");
$query->q_select();
$query->q_where('role', 'user');

print_r($query->q_builder()); // SELECT * FROM user WHERE role = 'user'
```

> Este QueryBuilder faz parte do RotyPHP, um ORM para PHP.

## Documentação
Aprenda a usar o RotyPHP lendo a nossa documentação clicando [aqui](https://rotyphp.silvaleal.dev/).