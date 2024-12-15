<?php

namespace App\Tainix;

use App\Tainix\Request\GameResponseRequest;
use App\Tainix\Response\GameResponse;
use App\Tainix\Response\GameStart;
use App\Tainix\Response\Sample;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class Api
{
    public function __construct(
        private HttpClientInterface $tainixApiClient,
        private SerializerInterface $serializer,
        private CacheInterface $cache,
        #[Autowire(env: 'TAINIX_KEY')]
        private string $token,
    ) {
    }

    public function loadSample($challenge): Sample
    {
        return $this->cache->get('tainix-sample-'.$challenge, function (ItemInterface $item) use ($challenge) {
            $item->expiresAfter(3600);

            $response = $this->tainixApiClient->request('GET', '/api/engines/sample/'.$challenge.'/'.$this->token);

            return $this->serializer->deserialize($response->getContent(), Sample::class, 'json');
        });
    }

    public function gameStart($challenge): GameStart
    {
        $response = $this->tainixApiClient->request('GET', '/api/games/start/'.$this->token.'/'.$challenge);

        return $this->serializer->deserialize($response->getContent(), GameStart::class, 'json');
    }

    public function gameResponse(string $token, string $anwser): GameResponse
    {
        $gameResponse = new GameResponseRequest($anwser);

        $gameResponseJson = $this->serializer->serialize($gameResponse, 'json');

        $response = $this->tainixApiClient->request('GET', '/api/games/response/'.$token.'/'.base64_encode($gameResponseJson));

        return $this->serializer->deserialize($response->getContent(), GameResponse::class, 'json');
    }
}
