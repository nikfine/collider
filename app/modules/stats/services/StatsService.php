<?php

namespace modules\stats\services;

use models\EventsModel;
use models\EventTypesModel;
use modules\stats\validators\StatsValidator;
use yii\db\Expression;
use yii\web\HttpException;

class StatsService
{
    /**
     * @throws HttpException
     */
    public function get(StatsValidator $validator): array
    {
        if (!$validator->validate()) {
            throw new HttpException(400, json_encode($validator->errors));
        }
        $mainQuery = EventsModel::find()
            ->alias('e')
            ->select([
                'total_events' => new Expression('COUNT(*)'),
                'unique_users' => new Expression('COUNT(DISTINCT e.user_id)'),
            ])
            ->innerJoin(['t' => EventTypesModel::tableName()], 't.id = e.type_id')
            ->where(['between', 'e.timestamp', $validator->from, $validator->to])
            ->andWhere(['t.name' => $validator->type])
            ->asArray();

        $topPagesQuery = EventsModel::find()
            ->alias('e')
            ->select([
                'page_path' => new Expression("e.metadata->>'page'"),
                'page_count' => new Expression('COUNT(*)'),
            ])
            ->innerJoin(['t' => EventTypesModel::tableName()], 't.id = e.type_id')
            ->where(['between', 'e.timestamp', $validator->from, $validator->to])
            ->andWhere(['t.name' => $validator->type])
            ->groupBy(new Expression("e.metadata->>'page'"))
            ->orderBy(['page_count' => SORT_DESC])
            ->limit(2)
            ->asArray();

        $stats = $mainQuery->one();
        $topPages = $topPagesQuery->all();

        $formattedTopPages = [];
        foreach ($topPages as $page) {
            $formattedTopPages[$page['page_path']] = (int)$page['page_count'];
        }
        return [
            'total_events' => (int)$stats['total_events'],
            'unique_users' => (int)$stats['unique_users'],
            'top_pages' => $formattedTopPages,
        ];
    }
}