<?php

namespace app\controllers;

use app\models\Response;
use app\models\TaskFilterForm;
use app\models\Task;
use Yii;
use yii\web\NotFoundHttpException;

class TasksController extends AppController
{
    /**
     * Displays page Tasks.
     *
     * @return string
     */

    public function actionIndex() :string
    {
        $this->view->title = 'Tasks - Task-Force';
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Описание страницы'], 'description');

        $filter = new TaskFilterForm();
        $filter->load(Yii::$app->request->get());

        return $this->render('index', ['filter' => $filter, 'dataProvider' => $filter->getDataProvider(),]);
    }

    public function actionView($id = null): string
    {

        $task = Task::find()
            ->where(['id' => $id])
            ->with(['category'])
            ->one();

        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }
        $this->view->title = "Задание: $task->title";

        $responses = Response::find()
            ->where(['task_id' => $id])
            ->with(['user'])
            ->all();

        foreach ($responses as $response){
            $response->user->total_reviews = \TaskForce\Helpers::getTotalReviews($response->user->id);
        }

        return $this->render('view', ['task' => $task, 'responses' => $responses,]);
    }
}
