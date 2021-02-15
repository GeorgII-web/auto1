<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="API",
 *     description="Marketplace API description.",
 *     version="0.1",
 *      @OA\Contact(
 *          email="george.webfullstack@gmail.com"
 *      ),
 * )
 * @OA\SecurityScheme(
 *     securityScheme="apiToken",
 *     type="apiKey",
 *     in="query",
 *     name="api_token",
 * )
 * @OA\Server(
 *      url="http://localhost",
 *      description="Marketplace API Server"
 * )
 * @OA\Tag(name="Lots", description="Marketplace lots.")
 * @OA\Tag(name="Bids", description="Lot bids.")
 *
 * @author GeorgII-web <george.webfullstack@gmail.com>
 */
class MarketplaceAPIController
{
    /**
     * Create new lot.
     * Only for sellers.
     *
     * @OA\Post(
     *     path="/api/lots",
     *     summary="Create lot, sellers endpoint",
     *     tags={"Lots"},
     *     description="Create lot in the marketplace",
     *     security={{"apiToken": {}}},
     *     @OA\Parameter(
     *          name="cultivar",
     *          description="Cultivar.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="country_of_origin",
     *          description="Country of origin.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="harvesting_date",
     *          description="Harvesting date.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="weight",
     *          description="Weight, minimum 1000Kg.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *              minimum="1000.00",
     *              default="1000.00"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="auction_start",
     *          description="Auction duration start time. Optionally start auction on create lot, may be delayed.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="auction_end",
     *          description="Auction duration end time. Optionally end auction on create lot. ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="initial_price",
     *          description="Initial price $/Kg (by default starting from $0.0/Kg).",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *              minimum="0.00",
     *              default="0.00"
     *          )
     *      ),
     *     @OA\Response(response=200, description="Success", @OA\JsonContent(ref="#/components/schemas/Lot")),
     *     @OA\Response(response=401, description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/Unathorized")),
     *     @OA\Response(response=422, description="Lot create error", @OA\JsonContent(ref="#/components/schemas/NotFound")),
     * )
     * @param Request $request Input data
     * @return JsonResponse
     */
    public function lotStore(Request $request): JsonResponse
    {
        /* 1) Seller "Delicious bananas LTD" (id=899) successfully adds lot of
        * "Red Dacca" cultivar bananas, planted in Costa Rica and harvested on
        * July 27, 2018 with total weight of 1500 kg.
        * 2) "Delicious bananas LTD" adds lot of "Red Dacca" cultivar bananas,
        * planted in Costa Rica and harvested on July 27, 2018 with total
        * weight of 500 kg, but minimum weight allowed is 1000 kg.
        */
    }

    /**
     * Update lot by id.
     *
     * @OA\Patch(
     *     path="/api/lots/{id}",
     *     summary="Update lot by id, sellers endpoint",
     *     tags={"Lots"},
     *     description="Update lot information",
     *     security={{"apiToken": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Lot id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="cultivar",
     *          description="Cultivar.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="country_of_origin",
     *          description="Country of origin.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="harvesting_date",
     *          description="Harvesting date.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="weight",
     *          description="Weight, minimum 1000Kg.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *              minimum="1000.00",
     *              default="1000.00"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="auction_start",
     *          description="Auction duration start time. Optionally start auction on update lot, may be delayed.",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="auction_end",
     *          description="Auction duration end time. Optionally end auction on update lot. ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="initial_price",
     *          description="Initial price $/Kg (by default starting from $0.0/Kg).",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *              minimum="0.00",
     *              default="0.00"
     *          )
     *      ),
     *     @OA\Response(response=200, description="Success", @OA\JsonContent(ref="#/components/schemas/Lot")),
     *     @OA\Response(response=401, description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/Unathorized")),
     *     @OA\Response(response=404, description="Lot not found", @OA\JsonContent(ref="#/components/schemas/NotFound")),
     *     @OA\Response(response=422, description="Lot update error", @OA\JsonContent(ref="#/components/schemas/Error")),
     * )
     * @param Request $request Input data
     * @param int     $id      Lot id
     * @return JsonResponse
     */
    public function lotUpdate(Request $request, int $id): JsonResponse
    {
        /**
         * 3) "Delicious bananas LTD" changes harvesting date of created lot to June 14, 2018.
         * 4) "Delicious bananas LTD" starts an auction on Sep 4, 2018 on the same lot with initial price $1.20/kg and duration 1 day.
         */
    }

    /**
     * Delete lot by id.
     *
     * @OA\Delete(
     *     path="/api/lots/{id}",
     *     summary="Delete lot by id, sellers endpoint",
     *     tags={"Lots"},
     *     description="Delete lot from marketplace",
     *     security={{"apiToken": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Lot id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/Success")),
     *     @OA\Response(response=401, description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/Unathorized")),
     *     @OA\Response(response=404, description="Lot not found", @OA\JsonContent(ref="#/components/schemas/NotFound")),
     *     @OA\Response(response=422, description="Lot delete error", @OA\JsonContent(ref="#/components/schemas/Error")),
     * )
     * @param int $id Lot id
     * @return JsonResponse
     */
    public function lotDestroy(int $id): JsonResponse
    {
        /**
         * 7) "Delicious bananas LTD" wants to remove sold lot
         */
    }

