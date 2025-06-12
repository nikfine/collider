<?php

namespace commands;

use Yii;
use yii\console\Controller;
use yii\db\Exception;
use yii\helpers\Console;

/**
 * @api
 */
class SeedController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex(): void
    {
        $start = microtime(true);
        Console::stdout("\rProcessing: ");
        Yii::$app->db
            ->createCommand(
                "INSERT INTO users (\"name\") SELECT (
                        md5(random()::text)
                    ) FROM generate_series(1, 100)",
            )
            ->execute();
        Yii::$app->db
            ->createCommand(
                "INSERT INTO event_types (\"name\") SELECT (
                        md5(random()::text)
                    ) FROM generate_series(1, 20);",
            )
            ->execute();
        Yii::$app->db
            ->createCommand(
                "WITH 
                      user_ids AS (SELECT array_agg(id) AS ids FROM users),
                      type_ids AS (SELECT array_agg(id) AS ids FROM event_types)
                    INSERT INTO events (user_id, metadata, type_id)
                    SELECT
                        user_ids.ids[1 + floor(random() * array_length(user_ids.ids, 1))],
                        jsonb_build_object(
                            'page', 
                            (ARRAY['/home', '/about', '/products', '/contact', '/login'])[
                                floor(random() * 5)::int + 1
                            ]
                        ),
                        type_ids.ids[1 + floor(random() * array_length(type_ids.ids, 1))]
                    FROM 
                        generate_series(1, 10000000),
                        user_ids,
                        type_ids;",
            )
            ->execute();
        Console::endProgress(1);
        Console::output(sprintf('Seeded in %.2f seconds', microtime(true) - $start));
    }

    /**
     * @return void
     * @throws Exception
     * @api
     */
    public function actionFlush(): void
    {
        $start = microtime(true);
        Console::stdout("\rProcessing: ");
        Yii::$app->db->createCommand("TRUNCATE TABLE users, event_types, events CASCADE")->execute();
        Console::endProgress(1);
        Console::output(sprintf('Flushed in %.2f seconds', microtime(true) - $start));
    }
}