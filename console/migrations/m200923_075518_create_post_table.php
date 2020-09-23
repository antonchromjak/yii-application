<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m200923_075518_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(512)->notNull(),
            'perex' => $this->text(),
            'content' => $this->text(),
            'publishedAt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'userId' => $this->integer(11),
        ]);

        // creates index for column `userId`
        $this->createIndex(
            '{{%idx-post-userId}}',
            '{{%post}}',
            'userId'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-post-userId}}',
            '{{%post}}',
            'userId',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-post-userId}}',
            '{{%post}}'
        );

        // drops index for column `userId`
        $this->dropIndex(
            '{{%idx-post-userId}}',
            '{{%post}}'
        );

        $this->dropTable('{{%post}}');
    }
}
