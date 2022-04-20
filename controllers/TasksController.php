<?php

namespace app\controllers;

use TaskForce\TaskStrategy;
use TaskForce\Helpers;
use yii\db\Query;



class TasksController extends \yii\web\Controller
{
    /**
     * Displays page Tasks.
     *
     * @return string
     */

    public function actionIndex()
    {
        $query = new Query();
        $query->select(['task.title as taskTitle', 'task.description', 'task.budget', 'task.creation_date', 'category.title as categoryTitle', 'city.title as cityTitle'])
            ->from('task')
            ->join('Left JOIN', 'category', 'task.category_id = category.id')
            ->join('Left JOIN', 'city', 'task.city_id = city.id')
            ->where (['task.status' => TaskStrategy::STATUS_NEW])
            ->orderBy(['task.creation_date' => SORT_DESC])
            ->limit(3);
        $tasks = $query->all();

        foreach ($tasks as $key => $task) {
            $tasks[$key]['creation_date'] = Helpers::getTimePassed($task['creation_date']);
        }

        return $this->render('index', compact('tasks'));
    }
}