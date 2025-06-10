<?php

use yii\db\Migration;

class m250604_015816_init extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE users (
                id SERIAL NOT NULL PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                created_at TIMESTAMP(0) NOT NULL DEFAULT now()
            );");
        $this->execute("CREATE TABLE event_types (
                id SERIAL NOT NULL PRIMARY KEY,
                name VARCHAR NOT NULL
            );");
        $this->execute("CREATE TABLE IF NOT EXISTS events (
                id SERIAL NOT NULL PRIMARY KEY,
                user_id bigint NOT NULL,
                type_id bigint NOT NULL,
                \"timestamp\" TIMESTAMP(0) NOT NULL DEFAULT now(),
                metadata jsonb NOT NULL,
                CONSTRAINT type_id FOREIGN KEY (type_id)
                    REFERENCES event_types (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
                    NOT VALID,
                CONSTRAINT user_id FOREIGN KEY (user_id)
                    REFERENCES users (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
                    NOT VALID
            )");
    }

    public function down()
    {
        echo "m250604_015816_init cannot be reverted.\n";

        return false;
    }

}
