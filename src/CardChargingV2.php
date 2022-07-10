<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2;

use Dinhdjj\CardChargingV2\Data\CardType;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class CardChargingV2
{
    protected array $connection;

    public function __construct(string|array|null $connection = null)
    {
        if (\is_string($connection) || null === $connection) {
            $connection ??= Config::get('card-charging-v2.default');

            if (!Config::has('card-charging-v2.connections.'.$connection)) {
                throw new InvalidArgumentException("Card Charging V2 connection [{$connection}] isn't defined yet.");
            }

            $connection = Config::get('card-charging-v2.connections.'.$connection);
        }

        if (\is_array($connection)) {
            $this->connection = $connection;
        }
    }

    /**
     * Use specific connection.
     */
    public static function connection(string|array|null $connection = null): static
    {
        return new static($connection);
    }

    /**
     * Fetch card types from thesieure.
     *
     * @throws \Illuminate\Http\Client\RequestException
     *
     * @return \Dinhdjj\Thesieure\Data\CardType[]
     */
    public function getFee(): array
    {
        $url = 'https://'.$this->config('domain').'/chargingws/v2/getfee?partner_id='.$this->config('partner_id');
        $response = Http::get($url)
            ->throw()
        ;

        return array_map(fn ($cardType) => new CardType(
            telco: $cardType['telco'],
            value: (int) $cardType['value'],
            fees: (int) $cardType['fees'],
            penalty: (int) $cardType['penalty'],
        ), $response->json());
    }

    /**
     * Get given config.
     */
    protected function config(string $key): mixed
    {
        return $this->connection[$key];
    }
}
