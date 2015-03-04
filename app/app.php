<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    session_start();

    if (empty($_SESSION['list_of_tasks'])) {
        $_SESSION['list_of_tasks'] = array();
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __Dir__.'/../views'
    ));

    $app->get("/", function() use ($app) {

        return $app['twig']->render('tasks.php', array('tasks' => Task::getAll()));

    });

    $app->post("/tasks", function() {
            $task = new Task($_POST['description']);
            $task->save();
            return  $app['twig']->render('create_task.php');

    });
    $app->post("/delete_tasks", function() {

            Task::deleteAll();

            return "
                <h1>List Cleared!</h1>
                <p><a href='/'>Home</a></p>
            ";
    });

    return $app;
?>
