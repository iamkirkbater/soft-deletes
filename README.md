#Soft Deletes Trait for Laravel Testing

This is a trait for extending Laravel 5.1 testing functionality, to see if something has been soft-deleted in the database.

##Usage:

First, require the composer package: `composer require kirkbater/soft-deletes`

Then, add the soft deletes functionality to your test:

```php
<?php

use Kirkbater\Testing\SoftDeletes;

class MyTestClass extends TestClass {

    use SoftDeletes;

}
```

Then, write your unit tests, just like normal:

```php
<?php

...

public function tests_that_its_soft_deleted()
{
    $user = [
        "id" => 1,
        "first" => "Test",
        "last" => "Name",
        "username" => "txltwc"
    ];

    $response = $this->call('delete', '/users/'.$user->id, []);
    $this->assertEquals(200, $response->status());
    $this->seeInDatabase("users", $user);
    $this->seeIsSoftDeletedInDatabase("users", $user);
}
