<?php
/**
 * Simple data generator
 */

class ContactsGenCommand extends CConsoleCommand {
    protected $_maleNames = array();
    protected $_femaleNames = array();
    protected $_lastNames = array();

    const PHONE_DIGITS = 6;

    public function init() {
        $this->_maleNames = $this->_loadNames('./data/names/imena_m.txt');
        $this->_femaleNames = $this->_loadNames('./data/names/imena_g.txt');
        $this->_lastNames = $this->_loadLastNames('./data/names/last_names.txt');
    }

    public function run($args) {
        if (!isset($args[0])) {
            return 0;
        }

        $count = $args[0];
        for ($i = 0; $i < $count; $i++) {
            $isMale = !!rand(0, 1);
            $name = $this->_getRandName($isMale);
            $secondName = $this->_getSecondName($this->_getRandName(true), $isMale);
            $lastName = $this->_lastNames[rand(0, count($this->_lastNames) - 1)];
            if (!$isMale) {
                $lastName .= 'а';
            }
            $birthday = date('d.m.Y', time() - ((rand(16, 70) * 12 + rand(0, 12) ) * 30 + rand(0, 31)) * 60 * 60 * 24);

            $q = new CDbCriteria;
            $q->order = 'RANDOM()';
            $street = Street::model()->find($q);

            $phone = rand(pow(10, self::PHONE_DIGITS - 1), pow(10, self::PHONE_DIGITS) - 1);

            echo "$lastName $name $secondName $birthday $street->city_id $street->name $phone\n";

            $c = new Contact();
            $c->attributes = array(
                'name' => $name,
                'second_name' => $secondName,
                'last_name' => $lastName,
                'birthday' => $birthday,
                'street_id' => $street->id,
                'phone' => $phone,
            );
            if (!$c->save()) {
                print_r($c->errors);
            }
        }
    }

    protected function _getRandName($isMale) {
        if ($isMale) {
            return $this->_maleNames[rand(0, count($this->_maleNames) - 1)];
        }
        else {
            return $this->_femaleNames[rand(0, count($this->_femaleNames) - 1)];
        }
    }


    protected function _getSecondName($name, $isMale) {
        if (substr($name, - 1) == "й") {
            $name = substr($name, 0, - 1);
            $suffix = ($isMale)? 'евич' : 'евна';
        }
        else {
            $suffix = ($isMale)? 'ович' : 'овна';
        }

        return $name . $suffix;
    }

    protected function _loadNames($path) {
        $matches = array();
        $result = array();
        foreach(file($path) as $line) {
            if (preg_match('!\t(.+)!', $line, $matches)) {
                $result[] = trim($matches[1]);
            }
        }
        return $result;
    }

    protected function _loadLastNames($path) {
        $result = array();
        foreach(file($path) as $line) {
            $result[] = trim($line);
        }
        return $result;
    }
}