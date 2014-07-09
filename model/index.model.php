<?php

class index extends medoo
{
	public function hello()
	{
		$datas[0] = 'This is function hello() of model index.';
		$datas[1] = 'datas from database.';
		return $datas;
	}
}