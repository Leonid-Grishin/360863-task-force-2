<?php

namespace TaskForce\data;

use app\models\Task;
use TaskForce\Helpers;
use TaskForce\TaskStrategy;
use yii\db\Query;

class TasksQuery
{
    /**
     * @return array
     */
    public static function getQuery(): array
    {
/*        $query = new Query();
        $query->select(['task.title as taskTitle', 'task.description', 'task.budget', 'task.creation_date', 'category.title as categoryTitle', 'city.title as cityTitle'])
            ->from('task')
            ->join('Left JOIN', 'category', 'task.category_id = category.id')
            ->join('Left JOIN', 'city', 'task.city_id = city.id')
            ->where (['task.status' => TaskStrategy::STATUS_NEW])
            ->orderBy(['task.creation_date' => SORT_DESC])
            ->limit(5);
        $tasks = $query->all();*/

        $tasks = Task::find()
            ->where (['status' => TaskStrategy::STATUS_NEW])
            ->joinWith( 'category')
            ->joinWith( 'city')
            ->orderBy(['task.creation_date' => SORT_DESC])
            ->limit(2)
            ->all();
        var_dump($tasks);

        foreach ($tasks as $key => $task) {
            $tasks[$key]['creation_date'] = Helpers::getTimePassed($task['creation_date']);
        }
        return $tasks;
    }
}
