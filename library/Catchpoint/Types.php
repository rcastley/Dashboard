<?php
class Catchpoint_Types
{

	public function Types ($typeId)
	{
		$types = array(
			0 => 'Web',
			1 => 'Transaction',
			2 => 'HTML Code',
			3 => 'FTP',
			4 => 'TCP',
			5 => 'DNS',
			6 => 'Ping',
			7 => 'SMTP',
			8 => 'UDP',
			9 => 'API',
			10 => 'Streaming'
		);

		return $types[$typeId];
	}
}