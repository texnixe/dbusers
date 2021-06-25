<?php

use Kirby\Cms\App as Kirby;
use Kirby\Database\Db;

class DbKirby extends Kirby
{

    public function users()
    {
        // get cached users if available
        if ($this->users !== null) {
            return $this->users;
        }
        // instantiate a new empty DbUsers object
        $userCollection = new DbUsers([], $this);
        $contentTable   = option('cookbook.dbusers.contentTable');
        // get users from database table
        $users          = Db::select(option('cookbook.dbusers.userTable'));
        $languageCode   = $this->multilang() === true ? $this->language()->code() : option('cookbook.dbusers.defaultLanguage');

        // loop through the users collection
        foreach ($users as $user) {
            $data            = $user->toArray();
            $content         = Db::first($contentTable, '*', ['id' => $user->id(), 'language' => $languageCode]);
            $data['content'] = $content !== false ? $content->toArray() : [];


            if ($this->multilang() === true) {
                unset($data['content']);
                $data['translations'] = $this->getDbContentTranslations($contentTable, $user->id());
            }
            // create a new DbUser object for each user item
            $user = new DbUser($data);
            // and append it to the user collection
            $userCollection->append($user->id(), $user);
        }

        return $this->users = $userCollection;
    }

    /**
     * Build content translations array
     * @return array
     */
    protected function getDbContentTranslations(string $table, string $id)
    {
        $translations = [];
        foreach ($this->languages() as $language) {
            $content =  Db::first($table, '*', ['id' => $id, 'language' => $language->code()]);
            if ($language === $this->defaultLanguage()) {
                $translations[] = [
                    'code'    => $language->code(),
                    'content' => $content !== false ? $content->toArray() : [],
                    'exists' => true,
                ];
            } else {
                $translations[] =  [
                    'code'    => $language->code(),
                    'content' => [
                        'country' => $content !== false ? $content->toArray()['country'] : null,
                    ],
                    'exists' => true,
                ];
            }
        }

        return $translations;
    }
}
