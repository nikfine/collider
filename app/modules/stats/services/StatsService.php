<?php

namespace modules\stats\services;

use models\EventsModel;
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
            ->select([
                'total_events' => new Expression('COUNT(*)'),
                'unique_users' => new Expression('COUNT(DISTINCT user_id)'),
            ])
            ->where(['between', 'timestamp', $validator->from, $validator->to])
            ->andWhere(['type_id' => $validator->type])
            ->asArray();

        $topPagesQuery = EventsModel::find()
            ->select([
                'page_path' => new Expression("metadata->>'page'"),
                'page_count' => new Expression('COUNT(*)'),
            ])
            ->where(['between', 'timestamp', $validator->from, $validator->to])
            ->andWhere(['type_id' => $validator->type])
            ->groupBy(new Expression("metadata->>'page'"))
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