    /**
     * Create new bid.
     *
     * @OA\Post(
     *     path="/api/lots/{id}/bids",
     *     summary="Create bid on the lot, buyers endpoint",
     *     tags={"Bids"},
     *     description="Create bid on the specified lot",
     *     security={{"apiToken": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Lot id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="bid_price",
     *          description="Bid $/Kg. Must be bigger than the lot initial price.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number",
     *              format="float",
     *              minimum="0.00",
     *              default="0.00"
     *          )
     *      ),
     *     @OA\Response(response=200, description="Success", @OA\JsonContent(ref="#/components/schemas/Bid")),
     *     @OA\Response(response=401, description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/Unathorized")),
     *     @OA\Response(response=404, description="Lot not found", @OA\JsonContent(ref="#/components/schemas/NotFound")),
     *     @OA\Response(response=422, description="Bid create error", @OA\JsonContent(ref="#/components/schemas/Error")),
     * )
     * @param Request $request Input data
     * @param int     $id      Lot id
     * @return JsonResponse
     */
    public function bidStore(Request $request, int $id): JsonResponse
    {
        /*
        * 5) A buyer "German Retailer GmbH" (id=72) bids on the same lot with a price $1.35/kg
        */
    }

    /**
     * List of the lot bids.
     *
     * @OA\Get(
     *     path="/api/lots/{id}/bids",
     *     summary="Get list of the lot bids, sellers endpoint",
     *     tags={"Bids"},
     *     description="Get list of the lot bids",
     *     security={{"apiToken": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="Lot id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(
     *            type="array",
     *            @OA\Items(
     *              ref="#/components/schemas/Bid"
     *            )
     *          )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/Unathorized")),
     *     @OA\Response(response=404, description="Lot not found", @OA\JsonContent(ref="#/components/schemas/NotFound")),
     *     @OA\Response(response=422, description="Get bids list error", @OA\JsonContent(ref="#/components/schemas/Error")),
     * )
     * @param Request $request Input data
     * @param int     $id      Lot id
     * @return JsonResponse
     */
    public function bidIndex(Request $request, int $id): JsonResponse
    {
        /*
        * 6) "Delicious bananas LTD" wants to see a list of bids on his lot
        */
    }
}

/**
 * @OA\Schema(
 *     description="Lot object"
 * )
 */
class Lot
{
    /**
     * @OA\Property(example="3901")
     * @var int
     */
    public int $id;

    /**
     * @OA\Property(example="899")
     * @var int
     */
    public int $seller_id;

    /**
     * @OA\Property(example="7902")
     * @var int
     */
    public int $winner_bid_id;

    /**
     * @OA\Property(example="Red Dacca")
     * @var string
     */
    public string $cultivar;

    /**
     * @OA\Property(example="Costa Rica")
     * @var string
     */
    public string $country_of_origin;

    /**
     * @OA\Property(format="date")
     * @var string
     */
    public string $harvesting_date;

    /**
     * @OA\Property(format="float", example="1500.01")
     * @var float
     */
    public float $weight;

    /**
     * @OA\Property(format="date-time")
     * @var string
     */
    public string $auction_start;

    /**
     * @OA\Property(format="date-time")
     * @var string
     */
    public string $auction_end;

    /**
     * @OA\Property(format="float", example="1.20")
     * @var float
     */
    public float $initial_price;
}

/**
 * @OA\Schema(
 *     description="Bid object"
 * )
 */
class Bid
{
    /**
     * @OA\Property(example="7902")
     * @var int
     */
    public int $id;

    /**
     * @OA\Property(example="3901")
     * @var int
     */
    public int $lot_id;

    /**
     * @OA\Property(example="72")
     * @var int
     */
    public int $buyer_id;

    /**
     * @OA\Property(format="date-time")
     * @var string
     */
    public string $bid_date;

    /**
     * @OA\Property(format="float", example="1.35")
     * @var float
     */
    public float $bid_price;
}

/**
 * @OA\Schema(
 *     description="Success response"
 * )
 */
class Success
{
    /**
     * @OA\Property(example="Success")
     * @var string
     */
    public string $message;
}

/**
 * @OA\Schema(
 *     description="Unathorized response"
 * )
 */
class Unathorized
{
    /**
     * @OA\Property(example="Unathorized")
     * @var string
     */
    public string $message;
}

/**
 * @OA\Schema(
 *     description="NotFound response"
 * )
 */
class NotFound
{
    /**
     * @OA\Property(example="Not found")
     * @var string
     */
    public string $message;
}

/**
 * @OA\Schema(
 *     description="Error response"
 * )
 */
class Error
{
    /**
     * @OA\Property(example="Error")
     * @var string
     */
    public string $message;
}
