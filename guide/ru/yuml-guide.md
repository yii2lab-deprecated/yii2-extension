Руководство
===

## Use case

```php
$lines = [
	'(note: figure 1.2{bg:beige})',
	'[User]-(Login)',
	'[Site Maintainer]-(Add User)',
	'(Add User)<(Add Company)',
	'[Site Maintainer]-(Upload Docs)',
	'(Upload Docs)<(Manage Folders)',
	'[User]-(Upload Docs)',
	'[User]-(Full Text Search Docs)',
	'(Full Text Search Docs)>(Preview Doc)',
	'(Full Text Search Docs)>(Download Docs)',
	'[User]-(Browse Docs)',
	'(Browse Docs)>(Preview Doc)',
	'(Download Docs)',
	'[Site Maintainer]-(Post New Event To The Web Site)',
	'[User]-(View Events)',
];

echo Uml::widget([
	'type' => Uml::TYPE_USE_CASE,
	'code' => UmlHelper::lines2string($lines),
]);

echo Uml::widget([
	'type' => Uml::TYPE_USE_CASE,
	'lines' => $lines,
]);
```

## Class

```php
$lines = [
	'[User|+Forename+;Surname;+HashedPassword;-Salt|+Login();+Logout()]',
];

echo Uml::widget([
	'type' => Uml::TYPE_CLASS,
	'code' => UmlHelper::lines2string($lines),
]);

echo Uml::widget([
	'type' => Uml::TYPE_CLASS,
	'lines' => $lines,
]);
```

## Activity

```php
$lines = [
	'(start)-><a>[kettle empty]->(Fill Kettle)->|b|',
    '<a>[kettle full]->|b|->(Boil Kettle)->|c|',
	'|b|->(Add Tea Bag)->(Add Milk)->|c|->(Pour Water)->(end)',
    '(Pour Water)->(end)',
];

echo Uml::widget([
	'type' => Uml::TYPE_ACTIVITY,
	'code' => UmlHelper::lines2string($lines),
]);

echo Uml::widget([
	'type' => Uml::TYPE_ACTIVITY,
	'lines' => $lines,
]);
```
