Руководство
===

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