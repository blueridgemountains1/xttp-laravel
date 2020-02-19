<?php

namespace JohnathanSmith\XttpLaravel;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Traits\Macroable;
use JohnathanSmith\Xttp\MakesXttpPending;
use JohnathanSmith\Xttp\ProcessesXttpRequests;
use JohnathanSmith\Xttp\XttpPending;
use JohnathanSmith\Xttp\XttpResponseWrapper;

/**
 * @method XttpResponseWrapper get(string $url, array $options = [], ClientInterface $client = null, ProcessesXttpRequests $processesXttpRequests = null, MakesXttpPending $pending = null)
 * @method XttpResponseWrapper post(string $url, array $options = [], ClientInterface $client = null, ProcessesXttpRequests $processesXttpRequests = null, MakesXttpPending $pending = null)
 * @method XttpResponseWrapper put(string $url, array $options = [], ClientInterface $client = null, ProcessesXttpRequests $processesXttpRequests = null, MakesXttpPending $pending = null)
 * @method XttpResponseWrapper patch(string $url, array $options = [], ClientInterface $client = null, ProcessesXttpRequests $processesXttpRequests = null, MakesXttpPending $pending = null)
 * @method XttpResponseWrapper delete(string $url, array $options = [], ClientInterface $client = null, ProcessesXttpRequests $processesXttpRequests = null, MakesXttpPending $pending = null)
 * @method XttpResponseWrapper makeRequest(string $method, string $url, array $options = [], ClientInterface $client = null, ProcessesXttpRequests $processesXttpRequests = null, MakesXttpPending $pending = null)
 */
class XttpLaravel
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * @var \JohnathanSmith\Xttp\MakesXttpPending
     */
    public $xttpPending;

    /**
     * @var \JohnathanSmith\Xttp\ProcessesXttpRequests
     */
    public $processesXttpRequests;

    public function __construct(MakesXttpPending $xttpPending, ProcessesXttpRequests $processesXttpRequests)
    {
        $this->xttpPending = $xttpPending;
        $this->processesXttpRequests = $processesXttpRequests;
    }

    public function __call($name, $arguments)
    {
        $lowerName = strtolower($name);

        if (in_array($lowerName, $this->validMethods(), true)) {
            return $this->request($lowerName, ...$arguments);
        }

        if ($name === 'makeRequest') {
            return $this->request(...$arguments);
        }

        return $this->macroCall($name, $arguments);

    }

    private function validMethods(): array
    {
        return [
            'post',
            'patch',
            'put',
            'delete',
            'get',
        ];
    }

    public function request(
        string $method,
        string $url,
        array $options = [],
        ClientInterface $client = null,
        ProcessesXttpRequests $processesXttpRequests = null,
        MakesXttpPending $pending = null
    ): XttpResponseWrapper {
        return ($pending ?? $this->xttpPending ?? XttpPending::new())
            ->setUrl($url)
            ->setMethod($method)
            ->setOptions($options)
            ->process($client, $processesXttpRequests ?? $this->processesXttpRequests);
    }
}
