<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%post}}`
 */
class m200924_070713_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text(),
            'userId' => $this->integer(11),
            'postId' => $this->integer(11),
        ]);

        // creates index for column `userId`
        $this->createIndex(
            '{{%idx-comment-userId}}',
            '{{%comment}}',
            'userId'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-comment-userId}}',
            '{{%comment}}',
            'userId',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `postId`
        $this->createIndex(
            '{{%idx-comment-postId}}',
            '{{%comment}}',
            'postId'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-comment-postId}}',
            '{{%comment}}',
            'postId',
            '{{%post}}',
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
            '{{%fk-comment-userId}}',
            '{{%comment}}'
        );

        // drops index for column `userId`
        $this->dropIndex(
            '{{%idx-comment-userId}}',
            '{{%comment}}'
        );

        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-comment-postId}}',
            '{{%comment}}'
        );

        // drops index for column `postId`
        $this->dropIndex(
            '{{%idx-comment-postId}}',
            '{{%comment}}'
        );

        $this->dropTable('{{%comment}}');
    }
}
