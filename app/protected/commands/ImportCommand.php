<?php
/**
 * Import references from file
 */

class ImportCommand extends CConsoleCommand {
    public function run($args) {
        foreach (CFileHelper::findFiles('./data/ref/') as $path) {
            foreach (file($path) as $i => $line) {
                if ($i == 0) {
                    $city = new City;
                    $city->name = $line;
                    $city->save();
                    continue;
                }

                $street = new Street();
                $street->name = $line;
                $street->city_id = $city->id;
                $street->save();
            }
        }
    }
}