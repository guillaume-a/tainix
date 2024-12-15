<?php

namespace App\Tainix;

use App\Tainix\Request\GameResponseRequest;
use App\Tainix\Response\GameResponse;
use App\Tainix\Response\GameStart;
use App\Tainix\Response\Sample;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class Api
{
    private const string TAINIX_URL = 'https://tainix.fr/api';
    //    private const TAINIX_URL_ENGINES_LIST = '/engines/list';
    //    private const TAINIX_URL_ENGINE_SAMPLE = '/engines/sample/';

    //    private const TAINIX_URL_ENGINE_SAMPLE = '/games/start/KEY/CODE'; => TOKEN + INPUT
    //    private const TAINIX_URL_ENGINE_SAMPLE = '/games/response/TOKEN/{{response}}';

    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer,
        private CacheInterface $cache,
    ) {
    }

    public function loadSample($challenge): Sample
    {
        return $this->cache->get('tainix-sample-'.$challenge, function (ItemInterface $item) use ($challenge) {
            $item->expiresAfter(3600);

            $response = $this->client->request('GET', self::TAINIX_URL.'/engines/sample/'.$challenge.'/'.($_ENV['TAINIX_KEY'] ?? ''));

            return $this->serializer->deserialize($response->getContent(), Sample::class, 'json');
        });
    }

    public function gameStart($challenge): GameStart
    {
        $response = $this->client->request('GET', self::TAINIX_URL.'/games/start/'.($_ENV['TAINIX_KEY'] ?? '').'/'.$challenge);

        return $this->serializer->deserialize($response->getContent(), GameStart::class, 'json');
    }

    public function gameResponse(string $token, string $anwser): GameResponse
    {
        $gameResponse = new GameResponseRequest($anwser);

        $gameResponseJson = $this->serializer->serialize($gameResponse, 'json');

        $response = $this->client->request('GET', self::TAINIX_URL.'/games/response/'.$token.'/'.base64_encode($gameResponseJson));

        return $this->serializer->deserialize($response->getContent(), GameResponse::class, 'json');
    }
}
