<?php

namespace App\Exclude;


use Psr\Cache\CacheItemPoolInterface;

class ContactCsvCache implements ContactInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;
    /**
     * @var ContactCsv
     */
    private $contact;

    public function __construct(
        CacheItemPoolInterface $cache,
        ContactCsv $contact
    ) {
        $this->cache = $cache;
        $this->contact = $contact;
    }

    /**
     * Reads the cache to find the contact.
     *
     * @param string $id The contact id
     *
     * @return array|null An associative array representing the contact or null if not found
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function find(string $id): ?array
    {
        $entry = $this->cache->getItem($id);
        if (!$entry->isHit()) {
            $new = $this->contact
                ->find($id);
            $new['from'] = 'cache';
            $entry->set($new);
            $this->cache->save($entry);
        }

        return $entry->get();
    }

    /**
     * @param array $contact The contact to add
     */
    public function add(array $contact): void
    {
        // TODO: Implement add() method.
    }
}