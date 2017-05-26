<?php namespace Phoenix\EloquentMeta;

use Illuminate\Support\Collection;
use Phoenix\EloquentMeta\Meta;

trait MetaTrait
{
    /**
     * Gets all meta data
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllMeta()
    {
        return new Collection($this->meta()->pluck('value', 'key'));
    }

    /**
     * Gets meta data
     *
     * @param $key
     * @param null $default
     * @param bool $getObj
     * @return Collection
     */
    public function getMeta($key, $default = null, $getObj = false)
    {
        $meta = $this->meta()
            ->where('key', $key)
            ->get();

        if ($getObj) {
            $collection = $meta;

        } else {
            $collection = new Collection();

            foreach ($meta as $m) {
                $collection->put($m->id, $m->value);
            }
        }

        // Were there no records? Return NULL if no default provided
        if (0 == $collection->count()) {
            return $default;
        }

        return $collection->count() <= 1 ? $collection->first() : $collection;
    }

    /**
     * Updates meta data
     *
     * @return mixed
     */
    public function updateMeta($key, $newValue, $oldValue = false)
    {
        $meta = $this->getMeta($key, null, true);

        if ($meta == null) {
            return $this->addMeta($key, $newValue);
        }

        $obj = $this->getEditableItem($meta, $oldValue);

        if ($obj !== false) {
            $isSaved = $obj->update([
                'value' => $newValue
            ]);

            return $isSaved ? $obj : $obj->getErrors();
        }

        return null;
    }

    /**
     * Adds meta data
     *
     * @return mixed
     */
    public function addMeta($key, $value)
    {
        $existing = $this->meta()
            ->where('key', $key)
            ->where('value', Helpers::maybeEncode($value))
            ->first();

        if ($existing) {
            return false;
        }

        $meta = $this->meta()->create([
            'key'   => $key,
            'value' => $value,
        ]);

        return $meta->isSaved() ? $meta : $meta->getErrors();
    }

    /**
     * Appends a value to an existing meta entry
     * Resets all keys
     *
     * @return mixed
     */
    public function appendMeta($key, $value)
    {
        $meta = $this->getMeta($key);

        if (!$meta) {
            $meta = [];

        } elseif (!is_array($meta)) {
            $meta = [$meta];
        }

        if (is_array($value)) {
            $meta = array_merge($meta, $value);
        } else {
            $meta[] = $value;
        }

        return $this->updateMeta($key, array_values(array_unique($meta)));
    }

    /**
     * Deletes meta data
     *
     * @param $key
     * @param bool $value
     * @return mixed
     */
    public function deleteMeta($key, $value = false)
    {
        if ($value) {
            $meta = $this->getMeta($key, null, true);

            if ($meta == null) {
                return false;
            }

            $obj = $this->getEditableItem($meta, $value);

            return $obj !== false ? $obj->delete() : false;

        } else {
            return $this->meta()->where('key', $key)->delete();
        }
    }

    /**
     * Deletes all meta data
     *
     * @return mixed
     */
    public function deleteAllMeta()
    {
        return $this->meta()->delete();
    }

    /**
     * Gets an item to edit
     *
     * @return mixed
     */
    protected function getEditableItem($meta, $value)
    {
        if ($meta instanceof Collection) {
            if ($value === false) {
                return false;
            }

            $filtered = $meta->filter(function($m) use ($value) {
                return $m->value == $value;
            });

            $obj = $filtered->first();

            if ($obj == null) {
                return false;
            }

        } else {
            $obj = $meta;
        }

        return $obj->exists ? $obj : false;
    }

    /**
     * Attaches meta data
     *
     * @return object
     */
    public function meta()
    {
        $meta_model = isset($this->meta_model) ? $this->meta_model : Meta::class;
        return $this->morphMany($meta_model, 'metable');
    }
}
