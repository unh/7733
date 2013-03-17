<?php

class m130317_063329_add_phone_to_contacts extends CDbMigration
{
	public function up()
	{
        $this->addColumn('contacts', 'phone', 'varchar(15)');
	}

	public function down()
	{
		echo "m130317_063329_add_phone_to_contacts does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}