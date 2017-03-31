<?php

namespace App\Jobs;

use App\Models\Link;

class CreateLinkJob
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * CreateLinkJob constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return Link
     */
    public function handle()
    {
        $link = null;

        if (is_null(array_get($this->data,'password'))
            && ($link = Link::where(['url' => array_get($this->data, 'url')])->first()) != null) {
            return $link;
        }

        try {
            $link = $this->createLink();
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                $this->createLink();
            }
        }

        return $link;
    }

    /**
     * @return mixed
     */
    protected function createLink()
    {
        $hash = str_random(5);

        array_set($this->data, 'hash', $hash);

        if (array_has($this->data, 'password')) {
            array_set($this->data, 'password', bcrypt(array_get($this->data, 'password')));
            array_set($this->data, 'url', encrypt(array_get($this->data, 'url')));
        }

        $link = Link::create($this->data);
        $link->setAttribute('hash', $hash);

        return $link;
    }
}
