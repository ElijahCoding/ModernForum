<?php

namespace App;

use Redis;

trait RecordsVisits
{
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey());
    }

    public function resetVisits()
    {
        return Redis::del($this->visitsCacheKey());

        return $this;
    }

    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}
