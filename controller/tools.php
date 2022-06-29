<?php

Class Tools
{
	public static function isCleanHtml($html)
	{
		$events = 'onmousedown|onmousemove|onmmouseup|onmouseover|onmouseout|onload|onunload|onfocus|onblur|onchange';
		$events .= '|onsubmit|ondblclick|onclick|onkeydown|onkeyup|onkeypress|onmouseenter|onmouseleave|onerror|onselect|onreset|onabort|ondragdrop|onresize|onactivate|onafterprint|onmoveend';
		$events .= '|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onmove';
		$events .= '|onbounce|oncellchange|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondeactivate|ondrag|ondragend|ondragenter|onmousewheel';
		$events .= '|ondragleave|ondragover|ondragstart|ondrop|onerrorupdate|onfilterchange|onfinish|onfocusin|onfocusout|onhashchange|onhelp|oninput|onlosecapture|onmessage|onmouseup|onmovestart';
		$events .= '|onoffline|ononline|onpaste|onpropertychange|onreadystatechange|onresizeend|onresizestart|onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onsearch|onselectionchange';
			

		return (!preg_match('/<[ \t\n]*script/ui', $html) && !preg_match('/<.*('.$events.')[ \t\n]*=/ui', $html) && !preg_match('/<[\s]*(i?frame|form|input|embed|object)/ims', $html)  && !preg_match('/.*script\:/ui', $html));
	}
	public static function cleanTags($pattern)
    {
        return preg_replace('/\\\[px]\{[a-z]{1,2}\}|(\/[a-z]*)u([a-z]*)$/i', '$1$2', $pattern);
    }
	public static function isInt($value)
	{
		return ((string)(int)$value === (string)$value || $value === false);
	}
	public static function isName($name)
    {
        return empty($name) || preg_match(Tools::cleanCode('/^[^<>={}]*$/u'), $name);
    }
	public static function cleanCode($data)
    {
        return preg_replace('/\\\[px]\{[a-z]{1,2}\}|(\/[a-z]*)u([a-z]*)$/i', '$1$2', $data);
    }
	public static function isPrice($price)
    {
        return preg_match('/^[0-9]{1,10}(\.[0-9]{1,9})?$/', $price);
    }
	public static function isSubmit($submit)
	{
		return (
			isset($_POST[$submit]) || isset($_POST[$submit.'_x']) || isset($_POST[$submit.'_y'])
			|| isset($_GET[$submit]) || isset($_GET[$submit.'_x']) || isset($_GET[$submit.'_y'])
		);
	}
	public static function getValue($key, $default_value = false)
	{
		if (!isset($key) || empty($key) || !is_string($key))
			return false;
		$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default_value));

		if (is_string($ret) === true)
			$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
		return !is_string($ret)? $ret : stripslashes($ret);
	}
	public static function insert($table,  $values) {
		global $db;
		$prep = array();
		foreach($values as $k => $v ) {
			$prep[':'.$k] = $v;
		}
		$sth = $db->prepare("INSERT INTO ".$table." ( " . implode(', ',array_keys($values)) . ") VALUES (" . implode(', ',array_keys($prep)) . ")");
		$res = $sth->execute($prep);
		if ($res) {
			return $db->lastInsertId();
		}
		else
			return $sth->errorInfo();
	}
	public static function update($table,  $data, $where) {
		global $db;
		$prep = array();
		foreach($data as $k => $v ) {
			$prep[$k.' = :'.$k] = $v;
		}
		
		$sth = $db->prepare("UPDATE ".$table." SET ".  implode(', ',array_keys($prep)) ."  WHERE ".$where."");
		$res = $sth->execute($data);
	}
	public static function getRow($table,  $where, $cloumn) {
		global $db;
		$datas = $db->query('SELECT * FROM '.$table.' WHERE '.$where.' LIMIT 1')->fetchAll();
		foreach ($datas as $data)
		{
			return $data[$cloumn];
		}
	}
	public static function getQuery($table,  $where) {
		global $db;
		return $db->query('SELECT * FROM '.$table.' WHERE '.$where.'')->fetchAll();
	}
	public static function deleteQuery($table,  $where) {
		global $db;
		return $db->query('DELETE FROM '.$table.' WHERE '.$where.'')->fetchAll();
	}
	public static function isHaveAttirupe($idProduct)
	{
		if (Tools::isInt($idProduct))
		{
			if(Tools::getRow('attirupe_grup', 'id_product = '.(int)$idProduct.'', 'id_grup'))
				return 1;
			else
				return 0;
		}
	}
}