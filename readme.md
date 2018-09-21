<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

# Unit Testing in Laravel
## Test Driven Development (TDD)

- Don’t write any production code until you have written a failing unit test.
- Don’t write more of a unit test than is sufficient to fail or fail to compile.
- Don’t write any more production code than is sufficient to pass the failing test.

This would force us to write clean, readable, maintainable code and a decoupled software! This cycle should be repeated in every minute or two, allowing us to be confident with making changes, refactoring, etc.

<p align="center"><img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Test-driven_development.PNG"></p>

## Unit Tests

<pre>php artisan make:test UserTest --unit</pre>

<p align="center"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Testing_Pyramid.svg/2000px-Testing_Pyramid.svg.png"></p>

Unit tests normally focus on a single method of a class, or the class itself. A unit is basically the smallest testable part of the application. In the most ideal case, the amount of your unit tests should equal to the amount of your code. Every method on your Models should have a test behind it. It tests each system of your application separately.

### Examples

````php
/** @test */
public function a_task_can_be_completed()
{
    $task = factory(Task::class)->create();

    $task->complete();

    $this->assertTrue($task->isComplete());
}

/** @test */
public function a_task_belongs_to_a_user()
{
    $task = factory(Task::class)->create();

    $this->assertEquals($task->user_id, $task->user->id);
}
````

## Feature Tests (or Integration Tests)

<pre>php artisan make:test GetDeviceTest</pre>

Feature Tests sit on the top of our Unit Tests, making sure that different Controllers, Models, etc. of our application can communicate with each other correctly. It tests the entire system as an integrated application. It is also called end-to-end testing, meaning that it takes a user action as an input, and asserts the expected output.

### Examples

````php
/** @test */
public function a_user_can_add_a_new_task()
{
    $this->loginWithFakeUser();

    $task = [
        'body' => 'Do the shopping',
        'user_id' => self::USER_ID,
    ];

    $this->post('/tasks', $task);

    $user = Auth::user();
    $tasks = $user->tasks;

    $this->assertEquals(1, count($tasks));
}
````

## Writing Tests

A test case normally includes 3 phases: Arrange -Act – Assert

In the Arrange phase you would setup the required environment for the actual test. For example create a user, or a product, what you are planning to test.
The Act phase is the action you are testing, for example add new products to a user.
In the Assert phase you assert that the result after your action (it can also be the status of the response for example) matches what you expected.

````php
/** @test */
public function a_user_can_complete_a_task()
{
    // Arrange
    $this->loginWithFakeUser();
    $tasks = factory(Task::class, 5)->create([
        'user_id' => self::USER_ID
    ]);
    $taskToBeCompleted = $tasks[0]->id;

    // Act
    $this->post('/tasks/complete/' . $taskToBeCompleted);

    // Assert
    $task = Task::find($taskToBeCompleted);
    $this->assertTrue(boolval($task->completed));
}
````
Find available assertions here: https://phpunit.readthedocs.io/en/7.3/index.html

## Database

Often you will need to test Controllers dealing with different Models, or Models connecting to the Database, etc., you must use a testing database. For this purpose, SQLite is a great choice as it can live in the memory which will make your tests lightning fast.

It is essential to have your migrations defined correctly, as PHPUnit is going to build up your testing database every time before running any tests, then run your migrations to create the table structure. When your tests finished, PHPUnit is going tear down the DB.

- Create .env.testing config file, set `APP_ENV` to `testing` and `DB_CONNECTION` to `sqlite_testing`
- Add new connection to config/database.php connections
    <pre>'sqlite_testing' => [
                     'driver' => 'sqlite',
                     'database' => ':memory:',
                     'prefix' => '',
                 ],
     </pre>
- Extend tests/TestCase.php
    ````php
    public function setUp()
             {
                 parent::setUp();
                 Artisan::call('migrate');
             }
             public function tearDown()
             {
                 Artisan::call('migrate:reset');
                 parent::tearDown();
             }
    ````
- Load the testing environment in tests/CreatesApplication.php
    ````php
    public function createApplication()
        {
            $app = require __DIR__.'/../bootstrap/app.php';
    
            $app->loadEnvironmentFrom('.env.testing');
    
            $app->make(Kernel::class)->bootstrap();
    
            return $app;
        }
  ````

## Model Factories

Most of the time while you are testing, you will just want to have some records in the DB, not worrying about real data. Model Factories come really handy when writing your tests, as you can easily populate some random users, combining the Faker Class with Factories. See more information here: https://laravel.com/docs/5.7/database-testing#writing-factories

## PHPStorm configuration

Configuring PHPStorm to run your tests should be pretty straightforward, however, it really depends on your local development environment. You can <a href="https://www.jetbrains.com/help/phpstorm/enabling-php-unit-support.html">find some instructions here.</a>
