<?php

namespace Gregoriohc\LaravelTrello;

use Illuminate\Config\Repository;
use Trello\Client;
use Trello\Manager;

class Wrapper
{
    /**
     * The config instance
     *
     * @var Repository
     */
    public $config;

    /**
     * The trello client instance
     *
     * @var \Trello\Client
     */
    private $client;

    /**
     * The trello manager instance
     *
     * @var \Trello\Manager
     */
    private $manager;

    /**
     * Client cache
     *
     * @var array
     */
    private $cache;

    /**
     * Client constructor
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        // Get the config data
        $this->config = $config;

        // Make the client instance
        $this->client = new Client();
        $this->client->authenticate($this->config->get('trello.api_key'), $this->config->get('trello.api_token'), Client::AUTH_URL_CLIENT_ID);
    }

    /**
     * Returns trello manager instance
     *
     * @return \Trello\Manager
     */
    public function manager()
    {
        if (!isset($this->manager)) {
            $this->manager = new Manager($this->client);
        }

        return $this->manager;
    }

    /**
     * Returns a trello object id by a given name
     *
     * @param string $type
     * @param string $name
     * @param array $options
     * @return bool|string
     */
    public function getObjectId($type, $name, $options = [])
    {
        switch ($type) {
            case 'organization':
                if (!isset($this->cache['organizations'])) {
                    $this->cache['organizations'] = $this->api('member')->organizations()->all('me');
                }

                foreach ($this->cache['organizations'] as $item) {
                    if ($name == $item['name']) {
                        return $item['id'];
                    }
                }

                break;
            case 'board':
                if (!isset($options['organization'])) {
                    $options['organization'] = $this->config->get('trello.organization');
                }
                $organizationId = $this->getObjectId('organization', $options['organization']);

                if (!isset($this->cache['boards'])) {
                    $this->cache['boards'] = $this->api('member')->boards()->all('me');
                }

                foreach ($this->cache['boards'] as $item) {
                    if ($name == $item['name'] && $organizationId == $item['idOrganization']) {
                        return $item['id'];
                    }
                }

                // Workaround for shared boards
                foreach ($this->cache['boards'] as $item) {
                    if ($name == $item['name']) {
                        return $item['id'];
                    }
                }

                break;
            case 'list':
                if (!isset($options['organization'])) {
                    $options['organization'] = $this->config->get('trello.organization');
                }
                if (!isset($options['board'])) {
                    $options['board'] = $this->config->get('trello.board');
                }

                $boardId = $this->getObjectId('board', $options['board'], ['organization' => $options['organization']]);
                if (!isset($this->cache['lists'][$boardId])) {
                    $this->cache['lists'][$boardId] = $this->api('board')->lists()->all($boardId);
                }

                foreach ($this->cache['lists'][$boardId] as $item) {
                    if ($name == $item['name']) {
                        return $item['id'];
                    }
                }

                break;
            case 'label':
                if (!isset($options['organization'])) {
                    $options['organization'] = $this->config->get('trello.organization');
                }
                if (!isset($options['board'])) {
                    $options['board'] = $this->config->get('trello.board');
                }

                $boardId = $this->getObjectId('board', $options['board'], ['organization' => $options['organization']]);
                if (!isset($this->cache['labels'][$boardId])) {
                    $this->cache['labels'][$boardId] = $this->api('board')->labels()->all($boardId);
                }

                foreach ($this->cache['labels'][$boardId] as $item) {
                    if ($name == $item['name']) {
                        return $item['id'];
                    }
                }

                break;
        }

        return false;
    }

    /**
     * Returns default organization id
     *
     * @return Manager
     */
    public function getDefaultOrganizationId()
    {
        return $this->getObjectId('organization', $this->config->get('trello.organization'));
    }

    /**
     * Returns default board id
     *
     * @return Manager
     */
    public function getDefaultBoardId()
    {
        return $this->getObjectId('board', $this->config->get('trello.board'));
    }

    /**
     * Returns default list id
     *
     * @return Manager
     */
    public function getDefaultListId()
    {
        return $this->getObjectId('list', $this->config->get('trello.list'));
    }

    /**
     * Handle dynamic calls to the client
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->client, $name], $arguments);
    }
}