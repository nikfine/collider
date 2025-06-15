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
    private const array EVENT_TYPES = [
        'user.registered',
        'user.login',
        'user.logout',
        'user.updated',
        'order.created',
        'order.paid',
        'order.shipped',
        'order.delivered',
        'payment.processed',
        'payment.failed',
        'payment.refunded',
        'product.viewed',
        'product.added_to_cart',
        'product.removed_from_cart',
        'email.sent',
        'email.opened',
        'email.clicked',
        'notification.sent',
        'notification.read',
        'api.request',
        'api.response',
        'api.error',
        'user.password_reset_requested',
        'user.password_changed',
        'user.two_factor_enabled',
        'user.two_factor_disabled',
        'user.deleted',
        'user.suspended',
        'user.reactivated',
        'user.subscription_started',
        'user.subscription_cancelled',
        'user.subscription_renewed',
        'user.invited',
        'user.invite_accepted',
        'user.feedback_submitted',
        'user.avatar_uploaded',
        'user.preferences_updated',
        'user.email_verified',
        'user.login_failed',
        'user.profile_viewed',
        'user.notification_preferences_updated',
        'user.newsletter_subscribed',
        'order.cancelled',
        'order.return_requested',
        'order.return_approved',
        'order.return_rejected',
        'order.review_submitted',
        'order.invoice_generated',
        'payment.pending',
        'payment.disputed',
        'payment.settled',
        'cart.viewed',
        'cart.updated',
        'cart.cleared',
        'checkout.started',
        'checkout.completed',
        'product.review_submitted',
        'product.wishlisted',
        'product.unwishlisted',
        'product.compared',
        'product.shared',
        'product.restock_requested',
        'product.stock_low',
        'email.bounced',
        'email.unsubscribed',
        'notification.dismissed',
        'notification.failed',
        'session.started',
        'session.expired',
        'session.terminated',
        'admin.login',
        'admin.logout',
        'admin.updated_user',
        'admin.deleted_user',
        'admin.generated_report',
        'admin.settings_updated',
        'file.uploaded',
        'file.deleted',
        'file.downloaded',
        'file.previewed',
        'support.ticket_created',
        'support.ticket_closed',
        'support.ticket_reopened',
        'support.message_sent',
        'support.rating_submitted',
        'search.performed',
        'search.filtered',
        'search.sorted',
        'settings.updated',
        'language.changed',
        'timezone.changed',
        'api.token_generated',
        'api.token_revoked',
        'api.rate_limited',
        'cron.job_started',
        'cron.job_finished',
        'cron.job_failed',
        'webhook.received',
        'webhook.verified',
        'webhook.failed',
    ];

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
        foreach (self::EVENT_TYPES as $type) {
            Yii::$app->db
                ->createCommand(
                    "INSERT INTO event_types (\"name\") VALUES ('{$type}');",
                )
                ->execute();
        }
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
        Yii::$app->db->createCommand("TRUNCATE TABLE users, event_types, events RESTART IDENTITY CASCADE")->execute();
        Console::endProgress(1);
        Console::output(sprintf('Flushed in %.2f seconds', microtime(true) - $start));
    }
}