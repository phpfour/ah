<?php

namespace App\Utility;

use Elastica\Client;
use Elastica\Document;
use Elastica\Query;
use Elastica\Request;
use Elastica\Search;

class Elastica
{
    /**
     * Elastica client.
     *
     * @var \Elastica\Client
     */
    protected $client;

    /**
     * Initialize Elastica
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get an index.
     *
     * @param $index
     * @return \Elastica\Index
     */
    public function getIndex($index)
    {
        return $this->client->getIndex($index);
    }

    /**
     * Create an index.
     *
     * @param $index
     */
    public function createIndex($index)
    {
        $index = $this->getIndex($index);

        if ($index->exists() === false) {
            $index->create();
        }
    }

    /**
     * Find a document by id.
     *
     * @param $id
     * @param $type
     * @param $index
     *
     * @return bool|Document
     */
    public function find($id, $type, $index = 'activehire')
    {
        $path = $index . '/' . $type . '/' . $id;
        $response = $this->client->request($path);

        if ($response->isOk()) {
            $responseData = $response->getData();
            return $this->createDocument($responseData['_source'], $type, $index);
        }

        return false;
    }

    /**
     * Create a new document object and return for further usage.
     *
     * @param array  $data
     * @param string $type
     * @param string $index
     *
     * @return Document
     */
    public function createDocument($data = [], $type, $index = 'activehire', $id = '')
    {
        return new Document($id, $data, $type, $index);
    }

    /**
     * Uses _bulk to send documents to the server.
     *
     * Array of \Elastica\Document as input. Index and type has to be
     * set inside the document, because for bulk settings documents,
     * documents can belong to any type and index
     *
     * @param  array|\Elastica\Document[]           $docs Array of Elastica\Document
     * @return \Elastica\Bulk\ResponseSet           Response object
     * @throws \Elastica\Exception\InvalidException If docs is empty
     * @link http://www.elasticsearch.org/guide/reference/api/bulk.html
     */
    public function addDocuments(array $docs)
    {
        return $this->client->addDocuments($docs);
    }

    /**
     * Uses _bulk to send documents to the server.
     *
     * Array of \Elastica\Document as input. Index and type has to be
     * set inside the document, because for bulk settings documents,
     * documents can belong to any type and index
     *
     * @param  array|\Elastica\Document[]           $docs Array of Elastica\Document
     * @return \Elastica\Bulk\ResponseSet           Response object
     * @throws \Elastica\Exception\InvalidException If docs is empty
     * @link http://www.elasticsearch.org/guide/reference/api/bulk.html
     */
    public function updateDocuments(array $docs)
    {
        return $this->client->updateDocuments($docs);
    }

    /**
     * Update document, using update script. Requires elasticsearch >= 0.19.0.
     *
     * @param  int                      $id      document id
     * @param  array|\Elastica\Document $data    raw data for request body
     * @param  string                   $index   index to update
     * @param  string                   $type    type of index to update
     * @param  array                    $options array of query params to use for query. For possible options check es api
     * @return \Elastica\Response
     * @link http://www.elasticsearch.org/guide/reference/api/update.html
     */
    public function updateDocument($id, $data, $type, $index = 'activehire', array $options = [])
    {
        return $this->client->updateDocument($id, $data, $index, $type, $options);
    }

    /**
     * Bulk deletes documents.
     *
     * @param  array|\Elastica\Document[]           $docs
     * @return \Elastica\Bulk\ResponseSet
     * @throws \Elastica\Exception\InvalidException
     */
    public function deleteDocuments(array $docs)
    {
        return $this->client->deleteDocuments($docs);
    }

    /**
     * Invoke Elasticsearch search.
     *
     * @param Query  $query
     * @param string $index
     * @param string $type
     * @param array  $options
     *
     * @return \Elastica\ResultSet
     */
    public function search($query, $type, $index = 'activehire', $options = [])
    {
        $search = new Search($this->client);
        $search->addType($type);
        $search->addIndex($index);
        $search->setOptions($options);

        $result = $search->search($query);
        return $result;
    }

    /**
     * Invoke Elasticsearch count.
     *
     * @param Query  $query
     * @param string $index
     * @param string $type
     * @param array  $options
     *
     * @return \Elastica\ResultSet
     */
    public function count($query, $type, $index = 'activehire', $options = [])
    {
        $search = new Search($this->client);
        $search->addType($type);
        $search->addIndex($index);
        $search->setOptions($options);

        $result = $search->count($query);
        return $result;
    }

    /**
     * Invoke Elasticsearch suggestor.
     *
     * @param $query
     * @param $index
     *
     * @return array
     */
    public function suggest($query, $index)
    {
        $index = $this->getIndex($index);
        $result = [];

        try {
            $response = $index->request('_suggest', Request::GET, $query);
            if ($response->isOk()) {
                $result = $response->getData();
            }
        } catch (\Exception $e) {
            // nothing to do
        }

        return $result;
    }
}